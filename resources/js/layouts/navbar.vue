<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="/" style="color:blue;">kafem.com</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="/admin/urunler">Menü İşlemleri</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/admin/kategoriler">Kategori İşlemleri</a>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Kullanıcı Bilgileri

              
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Bilgilerim</a></li>
              <li><a class="dropdown-item" href="#">Şifre Güncelle</a></li>
              <li><hr class="dropdown-divider" /></li>
            </ul>
          </li>
        </ul>
        <div class="search-container position-relative">
          <input
            class="form-control me-2"
            v-model="search"
            @input="onSearch"
            type="text"
            placeholder="Search"
            aria-label="Search"
          />
          <!-- Arama Sonuçları -->
          <div v-html="resultsHtml"></div>
        </div>
        <button class="btn btn-outline-success" type="button" @click="logout">
          Çıkış
        </button>
      </div>
    </div>
  </nav>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      search: "", // Kullanıcının arama kutusuna yazdığı metin
      results: "", // Arama sonuçlarını tutar
      
    };
  },
  methods: {
    async onSearch() {
      if (this.search.length < 3) {
        this.resultsHtml = "";
        return;
      }

      try {
        const response = await axios.get(
          `http://127.0.0.1:8000/api/search?query=${this.search}`
        );
        this.resultsHtml = response.data.html; // Dönen HTML veriyi kullan
      } catch (error) {
        console.error("Arama sırasında hata:", error.response || error);
        this.resultsHtml = "<p>Bir hata oluştu.</p>";
      }
    },
    
    async logout() {
      try {
        const token = localStorage.getItem("token");
        await axios.post(
          "http://127.0.0.1:8000/api/logout",
          {},
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        localStorage.removeItem("token");
        this.$router.push("/").then(() => {
          window.location.reload();
        });
        alert("Başarıyla çıkış yapıldı.");
      } catch (error) {
        console.error("Çıkış sırasında hata:", error.response || error);
        alert("Çıkış sırasında bir hata oluştu.");
      }
    },
  },
};
</script>

<style scoped>
.search-container .dropdown-menu{
  max-height: 200px;
  overflow-y: auto;
  position: relative;
}

.search-container input {
  width: 100%;
  border-radius: 0;
  border: 1px solid #ced4da;
}
.dropdown-menu {
  max-height: 200px;
  overflow-y: auto;
  border: 1px solid #ccc;
  background-color: #fff;
  padding: 0;
  list-style: none;
}

.dropdown-item {
  padding: 10px;
  border-bottom: 1px solid #eee;
  cursor: pointer;
}

.dropdown-item:last-child {
  border-bottom: none;
}

.dropdown-item a {
  color: black;
  text-decoration: none;
}

.dropdown-item a:hover {
  color: #007bff;
}
</style>
