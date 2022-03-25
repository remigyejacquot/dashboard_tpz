<template>
  <div class="container">
    <b-form v-if="loading === false">
      <b-form-group
        id="input-group-1"
        label="Adresse email:"
        label-for="input-1"
        description="Renseignez votre adresse email univ-reims"
      >
        <b-form-input
          id="input-1"
          v-model="email"
          type="email"
          placeholder="example@etudiant.univ-reims.fr"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="input-group-2"
        label="Mot de passe:"
        label-for="input-2"
      >
        <b-form-input
          id="input-2"
          v-model="password"
          type="password"
          required
        ></b-form-input>
      </b-form-group>
      <div class="d-flex justify-content-center row mt-3">
        <b-button variant="primary" @click="connexion" class="col-3"
          >Se connecter</b-button
        >
        <div class="d-flex justify-content-center mt-2">
          <b-link to="/resetpassword"> Mot de passe oublié? </b-link>
        </div>
      </div>
    </b-form>
    <div class="d-flex align-items-center" v-if="loading === true">
      <b-spinner class="ml-auto"></b-spinner>
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
      loading: false,
    };
  },
  methods: {
    async connexion() {
      this.loading = true;
      let userToConnect = {
        email: this.email,
        password: this.password,
      };
      await authentication(userToConnect).then((resp) => {
        this.loading = false;
        const token = resp.data.token;
        const userData = atob(resp.data.token.split(".")[1]); //on récupère les données de l'utilisateur, par défaut, login, rôles
        localStorage.setItem("user", userData); // store the user in localstorage
        localStorage.setItem("userToken", token); // store the token in localstorage
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

<style scoped>
.container {
  display: flex;
  justify-content: center;
}
form {
  width: 100%;
  text-align: start;
}
label {
  margin: 0.5em 0;
}
a {
  text-align: center;
}
</style>
