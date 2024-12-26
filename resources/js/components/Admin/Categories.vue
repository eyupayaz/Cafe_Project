<template>
    <div class="container d-flex">
        <!-- Sol tarafta kategori ekleme formu -->
        <div class="col-md-6">
            <h1>Kategori Ekle</h1>
            <form @submit.prevent="addCategory">
                <div class="mb-3">
                    <label for="categoryName" class="form-label">Kategori Adı</label>
                    <input v-model="newCategory.name" id="categoryName" class="form-control" />
                    
                    <label for="slug" class="form-label">Slug</label>
                    <input v-model="newCategory.slug" id="categorySlug" class="form-control" />
                    
                    <label for="categoryImage" class="form-label">Kategori Resmi</label>
                    <input
                        type="file"
                        @change="handleImageUpload"
                        id="categoryImage"
                        class="form-control"
                        accept="image/*"
                    />
                </div>
                <button type="submit" class="btn btn-primary">Ekle</button>
            </form>
        </div>

        <!-- Sağ tarafta kategoriler listesi -->
        <div class="col-md-6">
            <h2>Mevcut Kategoriler</h2>
            <div class="categories-container">
                <ul class="list-group">
                    <li v-for="category in categories" :key="category.id" class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ category.name }}</strong><br />
                            <small>{{ category.slug }}</small><br />
                            <img v-if="category.image" :src="`/storage/${category.image}`" alt="Kategori Resmi" width="50" height="50" class="mt-2"/>
                        </div>
                        <button @click="deleteCategory(category.id)" class="btn btn-danger btn-sm">Sil</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            categories: [],
            newCategory: {
                name: '',
                image: '',
            },
        };
    },
    methods: {
        async fetchCategories() {
            try {
                const response = await axios.get('/api/categories');
                this.categories = response.data;
            } catch (error) {
                console.error('Kategoriler alınırken hata oluştu:', error.response ? error.response.data : error.message);
                alert('Kategoriler alınamadı. Lütfen API bağlantınızı kontrol edin.');
            }
        },

        async addCategory() {
            try {
                const formData = new FormData();
                formData.append('name', this.newCategory.name);
                formData.append('slug', this.newCategory.slug);

                if (this.newCategory.image) {
                    formData.append('image', this.newCategory.image);
                }

                const response = await axios.post('/api/categories', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                });
                this.categories.push(response.data);
                this.newCategory = { name: '', slug: '', image: null }; // Formu temizle
            } catch (error) {
                console.error('Kategori eklenirken hata oluştu:', error.response ? error.response.data : error.message);
                alert('Kategori eklenemedi. Lütfen API bağlantınızı kontrol edin.');
            }
        },

        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.newCategory.image = file;
            }
        },

        deleteCategory(categoryId) {
            if (confirm("Bu kategoriyi silmek istediğinize emin misiniz?")) {
                axios.delete(`/api/categories/${categoryId}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    alert("Kategori başarıyla silindi.");
                    // Silinen kategori id'sine göre listeyi güncelle
                    this.categories = this.categories.filter(category => category.id !== categoryId);
                })
                .catch(error => {
                    console.error("Silme işlemi sırasında hata oluştu:", error.response ? error.response.data : error.message);
                    alert("Kategori silinirken bir hata oluştu.");
                });
            }
        }
    },

    mounted() {
        this.fetchCategories();
    }
};
</script>

<style scoped>
.categories-container {
    /* Sabit yükseklik verildi, taşma durumunda kaydırma çubuğu görünsün */
    height: 400px; /* Sabit yükseklik */
    overflow-y: scroll; /* Dikey kaydırma */
    background-color: #e4e4e4; /* Arka plan rengi */
    border-radius: 10px; /* Kenar yuvarlama */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Gölgeleme */
    padding: 20px; /* İç boşluk */
    margin-top: 20px;
}

/* Liste öğelerine özel stiller */
ul.list-group {
    margin: 0;
    padding: 0;
    list-style-type: none; /* Liste işaretlerini kaldır */
}

.list-group-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
</style>
