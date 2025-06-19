<template>
  <div>
    <canvas ref="canvas"></canvas>
  </div>
</template>

<script>
import { Bar } from 'vue-chartjs'

export default {
  name: 'BarChart',
  extends: Bar,
  props: {
    chartData: {
      type: Object,
      required: true
    },
    chartOptions: {
      type: Object,
      default: () => ({ responsive: true, maintainAspectRatio: false })
    }
  },
  mounted() {
    this.renderChart(this.chartData, this.chartOptions)
  },
  watch: {
    chartData(newData) {
      this.renderChart(newData, this.chartOptions)
    }
  }
}
</script>
