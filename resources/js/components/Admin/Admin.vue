<template>
    <div v-if="users.length">
      <h1>Admin Paneli</h1>
      <ul>
        <li v-for="user in users" :key="user.id">{{ user.name }}</li>
      </ul>
    </div>
    <div v-else>
      <p>Yükleniyor...</p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        users: []
      };
    },
    created() {
      this.fetchAdminDashboard();
    },
    methods: {
      fetchAdminDashboard() {
        axios.get('/admin/dashboard', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        .then(response => {
          this.users = response.data.users;
        })
        .catch(error => {
          console.log('Hata:', error);
        });
      }
    }
  };
  </script>
  