<template>
    <div>
        <h1 class="mb-4">Menü Yönetimi</h1>
        <button class="btn btn-primary mb-3" @click="showAddProductModal"> Yemek Ekle</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ürün Adı</th>
                    <th>Açıklama</th>
                    <th>Fiyat</th>
                    <th>Kategori</th>
                    <th></th>   
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products.data" :key="product.productId">
                    <td>{{ product.id }}</td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.description }}</td>
                    <td>{{ product.price }} ₺</td>
                    <td>{{ product.category ? product.category.name : 'Kategori Yok' }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" @click="editProduct(product)">Düzenle</button>
                        <button class="btn btn-sm btn-danger" @click="deleteProduct(product.id)">Sil</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Sayfalama Kontrolü -->
<div v-if="products">
    <nav>
        <ul class="pagination justify-content-center">
            <!-- İlk Sayfa -->
            <li class="page-item" :class="{ disabled: products.current_page === 1 }">
                <a class="page-link" href="#" @click.prevent="fetchProductsPage(1)">İlk</a>
            </li>

            <!-- Önceki Sayfa -->
            <li class="page-item" :class="{ disabled: !products.prev_page_url }">
                <a class="page-link" href="#" @click.prevent="fetchProductsPage(products.current_page - 1)">Önceki</a>
            </li>

            <!-- Sayfa Numaraları -->
            <li 
                class="page-item" 
                v-for="link in products.links.filter(l => l.url && !isNaN(l.label))" 
                :key="link.label" 
                :class="{ active: link.active }"
            >
                <a 
                    class="page-link" 
                    href="#" 
                    @click.prevent="fetchProductsPage(parseInt(link.url.split('=')[1]))"
                >
                    {{ link.label }}
                </a>
            </li>

            <!-- Sonraki Sayfa -->
            <li class="page-item" :class="{ disabled: !products.next_page_url }">
                <a class="page-link" href="#" @click.prevent="fetchProductsPage(products.current_page + 1)">Sonraki</a>
            </li>

            <!-- Son Sayfa -->
            <li class="page-item" :class="{ disabled: products.current_page === products.last_page }">
                <a class="page-link" href="#" @click.prevent="fetchProductsPage(products.last_page)">Son</a>
            </li>
        </ul>
    </nav>
</div>



        <Sidebar/>
    </div>
    
</template>

<script>
import axios from "axios";
import Sidebar from "../../layouts/sidebar.vue";
import Categories from "./Categories.vue";

export default {
    data() {
        return {
            products: [],
        };
    },
    methods: {
        async fetchProducts() {
    try {
        const response = await axios.get('/api/products');
        console.log(response.data);
        this.products = response.data; // Yanıt verisini doğrudan ata
    } catch (error) {
        console.error('Hata:', error.response ? error.response.data : error.message);
        alert('Ürünler alınamadı. Lütfen API bağlantınızı kontrol edin.');
    }
},

async fetchProductsPage(page) {
    if (!page || page < 1 || page > this.products.last_page) return; // Geçersiz sayfa kontrolü

    try {
        const response = await axios.get(`/api/products?page=${page}`);
        this.products = response.data; // Yeni sayfa verilerini ata
    } catch (error) {
        console.error('Hata:', error.response ? error.response.data : error.message);
        alert('Sayfa yüklenemedi. Lütfen tekrar deneyin.');
    }
},  

        
        async deleteProduct(productId) {
            if (confirm("Bu ürünü silmek istediğinize emin misiniz?")) {
            try {
                // API'den ürünü sil
                await axios.delete(`/api/products/${productId}`);
                // Ürün listesinden kaldır
                this.products = this.products.filter(product => product.id !== productId);
                alert("Ürün başarıyla silindi.");
            } catch (error) {
                console.error("Ürün silinirken hata oluştu:", error.response ? error.response.data : error.message);
                alert("Ürün silinemedi. Lütfen tekrar deneyin.");
            }
        }
    },
        showAddProductModal() {
            alert('Yeni ürün ekleme sayfasına gidiyorsunuz!!!');
            this.$router.push('/admin/urunler/ekle');
        },
        editProduct(product) {
            this.$router.push({ name: 'EditProduct', params: { id: product.id } });
        },
    },
    mounted() {
        this.fetchProducts();
    },
};
</script>
<style>
.pagination {
    justify-content: center; /* Ortalar */
    margin-top: 20px; /* Üstten boşluk ekler */
}
</style>
