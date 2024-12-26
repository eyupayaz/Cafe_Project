<template>
  <h3>Kullanıcı sayfasına hoş  geldiniz.</h3>
  <div class="container mt-5">
    <div class="row">
      <div class="col-6 col-md-3">
        <PieChart :data="pieData" :options="pieOptions" />
      </div>
    </div>
  </div>
  <div v-if="panelTitle && panelContent">
    <h1>Hoş geldiniz  {{ panelTitle }}</h1>
    <p>{{ panelContent }}</p>
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
      panelTitle: '',
      panelContent: '',
    };
  },
  created() {

    axios
      .get(`http://127.0.0.1:8000/api/user/panel/${this.$route.params.id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
          // 'Authorization': `Bearer ${token}`
        },
      })
      .then((response) => {
        this.panelTitle = response.data.title;
        this.panelContent = response.data.content;
        console.log('Başarılı yanıt:', response.data);
      })
      .catch((error) => {
        console.error(error.response ? error.response.data : error.message);
        alert('Panel bilgisi yüklenemedi.');
      });
  },
};


//pie
// import { Pie } from 'vue-chartjs';
// import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale } from 'chart.js';

// // Chart.js bileşenini kaydedin
// ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale);

// export default {
//   name: 'PieChartComponent',
//   components: {
//     PieChart: Pie,
//   },
//   data() {
//     return {
//       // Pie Chart verisi
//       pieData: {
//         labels: ['Red', 'Blue', 'Yellow'],
//         datasets: [
//           {
//             data: [300, 50, 100],
//             backgroundColor: ['#F0000', '#0000FF', '#FFFF00'],
//             hoverBackgroundColor: ['#FF6666', '#6666FF', '#FFFF99'],
//           },
//         ],
//       },
//       // Pie Chart opsiyonları
//       pieOptions: {
//         responsive: true,
//         plugins: {
//           legend: {
//             position: 'top',
//           },
//           tooltip: {
//             callbacks: {
//               label: function(tooltipItem) {
//                 return tooltipItem.label + ': ' + tooltipItem.raw;
//               },
//             },
//           },
//         },
//       },
//     };
//   },
// };
</script>

<!-- <style scoped>
.chart-container {
  max-width: 400px;
  margin: auto;
}
</style> -->

