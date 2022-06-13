<template>
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
      <div class="form-card">
        <b-form v-if="loading === false" id="user-register" class="form">
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
              id="input-firstname"
              label="Prénom:"
              label-for="firstname"
          >
            <b-form-input
                id="firstname"
                v-model="firstname"
                type="text"
                placeholder="Prénom"
                required
            ></b-form-input>
          </b-form-group>
          <b-form-group
              id="input-lastname"
              label="Nom:"
              label-for="lastname"
          >
            <b-form-input
                id="lastname"
                v-model="lastname"
                type="text"
                placeholder="Nom"
                required
            ></b-form-input>
          </b-form-group>
          <b-form-group id="spe" label="Spécialité" label-for="spe">
            <b-form-select v-model="isDev" :options="options"></b-form-select>
          </b-form-group>
          <b-form-group
              id="input-password"
              label="Mot de passe:"
              label-for="password"
          >
            <b-form-input
                id="password"
                v-model="password"
                type="password"
                placeholder="Mot de passe"
                required
            ></b-form-input>
          </b-form-group>
          <b-form-group
              id="input-confirmPassword"
              label="Confirmer le mot de passe:"
              label-for="confirmPassword"
          >
            <b-form-input
                id="confirmPassword"
                v-model="confirmPassword"
                type="password"
                placeholder="Mot de passe"
                required
            ></b-form-input>
          </b-form-group>
          <p id="error">{{error}}</p>
          <div class="d-flex justify-content-center w-100">
            <b-button class="btn-yellow text-white mt-4" @click="addUser">Créer mon compte</b-button>
          </div>
          <div class="d-flex justify-content-center mt-1 w-100">
            <router-link :to="{ name: 'Login' }" class="link-yellow"> Se connecter</router-link>
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
import axiosInstance from "../../api/axiosInstance";

export default {
  name: "Register",
  data() {
    return {
      loading: false,
      error:'',
      email: '',
      lastname: '',
      firstname: '',
      licence: '',
      password:'',
      confirmPassword: '',
      isDev: '',
      options : [
        { value: '', text: '' },
        { value: true, text: 'Développement' },
        { value: false, text: 'Communication' }
      ],
    };
  },
  methods: {
    async addUser() {
      let isEmpty = false;
      document.querySelectorAll("#user-register input, select").forEach((e) => {
        if (e.value === "") {
          isEmpty = true;
          e.classList.add("empty-field");
        }
      });
      if (!isEmpty) {
        if (this.password === this.confirmPassword) {
          this.loading = true;
          axiosInstance.post(
              "/addUsers/register",
              {
                email: this.email,
                lastname: this.lastname,
                firstname: this.firstname,
                password: this.password,
                roles: ["ROLE_USER"],
                isDev: this.isDev
              }
          ).then(() => {
                this.loading = false;
                this.$router.push({name: "Login"});
          }).catch((err) => this.error = err)
        } else {
          this.error =
              "Les mots de passe ne correspondent pas";
        }
      }
    }
  },
}
</script>

<style scoped>
@import '../assets/css/groupes.css';
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