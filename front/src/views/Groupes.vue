<template>
  <div class="container-fluid">
    <b-overlay :show="show" rounded="sm">
    </b-overlay>
    <!-- <form-update-projet id="3" name="toto23" agenceId="28"></form-update-projet>
    <form-update-projet id="" name="" agenceId="28"></form-update-projet>
    <commentary groupe="Groupe3" agenceId="28"></commentary>-->
    <div class="row h-100">
      <div class="container-liste-agence col-lg-6">
        <div class="d-flex justify-content-between align-items-center">
          <p class="action-title">Liste des groupes</p>
          <div>
            <div>
                <div
                    style="height: 30px; border-radius: 10px; border: solid white 2px"
                    class="d-flex align-items-center"
                >
                <span
                    :class="'text-center ' + (this.isDisplay === 'communication' ? 'active' : 'desactive')"
                    id="communication-switch"
                    style="border-radius: 15px 0 0 15px;"
                    @click="changeDisplay"
                >com</span
                >
                  <span
                      :class="'text-center ' + (this.isDisplay === 'developpement' ? 'active' : 'desactive')"
                      id="developpement-switch"
                      style="border-radius: 0 15px 15px 0;"
                      @click="changeDisplay"
                  >dev</span
                  >
                </div>
              </div>
            </div>
        </div>
        <div class="liste-agence">
          <div class="row d-flex justify-content-start align-items-stretch flex-wrap px-1">
            <div v-for="(item) in agenciesToDisplay" :key="item.id" class="groups_card m-2">
              <p class="name-agency">{{item.name}}</p>
              <ul class="p-0">
                <p v-if="item.users.length === 0">Aucun membre</p>
                <li v-for="(member) in item.users" :key="member.id" class="member-agency">
                  <p class="m-0">{{member.firstname}} {{member.lastname}}</p>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 container-forms">
        <div class="form add">
          <p class="action-title">Créer une agence</p>
          <b-form>
            <autocomplete-users v-bind:options="suggestions"  input="chef" placeholder="Chef d'agence"></autocomplete-users>
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
        <p class="my-4">Êtes-vous sûr de vouloir supprimer l'agence ?</p>
        <div class="d-flex justify-content-end">
          <button class="mt-3 mx-2 grey-button" @click="$bvModal.hide('modal-1')">Annuler</button>
          <button class="mt-3 red-button" @click="$bvModal.hide('modal-1'); supprimerGroupe()" variant="danger">Supprimer</button>
        </div>
      </b-modal>
      <router-view></router-view>
      </div>
  </div>
</template>

<style>
@import '../assets/css/groupes.css';
@import '../assets/css/loader.css';
</style>

<script>
import { addAgency } from "../../api/agencies";
import {getGroupesData, updateRole, deleteGroupe} from "../../api/gestion";
import AutocompleteUsers from "../components/autocompleteUsers";
import AutocompleteAgency from "../components/autocompleteAgency";

export default {
  name: "Groupes",
  components: {AutocompleteAgency, AutocompleteUsers },
  data () {
    return {
      chefProjet: "",
      show: false,
      is_dev : true,
      options : [
          { value: true, text: 'Développement' },
          { value: false, text: 'Communication' }
      ],
      suggestions : {},
      agencesDev : [],
      agencesCom : [],
      show_agencies : false,
      isDisplay : "communication",
      agenciesToDisplay: []
    }
  },
  async mounted () {
    this.getDataGroupes()
  },

  methods: {
    async ajoutGroupe() {
      this.show = true
      this.chefProjet = document.getElementById('id').value
      await addAgency(
          {
            tpz : "/dashboard_tpz/back/public/index.php/api/tpzs/" + localStorage.getItem('tpzId'),
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
      await updateRole('chef de projet', this.chefProjet, idAgence).then(() => {
        this.show = false
        document.getElementById('chef').value = ""
      })
    },
    async getDataGroupes() {
        await getGroupesData(localStorage.getItem("tpzId")).then((res) => {
          this.suggestions = res.data.users
          this.agencesDev = res.data.agenciesDev
          this.agencesCom = res.data.agenciesCom
          this.agenciesToDisplay = res.data.agenciesCom
        })
    },
    async supprimerGroupe() {
      let toDelete = document.getElementById('idAgency').value
      await deleteGroupe(toDelete)
    },
    changeDisplay() {
      this.isDisplay = this.isDisplay === 'communication' ? 'developpement' : 'communication'
      this.agenciesToDisplay = this.isDisplay === 'communication' ? this.agencesCom : this.agencesDev
      console.log(this.agenciesToDisplay)
    },
  }
}
</script>

<style scoped>
.groups_card{
  border: 2px solid #FAD26E;
  border-radius: 10px;
  max-width: 46%;
  min-width: 200px;
  flex-grow: 2;
}
.name-agency{
  font-size: 1.4rem;
  font-weight: bold;
  color: #FAD26E;
  text-align: center;
}
.member-agency{
  text-align: center;
  list-style: none;
  line-height: 18px;
}
.liste-agence{
  overflow-y: scroll;
  overflow-x: hidden;
  height: 80%;
}
/* Hide scrollbar for Chrome, Safari and Opera */
.liste-agence::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.liste-agence {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
.active {
  background-color: #4D3677;
  border: 1px solid #4D3677;
  color: white;
  width: 50px;
  cursor: pointer;
  padding:2px;
}

.desactive {
  color : #4D3677 !important;
  background-color: transparent;
  border: 1px solid #4D3677;
  width: 50px;
  padding:2px;
  cursor: pointer;
}
</style>