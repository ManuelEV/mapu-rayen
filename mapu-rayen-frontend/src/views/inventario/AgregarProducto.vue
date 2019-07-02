<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col md="6">
        <b-card>
          <div slot="header">
            <strong>Agregar productos al inventario</strong>
          </div>
          <b-form>

            <p>Si tiene un nuevo producto, por favor llene los siguientes datos para agregarlos al inventario</p>

            <hr>

            <h4>Nombre del producto</h4>
            <b-form-group>
              <b-input-group>
                <b-input-group-prepend>
                  <b-input-group-text><i class="fa fa-quote-left fa-lg"></i></b-input-group-text>
                </b-input-group-prepend>
                <b-form-input v-model="name" type="text" placeholder="Ingrese el nombre aquí"></b-form-input>
              </b-input-group>
            </b-form-group>

            <h4>Precio estimado del producto</h4>
            <b-form-group>
              <b-input-group>
                <b-input-group-prepend>
                  <b-input-group-text><i class="fa fa-dollar fa-lg"></i></b-input-group-text>
                </b-input-group-prepend>
                <b-form-input v-model="value" type="number" placeholder="Ingrese un número, por ejemplo: 1000"></b-form-input>
              </b-input-group>
            </b-form-group>

            <h4>Stock inicial del producto</h4>
            <b-form-group>
              <b-input-group>
                <b-input-group-prepend>
                  <b-input-group-text><i class="fa fa-archive fa-lg"></i></b-input-group-text>
                </b-input-group-prepend>
                <b-form-input v-model="stock" type="number" placeholder="Ingrese un número, por ejemplo: 1"></b-form-input>
              </b-input-group>
            </b-form-group>

            <br><br>
            <div slot="footer">
              <b-button v-on:click="validar" size="m" variant="primary"><i class="fa fa-dot-circle-o"></i> Agregar producto</b-button>
              <b-button type="reset" size="m" variant="danger"><i class="fa fa-ban"></i> Reset</b-button>
            </div>
          </b-form>
        </b-card>
      </b-col>

    </b-row>


  </div>
</template>

<script>
  import axios from 'axios';
  export default {
    name: 'agrear-producto',
    data() {
      return {
        name: '',
        value: 0,
        stock: 0
      }
    },
    methods: {
      validar(){
        let me = this;
        if (me.name == ''){
          console.log('ERROR')
        }else{
          me.store();
        }
      },
      store() {

        let me = this;
        const ruta = this.ruta;

        axios.post(ruta + '/item', {
          'name': this.name,
          'value': this.value,
          'stock': this.stock,
        }).then(function (response) {
          if (response.data.status == "OK") {
            console.log('Ingreso exitoso')
            me.name='';
            me.value='';
            me.stock='';
          } else {

          }
        }).catch(function (error) {
          console.log(error);

        });
      }
    },
    mounted() {

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
