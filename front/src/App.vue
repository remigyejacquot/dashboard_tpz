<template>
  <div id="app ">
<!--    <b-img-lazy v-bind="mainProps" center :src="require('./assets/tpz_logo.png')" fluid alt="Logo Troyes Point Zero"></b-img-lazy>-->
<!--    <b-button @click="logout">Déconnexion</b-button>-->
    <router-view />
  </div>
</template>

<script>

export default {
  data() {
    return {
      mainProps: { width: 200, height: 200}
    }
  },
  methods: {
    logout() {
      localStorage.clear();
      this.$router.push("/");
    }
  }
}
</script>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
