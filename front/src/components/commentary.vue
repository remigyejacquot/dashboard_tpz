<template>
  <div>
    <b-button class="modifier comment"  v-b-modal.commentary-modal>
      <font-awesome-icon icon="comment" size="1x" class="mr-2"/>
      notes
    </b-button>
    <b-modal id="commentary-modal" :title="'Agence: ' + groupe" hide-footer class="custom-modal">
      <p class="commentaires-title">Commentaires</p>
      <div id="commentaires-wrapper">
        <div v-for="commentary in commentaries" class="commentaire" v-bind:key="commentary.id">
          <div class="d-flex justify-content-between">
            <div class="commentaire-user">
              <font-awesome-icon icon="user-tie" size="1x" class="mr-2"/>
              {{commentary.user.firstname}} {{commentary.user.lastname}}
            </div>
            <div class="commentaire-date">
              {{formatDate(commentary.updated_at)}}
            </div>
          </div>
          <div>
              {{commentary.content}}
          </div>
          <div class="d-flex justify-content-end">
            <div>
              <a class="commentaire-link modify" :data-id="commentary.id" @click="updateCommentary($event)">modifier</a>
              <a class="commentaire-link delete" @click="deleteCommentary(commentary.id)">supprimer</a>
            </div>
          </div>
        </div>
      </div>
      <b-form class="mt-5">
        <b-form-group>
          <b-form-textarea id="name" v-model="commentaire" type="text" placeholder="Entrez votre commentaire" required></b-form-textarea>
        </b-form-group>
      </b-form>
      <div class="mt-3 valid-button-wrapper">
        <button v-if="id === ''" class="valid-button commentaire" @click="sendCommentary">Envoyer</button>
        <button v-else class="valid-button commentaire" @click="saveCommentaryUpdate">Modifier</button>
      </div>
      <p class="error text-center">{{error}}</p>
    </b-modal>
  </div>
</template>

<style>
@import '../assets/css/modal.css';
</style>

<script>
import {deleteCommentary, getCommentaries, postCommentary, putCommentary} from "../../api/commentaries";

export default {
  name: "commentary",
  props: ["groupe", "agenceId"],
  data() {
    return {
      id : '',
      commentaries: {},
      commentaire : '',
      error : ''
    }
  },
  watch: {
    agenceId: function update() {
      getCommentaries(this.agenceId) .then((res) => {
      this.commentaries = res.data['hydra:member']
      })
    }
  },
  mounted() {
    getCommentaries(this.agenceId) .then((res) => {
      this.commentaries = res.data['hydra:member']
    })
  },

  methods: {
    formatDate(date) {
      let dateFormat = new Date(date)
      return dateFormat.toLocaleDateString("fr")
    },
    updateCommentary(event) {
      const id = event.target.getAttribute('data-id')
      const commentaire = this.commentaries.find(commentary => {
        return commentary.id === parseInt(id)
      })
      if (commentaire) {
        this.commentaire = commentaire.content
        this.id = id
      }
    },
    async sendCommentary() {
      let user = localStorage.getItem('user')
      if(user) {
        user = JSON.parse(user)
      }
      const data = {
        content : this.commentaire,
        user : user['@id'],
        agence: "/dashboard_tpz/back/public/index.php/api/agencies/" + this.agenceId,
        "createdAt": new Date(),
        "updatedAt": new Date()
      }
      if( this.commentaire.length !== 0 && user && this.agenceId) {
        await postCommentary(data).then((res) => {
          let commentaries = this.commentaries
          commentaries.push(res.data)
          this.commentaries = commentaries
          this.commentaire = ''
        })
      }
    },
    async saveCommentaryUpdate() {
      const data = {
        content : this.commentaire,
        "updatedAt": new Date()
      }
      await putCommentary(this.id, data).then((res) => {
        const index = this.commentaries.findIndex(c => c.id === parseInt(this.id));
        if (index !== -1) {
          let commentaryListe = this.commentaries
          commentaryListe[index] = res.data
          this.commentaries = commentaryListe
          this.commentaire = ''
          this.id = ''
        }
      })
    },
    async deleteCommentary(id) {
      await deleteCommentary(id)
      const index = this.commentaries.findIndex(c => c.id === parseInt(id));
      if (index !== -1) {
        let commentaryListe = this.commentaries
        commentaryListe.splice(index, 1)
        this.commentaries = commentaryListe
        this.commentaire = ''
        this.id = ''
      }
    }
  }

}
</script>

<style scoped>
.modifier.comment {
  color: #F96197 !important;
}
</style>