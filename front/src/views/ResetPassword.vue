<template>
  <div>
    <div class="d-flex justify-content-center align-items-center vh-100" v-if="isSent">
      <div class="container">
        <div class="form-card">
          <p class="m-0">Si un compte existe à l'adresse indiqué un email a été envoyé.</p>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center align-items-center vh-100" v-else>
      <div class="container">
        <div class="form-card">
          <b-form v-if="loading === false">
            <h1>Mot de passe oublié?</h1>
            <b-form-group
                id="input-group-1"
                label="Adresse email:"
                label-for="input-1"
                description="Renseignez votre adresse email de connexion"
            >
              <b-form-input
                  id="input-1"
                  v-model="email"
                  type="email"
                  placeholder="example@etudiant.univ-reims.fr"
                  required
              ></b-form-input>
            </b-form-group>
            <div class="d-flex justify-content-center row mt-3">
              <button class="valid-button px-2" @click="requestNewPassword">Nouveau mot de passe</button>
              <div class="d-flex justify-content-center mt-2">
                <router-link :to="{ name: 'Login' }" class="link-yellow"> Se connecter</router-link>
              </div>
            </div>
          </b-form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {resetPassword} from "../../api/resetPassword";

export default {
  name: "ResetPassword",
  data() {
    return {
      email: "",
      loading: false,
      isSent: false,
    }
  },
  methods: {
    requestNewPassword() {
      let userInfo = {
        email: this.email
      }
      resetPassword(userInfo)
      this.isSent = true
    }
  }
}
</script>

<style scoped>
.container {
  display: flex;
  justify-content: center;
}
.form-card {
  max-width: 800px;
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
  background-color: transparent;
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
