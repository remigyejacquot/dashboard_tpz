<template>
  <div>
<!--    Liste des étudiants-->
    <section>
      <div class="mt-3">
        <b-button-group>
          <b-button @click="toggleLicence">DEV</b-button>
          <b-button @click="toggleLicence">COM</b-button>
        </b-button-group>
        <b-card-text>Liste des étudiants</b-card-text>
        <b-icon icon="plus-circle-fill" style='color: #F96197;' font-scale="1.5" @click="addStudent">+</b-icon>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: "GestionEtudiants",
  methods:{
    toggleLicence() {
      console.log('change licence')
    },
    addStudent() {
      console.log('add new student')
    }
  }
}
</script>

<style scoped>

</style>
