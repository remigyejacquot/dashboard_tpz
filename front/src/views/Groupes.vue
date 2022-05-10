<template>
  <div>
    <div>
      <div>
        Créer un groupe
        <b-form>
          <b-form-group id="chef" label="chef" label-for="chef">
            <b-form-input id="chef" v-model="chef" type="text" placeholder="Chef de projet" required></b-form-input>
          </b-form-group>
            <b-form-group id="spe" label="Spécialité" label-for="spe">
              <b-form-select v-model="is_dev" :options="options"></b-form-select>
            </b-form-group>
        </b-form>
        <b-button class="green-button mt-4" @click="ajoutGroupe">Ajouter</b-button>
      </div>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
import { addAgency } from "../../api/agencies";
import {getGroupesData} from "../../api/gestion";

export default {
  name: "Groupes",

  data () {
    return {
      chefProjet: "",
      is_dev : true,
      options : [
          { value: true, text: 'Développement' },
          { value: false, text: 'Communication' }
      ]
    }
  },
  async mounted () {
    this.getDataGroupes()
  },

  methods: {
    async ajoutGroupe() {
      await addAgency(
          {
            tpz : "/dashboard_tpz/back/public/index.php/api/tpzs/1",
            name : "Groupe" + Math.floor(1000 + Math.random() * 9000),
            isDev : this.is_dev
          }
      ).then(
          (res) => {
             console.log(res)
          }
      )
    },
    async getDataGroupes() {
        await getGroupesData(1).then((res) => {
          console.log(res)
        })
    }
  }
}
</script>

<style scoped>

</style>