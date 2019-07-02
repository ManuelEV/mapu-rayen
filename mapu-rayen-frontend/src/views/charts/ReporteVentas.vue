<script>
  import { Bar } from 'vue-chartjs'
  import { CustomTooltips } from '@coreui/coreui-plugin-chartjs-custom-tooltips'
  import axios from 'axios';

  export default {
    extends: Bar,
    data: function () {
      return{
        ventas: []
      }
    },
    methods: {
      async list(){

        let me = this;

        const ruta = this.ruta;
        const url = ruta + '/reportByMonth';


        await axios.get(url)
          .then(function (r) {
            const response = r.data;

            const datos = response.ventas;

            datos.forEach(function(element) {
              const test = element[0].total+'';
              var transformed = 0;
              if (test !== 'null'){
                transformed = parseInt(test,0);
              }
              me.ventas.push(transformed);

            });

            console.log(me.ventas);

            me.ventas.forEach(function(element) {
              console.log(element);
            });


          })
          .catch(function (error) {
            console.log(error);
          });


        // Overwriting base render method with actual data.
        this.renderChart(
          {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Deciembre'],
            datasets: [
              {
                label: 'Total de ventas ($)',
                backgroundColor: '#f87979',
                data: me.ventas
              }
            ]
          },
          {
            responsive: true,
            maintainAspectRatio: true,
            tooltips: {
              enabled: false,
              custom: CustomTooltips,
              intersect: true,
              mode: 'index',
              position: 'nearest',
              callbacks: {
                labelColor: function (tooltipItem, chart) {
                  return { backgroundColor: chart.data.datasets[tooltipItem.datasetIndex].backgroundColor }
                }
              }
            }
          }
        )
      }
    },
    mounted () {

      let me = this;

      me.list();

    }
  }
</script>
