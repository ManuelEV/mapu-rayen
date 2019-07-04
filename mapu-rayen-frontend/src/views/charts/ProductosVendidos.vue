<script>
  import { PolarArea } from 'vue-chartjs'
  import { CustomTooltips } from '@coreui/coreui-plugin-chartjs-custom-tooltips'
  import axios from 'axios';

  export default {
    extends: PolarArea,
    props: ['fromMonth', 'toMonth'],
    data: function () {
      return{
        product_occurrence: [],
        product_name: []
      }
    },
    methods: {
      async list() {
        let me = this;
        const ruta = this.ruta;
        const url = ruta + '/productReport?from=' + '2019-01-04' + '&to=' + '2019-07-04';
        console.log(this.fromMonth);
        console.log(this.toMonth);
        axios.get(url)
          .then(function (r) {

            const response = r.data;

            const products = response.items;
            console.log(products);
            for (var element in products){
              const split = element.split('-');
              const transformedOcurrence = Number(split[0]);
              me.product_occurrence.push(transformedOcurrence);
              me.product_name.push(split[1]);
            }

            console.log(me.product_occurrence);
            console.log(me.product_name);
          })
          .catch(function (error) {
            console.log(error);
          });

        this.renderChart({
          labels: me.product_name.slice(0,5),//['Eating', 'Drinking', 'Sleeping', 'Designing', 'Coding', 'Cycling', 'Running'],
          datasets: [
            {
              label: 'My First dataset',
              backgroundColor: 'rgba(179,181,198,0.2)',
              pointBackgroundColor: 'rgba(179,181,198,1)',
              pointBorderColor: '#fff',
              pointHoverBackgroundColor: '#fff',
              pointHoverBorderColor: 'rgba(179,181,198,1)',
              data: me.product_occurrence.slice(0,5)//[28, 48, 40, 19, 96, 27, 100]
            }
          ]
        }, {
          responsive: true,
          maintainAspectRatio: false,
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
        })
      }
      },
    mounted () {
      let me = this;
      me.list();
    }
  }
</script>
