<template>
  <div class="animated fadeIn">

    <b-card> <!--header="Reporte de ventas">-->

      <h4><i class="fa fa-filter fa-lg mt-4"></i>Filtros</h4>

      <div class="animated fadeIn">
        <b-row>
          <b-col cols="12" sm="6" lg="4">
          </b-col>
          <b-col cols="12" sm="6" lg="4">
            <p >Fecha de inicio     -     Fecha de término</p>
            <input type="date" v-model="fromMonth" @input="onChange">
            <input type="date" v-model="toMonth" @input="onChange">
          </b-col>
          <b-col cols="12" sm="6" lg="4">
          </b-col>
        </b-row>
      </div>

    </b-card>

    <h1>Resumen</h1>

    <b-col cols="12" sm="6" lg="6" v-if="reportSummary.length===0">
      <br><br>
      <div class="animated fadeIn">
        <p><i class="fa fa-circle-o-notch fa-lg mt-4 fa-spin"></i>los datos del resumen se están cargando</p>
      </div>
      <br><br>
    </b-col>
    <div class="animated fadeIn" v-if="reportSummary.length>0">
      <b-row>
        <b-col cols="12" sm="6" lg="6">
          <b-card :no-body="true">
            <b-card-body class="p-0 clearfix">
              <i class="fa fa-money bg-primary p-4 px-5 font-2xl mr-3 float-left"></i>
              <div class="h5 text-primary mb-0 pt-3">${{reportSummary[0].total}}</div>
              <div class="text-muted text-uppercase font-weight-bold font-xs">Total real de ventas</div>
            </b-card-body>
          </b-card>
        </b-col>
        <b-col cols="12" sm="6" lg="6">
          <b-card :no-body="true">
            <b-card-body class="p-0 clearfix">
              <i class="fa fa-dollar bg-info p-4 px-5 font-2xl mr-3 float-left"></i>
              <div class="h5 text-info mb-0 pt-3">${{reportSummary[0].subtotal}}</div>
              <div class="text-muted text-uppercase font-weight-bold font-xs">Total sin descuento</div>
            </b-card-body>
          </b-card>
        </b-col>
        <b-col cols="12" sm="6" lg="4">
          <b-card :no-body="true">
            <b-card-body class="p-0 clearfix">
              <i class="fa fa-calculator bg-warning p-4 px-5 font-2xl mr-3 float-left"></i>
              <div class="h5 text-warning mb-0 pt-3">${{reportSummary[0].average}}</div>
              <div class="text-muted text-uppercase font-weight-bold font-xs">Promedio de ventas</div>
            </b-card-body>
          </b-card>
        </b-col>
        <b-col cols="12" sm="6" lg="4">
          <div class="progress-group">
            <div class="progress-group-header">
              <i class="fa fa-check-square"></i>
              <span class="title"> Ventas con descuento</span>
              <span class="ml-auto font-weight-bold">{{discount.true[0].count}}</span>
            </div>
            <div class="progress-group-bars">
              <b-progress height={} :max="reportSummary[0].count" class="progress-xs" :value="discount.true[0].count"
                          variant="warning"></b-progress>
            </div>
          </div>
          <div class="progress-group mb-5">
            <div class="progress-group-header">
              <i class="fa fa-minus-square"></i>
              <span class="title"> Ventas sin descuento</span>
              <span class="ml-auto font-weight-bold">{{discount.false[0].count}}</span>
            </div>
            <div class="progress-group-bars">
              <b-progress height={} class="progress-xs" :value="discount.false[0].count" variant="warning"
                          :max="reportSummary[0].count"></b-progress>
            </div>
          </div>
        </b-col>
        <b-col cols="12" sm="6" lg="4">
          <b-card :no-body="true">
            <b-card-body class="p-0 clearfix">
              <i class="fa fa-hashtag bg-danger p-4 px-5 font-2xl mr-3 float-left"></i>
              <div class="h5 text-danger mb-0 pt-3">{{reportSummary[0].count}}</div>
              <div class="text-muted text-uppercase font-weight-bold font-xs">Cantidad de ventas</div>
            </b-card-body>
          </b-card>
        </b-col>
      </b-row>


    </div>

    <h1>Gráficos año 2019</h1>

    <b-card-group columns class="card-columns">
      <b-card header="Reporte de ventas">
        <div class="chart-wrapper">
          <reporte-ventas chartId="chart-bar-01"/>
        </div>
      </b-card>
      <b-card header="Tipos de ventas">
        <div class="chart-wrapper">
          <ventas-descuentos chartId="chart-line-01"/>
        </div>
      </b-card>
      <b-card header="Valor venta real vs esperada">
        <div class="chart-wrapper">
          <real-versus-esperada></real-versus-esperada>
        </div>
      </b-card>
      <!--
      <b-card header="Productos vendidos">
        <div class="chart-wrapper">
          <productos-vendidos chartId="chart-doughnut-01"/>
        </div>
      </b-card>
      -->
    </b-card-group>



  </div>

</template>
<script>
  import InventarioItems from './charts/InventarioItems'
  import ReporteVentas from './charts/ReporteVentas'
  import VentasDescuentos from './charts/VentasDescuentos'
  import ProductosVendidos from './charts/ProductosVendidos'
  import RealVersusEsperada from './charts/VentaRealVersusEsperada'

  import axios from 'axios'
  import Datepicker from "vuejs-datepicker/dist/vuejs-datepicker.esm"
  import {es} from 'vuejs-datepicker/dist/locale'

  export default {
    name: 'charts',
    components: {
      InventarioItems,
      ReporteVentas,
      VentasDescuentos,
      ProductosVendidos,
      RealVersusEsperada,
      Datepicker
    },
    data: function () {
      return {
        es: es,
        dateFormat: 'yyyy-MM-dd',
        salesReportRange: '2',
        salesRangeOptions: [
          {text: 'Últimos 6 meses', value: '1'},
          {text: 'Último año', value: '2'},
          {text: 'Últimos 2 años', value: '3'}
        ],
        reportSummary: [],
        toMonth: new Date(),
        fromMonth: new Date(),
        toDay: '',
        fromDay: '',
        discount: []
      }
    },
    methods: {
      list() {
        let me = this;
        const ruta = this.ruta;
        const url = ruta + '/salesReport?from=' + me.fromMonth + '&to=' + me.toMonth;


        axios.get(url)
          .then(function (r) {
            const response = r.data;

            me.reportSummary = response.report.reportSummary;
            me.discount = response.report.discount;
            console.log(me.discount)

            console.log(me.reportSummary);
            console.log(response.report);
            console.log(me.reportSummary[0].subtotal);

          })
          .catch(function (error) {
            console.log(error);
          });

      },
      dateSetup() {
        let me = this;
        const ruta = this.ruta;
        axios.get(ruta + '/dateSetup')
          .then(function (r) {
            const response = r.data;

            me.fromMonth = response.dateSetup.inferior.date;
            me.toMonth = response.dateSetup.superior.date;

            me.list();
          })
          .catch(function (error) {
            console.log(error);
          });
      },
      onChange() {
        let me = this;
        me.list();
      }
    }, mounted() {
      this.dateSetup();
      //this.list();
    }

  }
</script>

<style>

</style>
