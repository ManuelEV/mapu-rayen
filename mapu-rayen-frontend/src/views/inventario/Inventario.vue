<template>
  <div class="animated fadeIn">


    <b-row>
      <b-col md="6" class="my-1">
        <b-form-group label-cols-sm="3" label="Filtro" class="mb-0">
          <b-input-group>
            <b-form-input v-model="filter" placeholder="Escriba para filtrar"></b-form-input>
            <b-input-group-append>
              <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
      </b-col>
    </b-row>
    <b-col md="9" class="my-1">

      <b-table striped hover small :items="itemsArray" :fields="fields"
               :filter="filter" :current-page="currentPage" :per-page="perPage" stacked="md">

        <template v-slot:cell(agregar)="data" v-slot-scope="data">
          <!-- `data.value` is the value after formatted by the Formatter -->
          <a :href="`#`"><i class="fa fa-minus-circle fa-lg"></i><i class="fa fa-plus-circle fa-lg"></i></a>
        </template>
        <template v-slot:cell(editar)="data" v-slot-scope="data">
          <!-- `data.value` is the value after formatted by the Formatter -->
          <a :href="`#`">Editar</a>
        </template>
        <template v-slot:cell(eliminar)="data" v-slot-scope="data">
          <!-- `data.value` is the value after formatted by the Formatter -->
          <a :href="`#`">Eliminar</a>
        </template>
      </b-table>
    </b-col>
    <b-row>
      <b-col md="6" class="my-1">
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          class="my-0"
        ></b-pagination>
      </b-col>
    </b-row>

  </div>

</template>

<script>
  import cTable from '../base/Table.vue'
  import axios from 'axios';


  export default {
    name: 'tables',
    components: {
      cTable
    },
    data: () => {
      return {
        filter: null,
        totalRows: 1,
        currentPage: 1,
        perPage: 10,
        pageOptions: [5, 10, 15],
        fields: [
          {key: 'id', label: 'ID', sortable: true},
          {key: 'name', label: 'Nombre del producto', sortable: true},
          {key: 'value', label: 'Precio del producto', sortable: true},
          {key: 'stock', label: 'Stock en el inventario', sortable: true},
          {key: 'editar', label: 'Opciones'},
          {key: 'eliminar', label: ' '},
          {key: 'agregar', label: ' '}
        ],
        itemsArray: []
      }
    },
    methods: {
      async list() {
        let me = this;
        const ruta = this.ruta;

        axios.get(ruta + '/item')
          .then(function (r) {
            const response = r.data;

            me.itemsArray = response.items;
            me.totalRows = me.itemsArray.length;
          })
          .catch(function (error) {
            console.log(error);
          });

      }
    }, mounted() {
      this.list();
    }
  }
</script>


