<template>
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Crear Permiso</h1>
          </div><!-- /.col v-on -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->

      <div class="content container-fluid">
        <div class="card">
          <div class="card-header">
            <div class="card-tools">
              <router-link class="btn btn-info btn-sm" :to="'/permiso'">
                <i class="fas fa-arrow-left"></i>Regresar
              </router-link>             
            </div>
          </div>
          <div class="card-body">
            <div class="container-fluid">
                 
                    <div class="card card-info">
                        <div class="card-header">
                        <h3 class="card-title">Formulario Registrar Permisos</h3>
                        </div>
                        <div class="card-body">
                        <form action="" role="form">
                            <div class="row">

                            <div class="col-md-12">
                                <div class="form-group row">
                                <label for="" class="col-md-3 col-form-label">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" 
                                    v-model="fillCrearPermiso.cNombre" @keyup.enter="setRegistrarPermiso" >
                                </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                <label for="" class="col-md-3 col-form-label">URL AMIGABLE</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" 
                                    v-model="fillCrearPermiso.cSlug" @keyup.enter="setRegistrarPermiso" >
                                </div>
                                </div>
                            </div>

                            </div>
                        </form>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                            <div class="col-md-4 offset-4">
                                <button class="btn btn-flat btn-info btnWidth" @click.prevent="setRegistrarPermiso"
                                v-loading.fullscreen.lock="fullscreenLoading">Registrar</button>
                                <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriterios">Limpiar</button> 
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
      fillCrearPermiso:{
        cNombre : '',
        cSlug: ''
      },
      
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
    
  },
  

  methods: {
      limpiarCriterios(){
          this.fillCrearPermiso.cNombre = '';
          this.fillCrearPermiso.cSlug = '';
      },
      abrirModal(){
          this.modalShow = !this.modalShow;
      },
      getListarPermisosByRol(){
          var ruta = '/administracion/rol/getListarPermisosByRol'
          axios.get(ruta).then( response =>{
              this.listPermisos = response.data;
              this.filterPermisosByRol();
          })
      },
      filterPermisosByRol(){
          let me = this;
          me.listPermisos.map(function(x, y){
              me.listPermisosFilter.push({
              'id': x.id,
              'name': x.name,
              'slug': x.slug,
              'checked': false
              })  
          });
      },
      marcarFila(index){
          this.listPermisosFilter[index].checked = !this.listPermisosFilter[index].checked;
      },
      setRegistrarPermiso(){
          if (this.validarRegistrarPermiso()){
              this.modalShow = true;
              return;
          }
          this.fullscreenLoading = true;
          var url = '/administracion/permiso/setRegistrarPermiso'
          axios.post(url, {
              'cNombre' : this.fillCrearPermiso.cNombre,
              'cSlug' : this.fillCrearPermiso.cSlug
          }).then(response => {
              //console.log("Registro de usuario exitoso");
              this.fullscreenLoading = false;
              this.$router.push('/permiso');
          }).catch(error => {
            if (error.response.status == 401) {
              this.$router.push({name: 'login'})
              location.reload();
              sessionStorage.clear();
              this.fullscreenLoading = false;
            }
          })
      },
      validarRegistrarPermiso(){
          this.error = 0;
          this.mensajeError = [];

          if (!this.fillCrearPermiso.cNombre) {
              this.mensajeError.push("El Nombre es obligatorio")
          }
          if (!this.fillCrearPermiso.cSlug) {
              this.mensajeError.push("url campo obligatorio")
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

</style>