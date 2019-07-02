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
        const url = ruta + '/discountByMonth';


        await axios.get(url)
          .then(function (r) {
            const response = r.data;

            const conDesct = response.conDescuento;

            conDesct.forEach(function(element) {
              const test = element[0].con+'';
              var transformed = 0;
              if (test !== 'null'){
                transformed = parseInt(test,0);
              }
              me.conDescuento.push(transformed);

            });

            const sinDesct = response.sinDescuento;

            sinDesct.forEach(function(element) {
              const test = element[0].sin+'';
              var transformed = 0;
              if (test !== 'null'){
                transformed = parseInt(test,0);
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
                label: 'Con descuento',
                backgroundColor: hexToRgba('#E46651', 90),
                data: me.conDescuento//[30, 39, 10, 50, 30, 70, 35]
              },
              {
                label: 'Sin descuento',
                backgroundColor: hexToRgba('#00D8FF', 90),
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
