<template>
  <div>
    <div v-if="id !== ''" class="modifier"  v-b-modal.update-project>
      <font-awesome-icon icon="pen" size="1x" class="mr-2"/>
        modifier
    </div>
    <div v-else v-b-modal.add-project>
      <b-icon
          icon="plus-circle-fill"
          style="color: #f96197"
          font-scale="1.5"
          @click="()=>{}"
          class="icon-btn"/>
    </div>
    <b-modal :id="idModal" title="Gestion du projet" hide-footer class="custom-modal">
      <b-form>
        <b-form-group id="name-input" label="Nom du projet" label-for="name" class="d-flex align-items-center">
          <b-form-input id="name" v-model="name" type="text" placeholder="Nom du projet" required></b-form-input>
        </b-form-group>
      </b-form>
      <div class="mt-3 valid-button-wrapper">
        <button v-if="id !== ''" class="valid-button" @click="updateProjet">Valider</button>
        <button v-else class="valid-button" @click="newProject">Ajouter</button>
      </div>
      <p class="error text-center">{{error}}</p>
      <div v-if="id !== ''" class="bottom-modal w-100">
        <button v-b-modal.modal-suppression class="red-button float-start mt-2" @click="$bvModal.hide(idModal)">Supprimer</button>
      </div>
    </b-modal>
    <b-modal v-if="id !== ''" id="modal-suppression" title="Suppression"  hide-footer>
      <p class="my-4 text-center">Êtes-vous sûr de vouloir supprimer le projet {{name}} ?</p>
      <div class="d-flex justify-content-between">
        <button class="mt-3 mr-2 grey-button" @click="$bvModal.hide('modal-suppression')">Annuler</button>
        <button class="mt-3 red-button" @click="deleteProject">Supprimer</button>
      </div>
    </b-modal>
  </div>
</template>

<style>
@import '../assets/css/modal.css';
</style>

<script>
import {addProject, deleteProject, updateProject} from "../../api/projet";

export default {
  name: "formUpdateProjet",
  props: ["id", "name", "agenceId"],
  data () {
    return {
      error: '',
      idModal : this.id !== '' ? 'update-project' : 'add-project'
    }
  },
  methods: {
    async newProject() {
      const data = {
        'name' : this.name,
        'agency' : "/dashboard_tpz/back/public/index.php/api/agencies/" + this.agenceId,
        "createdAt": new Date(),
        "updatedAt": new Date()
      }
      if (this.name !== "" && this.agenceId !== "") {
        this.$bvModal.hide('add-project')
        this.error = ""
        await addProject(data)
      } else if (this.agenceId === ""){
        this.error = 'Aucune agence trouvée'
      } else {
        this.error = 'Le nom du projet doit être renseigné'
      }
    },
    async updateProjet() {
      const data = {
        'name' : this.name,
        "updatedAt": new Date()
      }
      if (this.name !== "") {
        this.$bvModal.hide('update-project')
        await updateProject(this.id, data)
        this.error = ""
      } else {
        this.error = 'Le nom du projet doit être renseigné'
      }
    },
    async deleteProject() {
      if(this.id) {
        this.$bvModal.hide('modal-suppression')
        await deleteProject(this.id)
        this.error = ""
      } else {
        this.error = 'Aucun projet'
      }
    }
  }
}
</script>

<style scoped>

</style>