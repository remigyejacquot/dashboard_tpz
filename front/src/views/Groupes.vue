<template>
  <div class="container-fluid">
    <div class="row h-100">
      <div class="container-liste-agence col-lg-6">
        <p class="action-title">Liste des groupes</p>
        <div v-for="(item) in agencesDev" :key="item.id">
          <p>{{item.name}}</p>
          <ul>
            <li v-for="(member) in item.users" :key="member.id">
              {{member.firstname}} {{member.lastname}}
            </li>
          </ul>
        </div>
        <div v-for="(item) in agencesCom" :key="item.id">
          <p>{{item.name}}</p>
          <ul>
            <li v-for="(member) in item.users" :key="member.id">
              {{member.firstname}} {{member.lastname}}
            </li>
          </ul>
        </div>
      </div>
      <div class="col-lg-6 container-forms">
        <div class="form add">
          <p class="action-title">Créer une agence</p>
          <b-form>
            <autocomplete-users v-bind:options="suggestions"  input="chef" placeholder="Chef de projet"></autocomplete-users>
              <b-form-group id="spe" label="Spécialité" label-for="spe">
                <b-form-select v-model="is_dev" :options="options"></b-form-select>
              </b-form-group>
          </b-form>
          <button class="valid-button mt-4" @click="ajoutGroupe">Ajouter</button>
        </div>
        <div class="form mt-4 delete">
          <p class="action-title">Supprimer une agence</p>
          <b-form>
            <autocomplete-agency v-bind:agencesDev="agencesDev" v-bind:agencesCom="agencesCom" input="groupe" placeholder="Agence"></autocomplete-agency>
          </b-form>
          <button v-b-modal.modal-1 class="red-button mt-4">Supprimer</button>
        </div>
      </div>
      <b-modal id="modal-1" title="Suppression"  hide-footer>
        <p class="my-4">Êtes-vous sûr de vouloir supprimer l'agence' ?</p>
        <div class="d-flex justify-content-end">
          <b-button class="mt-3 mr-2" block @click="$bvModal.hide('bv-modal-example')">Annuler</b-button>
          <b-button class="mt-3" block @click="$bvModal.hide('bv-modal-example'); supprimerGroupe()" variant="danger">Supprimer</b-button>
        </div>
      </b-modal>
      <router-view></router-view>
      </div>
  </div>
</template>

<style>
@import '../assets/css/groupes.css';
</style>

<script>
import { addAgency } from "../../api/agencies";
import {getGroupesData, updateRole, deleteGroupe} from "../../api/gestion";
import AutocompleteUsers from "../components/autocompleteUsers";
import AutocompleteAgency from "../components/autocompleteAgency";

export default {
  name: "Groupes",
  components: { AutocompleteAgency, AutocompleteUsers },
  data () {
    return {
      chefProjet: "",
      is_dev : true,
      options : [
          { value: true, text: 'Développement' },
          { value: false, text: 'Communication' }
      ],
      suggestions : {},
      agencesDev : [],
      agencesCom: [],
    }
  },
  async mounted () {
    this.getDataGroupes()
  },

  methods: {
    async ajoutGroupe() {
      this.chefProjet = document.getElementById('id').value
      await addAgency(
          {
            tpz : "/dashboard_tpz/back/public/index.php/api/tpzs/1",
            name : "Groupe" + Math.floor(1000 + Math.random() * 9000),
            isDev : this.is_dev
          }
      ).then(
          (res) => {
            this.updateRoleChef(res.data['@id'].replace(/\D/g, ""))
          }
      )
    },
    async updateRoleChef(idAgence) {
      await updateRole('chef de projet', this.chefProjet, idAgence)
    },
    async getDataGroupes() {
        await getGroupesData(1).then((res) => {
          this.suggestions = res.data.users
          this.agencesDev = res.data.agenciesDev
          this.agencesCom = res.data.agenciesCom
        })
    },
    async supprimerGroupe() {
      let toDelete = document.getElementById('idAgency').value
      await deleteGroupe(toDelete)
    }
  }
}
</script>

<style scoped>

</style>