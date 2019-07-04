<script>
  import { Line } from 'vue-chartjs'
  import { CustomTooltips } from '@coreui/coreui-plugin-chartjs-custom-tooltips'
  import { hexToRgba } from '@coreui/coreui/dist/js/coreui-utilities'
  import axios from 'axios';

  export default {
    components: {
      hexToRgba,
      CustomTooltips
    },
    extends: Line,
    data: function () {
      return{
        conDescuento: [],
        sinDescuento: []
      }
    },
    methods: {
      async list(){

        let me = this;

        const ruta = this.ruta;
        const url = ruta + '/salesVersus';


        await axios.get(url)
          .then(function (r) {
            const response = r.data;

            const ventas = response.ventas;

            ventas.forEach(function(element) {
              const test = element[0].total+'';
              var transformed = 0;
              if (test !== 'null'){
                transformed = parseFloat(test).toFixed(2);
              }
              me.conDescuento.push(transformed);

            });

            ventas.forEach(function(element) {
              const test = element[0].subtotal+'';
              var transformed = 0;
              if (test !== 'null'){
                transformed = parseFloat(test).toFixed(2);
              }
              me.sinDescuento.push(transformed);

            });

          })
          .catch(function (error) {
            console.log(error);
          });

        this.renderChart(
          {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Deciembre'],
            datasets: [
              {
                label: 'Promedio ventas',
                backgroundColor: hexToRgba('#e4d000', 90),
                data: me.conDescuento//[30, 39, 10, 50, 30, 70, 35]
              },
              {
                label: 'Total ventas',
                backgroundColor: hexToRgba('#91ff00', 90),
                data: me.sinDescuento//[39, 80, 40, 35, 40, 20, 45]
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
