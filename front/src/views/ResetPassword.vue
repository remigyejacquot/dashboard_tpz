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
      <div class="d-flex justify-content-center row mt-3">
        <b-button variant="primary" @click="connexion" class="col-3"
        >Se connecter</b-button
        >
        <div class="d-flex justify-content-center mt-2">
          <b-link to="/"> Mot de passe oublié? </b-link>
        </div>
      </div>
    </b-form>
    <div class="d-flex align-items-center" v-if="loading === true">
      <b-spinner class="ml-auto"></b-spinner>
    </div>
  </div>
</template>

<script>
export default {
  name: "ResetPassword",
  data() {
    return {
      email: ""
    }
  }
}
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
