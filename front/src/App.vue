<template>
  <div id="app">
    <!-- <b-img-lazy v-bind="mainProps" center :src="require('./assets/tpz_logo.png')" fluid alt="Logo Troyes Point Zero"></b-img-lazy> -->
        <b-navbar id="navbar" toggleable="lg" type="light" class="d-flex flex-column justify-content-start align-items-center">
          <b-navbar-brand href="#" class="w-100 m-0 px-5">
            <!-- <b-img :src="require('./assets/gontrand.jpg')" rounded="circle" fluid class="pb-2"/> -->
            <div>Jean Jacques</div>
            <div class="text-small">Licence  {{user.is_dev ? 'DEV' : 'COM'}}</div>
          </b-navbar-brand>

          <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

          <b-collapse id="nav-collapse" is-nav class="align-items-start w-100">
            <b-navbar-nav class="d-flex flex-column w-100">
              <b-nav-item href="#" class="d-flex flex-column justify-content-center align-items-center py-2">
                <div class="nav-item-color d-flex flex-column justify-content-center align-items-center w-100">
                  <font-awesome-icon icon="fa-solid fa-chalkboard-user" />
                  <span>Dashboard</span>
                </div>
              </b-nav-item>
              <b-nav-item href="#" class="d-flex flex-column justify-content-center align-items-center py-2">
                <div class="nav-item-color d-flex flex-column justify-content-center align-items-center w-100">
                  <font-awesome-icon icon="fa-solid fa-user-group" />
                  <span>Mes projets</span>
                </div>
              </b-nav-item>
              <b-nav-item href="#" class="d-flex flex-column justify-content-center align-items-center py-2">
                <div class="nav-item-color d-flex flex-column justify-content-center align-items-center w-100">
                  <font-awesome-icon icon="fa-solid fa-gear" />
                  <span>Gérer les utilisateurs</span>
                </div>
              </b-nav-item>
                  <b-button @click="logout">Déconnexion</b-button>
            </b-navbar-nav>
          </b-collapse>
        </b-navbar>
      <div style="margin-left: 15rem;">
        <router-view />
      </div>
  </div>
</template>

<script>
import {getUser} from "../api/users";

export default {
  data() {
    return {
      mainProps: { width: 200, height: 200},
      user:{}
    }
  },
  methods: {
    logout() {
      localStorage.clear();
      this.$router.push("/");
    },
    fetchUserInfo(id) {
      getUser(id).then((res)=>{
        console.log(res.data)
        this.user = res.data
        localStorage.setItem("user", JSON.stringify(res.data)) // store the user in localstorage
      })
    },
  },
  created() {
    const userId = JSON.parse(localStorage.getItem("user")).id ||
    JSON.parse(localStorage.getItem("user"))["@id"].substr(-1)
    // console.log(userId)
    this.fetchUserInfo(userId)
  },
}
</script>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  background: #e5e5e5;
  min-height: 100vh;
  font-size: 1.1rem;
}

#navbar {
  background-color: white;
  height: 100vh;
  width: 15rem;
  position: fixed;
}

.nav-item-color {
  color:  #FAD26E;
}

.nav-item {
  border-top: #FAD26E solid 1px;
  border-bottom: #FAD26E solid 1px;
}

.nav-item:nth-child(1) {
  border-top: #FAD26E solid 2px;
}

.nav-item:nth-last-child(1) {
  border-bottom: #FAD26E solid 2px;
}

.text-small {
  font-size: 0.9rem;
}

</style>
