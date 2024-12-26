<template>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand"  href="/" style="color:blue;">kafem.com</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Kullanıcı Bilgileri
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Bilgilerim</a></li>
            <li><a class="dropdown-item" href="#">Şifre Güncelle</a></li>
            <li><hr class="dropdown-divider"></li>
         </ul>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Ara</button> 
        <button class="btn btn-outline-success" type="submit" @click="logout">Çıkış</button>
      </form>
    </div>
  </div>
</nav>
</template>
<script>
import axios from 'axios';

export default {
  methods: {
    async logout() {
      try {
        const token = localStorage.getItem('token'); // Token'i localStorage'dan al
        await axios.post('http://127.0.0.1:8000/api/logout', {}, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        // Çıkış yapıldıktan sonra token'ı temizle
        localStorage.removeItem('token'); // Token'i temizle

        // Kullanıcıyı giriş sayfasına yönlendir
        this.$router.push('/').then(() => {
        window.location.reload(); // Sayfayı yeniden yükle
        });
        alert('Başarıyla çıkış yapıldı.');
      } catch (error) {
        console.error(error.response ? error.response.data : error.message);
        alert('Çıkış sırasında bir hata oluştu.');
      }
    }
  }
};

</script>