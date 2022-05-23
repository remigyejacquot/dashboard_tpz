<template>
  <div class="d-flex flex-row menu-container">
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
        <b-nav-item to="/">
            <font-awesome-icon icon="user-pen" class="gestion-icones-menu" size="2x"/>
            etudiants
        </b-nav-item>
        <b-nav-item to="/">
            <font-awesome-icon icon="user-tie" class="gestion-icones-menu" size="2x"/>
            profs
    </div>
    <router-view></router-view>
  </div>
</template>

<style>
@import '../assets/css/gestion-menu.css';
</style>

<script>
export default {
  name: "Gestion",
}
</script>

<style scoped>

</style>
