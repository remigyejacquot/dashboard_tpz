<template>
  <div>
    <b-button class="modifier"  v-b-modal.update-project>
      <font-awesome-icon icon="pen" size="1x" class="mr-2"/>
        modifier
    </b-button>
    <b-modal id="update-project" title="Gestion du projet" hide-footer class="custom-modal">
      <b-form>
        <b-form-group id="name-input" label="Nom du projet" label-for="name" class="d-flex align-items-center">
          <b-form-input id="name" v-model="name" type="text" placeholder="Nom du projet" required></b-form-input>
        </b-form-group>
        <div class="mt-3 valid-button-wrapper">
          <button class="valid-button">Valider</button>
        </div>
      </b-form>
      <div class="bottom-modal w-100">
        <button class="red-button float-start mt-2">Supprimer</button>
      </div>
    </b-modal>
  </div>
</template>

<style>
@import '../assets/css/modal.css';
</style>

<script>
export default {
  name: "formUpdateProjet",
  data () {
    return {
      name: ''
    }
  },
}
</script>

<style scoped>

</style>