<template>
  <div>
    <div>
      <div>
        Créer un groupe
        <b-form>
          <autocomplete-users v-bind:options="suggestions"  input="chef" placeholder="Chef de projet"></autocomplete-users>
            <b-form-group id="spe" label="Spécialité" label-for="spe">
              <b-form-select v-model="is_dev" :options="options"></b-form-select>
            </b-form-group>
        </b-form>
        <b-button class="green-button mt-4" @click="ajoutGroupe">Ajouter</b-button>
      </div>
    </div>
    <div>
      <div>
        Supprimer un groupe
        <b-form>
          <autocomplete-agency v-bind:agencesDev="agencesDev" v-bind:agencesCom="agencesCom" input="groupe" placeholder="Groupe"></autocomplete-agency>
        </b-form>
        <b-button class="green-button mt-4" @click="supprimerGroupe">Supprimer</b-button>
      </div>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
import { addAgency } from "../../api/agencies";
import {getGroupesData, updateRole} from "../../api/gestion";
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

    }
  }
}
</script>

<style scoped>

</style>