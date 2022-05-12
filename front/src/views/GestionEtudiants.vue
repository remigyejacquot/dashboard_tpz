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
<!--    Recherche-->
    <section>
      <autocomplete-users v-bind:options="suggestions"  input="etudiant" placeholder="Rechercher un étudiant"></autocomplete-users>
    </section>
  </div>
</template>


<script>
import {getUsers} from "../../api/users";
import AutocompleteUsers from "../components/autocompleteUsers";

export default {
  name: "GestionEtudiants",
  components: { AutocompleteUsers },
  data() {
    return{
      suggestions:{}
    }
  },
  mounted() {
    this.getAllStudents()
  },
  methods:{
    toggleLicence() {
      console.log('change licence')
    },
    addStudent() {
      console.log('add new student')
    },
    getAllStudents() {
      getUsers(JSON.parse(localStorage.getItem("tpzId"))).then(res=>{
        console.log(res.data)
      })
    }
  }
}
</script>

<style scoped>

</style>
