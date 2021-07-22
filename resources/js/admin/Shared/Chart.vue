<template>
  <canvas :id="id" :width="width" :height="height"></canvas>
</template>

<script>
import { Chart, registerables } from 'chart.js'
Chart.register(...registerables)

export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `chart-${this._uid}`
      },
    },
    type: {
      type: String,
      default: 'line',
    },
    title: {
      type: String,
      default: 'Chart',
    },
    height: {
      type: Number,
      default: 400,
    },
    width: {
      type: Number,
      default: 600,
    },
    labels: {
      type: Array,
      default() {
        return ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
      },
    },
    datasets: {
      type: Array,
      default() {
        return [
          {
            backgroundColor: 'rgba(99,179,237,0.4)',
            strokeColor: '#63b3ed',
            pointColor: '#fff',
            pointStrokeColor: '#63b3ed',
            data: [203, 156, 99, 251, 305, 247, 256],
          },
          {
            backgroundColor: 'rgba(198,198,198,0.4)',
            strokeColor: '#f7fafc',
            pointColor: '#fff',
            pointStrokeColor: '#f7fafc',
            data: [86, 97, 144, 114, 94, 108, 156],
          },
        ]
      },
    },
    options: {
      type: Object,
      default() {
        return {
          responsive: true,
          plugins: {
            legend: {
              display: false,
            },
            title: {
              display: true,
              text: this.title,
            },
          },
          scales: {
            y: {
              min: 0,
            },
          },
        }
      },
    },
  },
  data() {
    return {
      chartConfig: {
        type: this.type,
        data: {
          labels: this.labels,
          datasets: this.datasets,
        },
        options: this.options,
      },
    }
  },
  mounted() {
    new Chart(document.getElementById(this.id), this.chartConfig)
  },
}
</script>
