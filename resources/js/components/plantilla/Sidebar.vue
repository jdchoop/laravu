<template>
    <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img :src="ruta + '/img/adminLTElogo.png'"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Sistema laravel y vue</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img :src="ruta + '/img/avatar.png'" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">DANIEL COTRINA</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <router-link class="nav-link active" :to="'/'">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </router-link>
            
          <li class="nav-header">OPERACIONES</li>
          <li class="nav-item">
            <router-link class="nav-link" :to="'/pedido'">
              <i class="nav-icon fas fa-cash-register"></i>
              <p>
                PEDIDOS
                <span class="badge badge-info right">2</span>
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" :to="'/cliente'">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                CLIENTES
              </p>
            </router-link>
          </li>
          
          <li class="nav-header">CONFIGURACION</li>
          <li class="nav-item">
            <router-link class="nav-link" :to="'/categoria'">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>CATEGORIAS</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" :to="'/producto'">
              <i class="nav-icon fas fa-apple-alt"></i>
              <p>PRODUCTOS</p>
            </router-link>
          </li>

          <li class="nav-header">ADMINISTRACION</li>
          <li class="nav-item">
            <router-link class="nav-link" :to="'/usuario'">
              <i class="nav-icon fas fa-users"></i>
              <p>USUARIOS</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" :to="'/rol'">
              <i class="nav-icon fas fa-unlock-alt"></i>
              <p>ROLES</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" :to="'/permiso'">
              <i class="nav-icon fas fa-key"></i>
              <p>PERMISOS</p>
            </router-link>
          </li>
          
          <li class="nav-header">REPORTES</li>
          <li class="nav-item">
            <router-link class="nav-link" :to="'/pedido'">
              <i class="nav-icon fas fa-file-export"></i>
              <p>PEDIDOS</p>
            </router-link>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

</template>

<script>
export default {
    props: ['ruta'],
}
</script>

<style>

</style>