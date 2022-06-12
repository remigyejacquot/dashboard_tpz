<template>
  <div id="nav" class="col-2">
    <!-- <b-img-lazy v-bind="mainProps" center :src="require('./assets/tpz_logo.png')" fluid alt="Logo Troyes Point Zero"></b-img-lazy> -->
        <b-navbar id="navbar" toggleable="lg" type="light" class="d-flex flex-column justify-content-start align-items-center">
          <b-navbar-brand href="#" class="w-100 m-0 mt-5 px-1 d-flex flex-column align-items-center justify-content-center">
            <b-img :src="require('../assets/default-user-image.png')" rounded="circle" class="avatar"/>
            <div class="d-flex flex-row justify-content-center align-items-center w-100">
              <p class="mb-0 text-center">{{user.firstname}} {{user.lastname}} &nbsp;</p>
              <div class="d-flex" v-if="user.tpzRolesArray && user.tpzRolesArray.includes('chef de projet')"><font-awesome-icon class="crown-icon" icon="fa-solid fa-crown" /></div>
            </div>
            <div class="text-small">Licence  {{user.is_dev ? 'dev' : 'com'}}</div>
          </b-navbar-brand>

          <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

          <b-collapse id="nav-collapse" is-nav class="align-items-start w-100">
            <b-navbar-nav class="d-flex flex-column w-100">
              <li class="nav-item">
                <router-link :to="{ name: 'Dashboard' }" class="d-flex flex-column justify-content-center align-items-center">
                  <div class="nav-item-color d-flex flex-column justify-content-center align-items-center w-100">
                    <font-awesome-icon icon="fa-solid fa-chalkboard-user" />
                    <span>Dashboard</span>
                  </div>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link :to="{ name: 'Projects' }" class="d-flex flex-column justify-content-center align-items-center">
                  <div class="nav-item-color d-flex flex-column justify-content-center align-items-center w-100">
                    <font-awesome-icon icon="fa-solid fa-user-group" />
                    <span>Mes projets</span>
                  </div>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link :to="{ name: 'GestionEtudiants' }" class="d-flex flex-column justify-content-center align-items-center">
                  <div class="nav-item-color d-flex flex-column justify-content-center align-items-center w-100">
                    <font-awesome-icon icon="fa-solid fa-gear" />
                    <span class="text-center w-100">Gérer les utilisateurs</span>
                  </div>
                </router-link>
              </li>
              <b-nav-item class="d-flex flex-column justify-content-center align-items-center">
                  <div class="nav-item-color d-flex flex-column justify-content-center align-items-center w-100" @click="logout">
                    <font-awesome-icon icon="fa-solid fa-arrow-right-from-bracket" />
                    <span>Déconnexion</span>
                  </div>
              </b-nav-item>
            </b-navbar-nav>
          </b-collapse>
        </b-navbar>
  </div>
</template>

<script>
import {getUser} from "../../api/users";

export default {
  name: "NavSidebar",
  data() {
    return {
      mainProps: { width: 200, height: 200},
      user: {},
      devAgencies: [],
      comAgencies: [],
      type: "",
    }
  },
  methods: {
    logout() {
      localStorage.clear();
      this.$router.push("/");
    },
    fetchUserInfo(id) {
        getUser(id).then((res) => {
        this.user = res.data;
        this.type = res.data.is_dev ? "dev" : "com";
        localStorage.setItem("user", JSON.stringify(res.data))
      });
    },
  },
  created() {
    const userId = JSON.parse(localStorage.getItem("user")).id ||
    JSON.parse(localStorage.getItem("user"))["@id"].substr(-1)
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

#nav {
  padding: 0;
}

#navbar {
  background-color: white;
  height: 100%;
  width: 100%;
}

.nav-item-color {
  color:  #FAD26E;
}

.nav-item {
  border-top: #FAD26E solid 1px;
  border-bottom: #FAD26E solid 1px;
}

a {
  text-decoration: none !important;
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

.crown-icon {
  color: #F7B000;
}

.router-link-active {
  background-color: #FAD26E;
}

.router-link-active .nav-item-color {
  color:  #ffffff;
}

.avatar {
  width: 100px;
}

</style>
