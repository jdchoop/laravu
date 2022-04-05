<template>
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Crear Pedido</h1>
          </div><!-- /.col v-on -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->

      <div class="content container-fluid">
        <div class="card">
          <div class="card-header">
            <div class="card-tools">
              <router-link class="btn btn-info btn-sm" :to="'/pedido'">
                <i class="fas fa-arrow-left"></i>Regresar
              </router-link>             
            </div>
          </div>
          <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
            <div class="card " :class="(switchCliente) ? 'card-info' : 'card-success'">
                <div class="card-header">
                  <h3 class="card-title">Formulario {{(switchCliente) ? 'REGISTRAR' : 'BUSCAR'}} Cliente</h3>
                </div>
                <div class="card-body">
                  <form action="" role="form">
                    <div class="row">
                    <div class="col-md-3">
                        <vs-switch square v-model="switchCliente" @change="limpiarCriterios">
                            <template #off>
                                <i class="fas fa-plus-square"></i>
                            </template>
                            <template #on>
                                <i class="fas fa-search"></i>
                            </template>
                        </vs-switch>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group row">
                          <label for="" class="col-md-12 col-form-label">Documento</label>
                          <div class="col-md-12">
                              <template v-if="switchCliente">
                                  <input type="text" class="form-control" 
                                v-model="fillCrearCliente.cDocumento" @keyup.enter="setRegistrarPedido" >
                              </template>
                            <template v-else>
                                <el-autocomplete
                                        class="inline-input"
                                        v-model="cBusqueda"
                                        :fetch-suggestions="querySearch"
                                        placeholder="Buscar.."
                                        :trigger-on-focus="true"
                                        size="medium"
                                        @select="clientSelect"
                                    >
                                    <i
                                        class="el-icon-search el-input__icon"
                                        slot="suffix"
                                        >
                                    </i>
                                    <!-- <el-button slot="append" icon="el-icon-search"></el-button> -->
                                    </el-autocomplete>
                            </template>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label for="" class="col-md-12 col-form-label">Nombre</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" 
                            v-model="fillCrearCliente.cNombre" @keyup.enter="setRegistrarPedido" 
                            :disabled="(switchCliente) ? false : true">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label for="" class="col-md-12 col-form-label">Apellidos</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" 
                            v-model="fillCrearCliente.cApellido" @keyup.enter="setRegistrarPedido" 
                            :disabled="(switchCliente) ? false : true">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label for="" class="col-md-12 col-form-label">CORREO</label>
                          <div class="col-md-12">
                            
                            <vs-input v-model="fillCrearCliente.cEmail"  @keyup.enter="setRegistrarPedido" 
                            placeholder="vuesax@gmail.com" :disabled="(switchCliente) ? false : true">
                                    <template v-if="validEmail" #message-success>
                                    CORREO VALIDO
                                    </template>
                                    <template v-if="!validEmail && fillCrearCliente.cEmail !== ''" #message-danger>
                                    CORREO INVALIDO
                                    </template>
                                </vs-input>
                            
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label for="" class="col-md-12 col-form-label">TELEFONO</label>
                          <div class="col-md-12">
                            <input type="tel" class="form-control" 
                            v-model="fillCrearCliente.cTelefono" @keyup.enter="setRegistrarPedido" 
                            :disabled="(switchCliente) ? false : true">
                          </div>
                        </div>
                      </div>

                    </div>
                  </form>
                </div>
                <div class="card-footer">
                  <div class="row">
                    <button v-if="fTotalPedido > 0 && listPedidos.length > 0"
                     class="btn btn-flat btn-info btnFull" @click.prevent="setRegistrarPedido"
                    v-loading.fullscreen.lock="fullscreenLoading">Registrar</button>
                    
                  </div>
                </div>
              </div>
            </div>

        <div class="col-md-8">
            <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">SELECCIONE SUS PRODUCTOS</h3>
                </div>

            <div class="card-body table-responsive">
              <vs-tooltip not-arrow right>
                <vs-button
                @click.prevent="agregarProducto"
                    square
                    icon
                    color="rgb(59,222,200)"
                    gradient>
                    <i class="fas fa-plus-square"></i>
                  </vs-button>
                <template #tooltip>
                  AGREGA UN PRODUCTO
                </template>
              </vs-tooltip>

               

                  <template v-if="listPedidos.length">
                    <div class="scrollTable">
                  <table class="table table-hover table-head-fixed text-nowrap projects">
                    <thead>
                      <tr>
                        <th>ARTICULO</th>
                        <th>STOCK</th>
                        <th>PRECIO</th>
                        <th>SUB TOTAL</th>
                        <th>ACCIONES</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in listPedidos " :key="index" 
                      >
                        <td>
                          <el-select v-model="item.nIdProducto" 
                          @change="obtenerProducto(item.nIdProducto, index)"
                          placeholder="Seleccione un PRODUCTO" clearable filterable="">
                            <el-option
                              v-for="item in listProductos"
                              :key="item.id"
                              :label="item.name"
                              :value="item.id">
                            </el-option>
                          </el-select>
                            <!-- ira un check para seleccionar permisos -->
                           
                        </td>
                        <td>
                          <el-input-number v-model="item.nStock" controls-position="right" 
                                     :min="1" :max="(item.nIdProducto) ? item.nStockFlag : 1" >
                          </el-input-number>
                        </td>
                        <td v-text="item.fPrecio"></td>
                        <td >{{ item.fSubTotal = item.nStock * item.fPrecio }}</td>
                        <td>
                          <el-tooltip class="item" effect="dark" content="REMOVER PRODUCTO" placement="left">
                          <vs-button
                          @click.prevent="removerProducto(index)"
                              square
                              icon
                              danger>
                              <i class="fas fa-trash"></i>
                            </vs-button>
                          
                        </el-tooltip>
                        </td>
                        <!-- <td>
                          <router-link class="btn btn-primary btn-sm" :to="{name:'usuario.ver', params:{id: item.id}}">
                            <i class="fas fa-folder">Ver</i>
                          </router-link>
                          <template v-if="item.state == 'A'">
                          <router-link class="btn btn-info btn-sm" :to="{name:'usuario.editar', params:{id: item.id}}">
                            <i class="fas fa-pencil-alt">Editar</i>
                          </router-link>
                        </td> -->
                      </tr>
                    </tbody>
                  </table>
                  </div>
                  <el-row :gutter="20">
                    <el-col :span="16">
                      <vs-input border v-model="cComentario" placeholder="COMENTARIO" />
                    </el-col>
                    <el-col :span="8">
                      <strong>Total : </strong>{{fTotalPedido = totalPedido}}
                      </el-col>
                  </el-row>
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
              

              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Bandeja de Resultados</h3>
                </div>
                
              </div>

            </div>
          </div>
        </div>
        <div class="modal fade" :class="{ show:modalShow}" :style="modalShow ? mostrarModal : ocultarModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">SISTEMA</h5>
                    <button class="close" @click="abrirModal"></button>
                </div>
                <div class="modal-body">
                    <div class="callout callout-danger" style="padding:5px " v-for="(item, index) in mensajeError" :key="index" v-text="item">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="close" @click="abrirModal">Cerrar</button>
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
      fillCrearCliente:{
          nIdCliente: '',
          cDocumento: '',
        cNombre : '',
        cApellido: '',
        cEmail: '',
        cTelefono: ''
      },
      switchCliente: false,

      cBusqueda: '',
      listClientes: [],
      listClientesFilter: [],

      listProductos: [],
      listPedidos: [],
      cComentario:'',
      fTotalPedido:0,

      listProductos: [],
      
      fullscreenLoading: false,
      modalShow: false,
      mostrarModal:{
          display: 'block',
          background: '#0000006b',
      },
      ocultarModal:{
          display: 'none',
      },
      error: 0,
      mensajeError: []
    }
  },
  computed: {
     validEmail() {
          return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.fillCrearCliente.cEmail)
        },
      totalPedido(){
        return this.listPedidos.reduce(function(valorAnterior, valorActual){
          return valorAnterior + parseFloat(valorActual.fSubTotal)
        },0)
      }
  },
  mounted(){
      this.agregarProducto();
      this.getListarClientes();
      this.getListarProductos();
  },

  methods: {
        querySearch(queryString, cb) {
        var links = this.listClientesFilter;
        var results = queryString ? links.filter(this.createFilter(queryString)) : links;
        // call callback function to return suggestion objects
        cb(results);
      },
      createFilter(queryString) {
        return (link) => {
          return (link.value.toLowerCase().indexOf(queryString.toLowerCase()) != -1);
        };
      },
      
      getListarClientes(){
          var ruta = '/operacion/cliente/getListarClientes'
          axios.get(ruta).then( response => {
              this.listClientes = response.data;
              this.filterListarClientes();   
          }).catch(error => {
          if (error.response.status == 401) {
            this.$router.push({name: 'login'})
            location.reload();
            sessionStorage.clear();
            this.fullscreenLoading = false;
          }
        })
      },
      filterListarClientes(){
          let me = this;
          me.listClientesFilter = [];
          me.listClientes.map(function(x, y){
              
                me.listClientesFilter.push({
                  'value' : x.document + ' - '+ x.fullname,
                  'link' : x.id
                }) 
              
          })
      },
      clientSelect(item) {
        let rpta = this.listClientes.filter (cliente => {
          return (String(cliente.id).indexOf(String(item.link)) != -1);
        })
        
        this.fillCrearCliente.nIdCliente = rpta[0].id;
        this.fillCrearCliente.cDocumento = rpta[0].document;
        this.fillCrearCliente.cNombre = rpta[0].name;
          this.fillCrearCliente.cApellido = rpta[0].lastname;
          this.fillCrearCliente.cEmail = rpta[0].email;
          this.fillCrearCliente.cTelefono = rpta[0].phone;
      },
      getListarProductos(){
          var ruta = '/configuracion/producto/getListarProductos'
          axios.get(ruta).then( response => {
              this.listProductos = response.data;
              
          }).catch(error => {
          if (error.response.status == 401) {
            this.$router.push({name: 'login'})
            location.reload();
            sessionStorage.clear();
            this.fullscreenLoading = false;
          }
        })
      },
      limpiarCriterios(){
        this.fillCrearCliente.nIdCliente = '';
        this.cBusqueda = '';
        this.fillCrearCliente.cDocumento = '';
        this.fillCrearCliente.cNombre = '';
          this.fillCrearCliente.cApellido = '';
          this.fillCrearCliente.cEmail = '';
          this.fillCrearCliente.cTelefono = '';
      },
      abrirModal(){
          this.modalShow = !this.modalShow;
      },
      agregarProducto(){
        let me = this;
         if (this.listPedidos.length == 0){
           this.listPedidos.push({
           'nIdProducto': '',
           'nStock': '',
           'nStockFlag': '',
           'fPrecio': '',
           'fSubTotal': ''
         })
         } else {
           let contador = 0;
           this.listPedidos.map(function(x, y){
             if (!x.nIdProducto || !x.nStock || !x.fPrecio || !x.fSubTotal) {
               contador++;

               const noti = me.$vs.notification({
                square: true,
                color: 'rgb(59,222,200)',
                title: 'ALERTA',
                text: 'DEBE COMPLETAR LA INFORMACION DE LA FILA' + (y+1)
              })
             }
           })
           if (contador == 0) {
              this.listPedidos.push({
              'nIdProducto': '',
              'nStock': '',
              'fPrecio': '',
              'fSubTotal': ''
            })
           }
         }
      },
      removerProducto(index){
        this.$delete(this.listPedidos, index);
      },
      obtenerProducto(nIdProducto, index){
        let me = this;
        if (!nIdProducto) {
          Vue.nextTick(function () {
              me.listPedidos[index].nStock = '';
              me.listPedidos[index].nStockFlag = '';
              me.listPedidos[index].fPrecio = '';
          })
          
        }
           let contador = 0;
           this.listPedidos.map(function(x, y){
             if (x.nIdProducto == nIdProducto && y != index) {
               contador++;

               const noti = me.$vs.notification({
                square: true,
                color: 'rgb(59,222,200)',
                title: 'ALERTA',
                text: 'este producto ya se encuentra agregado en LA FILA' + (y+1)
              })
             }
           })
           if (contador == 0) {
              let rpta = this.listProductos.filter (producto => {
                return (String(producto.id).indexOf(String(nIdProducto)) != -1);
              })
              if (rpta[0].stock > 0){
                this.listPedidos[index].nStock = rpta[0].stock;
                this.listPedidos[index].nStockFlag = rpta[0].stock;
                this.listPedidos[index].fPrecio = rpta[0].price;
              } else {
                this.listPedidos[index].nIdProducto = '';
                const noti = me.$vs.notification({
                square: true,
                color: 'rgb(59,222,200)',
                title: 'ALERTA',
                text: 'este producto no cuenta con stock disponible' 
                })
              }
              
           } else {
             this.listPedidos[index].nIdProducto = '';
           }      
      },
      
      setRegistrarPedido(){
          if (this.validarRegistrarPedido()) {
              this.modalShow = true;
              return;
          }
          this.fullscreenLoading = true;
          if (this.switchCliente) {
              this.setRegistrarCliente();
          } else {
            this.setGuardarPedido(this.fillCrearCliente.nIdCliente);
          }
          
      },
      setRegistrarCliente(){
        this.fullscreenLoading = true;
          var url = '/operacion/cliente/setRegistrarCliente'
          axios.post(url, {
              'cDocumento' : this.fillCrearCliente.cDocumento,
              'cNombre' : this.fillCrearCliente.cNombre,
              'cApellido' : this.fillCrearCliente.cApellido,
              'cEmail' : this.fillCrearCliente.cEmail,
              'cTelefono' : this.fillCrearCliente.cTelefono
          }).then(response => {
              let nIdCliente = response.data[0].nIdCliente;
              this.setGuardarPedido(nIdCliente);
          }).catch(error => {
          if (error.response.status == 401) {
            this.$router.push({name: 'login'})
            location.reload();
            sessionStorage.clear();
            this.fullscreenLoading = false;
          }
        })
      },
      setGuardarPedido(nIdCliente){
        this.fullscreenLoading = true;
          var url = '/operacion/pedido/setRegistrarPedido'
          axios.post(url, {
              'nIdCliente' : nIdCliente,
              'cComentario' : this.cComentario,
              'fTotalPedido' : this.fTotalPedido,
              'listPedido' : this.listPedidos,
              
          }).then(response => {
            this.fullscreenLoading = true;
              this.$router.push('/pedido')
          }).catch(error => {
          if (error.response.status == 401) {
            this.$router.push({name: 'login'})
            location.reload();
            sessionStorage.clear();
            this.fullscreenLoading = false;
          }
        })
      },
      validarRegistrarPedido(){
          this.error = 0;
          this.mensajeError = [];

          if (this.switchCliente) {
            if (!this.fillCrearCliente.cDocumento) {
                this.mensajeError.push("El DOC es obligatorio")
            }
            if (!this.fillCrearCliente.cNombre) {
                this.mensajeError.push("url NOM obligatorio")
            }
            if (!this.fillCrearCliente.cApellido) {
                this.mensajeError.push("url APE obligatorio")
            }
            if (!this.fillCrearCliente.cEmail) {
                 if (!this.validEmail) {
                this.mensajeError.push("verifique el correo , formato invalido")
               }
            }
          } else {
            if (!this.fillCrearCliente.nIdCliente) {
                this.mensajeError.push("carga el cliente")
            }
          }
         
          if (this.mensajeError.length) {
              this.error = 1;
          }
          return this.error;
      }
  }
}
</script>

<style>
  .el-row {
    margin-bottom: 20px;
    
  }
  .el-col {
    border-radius: 4px;
  }
  .bg-purple-dark {
    background: #99a9bf;
  }
  .bg-purple {
    background: #d3dce6;
  }
  .bg-purple-light {
    background: #e5e9f2;
  }
  .grid-content {
    border-radius: 4px;
    min-height: 36px;
  }
  .row-bg {
    padding: 10px 0;
    background-color: #f9fafc;
  }
</style>