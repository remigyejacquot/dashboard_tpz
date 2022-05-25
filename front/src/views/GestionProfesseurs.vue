<template>
  <div class="container">
    <!--    Liste des professeurs-->
    <b-card class="card item-list">
      <div class="mt-3">
        <div class="add-btn mt-3">
          <b-icon
            icon="plus-circle-fill"
            style="color: #f96197"
            font-scale="1.5"
            @click="showAddUserCard"
            class="icon-btn"
            >+</b-icon
          >
        </div>
        <div class="mt-3">
          <b-card-text>Liste des professeurs</b-card-text>
          <div
            class="itemStudent pt-1 pb-1"
            v-for="teacher in teachers"
            :key="teacher.id"
          >
            {{ teacher.lastname }} {{ teacher.firstname }}
            <div>
              <b-button id="update" @click="showUpdateUserCard(teacher)">
                modifier
              </b-button>
              <b-button
                id="delete"
                @click="deleteSelectedStudent(teacher)"
                class="pe-0"
              >
                supprimer
              </b-button>
            </div>
          </div>
        </div>
      </div>
    </b-card>
    <!--    Recherche-->
    <b-card class="card item-search">
      <autocomplete-users
        v-bind:options="teachers"
        input="professeur"
        placeholder="Rechercher un professeur"
      ></autocomplete-users>
    </b-card>
    <!--    Ajouter un professeur-->
    <b-card
      class="card item-add"
      v-if="isUpdateUserCardDisplayed || isAddUserCardDisplayed"
    >
      <b-card-text v-if="isAddUserCardDisplayed"
        >Ajouter un professeur</b-card-text
      ><b-card-text v-else-if="isUpdateUserCardDisplayed"
        >Modifier les informations du professeur
        <b>{{ teacher.lastname }} {{ teacher.firstname }}</b></b-card-text
      >
      <div>
        <b-form-group label="Nom" label-for="input-lastname" class="m-2">
          <b-form-input
            id="input-lastname"
            v-model="teacher.lastname"
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
            v-model="teacher.firstname"
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
            v-model="teacher.email"
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
          v-if="isAddUserCardDisplayed"
          type="submit"
          id="submit-btn"
          :style="bgColors.yellow"
          @click="addNewStudent"
          >Ajouter</b-button
        ><b-button
          v-else-if="isUpdateUserCardDisplayed"
          type="submit"
          id="submit-btn"
          :style="bgColors.yellow"
          @click="updateSelectedStudent"
          >Ajouter</b-button
        >
      </div>
    </b-card>
  </div>
</template>

<script>
import {
  addStudent,
  deleteStudent,
  getTeachers,
  updateStudent,
} from "../../api/users";
import AutocompleteUsers from "../components/autocompleteUsers";
import { COLORS } from "../utils/colors";

export default {
  name: "GestionProfesseurs",
  components: { AutocompleteUsers },
  data() {
    return {
      //Pour l'affichage des cartes
      isAddUserCardDisplayed: false,
      isUpdateUserCardDisplayed: false,
      //Liste de tous les étudiants
      teachers: [],
      //Model de professeur
      teacher: {
        email: "",
        firstname: "",
        lastname: "",
        tpz: null,
        isDev: null,
      },
      //Permet de styliser les boutons d'après une variable globale
      bgColors: {
        yellow: "background-color: " + COLORS.lightyellow,
      },
      //Pour la validation des champs
      lastnameValidation: null,
      firstnameValidation: null,
      emailValidation: null,
    };
  },
  mounted() {
    this.getAllTeachers();
  },
  methods: {
    //Affiche la carte pour ajouter un noouvel étudiant
    showAddUserCard() {
      this.isUpdateUserCardDisplayed = false;
      this.isAddUserCardDisplayed = true;
    },
    //Fetch tous les étudiants
    getAllTeachers() {
      this.teachers = [];
      getTeachers().then((res) => {
        this.teachers = res.data
      });
    },
    //Ajoute un nouvel étudiant qui ne serait pas d'office dans la liste + contrôle des champs
    addNewStudent() {
      this.lastnameValidation = null;
      this.firstnameValidation = null;
      this.emailValidation = null;
      if (
        this.teacher.lastname.length !== 0 &&
        this.teacher.firstname !== 0 &&
        this.teacher.email !== 0 &&
        this.teacher.email.includes("@")
      ) {
        this.lastnameValidation = true;
        this.firstnameValidation = true;
        this.emailValidation = true;
        console.log(this.teacher);
        addStudent(this.teacher).then((res) => {
          console.log(res);
          this.teacher.lastname = "";
          this.teacher.firstname = "";
          this.teacher.email = "";
          this.lastnameValidation = null;
          this.firstnameValidation = null;
          this.emailValidation = null;
          this.getAllTeachers();
        });
      } else {
        this.lastnameValidation = this.teacher.lastname.length !== 0;
        this.firstnameValidation = this.teacher.firstname.length !== 0;
        this.emailValidation = !(
          this.teacher.email.length === 0 || !this.teacher.email.includes("@")
        );
      }
    },
    //Affiche la carte pour modifier les infos d'un étudiant
    showUpdateUserCard(selectedStudent) {
      this.teacher.id = selectedStudent.id;
      this.teacher.email = selectedStudent.email;
      this.teacher.lastname = selectedStudent.lastname;
      this.teacher.firstname = selectedStudent.firstname;
      this.isAddUserCardDisplayed = false;
      this.isUpdateUserCardDisplayed = true;
    },
    //Supprimer un étudiant
    deleteSelectedStudent: function (selectedStudent) {
      console.log(selectedStudent.id);
      deleteStudent(selectedStudent.id).then((res) => {
        console.log(res);
        this.getAllTeachers();
      });
    },
    //Modifier un étudiant
    updateSelectedStudent() {
      this.lastnameValidation = null;
      this.firstnameValidation = null;
      this.emailValidation = null;
      if (
        this.teacher.lastname.length !== 0 &&
        this.teacher.firstname !== 0 &&
        this.teacher.email !== 0 &&
        this.teacher.email.includes("@")
      ) {
        this.lastnameValidation = true;
        this.firstnameValidation = true;
        this.emailValidation = true;
        updateStudent(this.teacher.id, this.teacher).then((res) => {
          console.log(res);
          this.teacher.lastname = "";
          this.teacher.firstname = "";
          this.teacher.email = "";
          this.lastnameValidation = null;
          this.firstnameValidation = null;
          this.emailValidation = null;
          this.getAllTeachers();
        });
      } else {
        this.lastnameValidation = this.teacher.lastname.length !== 0;
        this.firstnameValidation = this.teacher.firstname.length !== 0;
        this.emailValidation = !(
          this.teacher.email.length === 0 && !this.teacher.email.includes("@")
        );
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
.add-btn {
  display: flex;
  flex-direction: row;
  justify-content: flex-end;
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
.icon-btn {
  cursor: pointer;
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
  border-bottom: 1px solid #fad26e;
}
#update {
  color: #fad26e;
  background-color: transparent;
  border: none;
}
#delete {
  color: #ff6969;
  background-color: transparent;
  border: none;
}
</style>
