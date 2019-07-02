<script>
  import { Doughnut } from 'vue-chartjs'

  export default {
    extends: Doughnut,
    mounted () {
      this.renderChart({
        labels: ['Producto1', 'Producto2', 'Producto3', 'Producto4'],
        datasets: [
          {
            backgroundColor: [
              '#41B883',
              '#E46651',
              '#00D8FF',
              '#DD1B16'
            ],
            data: [40, 20, 80, 10]
          }
        ]
      }, {responsive: true, maintainAspectRatio: true})
    }
  }
</script>
