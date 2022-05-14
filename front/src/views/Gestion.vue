<template>
  <div class="d-flex flex-row menu-container">
    <div class="gestion-menu">
      <b-nav class="d-flex flex-column gestion-nav">
        <b-nav-item active>
          <router-link :to="{ name: 'Groupes'}">
            <font-awesome-icon icon="users" class="gestion-icones-menu" size="2x"/>
            Groupes
          </router-link>
        </b-nav-item>
        <b-nav-item>
          <router-link :to="{ name: 'Bureau'}">
            <font-awesome-icon icon="users-gear" class="gestion-icones-menu" size="2x"/>
            Bureau
          </router-link>
        </b-nav-item>
        <b-nav-item>
          <router-link to="/">
            <font-awesome-icon icon="user-pen" class="gestion-icones-menu" size="2x"/>
            etudiants
          </router-link>
        </b-nav-item>
        <b-nav-item>
          <router-link to="/">
            <font-awesome-icon icon="user-tie" class="gestion-icones-menu" size="2x"/>
            profs
          </router-link>
        </b-nav-item>
      </b-nav>
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