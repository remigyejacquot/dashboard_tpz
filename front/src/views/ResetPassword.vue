<template>
  <div class="container">
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
        <b-button variant="primary" @click="resetPassword" class="col-3"
        >Nouveau mot de passe</b-button
        >
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
      email: "",
      loading: false,
      isSent: false,
    }
  },
  methods: {
    async resetPassword() {
      this.loading = true;

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
