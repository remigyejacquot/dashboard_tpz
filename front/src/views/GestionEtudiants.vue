<template>
  <div class="container">
    <!--    Liste des étudiants-->
    <b-card class="card item-list">
      <div class="mt-3">
        <b-button-group>
          <b-button id="dev" @click="toggleLicence($event)" :style="style.dev">DEV</b-button>
          <b-button id="com" @click="toggleLicence($event)" :style="style.com"
            >COM</b-button
          >
        </b-button-group>
        <b-icon
            icon="plus-circle-fill"
            style="color: #f96197"
            font-scale="1.5"
            @click="addStudent"
        >+</b-icon
        >
        <b-card-text>Liste des étudiants</b-card-text>
        <b-card-text v-for="user in users" :key="user.id">{{user}}</b-card-text>
      </div>
    </b-card>
    <!--    Recherche-->
    <b-card class="card item-search">
      <autocomplete-users
        v-bind:options="suggestions"
        input="etudiant"
        placeholder="Rechercher un étudiant"
      ></autocomplete-users>
    </b-card>
    <b-card class="card item-add">
      <b-card-text>Ajouter un étudiant</b-card-text>
    </b-card>
  </div>
</template>

<script>
import { getUsers } from "../../api/users";
import AutocompleteUsers from "../components/autocompleteUsers";
import {COLORS} from "../utils/colors";

export default {
  name: "GestionEtudiants",
  components: { AutocompleteUsers },
  data() {
    return {
      users:[],
      suggestions: {},
      type: "dev",
      style: {
        dev: "background-color: "+COLORS.yellow,
        com: "",
      },
    };
  },
  mounted() {
    this.getAllStudents();
  },
  methods: {
    getAllStudents() {
      getUsers(JSON.parse(localStorage.getItem("tpzId"))).then((res) => {
        this.users=res.data
      }).catch(err=>{
        console.log(err)
      })
    },
    toggleLicence(e) {
      console.log(e.target.id)
      /*si on clique sur DEV et que COM était sélectionné on switch sinon rien*/
      if (e.target.id === 'dev'){
        if(this.type === 'com'){
          this.type = 'dev'
          this.style = {
            dev: "background-color: "+COLORS.yellow,
            com: ""
          }
        }
      /*si on clique sur COM et que DEV était sélectionné on switch sinon rien*/
      } else if (e.target.id === 'com') {
        if(this.type === 'dev'){
          this.type = 'com'
          this.style = {
            dev: "",
            com: "background-color: "+COLORS.yellow,
          }
        }
      }
    },
    addStudent() {
      console.log("add new student");
    },
  },
};
</script>

<style scoped>
.container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: auto;
  grid-template-areas:
    "list search"
    "list add";
  justify-items: stretch;
}
.item-list {
  grid-area: list;
}
.item-search {
  grid-area: search;
}
.item-add {
  grid-area: add;
}
.card {
  margin: 2em;
}


</style>
