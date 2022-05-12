<template>
  <div>
    <!--    Liste des étudiants-->
    <section>
      <div class="mt-3">
        <b-button-group>
          <b-button id="dev" @click="toggleLicence($event)" :style="style.dev">DEV</b-button>
          <b-button id="com" @click="toggleLicence($event)" :style="style.com"
            >COM</b-button
          >
        </b-button-group>
        <b-card-text>Liste des étudiants</b-card-text>
        <b-icon
          icon="plus-circle-fill"
          style="color: #f96197"
          font-scale="1.5"
          @click="addStudent"
          >+</b-icon
        >
      </div>
    </section>
    <!--    Recherche-->
    <section>
      <autocomplete-users
        v-bind:options="suggestions"
        input="etudiant"
        placeholder="Rechercher un étudiant"
      ></autocomplete-users>
    </section>
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
    getAllStudents() {
      getUsers(JSON.parse(localStorage.getItem("tpzId"))).then((res) => {
        console.log(res.data);
      });
    },
  },
};
</script>

<style scoped></style>
