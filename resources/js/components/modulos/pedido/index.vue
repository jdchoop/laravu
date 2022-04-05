<template>
<div>
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pedidos</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

      <div class="content container-fluid">
        <div class="card">
          <div class="card-header">
            <div class="card-tools">
              <template v-if="listRolPermisosByUsuario.includes('pedido.crear')">
                <router-link class="btn btn-info btn-sm" :to="{name: 'pedido.crear'}">
                <i class="fas fa-plus-square"></i>Nuevo Pedido
                </router-link> 
              </template>
                          
            </div>
          </div>
          <div class="card-body">
            <div class="container-fluid">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Criterios de Busqueda</h3>
                </div>
                <div class="card-body">
                  <form action="" role="form">
                    <div class="row">

                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="" class="col-md-3 col-form-label">Nombre</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control" 
                            v-model="fillBsqPedido.cNombre" @keyup.enter="getListarPedidos" >
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="" class="col-md-3 col-form-label">#DOCUMENTO</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control" 
                            v-model="fillBsqPedido.cDocumento" @keyup.enter="getListarPedidos">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="" class="col-md-3 col-form-label">#PEDIDO</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control" 
                            v-model="fillBsqPedido.cPedido" @keyup.enter="getListarPedidos">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="" class="col-md-3 col-form-label">ESTADO</label>
                          <div class="col-md-9">
                            <el-select v-model="fillBsqPedido.nIdEstado" placeholder="Seleccione una ESTADO" clearable>
                            <el-option
                              v-for="item in listEstados"
                              :key="item.value"
                              :label="item.label"
                              :value="item.value">
                            </el-option>
                          </el-select></div>
                        </div>
                      </div>

                    </div>
                  </form>
                </div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="getListarPedidos"
                    v-loading.fullscreen.lock="fullscreenLoading">Buscar</button>
                    <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriteriosBsq">Limpiar</button>
                    </div>  
                  </div>
                </div>
              </div>

              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Bandeja de Resultados</h3>
                </div>
                <div class="card-body table-responsive">
                  <template v-if="listarPedidosPaginated.length">
                    
                  <table class="table table-hover table-head-fixed text-nowrap projects">
                    <thead>
                      <tr>
                        <th>#PEDIDO</th>
                        <th>#DOCUMENTO</th>
                        <th>CLIENTE</th>
                        <th>TOTAL</th>
                        <th>VENDEDOR</th>
                        <th>ESTADO</th>
                        <th>ACCIONES</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in listarPedidosPaginated " :key="index">
                        
                        <td v-text="item.pedido"></td>
                        <td v-text="item.documento"></td>
                        <td v-text="item.cliente"></td>
                        <td v-text="item.total"></td>
                        <td v-text="item.vendedor"></td>
                        <td v-text="item.estado"></td>
                        
                        <td>
                          
                            <template v-if="listRolPermisosByUsuario.includes('pedido.ver')">
                              <button class="btn btn-info btn-sm" >
                                <i class="fas fa-file-pdf">VER PDF</i>
                              </button>
                            </template>
                            <template v-if="listRolPermisosByUsuario.includes('pedido.rechazar')">
                              <button class="btn btn-danger btn-sm" >
                                <i class="fas fa-trash">RECHAZAR</i>
                              </button>
                            </template>
                        </td>
                        
                        
                      </tr>
                    </tbody>
                  </table>
                  <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                      <li class="page-item" v-if="pageNumber > 0">
                        <a href="#" class="page-link" @click.prevent="prevPage">Ant</a>
                      </li>
                      <li class="page-item " v-for="(page, index) in pagesList" :key="index"
                      :class="[page == pageNumber ? 'active' : '']">
                        <a href="#" class="page-link" @click.prevent="selectPage(page)">{{ page+1 }}</a>
                      </li>
                      <li class="page-item" v-if="pageNumber < pageCount -1">
                        <a href="#" class="page-link" @click.prevent="nextPage">Post</a>
                      </li>
                    </ul>
                  </div>
                  </template>
                  <template v-else>
                    <div class="callout callout-info">
                      <h5>NO SE ENCONTRARON RESULTADOS...</h5>
                    </div>
                  </template>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    
</template>

<script>
export default {
  data(){
    return{
      fillBsqPedido:{
        cNombre : '',
        cDocumento: '',
        cPedido: '',
        nIdEstado:''
      },
      listPedidos: [],
      listEstados: [
        {value: 'A', label: 'Activo'},
        {value: 'I', label: 'Inactivo'}
      ],
      listRolPermisosByUsuario: JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario')),
      pageNumber: 0,
      fullscreenLoading: false,
      perPage: 5
    }
  },
  computed: {
    pageCount() {
      let a = this.listPedidos.length,
          b = this.perPage;
          return Math.ceil(a / b);
    },
    listarPedidosPaginated(){
      let inicio = this.pageNumber * this.perPage,
          fin =inicio + this.perPage;
          return this.listPedidos.slice(inicio, fin);
    },
    pagesList() {
      let a = this.listPedidos.length,
          b = this.perPage;
          let pageCount = Math.ceil( a / b);
          let count = 0,
          pagesArray =[];
          while (count < pageCount){
            pagesArray.push(count);
            count++;
          }
          return pagesArray;
          
    }
  },
  
  methods: {
    limpiarCriteriosBsq(){
      this.fillBsqPedido.cNombre = '';
      this.fillBsqPedido.cDocumento = '';
      this.fillBsqPedido.cPedido = '';
      this.fillBsqPedido.nIdEstado = '';
    },
    limpiarBandejaUsuarios(){
      this.listPedidos = [];
    },
    
    getListarPedidos(){
      this.fullscreenLoading = true;
      var url = '/operacion/pedido/getListarPedidos'
      axios.get(url, {
        params: {
          'cNombre' : this.fillBsqPedido.cNombre,
          'cDocumento' : this.fillBsqPedido.cDocumento,
          'cPedido' : this.fillBsqPedido.cPedido,
          'nIdEstado' : this.fillBsqPedido.nIdEstado
        }
      }).then(response => {
        this.inicializarPaginacion();
        
        this.listPedidos = response.data;
         this.fullscreenLoading = false;
      }).catch(error => {
        if (error.response.status == 401) {
          this.$router.push({name: 'login'})
          location.reload();
          sessionStorage.clear();
          this.fullscreenLoading = false;
        }
      })
     
      
    },
    nextPage() {
      this.pageNumber++;
    },
    prevPage() {
      this.pageNumber--;
    },
    selectPage(page){
      this.pageNumber = page;
    },
    inicializarPaginacion(){
      this.pageNumber = 0;
    }
    
  }
}
</script>

<style>

</style>