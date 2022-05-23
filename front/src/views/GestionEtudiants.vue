<template>
  <div class="container">
    <!--    Liste des étudiants-->
    <b-card class="card item-list">
      <div class="mt-3">
        <div class="toggleBar mt-3">
          <b-button-group>
            <b-button id="dev" @click="toggleLicence($event)" :style="style.dev"
              >DEV</b-button
            >
            <b-button id="com" @click="toggleLicence($event)" :style="style.com"
              >COM</b-button
            >
          </b-button-group>
          <b-icon
            icon="plus-circle-fill"
            style="color: #f96197"
            font-scale="1.5"
            @click="showAddUserCard"
            >+</b-icon
          >
        </div>
        <div class="mt-3">
          <b-card-text>Liste des étudiants</b-card-text>
          <div class="itemStudent pt-1 pb-1" v-for="user in users" :key="user.id">
            {{ user.lastname }} {{ user.firstname }}
            <div>
              <b-button id="update" @click="updateUser"> modifier </b-button>
              <b-button id="delete" @click="deleteUser" class="pe-0"> supprimer </b-button>
            </div>
          </div>
        </div>
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
<!--    Ajouter un étudiant-->
    <b-card class="card item-add" v-if="showAddUserCardValue">
      <b-card-text
        >Ajouter un étudiant en licence {{ type.toUpperCase() }}</b-card-text
      >
      <div>
        <b-form-group label="Nom" label-for="input-lastname" class="m-2">
          <b-form-input
            id="input-lastname"
            v-model="userToAdd.lastname"
            :state="lastnameValidation"
            placeholder="Nom de l'étudiant"
            lazy-formatter
            :required="true"
          ></b-form-input>
          <b-form-invalid-feedback :state="lastnameValidation">
            Le nom doit être renseigné
          </b-form-invalid-feedback>
        </b-form-group>
        <b-form-group label="Prénom" label-for="input-firstname" class="m-2"
          ><b-form-input
            id="input-firstname"
            v-model="userToAdd.firstname"
            :state="firstnameValidation"
            placeholder="Prénom de l'étudiant"
            lazy-formatter
            :required="true"
          ></b-form-input>
          <b-form-invalid-feedback :state="firstnameValidation">
            Le prenom doit être renseigné
          </b-form-invalid-feedback>
        </b-form-group>
        <b-form-group label="Email" label-for="input-email" class="m-2"
          ><b-form-input
            id="input-email"
            v-model="userToAdd.email"
            :state="emailValidation"
            placeholder="Email de l'étudiant"
            lazy-formatter
            :required="true"
          ></b-form-input>
          <b-form-invalid-feedback :state="emailValidation">
            L'email doit être renseigné et être au bon format (@)
          </b-form-invalid-feedback>
        </b-form-group>
        <b-button
          type="submit"
          id="submit-btn"
          :style="bgColors.yellow"
          @click="addNewStudent"
          >Ajouter</b-button
        >
      </div>
    </b-card>
  </div>
</template>

<script>
import { addStudent, getUsers } from "../../api/users";
import AutocompleteUsers from "../components/autocompleteUsers";
import { COLORS } from "../utils/colors";

export default {
  name: "GestionEtudiants",
  components: { AutocompleteUsers },
  data() {
    return {
      showAddUserCardValue : false,
      users: [],
      userToAdd: {
        email: "",
        firstname: "",
        lastname: "",
        tpz: JSON.parse(localStorage.getItem("tpzId")),
        isDev: true,
      },
      suggestions: [],
      type: "dev",
      style: {
        dev: "background-color: " + COLORS.lightyellow,
        com: "",
      },
      bgColors: {
        yellow: "background-color: " + COLORS.lightyellow,
      },
      lastnameValidation: null,
      firstnameValidation: null,
      emailValidation: null,
    };
  },
  mounted() {
    this.getAllStudents();
  },
  methods: {
    showAddUserCard() {
      this.showAddUserCardValue = true;
    },
    getAllStudents() {
      getUsers(JSON.parse(localStorage.getItem("tpzId")))
        .then((res) => {
          res.data["hydra:member"].map((el) => {
            if (el.is_dev) {
              console.log(el);
              this.suggestions.push(el);
            }
          });
          this.users = res.data["hydra:member"];
        })
        .catch((err) => {
          console.log(err);
        });
    },
    updateUser(){
      console.log('udated')
    },
    deleteUser(){
      console.log('udated')
    },
    toggleLicence(e) {
      console.log(e.target.id);
      /*si on clique sur DEV et que COM était sélectionné on switch sinon rien*/
      if (e.target.id === "dev") {
        if (this.type === "com") {
          this.type = "dev";
          this.userToAdd.isDev = true;
          this.style = {
            dev: "background-color: " + COLORS.yellow,
            com: "",
          };
        }
        /*si on clique sur COM et que DEV était sélectionné on switch sinon rien*/
      } else if (e.target.id === "com") {
        if (this.type === "dev") {
          this.type = "com";
          this.userToAdd.isDev = false;
          this.style = {
            dev: "",
            com: "background-color: " + COLORS.yellow,
          };
        }
      }
    },
    addNewStudent() {
      this.lastnameValidation = null;
      this.firstnameValidation = null;
      this.emailValidation = null;
      if (
        this.userToAdd.lastname.length !== 0 &&
        this.userToAdd.firstname !== 0 &&
        this.userToAdd.email !== 0 &&
        this.userToAdd.email.includes("@")
      ) {
        this.lastnameValidation = true;
        this.firstnameValidation = true;
        this.emailValidation = true;
        addStudent(this.userToAdd).then((res) => {
          console.log(res);
          this.userToAdd.lastname = "";
          this.userToAdd.firstname = "";
          this.userToAdd.email = "";
        });
      } else {
        if (this.userToAdd.lastname.length === 0) {
          this.lastnameValidation = false;
        } else {
          this.lastnameValidation = true;
        }
        if (this.userToAdd.firstname.length === 0) {
          this.firstnameValidation = false;
        } else {
          this.firstnameValidation = true;
        }
        if (
          this.userToAdd.email.length === 0 &&
          !this.userToAdd.email.includes("@")
        ) {
          this.emailValidation = false;
        } else {
          this.emailValidation = true;
        }
      }
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
.toggleBar {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
}
.btn-group > .btn:first-child {
  border-top-left-radius: 100px;
  border-bottom-left-radius: 100px;
}
.btn-group > .btn:last-child {
  border-top-right-radius: 100px;
  border-bottom-right-radius: 100px;
}
.btn {
  border: none;
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
#submit-btn {
  width: 10em;
  border-radius: 10em;
  border-color: transparent;
  margin: 1em;
}
.itemStudent {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #FAD26E;
}
#update {
  color: #FAD26E;
  background-color: transparent;
  border: none;
}
#delete {
  color: #FF6969;
  background-color: transparent;
  border: none;
}
</style>
