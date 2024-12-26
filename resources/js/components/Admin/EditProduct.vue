<template>
    <div>
        <h1 class="mb-4">Yemek Düzenle</h1>
        <form @submit.prevent="updateProduct"> <!-- Güncelleme fonksiyonuna yönlendirme -->
            <div class="mb-3">
                <label for="productname" class="form-label">Ürün Adı</label>
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
      newProduct: {
        name: '',
        slug: '',
        description: '',
        price: '',
        category_id: '',
        image: null,
      },
      categories: []
    };
  },

  mounted() {
    const productId = this.$route.params.id; // URL parametresinden ID'yi al
    if (productId) {
      this.fetchProduct(productId); // Ürünü al
    } else {
      alert('Ürün ID alınamadı!');
      this.$router.push('/urunler'); // Geri yönlendirme
    }
    this.fetchCategories(); // Kategorileri al
  },

  methods: {
    async fetchCategories() {
      try {
        const response = await axios.get('/api/categories');
        this.categories = response.data;
      } catch (error) {
        console.error('Kategoriler alınırken hata oluştu:', error.message);
        alert('Kategoriler yüklenemedi.');
      }
    },

    async fetchProduct(productId) {
      try {
        const response = await axios.get(`/api/products/${productId}`); // Ürünü API'den al
        this.newProduct = response.data; // Formu doldur
      } catch (error) {
        console.error('Ürün alınırken hata oluştu:', error.message);
        alert('Ürün bulunamadı!');
      }
    },

    async updateProduct() {
       const productId = this.$route.params.id; // URL parametresinden ID'yi al

      try {
        const formData = new FormData();
        formData.append('name', this.newProduct.name);
        formData.append('slug', this.newProduct.slug);
        formData.append('description', this.newProduct.description);
        formData.append('price', this.newProduct.price);
        formData.append('category_id', this.newProduct.category_id);
        formData.append('panel_id', this.newProduct.panel_id || null);


        if (this.newProduct.image instanceof File) {
          formData.append('image', this.newProduct.image);
        }

        const response = await axios.put(`/api/products/${productId}`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });

        alert('Ürün başarıyla güncellendi.');
        this.$router.push('/admin/urunler');
      } catch (error) {
        console.error('Ürün güncellenirken hata oluştu:', error.message);
        alert('Ürün güncellenemedi.');
      }
    },

    handleImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.newProduct.image = file;
      }
    }
  }
};
</script>
