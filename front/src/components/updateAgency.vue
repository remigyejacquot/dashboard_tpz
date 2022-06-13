<template>
  <div>
    <div class="d-flex justify-content-center align-items-center modifier fw-bold" v-b-modal.update-agency>
      <font-awesome-icon icon="pen" size="1x" class="mx-1"/>
      modifier
    </div>
    <b-modal id="update-agency" title="Gestion de l'agence" hide-footer class="custom-modal">
      <b-form-group id="input-name" label="Nom de l'agence" label-for="input-name" class="step-form">
        <b-form-input id="input-name" v-model="name" type="text" placeholder="Nom de l'agence"></b-form-input>
      </b-form-group>
      <div class="update-chef step-form d-flex flex-column w-100">
        <label>Chef d'agence</label>
        <select id="users-chef" v-model="chef" class="w-100 select">
          <option v-for="user in users" :value="user" v-bind:key="user.id">{{user.firstname}} {{user.lastname}}</option>
        </select>
      </div>
      <div class="membres d-flex w-100 step-form flex-column">
        <div class="w-100 d-flex">
          <div class="w-25">Membres</div>
          <div class="w-75">
            <div v-for="user in users" v-bind:key="user.id" class="user-list w-100 d-flex justify-content-between align-items-center">
              <div>{{user.firstname}} {{user.lastname}}</div>
              <div v-if="!user.tpzRolesArray.includes('chef de projet')" @click="removeMembre" :data-id="user['@id']">
                <font-awesome-icon icon="fa-solid fa-minus" :data-id="user['@id']"/>
              </div>
            </div>
          </div>
        </div>
        <div class="add-user">
          <b-form>
            <autocomplete-users v-bind:options="suggestions"  input="etudiant" placeholder="Chercher un membre"></autocomplete-users>
          </b-form>
          <button class="valid-button" @click="addMembre" style="height: 35px; width: 100px; margin-left: 10px !important; padding: 0">Ajouter</button>
        </div>
      </div>
      <button class="valid-button mt-2" @click="updateAgence">Valider</button>
    </b-modal>
  </div>
</template>

<script>
import AutocompleteUsers from "./autocompleteUsers";
import {getUsers} from "../../api/users";
import {updateAgency} from "../../api/agencies";
import {updateRole} from "../../api/gestion";

export default {
  components: {AutocompleteUsers},
  props: ['agency'],
  name: "updateAgency",
  data() {
    return {
      name: '',
      users: [],
      chef: {},
      suggestions : []
    }
  },
  mounted() {
    this.getUsersData()
  },
  methods: {
    async getUsersData() {
      await getUsers(localStorage.getItem("tpzId")).then((res) => {
        this.suggestions = res.data['hydra:member']
      })
    },
    addMembre() {
      const etudiant = document.querySelector('.add-user #id')
      if (etudiant && etudiant.value !== '') {
        const toAdd = this.suggestions.filter(obj => {
          return obj.id == etudiant.value
        })
        if (toAdd && toAdd[0] && !this.users.some(person => person['@id'] === toAdd[0]['@id'])) {
          this.users.push(toAdd[0])
        }
        etudiant.value = ''
        document.querySelector('.add-user #etudiant').value = ''
      }
    },
    removeMembre(e) {
      this.users.some((person, index) => {
        if (person['@id'] === e.target.getAttribute('data-id')) {
          this.users.splice(index, 1)
        }
      })
    },
    updateAgence() {
      updateRole('chef de projet', this.chef['@id'].replace(/\D/g, ''), this.agency.id)
      let usersIRI = this.users.map(user => user['@id'])
      const data = {
        name : this.name,
        users: usersIRI
      }
      updateAgency(this.agency.id, data).then((res) => {
        this.agency = res.data
      })
    }
  },
  watch: {
    agency : function() {
      this.name = this.agency.name
      this.users = this.agency.users
      let chef = ''
      this.agency.users.map((user) => {
        if(user.tpzRolesArray.includes('chef de projet')) {
          chef = user
        }
      })
      this.chef = chef
    }
  }
}
</script>

<style scoped>
input, .select {
  background-color: #F6F6F6;
  border: none;
}

.select {
  height: 40px !important;
  padding: 5px;
}

.step-form {
  padding: 20px 0 20px 0;
  border-bottom: 1px solid #e7e7e7;
}

.user-list {
  background-color: #F6F6F6;
  padding: 5px 20px;
  border-bottom: 1px solid #cecece;
}

.add-user {
  display: flex;
  justify-content: end;
  align-items: end;
  margin-top: 20px;
}
</style>