<template>
  <div class="dashboard">
    <h1>Tableau de bord</h1>
    <div v-if="loading">Chargement...</div>
    <div v-else class="cards">
      <div v-for="stat in stats" :key="stat.id" class="card">
        <h2>{{ stat.mois }}</h2>
        <p>{{ stat.total_ventes }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import axios from 'axios'

export default {
  name: 'StatistiqueVente',
  data() {
    return {
      stats: [],
      loading: true
    }
  },
  mounted() {
    this.fetchStats()
  },
  methods: {
    async fetchStats() {
      try {
        const response = await axios.get(`${this.apiBaseURL}/fetch_vente_detail_parmois`)
        this.stats = response.data
      } catch (error) {
        console.error('Erreur API :', error)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.dashboard {
  padding: 2rem;
}
.cards {
  display: flex;
  gap: 1rem;
}
.card {
  background: #f4f4f4;
  padding: 1rem;
  border-radius: 10px;
  min-width: 150px;
  text-align: center;
}
</style>
