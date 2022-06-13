<template>
<div class="row">
  <navSidebar/>
  <div class="container col-10 p-0">
    <div class="d-flex flex-row menu-container" v-if="user.roles.includes('ROLE_ADMIN') || user.tpzRolesArray.includes('president') || user.tpzRolesArray.includes('vice-president') ">
      <div class="gestion-menu">
        <b-nav class="d-flex flex-column gestion-nav">
          <b-nav-item :to="{ name: 'Groupes'}" :active='$route.name === "Groupes"'>
              <font-awesome-icon icon="users" class="gestion-icones-menu" size="2x"/>
              Groupes
          </b-nav-item>
          <b-nav-item :to="{ name: 'Bureau'}" :active='$route.name === "Bureau"'>
              <font-awesome-icon icon="users-gear" class="gestion-icones-menu" size="2x"/>
              Bureau
          </b-nav-item>
          <b-nav-item :to="{ name: 'GestionEtudiants'}" :active='$route.name === "GestionEtudiants"' v-if="user.roles.includes('ROLE_ADMIN')">
              <font-awesome-icon icon="user-pen" class="gestion-icones-menu" size="2x"/>
              etudiants
          </b-nav-item>
          <b-nav-item :to="{ name: 'GestionProfesseurs'}" :active='$route.name === "GestionProfesseurs"' v-if="user.roles.includes('ROLE_ADMIN')">
              <font-awesome-icon icon="user-tie" class="gestion-icones-menu" size="2x"/>
              profs
          </b-nav-item>
        </b-nav>
      </div>
      <router-view></router-view>
    </div>
    <div class="d-flex flex-row menu-container justify-content-center align-items-center" v-else>
      <div class="bg-white d-flex justify-content-center align-items-center h-25 px-4" style="border-radius: 10px">
        <p>Vous n'avez pas les accès necessaires pour accéder à ce contenu.</p>
      </div>
    </div>
  </div>
</div>

</template>

<style>
@import '../assets/css/gestion-menu.css';
</style>

<script>
import NavSidebar from "../components/navSidebar";
export default {
  name: "Gestion",
  components: { NavSidebar },
  data() {
    return {
      user: JSON.parse(localStorage.getItem('user'))
    }
  }
}
</script>

<style scoped>

</style>
