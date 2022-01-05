<template>
  <div class="container">
    <div class="form">
      <router-link to="/register" class="btn-left-part" href=""
        >S'inscrire</router-link
      >
      <label for="email">Adresse mail</label>
      <input id="email" type="email" value="" v-model="email" />
      <label for="password">Mot de passe</label>
      <input id="password" type="password" value="" v-model="password" />
      <button class="btn-right-part" @click="connexion">Se connecter</button>
      <router-link to="/"> Mot de passe oublié? </router-link>
    </div>
  </div>
</template>

<script>
import router from "../router";
import { authentication } from "../../api/login";

export default {
  name: "Login",
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    async connexion() {
      let userToConnect = {
        email: this.email,
        password: this.password,
      };
      await authentication(userToConnect).then((resp) => {
        const token = resp.data.token;
        const userData = atob(resp.data.token.split(".")[1]); //on récupère les données de l'utilisateur, par défaut, login, rôles
        localStorage.setItem("user", userData); // store the user in localstorage
        localStorage.setItem("usertoken", token); // store the token in localstorage
        router.push("/dashboard").catch((err) => {
          console.log("err", err);
          localStorage.removeItem("user");
          localStorage.removeItem("userToken");
        });
      });
    },
  },
};
</script>

<style>
.container {
  display: flex;
  justify-content: center;
}
.form {
  display: flex;
  width: 50%;
  flex-direction: column;
}
</style>
