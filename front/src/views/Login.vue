<template>
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
      <div class="form-card">
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
          <p class="error text-center">{{ error }}</p>
          <div class="d-flex justify-content-center align-items-center flex-column mt-3">
            <b-button variant="primary" @click="connexion" class="btn-yellow"
              >Se connecter</b-button
            >
            <div class="d-flex justify-content-center mt-2">
              <b-link to="/resetpassword" class="link-yellow"> Mot de passe oublié? </b-link>
            </div>
          </div>
        </b-form>
        <div class="d-flex align-items-center" v-if="loading === true">
          <b-spinner class="ml-auto"></b-spinner>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import router from "../router";
import { login } from "../../api/authentication";

export default {
  name: "Login",
  data() {
    return {
      email: "",
      password: "",
      loading: false,
      error : ''
    };
  },
  methods: {
    async connexion() {
      this.loading = true;
      let userToConnect = {
        email: this.email,
        password: this.password,
      };
      await login(userToConnect).then((resp) => {
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
      }).catch((error) => {
        this.loading = false;
        if(error.response && error.response.status === 401) {
          this.error = "L'email ou le mot de passe est incorrect"
        }
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
.form-card {
  max-width: 600px;
  background: #ffffff;
  padding: 5%;
  border-radius: 10px;
}
.btn-yellow {
  padding: 3% 5%;
  border-radius: 50px;
  border: none;
  background-color: #FAD26E;
}
.btn-yellow:hover {
  background-color: #ffde8c;
}
.link-yellow {
  text-decoration: none;
  color: #F7B000;
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
