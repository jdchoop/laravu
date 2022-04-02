.<template>
  <div class="login-box">
  <div class="login-logo">
      <router-link :to="{name:'login'}">
          <b>Iniciar sesion</b>
      </router-link>
    <a href="../../index2.html"><b>INICIAR SESION</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Ingresa tus  cuentas para iniciar Sesión</p>

      <form  method="post">
        <div class="input-group mb-3">
          <input type="email" @keyup.enter="login"  v-model="fillLogin.cEmail" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" @keyup.enter="login"   v-model="fillLogin.cContraseña"  class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
      </form>
      
    <div class="row">
        <div class="col-md-12 ">
            <span v-if="error" >
                <div v-for="(e, index) in mensajeError" 
            :key="index" v-text="e" class="callout callout-danger"></div>
            </span>
        </div>
    </div>

      <div class="social-auth-links text-center mb-3">  
        <button  class="btn btn-flat btn-block btn-danger" @click.prevent="login" v-loading.fullscreen.lock="fullscreenLoading">
           INICIAR SESION
        </button>
      </div>
      
    </div>
    
    <!-- /.login-card-body -->
  </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            fillLogin : {
                cEmail: '',
                cContraseña: ''
            },
            listRolPermisosByUsuario:[],
            listRolPermisosByUsuarioFilter:[],
            fullscreenLoading: false,
            error: 0,
            mensajeError: []
        }
    },

    methods:{
        login() {
            if (this.validarLogin()){
                return;
            }
            this.fullscreenLoading = true;
            var url = '/authenticate/login'
            axios.post(url, {
                
                    'cEmail' : this.fillLogin.cEmail,
                    'cContraseña' : this.fillLogin.cContraseña
                
            }).then(response =>{
                //console.log(response.data)
                if (response.data.code == 401) {
                    this.loginFailed();
                }
                if (response.data.code == 200) {
                    //this.loginSuccess();
                    this.getListarRolPermisosByUsuario(response.data.authUser)
                }
                this.fullscreenLoading = false;
            })
        },
        getListarRolPermisosByUsuario(authUser){
          var ruta = '/administracion/usuario/getListarRolPermisosByUsuario'
          axios.get(ruta, {
             params: {
                'nIdUsuario' : authUser.id
              }
          }).then( response => {
              this.listRolPermisosByUsuario = response.data;
              this.filterListarRolPermisosByUsuario(authUser);   
          })
      },
      filterListarRolPermisosByUsuario(authUser){
          let me = this;
          me.listRolPermisosByUsuario.map(function(x, y){
              me.listRolPermisosByUsuarioFilter.push(x.slug)  
          })
          sessionStorage.setItem('listRolPermisosByUsuario', JSON.stringify(me.listRolPermisosByUsuarioFilter));
          sessionStorage.setItem('authUser', JSON.stringify(authUser));
          this.loginSuccess();
      },
        validarLogin() {
            this.error = 0; 
            this.mensajeError = [];

            if(!this.fillLogin.cEmail) {
                this.mensajeError.push('El correo debe  es un campo obligatorio')
            }
            if(!this.fillLogin.cContraseña) {
                this.mensajeError.push('El Contraseña es un campo obligatorio')
            }
            if(this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        },
        loginFailed(){
            this.error = 0;
            this.mensajeError = [];
            
            this.mensajeError.push('Estas credenciales no coinciden con nuestros registros');
            this.fillLogin.cContraseña='';
            if(this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        },
        loginSuccess(){
            this.$router.push({name: 'dashboard.index'})
            location.reload();
        }
    },
}
</script>

<style>

</style>