<template>
    <div>
        <h1 class="mb-4">Yemek Ekle</h1>
        <form @submit.prevent="addProducts">
            <div class="mb-3">
                <label for="productname" class="form-label">Ürun Adı</label>
                <input v-model="newProduct.name" id="productname" class="form-control" />
                
                <label for="slug" class="form-label">Slug</label>
                <input v-model="newProduct.slug" id="slug" class="form-control" />

                <label for="description" class="form-label">Açıklama</label>
                <input v-model="newProduct.description" id="description" class="form-control" />
                
                <label for="price" class="form-label">Fiyat</label>
                <input v-model="newProduct.price" id="price" class="form-control" />

                <label for="category_id" class="form-label">Kategori</label>
                <select v-model="newProduct.category_id" id="category_id" class="form-control">
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
                
                <label for="image" class="form-label">Yemek Resmi</label>
                <input
                    type="file"
                    @change="handleImageUpload"
                    id="categoryImage"
                    class="form-control"
                    accept="image/*"
                />
            </div>
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </form>
    </div>
    <Sidebar/>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            categories: [], // Kategoriler için yeni bir dizi eklendi
            Products: [],
            newProduct: {
                name: '',
                slug: '',
                description: '',
                price: '',
                category_id: '',
                image: null,
            },
        };
    },

    methods: {
        async fetchCategories() {
            try {
                const response = await axios.get('/api/categories'); // Kategorileri backend'den alıyoruz
                this.categories = response.data;
            } catch (error) {
                console.error('Kategoriler alınırken hata oluştu:', error.response ? error.response.data : error.message);
                alert('Kategoriler yüklenemedi. Lütfen API bağlantınızı kontrol edin.');
            }
        },

        async addProducts() {
            try {
                const formData = new FormData();
                formData.append('name', this.newProduct.name);
                formData.append('slug', this.newProduct.slug);
                formData.append('description', this.newProduct.description);
                formData.append('price', this.newProduct.price);
                formData.append('category_id', this.newProduct.category_id);

                if (this.newProduct.image) {
                    formData.append('image', this.newProduct.image);
                }

                const response = await axios.post('/api/products', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' },
                });

                // Ürün başarıyla eklendiğinde:
                this.Products.push(response.data); // Yeni ürünü listeye ekle
                this.newProduct = { name: '', slug: '', description: '', price: '', category_id: '', image: null }; // Formu sıfırla
            } catch (error) {
                console.error('Ürün eklenirken hata oluştu:', error.response ? error.response.data : error.message);
                alert('Ürün eklenemedi. Lütfen API bağlantınızı kontrol edin.');
            }
        },

        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.newProduct.image = file; // Doğru değişkeni kullanalım
            }
        },
    },

    mounted() {
        this.fetchCategories(); // Sayfa yüklendiğinde kategorileri getiriyoruz
    },
};
</script>
