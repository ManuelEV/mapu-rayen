<script>
  import { Doughnut } from 'vue-chartjs'

  export default {
    extends: Doughnut,
    mounted () {
      this.renderChart({
        labels: ['Materia prima', 'Productos'],
        datasets: [
          {
            backgroundColor: [
              '#41B883',
              '#E46651'
            ],
            data: [40, 20]
          }
        ]
      }, {responsive: true, maintainAspectRatio: true})
    }
  }
</script>
