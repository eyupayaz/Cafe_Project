<template>
     <Navbar/>
     <Sidebar />
     
    <div class="content">
      <main>
        <router-view></router-view> 
      </main>
    </div>

    <!-- Footer sayfanın en altında -->
    <Footer /> 
</template>

<script>
import Navbar from './navbar.vue'
import Footer from './footer.vue';
import Sidebar from './sidebar.vue';

export default {
  components: {
    Navbar,
    Sidebar,
    Footer,
  },
};
</script>

<style scoped>
/* Admin Layout için flex düzeni */
.admin-layout {
  display: flex;
  min-height: 100vh; /* Sayfa yüksekliğini tamamen kapsar */
  flex-direction: column; /* Sayfa baştan sona dikey olarak yerleşecek */
}

.content {
  display: flex;
  flex: 1;
  flex-direction: row; /* Sidebar'ı ve main içeriği yan yana yerleştirir */
}

main {
  flex-grow: 1;
  padding: 20px; /* Sayfa içeriği için boşluk */
}

footer {
  background-color: #f1f1f1;
  text-align: center;
  padding: 10px;
}


</style>
