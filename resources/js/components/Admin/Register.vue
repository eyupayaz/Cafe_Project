<template>
    <head>
      <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-3/assets/css/login-3.css">
    </head>
  <!-- Login 3 - Bootstrap Brain Component -->
  <section class="p-3 p-md-4 p-xl-5">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-6 bsb-tpl-bg-platinum">
          <div class="d-flex flex-column justify-content-between h-100 p-3 p-md-4 p-xl-5">
            <h3 class="m-0">Hoşgeldiniz!</h3>
            <img class="img-fluid rounded mx-auto my-4" loading="lazy" src="/src/assets/burger.jpg" width="800" height="1000" alt="BootstrapBrain Logo">
          </div>
        </div>
        <div class="col-12 col-md-6 bsb-tpl-bg-lotion">
          <div class="p-3 p-md-4 p-xl-5">
            <div class="row">
              <div class="col-12">
                <div class="mb-5">
                  <h3>Hesap Oluştur</h3>
                </div>
              </div>
            </div>
            <form @submit.prevent="register" method="POST">
              <meta name="csrf-token" content="{{ csrf_token() }}">
              <div class="row gy-3 gy-md-4 overflow-hidden">
                <div class="col-12">
                  <label for="name" class="form-label">Ad Soyad<span class="text-danger">*</span></label>
                  <input type="name" class="form-control" name="name" id="name" v-model="name" required>
                </div>
                <div class="col-12">
                  <label for="username" class="form-label">Kullanıcı Adı <span class="text-danger">*</span></label>
                  <input type="username" class="form-control" name="username" id="username" v-model="username" required>
                </div>
                <div class="col-12">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" name="email" id="email" v-model="email" placeholder="name@example.com" required>
                </div>
                <div class="col-12">
                  <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" name="password" id="password" v-model="password" value="" required>
                </div>
                <div class="col-12">
                  <div class="d-grid">
                    <button class="btn bsb-btn-xl btn-primary" type="submit">Kayıt Ol</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  </template>

  <script>
import axios from 'axios';

axios.defaults.withCredentials = true;


export default {
  data() {
    return {
      name: '',
      username: '',
      email: '',
      password: '',
    };
  },
  methods: {
    async register() {
      try {
        await axios.post('http://127.0.0.1:8000/api/admin/kayitol', {
          name: this.name,
          username: this.username,
          email: this.email,  
          password: this.password,
        });
        alert('Kullanıcı başarıyla oluşturuldu.');
          this.name = '';
          this.username = '';
          this.email = '';
          this.password = '';

          // Giriş sayfasına yönlendir
          this.$router.push('/giris');

        } catch (error) {
    if (error.response && error.response.data) {
      console.error('Error:', error.response.data); // Backend'den gelen hata mesajını kontrol et
      alert(error.response.data.message || 'Bu hesap mevcut lütfen farklı bir hesap oluşturun.');
    }
  }
    },
  },
  
};

</script>