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
          <div
            class="itemStudent pt-1 pb-1"
            v-for="student in students"
            :key="student.id"
          >
            {{ student.lastname }} {{ student.firstname }}
            <div>
              <b-button id="update" @click="showUpdateUserCard(student)">
                modifier
              </b-button>
              <b-button
                id="delete"
                @click="handleDeleteStudent(student)"
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
        v-bind:options="suggestions"
        input="etudiant"
        placeholder="Rechercher un étudiant"
      ></autocomplete-users>
    </b-card>
    <!--    Ajouter un étudiant-->
    <b-card class="card item-add" v-if="showAddUserInput">
      <b-card-text
        >Ajouter un étudiant en licence {{ type.toUpperCase() }}</b-card-text
      >
      <div>
        <b-form-group label="Nom" label-for="input-lastname" class="m-2">
          <b-form-input
            id="input-lastname"
            v-model="student.lastname"
            :state="lastnameValidation"
            placeholder="Nom de l'étudiant"
            lazy-formatter
            :required="true"
          ></b-form-input>
          <p>{{this.student.lastname}}</p>
          <b-form-invalid-feedback :state="lastnameValidation">
            Le nom doit être renseigné
          </b-form-invalid-feedback>
        </b-form-group>
        <b-form-group label="Prénom" label-for="input-firstname" class="m-2"
          ><b-form-input
            id="input-firstname"
            v-model="student.firstname"
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
            v-model="student.email"
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
    <!--    Modifier un étudiant-->
    <b-card class="card item-add" v-else-if="showUpdateUserInput">
      <b-card-text>Modifier les informations concernant </b-card-text>
      <div>
        <b-form-group label="Nom" label-for="input-lastname" class="m-2">
          <b-form-input
            id="input-lastname"
            v-model="student.lastname"
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
            v-model="student.firstname"
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
            v-model="student.email"
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
          @click="handleUpdateStudent"
          >Modifier</b-button
        >
      </div>
    </b-card>
  </div>
</template>

<script>
import {
  addStudent, deleteStudent,
  getUsers,
  updateStudent,
} from "../../api/users";
import AutocompleteUsers from "../components/autocompleteUsers";
import { COLORS } from "../utils/colors";

export default {
  name: "GestionEtudiants",
  components: { AutocompleteUsers },
  data() {
    return {
      showAddUserInput: false,
      showUpdateUserInput: false,
      students: [],
      student: {
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
      this.showAddUserInput = true;
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
          this.students = res.data["hydra:member"];
        })
        .catch((err) => {
          console.log(err);
        });
    },
    toggleLicence(e) {
      console.log(e.target.id);
      /*si on clique sur DEV et que COM était sélectionné on switch sinon rien*/
      if (e.target.id === "dev") {
        if (this.type === "com") {
          this.type = "dev";
          this.student.isDev = true;
          this.style = {
            dev: "background-color: " + COLORS.yellow,
            com: "",
          };
        }
        /*si on clique sur COM et que DEV était sélectionné on switch sinon rien*/
      } else if (e.target.id === "com") {
        if (this.type === "dev") {
          this.type = "com";
          this.student.isDev = false;
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
        this.student.lastname.length !== 0 &&
        this.student.firstname !== 0 &&
        this.student.email !== 0 &&
        this.student.email.includes("@")
      ) {
        this.lastnameValidation = true;
        this.firstnameValidation = true;
        this.emailValidation = true;
        console.log(this.student)
        addStudent(this.student).then((res) => {
          console.log(res);
          this.student.lastname = "";
          this.student.firstname = "";
          this.student.email = "";
          this.lastnameValidation = null;
          this.firstnameValidation = null;
          this.emailValidation = null;
          this.getAllStudents()
        });
      } else {
        this.lastnameValidation = this.student.lastname.length !== 0;
        this.firstnameValidation = this.student.firstname.length !== 0;
        this.emailValidation = !(this.student.email.length === 0 ||
            !this.student.email.includes("@"));
      }
    },
    //show or not the card to update the student
    showUpdateUserCard(selectedStudent) {
      console.log(selectedStudent);
      this.student.id = selectedStudent.id;
      this.student.email = selectedStudent.email;
      this.student.lastname = selectedStudent.lastname;
      this.student.firstname = selectedStudent.firstname;
      this.showAddUserInput = false;
      this.showUpdateUserInput = true;
    },
    handleDeleteStudent: function (selectedStudent) {
      console.log(selectedStudent.id)
      deleteStudent(selectedStudent.id).then(res => {
        console.log(res)
        this.getAllStudents()
      })
    },
    handleUpdateStudent() {
      this.lastnameValidation = null;
      this.firstnameValidation = null;
      this.emailValidation = null;
      if (
        this.student.lastname.length !== 0 &&
        this.student.firstname !== 0 &&
        this.student.email !== 0 &&
        this.student.email.includes("@")
      ) {
        this.lastnameValidation = true;
        this.firstnameValidation = true;
        this.emailValidation = true;
        updateStudent(this.student.id, this.student).then((res) => {
          console.log(res);
          this.student.lastname = "";
          this.student.firstname = "";
          this.student.email = "";
        });
      } else {
        this.lastnameValidation = this.student.lastname.length !== 0;
        this.firstnameValidation = this.student.firstname.length !== 0;
        this.emailValidation = !(this.student.email.length === 0 &&
            !this.student.email.includes("@"));
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
