import { createApp } from 'vue'
import App from './App.vue'
import { createRouter,createWebHistory  } from 'vue-router'
import AdminLayout from './layouts/AdminLayout.vue';
import Products from './components/Admin/Products.vue';
import Categories from './components/Admin/Categories.vue';
import CreateProduct from './components/Admin/CreateProduct.vue';
import EditProduct from './components/Admin/EditProduct.vue';
import Login from './components/Admin/Login.vue';
import Register from './components/Admin/Register.vue';
import Admin from './components/Admin/Admin.vue';
import UserPanel from './components/Admin/Dashboard.vue';
const routes = [
    {
      path: '/admin',
      component: AdminLayout,
      children: [
        {
          path:'',
          component:Admin
        },  
        {
          path: 'kategoriler', 
          component: Categories,
        },
        {
          path: 'urunler',
          component: Products,
        },
        {
          path: 'urunler/ekle',
          component:CreateProduct
        },

        
        {
          path: 'urunler/:id',
          name: 'EditProduct',
          component:EditProduct
        },
      ],
    },

    // Kullanıcı paneli rotası
  {
    path: '/user',
    component: AdminLayout,
    children: [
      {
        path: 'panel/:id',
        name: 'UserPanel',
        component: UserPanel,
      },
    ],
  },

    {
      path: '/giris',
      component: Login,
    },
    {
      path: '/kayitol',
      component:Register,
    },
  ];
  

  

  const router = createRouter({
    history: createWebHistory(),
    routes,
  });

  const app = createApp(App);
  app.use(router);
  app.mount('#app');
