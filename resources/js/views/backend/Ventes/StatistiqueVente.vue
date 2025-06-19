<template>
  <div class="dashboard">
    <h1>Statistiques des ventes</h1>
    <div v-if="loading">Chargement...</div>
    <div v-else>
      <BarChart :chart-data="chartData" :chart-options="chartOptions" />
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import BarChart from './BarChart.vue'

export default {
  components: { BarChart },
  data() {
    return {
      stats: [],
      chartData: null,
      chartOptions: {},
      loading: true,
      apiBaseURL: '/api' // change si besoin
    }
  },
  async mounted() {
    try {
      const res = await axios.get(`${this.apiBaseURL}/fetch_vente_detail_parmois`)
      this.stats = res.data

      this.chartData = {
        labels: this.stats.map(s => s.mois),
        datasets: [{
          label: 'Ventes mensuelles',
          backgroundColor: '#42A5F5',
          borderColor: '#1E88E5',
          data: this.stats.map(s => s.total_ventes),
          fill: false
        }]
      }

      this.chartOptions = {
        responsive: true,
        maintainAspectRatio: false
      }
    } catch (error) {
      console.error('Erreur API:', error)
    } finally {
      this.loading = false
    }
  }
}
</script>

<style scoped>
.dashboard {
  padding: 2rem;
}
</style>
