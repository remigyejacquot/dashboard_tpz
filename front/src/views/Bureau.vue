<template>
  <div class="container-fluid">
    <div class="row bureau-form">
      <div class="col-lg-12">
        <h1>Bureau</h1>
      </div>
      <div class="col-lg-6">
        <div id="president-fields" class="input-gestion">
          <autocomplete-users v-bind:options="suggestions"  input="president" placeholder="Président"></autocomplete-users>
        </div>
        <div id="tresorier-fields" class="input-gestion">
          <autocomplete-users v-bind:options="suggestions"  input="tresorier" placeholder="Trésorier"></autocomplete-users>
        </div>
        <div id="secretaire-fields" class="input-gestion">
          <autocomplete-users v-bind:options="suggestions"  input="secretaire" placeholder="Secrétaire"></autocomplete-users>
        </div>
      </div>
      <div class="col-lg-6">
        <div id="vice-president-fields" class="input-gestion">
          <autocomplete-users v-bind:options="suggestions"  input="vice-president" placeholder="Vice-président"></autocomplete-users>
        </div>
        <div id="vice-tresorier-fields" class="input-gestion">
          <autocomplete-users v-bind:options="suggestions"  input="vice-tresorier" placeholder="Vice-trésorier"></autocomplete-users>
        </div>
        <div id="vice-secretaire-fields" class="input-gestion">
          <autocomplete-users v-bind:options="suggestions"  input="vice-secretaire" placeholder="Vice-secrétaire"></autocomplete-users>
        </div>
      </div>
      <div class="col-lg-12">
        <button class="valid-button mt-4" @click="updateRoleBureau">Valider</button>
      </div>
    </div>
  </div>
</template>
<style>
  @import '../assets/css/bureau.css';
</style>

<script>
import AutocompleteUsers from "../components/autocompleteUsers";
import {getUsers} from "../../api/users";
import {updateRoleBureau, getMembresBureau} from "../../api/gestion";

export default {
  name: "Bureau",
  data () {
    return {
      suggestions : []
    }
  },
  components: {AutocompleteUsers},
  async mounted () {
    this.getUsersData()
    this.getRolesBureau()
  },
  methods : {
    async getUsersData() {
      await getUsers(1).then((res) => {
        this.suggestions = res.data
      })
    },
    async updateRoleBureau() {
      const roles = ['president', 'vice-president', 'secretaire', 'vice-secretaire', 'tresorier', 'vice-tresorier']
      let data = []
      for (let role in roles) {
        let value = document.querySelector("#" + roles[role] + '-fields ' + '#id' ).value;
        if(value != "") {
          data.push([roles[role], value])
        }
      }
      await updateRoleBureau(data, 1)
    },

    async getRolesBureau() {
      await getMembresBureau(1).then((res) => {
        const membres = res.data
        for (let i in membres) {
          for(let role in membres[i].tpzRolesArray) {
            this.setValueToField(membres[i], membres[i].tpzRolesArray[role])
          }
        }
      })
    },
    setValueToField(user, role) {
      const field = document.querySelector("#" + role + '-fields ' + '#id' )
      const user_field = document.querySelector("#" + role)
      if(field){
        field.value = user.id
      }
      if(user_field) {
        user_field.value = user.lastname + ' ' + user.firstname
      }
    }
  }
}
</script>

<style scoped>

</style>