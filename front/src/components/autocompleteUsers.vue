<template>
  <div class="autocomplete">
    <b-form-group id="input" v-bind:label="placeholder" v-bind:label-for="input">
      <b-form-input v-bind:id="input" v-model="user" type="text" v-bind:placeholder="placeholder" required v-on:update="onChange($event)"></b-form-input>
      <div v-bind:class="(autocompeleteList.length === 0) ? 'd-none' : ''">
        <ul :id="'results-' + input"  class="results">
          <p class="infos" v-if="input==='etudiant'">Veuillez selectionner l'étudiant</p>
          <p class="infos" v-else>Veuillez selectionner le professeur</p>
          <li v-for="(item) in autocompeleteList" :key="item.id" @click="updateField(item)" class="autocomplete-result" :style="{'cursor': 'pointer'}">
              {{ item.lastname }} {{ item.firstname }}
          </li>
        </ul>
      </div>
      <b-form-input id="id" v-model="id" type="text" placeholder="" required hidden></b-form-input>
    </b-form-group>
  </div>
</template>

<script>
export default {
  name: "autocompleteUsers",
  props: ['options', 'input', 'placeholder'],
  data () {
    return {
      user: "",
      id : null,
      searchList : this.options,
      autocompeleteList : [],
    }
  },
  async mounted() {
    this.listenerCloseResults()
  },
  methods : {
    onChange($event) {
      let searchResults = this.options.filter((group) => group['lastname'].toLowerCase().startsWith($event.toLowerCase()) || group['firstname'].toLowerCase().startsWith($event.toLowerCase()) )
      let results = []
      searchResults.forEach( (result) => {
        results.push(result)
      })
      this.autocompeleteList = results
    },
    updateField(item){
      this.user = item.lastname + ' ' + item.firstname
      this.id = item.id
      this.autocompeleteList = []
    },
    listenerCloseResults() {
      document.addEventListener('click', (event) => {
        const box = document.getElementById('results-' + this.input);
        if (box && !box.contains(event.target) && event.target.id != this.input) {
          this.autocompeleteList = []
        }
      });
    }
  }
}

</script>

<style>
@import "../assets/css/autocomplete.css";
</style>
