<template>
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Crear Usuario</h1>
          </div><!-- /.col v-on -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->

      <div class="content container-fluid">
        <div class="card">
          <div class="card-header">
            <div class="card-tools">
              <router-link class="btn btn-info btn-sm" :to="'/usuario'">
                <i class="fas fa-arrow-left"></i>Regresar
              </router-link>             
            </div>
          </div>
          <div class="card-body">
            <div class="container-fluid">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Formulario Registrar Usuario</h3>
                </div>
                <div class="card-body">
                  <form action="" role="form">
                    <div class="row">

                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="" class="col-md-3 col-form-label">Primer Nombre</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control" 
                            v-model="fillCrearUsuario.cPrimerNombre" @keyup.enter="setRegistrarUsuario" >
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="" class="col-md-3 col-form-label">Segundo Nombre</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control" 
                            v-model="fillCrearUsuario.cSegundoNombre" @keyup.enter="setRegistrarUsuario" >
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="" class="col-md-3 col-form-label">Apellido</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control" 
                            v-model="fillCrearUsuario.cApellido" @keyup.enter="setRegistrarUsuario" >
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="" class="col-md-3 col-form-label">Usuario</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control" 
                            v-model="fillCrearUsuario.cUsuario" @keyup.enter="setRegistrarUsuario" >
                          </div>
                        </div>
                      </div>
                        <div class="col-md-6">
                        <div class="form-group row">
                          <label for="" class="col-md-3 col-form-label">correo</label>
                          <div class="col-md-9">
                            <input type="email" class="form-control" 
                            v-model="fillCrearUsuario.cCorreo" @keyup.enter="setRegistrarUsuario" >
                          </div>
                        </div>
                      </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label for="" class="col-md-3 col-form-label">Contraseña</label>
                          <div class="col-md-9">
                            <el-input placeholder="Ingrese Contraseña" v-model="fillCrearUsuario.cContraseña" 
                            @keyup.enter="setRegistrarUsuario" show-password></el-input>
                            
                          </div>
                        </div>
                      </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                          <label for="" class="col-md-3 col-form-label">ROL</label>
                          <div class="col-md-9">
                            <el-select v-model="fillCrearUsuario.nIdRol" placeholder="Seleccione un ROL" clearable>
                            <el-option
                              v-for="item in listRoles"
                              :key="item.id"
                              :label="item.name"
                              :value="item.id">
                            </el-option>
                          </el-select></div>
                        </div>
                      </div>


                    <div class="col-md-6">
                        <div class="form-group row">
                          <label for="" class="col-md-3 col-form-label">Fotografia</label>
                          <div class="col-md-9">
                            <input type="file" class="form-control" @change='getFile'>
                          </div>
                        </div>
                      </div>

                    </div>
                  </form>
                </div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="setRegistrarUsuario"
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
      fillCrearUsuario:{
        nIdRol: '',
        cPrimerNombre : '',
        cSegundoNombre : '',
        cApellido: '',
        cUsuario: '',
        cCorreo: '',
        cContraseña: '',
        oFotografia: ''
      },
      listRoles:[],
      form: new FormData,
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
  mounted(){
    this.getListarRoles();
  },
  methods: {
      limpiarCriterios(){
          this.fillCrearUsuario.cPrimerNombre = '';
          this.fillCrearUsuario.cSegundoNombre = '';
          this.fillCrearUsuario.cApellido = '';
          this.fillCrearUsuario.cUsuario = '';
          this.fillCrearUsuario.cCorreo = '';
          this.fillCrearUsuario.cContraseña = '';
          this.fillCrearUsuario.oFotografia = '';
         
      },
      abrirModal(){
          this.modalShow = !this.modalShow;
      },
      getListarRoles(){
      this.fullscreenLoading = true;
      var url = '/administracion/rol/getListarRoles'
      axios.get(url).then(response => {
        
        
        this.listRoles = response.data;
         this.fullscreenLoading = false;
      })
     
      
    },
      getFile(e){
          this.fillCrearUsuario.oFotografia = e.target.files[0];
      },
      setRegistrarUsuario(){
           if (this.validarRegistrarUsuario()){
            this.modalShow = true;
               return;
           }
           this.fullscreenLoading = true;

          if (!this.fillCrearUsuario.oFotografia || this.fillCrearUsuario.oFotografia == undefined) {
              this.setGuardarUsuario(0);
          } else {
              this.setRegistrarArchivo();
          }
      },
      setRegistrarArchivo(){
          this.form.append('file', this.fillCrearUsuario.oFotografia)
          const config = { headers: { 'Content-Type':'multipart/form-data'}}
          var url = '/archivo/setRegistrarArchivo'
          axios.post(url, this.form, config).then(response =>{
              console.log(response)
              var nIdFile = response.data[0].nIdFile;
              this.setGuardarUsuario(nIdFile);
          }).catch(error => {
              if (error.response.status == 401) {
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
            })
      },
      setGuardarUsuario(nIdFile){
          var url = '/administracion/usuario/setRegistrarUsuario'
          axios.post(url, {
              'cPrimerNombre' : this.fillCrearUsuario.cPrimerNombre,
              'cSegundoNombre' : this.fillCrearUsuario.cSegundoNombre,
              'cApellido' : this.fillCrearUsuario.cApellido,
              'cUsuario' : this.fillCrearUsuario.cUsuario,
              'cCorreo' : this.fillCrearUsuario.cCorreo,
              'cContraseña' : this.fillCrearUsuario.cContraseña,
              'oFotografia' : nIdFile,
          }).then(response => {
            // console.log(response.data);
              this.setEditarRolByUsuario(response.data);
          })
      },
      setEditarRolByUsuario(nIdUsuario){
        
              var url = '/administracion/usuario/setEditarRolByUsuario'
              axios.post(url, {
              'nIdUsuario' : nIdUsuario,
              'nIdRol' : this.fillCrearUsuario.nIdRol
              
          }).then(response => {
              
               this.fullscreenLoading = false;
              this.$router.push('/usuario');

          }).catch(error => {
              if (error.response.status == 401) {
                this.$router.push({name: 'login'})
                location.reload();
                sessionStorage.clear();
                this.fullscreenLoading = false;
              }
            })
        }, 
      validarRegistrarUsuario(){
          this.error = 0;
          this.mensajeError = [];

          if (!this.fillCrearUsuario.cPrimerNombre) {
              this.mensajeError.push("El Primer Nombre es obligatorio")
          }
          if (!this.fillCrearUsuario.cSegundoNombre) {
              this.mensajeError.push("El 2DO Nombre es obligatorio")
          }
          if (!this.fillCrearUsuario.cUsuario) {
              this.mensajeError.push("El USER Nombre es obligatorio")
          }
          if (!this.fillCrearUsuario.cCorreo) {
              this.mensajeError.push("El EMAIL Nombre es obligatorio")
          }
          if (!this.fillCrearUsuario.cContraseña) {
              this.mensajeError.push("El PASS Nombre es obligatorio")
          }
          if (!this.fillCrearUsuario.nIdRol) {
              this.mensajeError.push("seleccione el rol")
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