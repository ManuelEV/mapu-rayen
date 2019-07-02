<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col md="6">
        <b-card>
          <div slot="header">
            <strong>Ingresar venta</strong>
          </div>
          <b-form>

            <h4>Valor actual estimado de la venta: <b>${{valorActualVenta}}</b></h4>
            <hr>
            <p>Lista de productos seleccionados, para agregar uno nuevo, seleccione la opción de agregar uno nuevo.</p>

            <table class="table table-hover">
              <thead>
              <tr>
                <th>Nombre del producto</th>
                <th>Precio</th>
                <th>Opciones</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="producto in selectedItems">
                <td>{{producto.name}}</td>
                <td>${{producto.value}}</td>
                <td><a href="#" @click.prevent="deleteFromList(producto)"><i class="fa fa-trash fa-lg"></i></a></td>
              </tr>
              </tbody>
            </table>

            <hr>

            <h4>Ingrese el valor de la venta</h4>
            <b-form-group>
              <b-input-group>
                <b-input-group-prepend>
                  <b-input-group-text><i class="fa fa-dollar fa-lg"></i></b-input-group-text>
                </b-input-group-prepend>
                <b-form-input v-model="valorRealVenta" type="number"></b-form-input>
              </b-input-group>
            </b-form-group>
            <br><br>
            <div>
              <b-alert :show="dismissCountDown"
                       dismissible
                       variant="success"
                       @dismissed="dismissCountdown=0"
                       @dismiss-count-down="countDownChanged">
                Venta registrada con éxito <i class="fa fa-check-square fa-lg"></i>
              </b-alert>
            </div>
            <div slot="footer">
              <b-button v-on:click="validateSale" size="m" variant="primary"><i class="fa fa-dot-circle-o"></i> Realizar venta</b-button>
              <b-button v-on:click="reset()" type="reset" size="m" variant="danger"><i class="fa fa-ban"></i> Reset</b-button>
            </div>
          </b-form>
        </b-card>
      </b-col>


      <b-col md="6">
        <b-card>
          <div slot="header">
            <strong>Lista de productos</strong>
          </div>
          <b-form>

            <table class="table table-hover">
              <thead>
              <tr>
                <th>Nombre del producto</th>
                <th>Precio</th>
                <th>Agregar producto para vender: <i class="fa fa-plus-circle fa-lg"></i></th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="producto in itemList">
                <td>{{producto.name}}</td>
                <td>${{producto.value}}</td>
                <td><a href="#" @click.prevent="list(producto)"><i class="fa fa-plus-circle fa-lg"></i></a> </td>
              </tr>
              </tbody>
            </table>

          </b-form>
        </b-card>
      </b-col>

    </b-row>


  </div>
</template>

<script>
  import axios from 'axios';
  export default {
    name: 'forms',
    data() {
      return {
        //Alerta venta
        dismissSecs: 2,
        dismissCountDown: 0,
        showDismissibleAlert: false,
        //venta
        selected: [], // Must be an array reference!
        show: true,
        valorActualVenta: 0,
        itemList: [],
        selectedItems: [],
        valorRealVenta: 0,
        discount: 0
      }
    },
    methods: {
      validateSale(){
        let me = this;
        if (me.selectedItems.length>0){
          me.storeSale();
        }
      },
      storeSale(){
        let me = this;
        const ruta = this.ruta;

        if(me.valorRealVenta<me.valorActualVenta){
          me.discount = 1;
        }else{
          me.discount = 0;
        }

        axios.post(ruta + '/sale', {
          'total': me.valorRealVenta,
          'subtotal': me.valorActualVenta,
          'discount': me.discount,
          'selectedItems': me.selectedItems,
        }).then(function (response) {
          if (response.data.status == "OK") {
            console.log('Ingreso exitoso')
            me.discount=0;
            me.selectedItems=[];
            me.valorActualVenta=0;
            me.valorRealVenta=0;

            me.showAlert();
          } else {

          }
        }).catch(function (error) {
          console.log(error);

        });
      },
      list(producto){
        let me = this;
        const ruta = this.ruta;
        axios.get(ruta + '/item')
          .then(function (r) {
            const response = r.data;
            me.itemList = response.items;
          })
          .catch(function (error) {
            console.log(error);
          });

        if (producto!=='just list') {
          me.updateSelectedItems(producto);
        }
      },
      updateSelectedItems(producto){
        let me = this;
        const value = parseInt(producto.value);
        const current = parseInt(me.valorActualVenta);
        me.valorActualVenta = current+value;
        me.selectedItems.push(producto);
      },
      reset(){
        let me = this;
        me.valorActualVenta = 0;
        me.selectedItems=[];

      },
      deleteFromList(producto){
        let me = this;
        const value = parseInt(producto.value);
        const current = parseInt(me.valorActualVenta);
        me.valorActualVenta = current-value;
        const itemIndex = me.selectedItems.valueOf(producto);

        me.selectedItems.splice(itemIndex,1);
      },
      countDownChanged (dismissCountDown) {
        this.dismissCountDown = dismissCountDown
      },
      showAlert () {
        this.dismissCountDown = this.dismissSecs
      }

    },
    mounted() {
      this.list('just list');
    }
  }
</script>

<style scoped>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.5s;
  }

  .fade-enter,
  .fade-leave-to {
    opacity: 0;
  }
</style>
