<template>
  <div class="d-flex flex-row">
    <div>
      <b-nav class="d-flex flex-column">
        <b-nav-item active><router-link :to="{ name: 'Groupes'}">Groupes</router-link></b-nav-item>
        <b-nav-item><router-link :to="{ name: 'Bureau'}">Bureau</router-link></b-nav-item>
        <b-nav-item><router-link :to="{ name: 'GestionEtudiants'}">etudiants</router-link></b-nav-item>
        <b-nav-item><router-link to="/">profs</router-link></b-nav-item>
      </b-nav>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: "Gestion"
}
</script>

<style scoped>

</style>
