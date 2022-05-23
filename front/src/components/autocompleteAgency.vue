<template>
  <div>
    <b-form-group id="input" v-bind:label="placeholder" v-bind:label-for="input">
      <b-form-input v-bind:id="input" v-model="agency" type="text" v-bind:placeholder="placeholder" required v-on:update="onChange($event)"></b-form-input>
      <div v-bind:class="(autocompeleteList.length === 0) ? 'd-none' : ''">
        <ul id="results" class="results">
          <p class="infos">Veuillez selectionner l'étudiant</p>
          <li v-for="(item) in autocompeleteList" :key="item.id" @click="updateField(item)" class="autocomplete-result" :style="{'cursor': 'pointer'}">
              {{ item.name }}
          </li>
        </ul>
      </div>
      <b-form-input id="idAgency" v-model="idAgency" type="text" placeholder="" required hidden></b-form-input>
    </b-form-group>
  </div>
</template>

<style>
@import "../assets/css/autocomplete.css";
</style>

<script>
export default {
  name: "autocompleteAgency",
  props: {
    'agencesCom' : Array,
    'agencesDev' : Array,
    'input' : String,
    'placeholder' : String
  },
  data () {
    return {
      agency : "",
      idAgency : null,
      autocompeleteList : [],
    }
  },
  async mounted() {
    this.listenerCloseResults()
  },
  methods : {
    onChange($event) {
      let results = []
      results = this.search(this.agencesCom, results, $event)
      results = this.search(this.agencesDev, results, $event)
      this.autocompeleteList = results
    },
    updateField(item){
      this.agency = item.name
      this.idAgency = item.id
      this.autocompeleteList = []
    },
    search(array, results, $event) {
      array = JSON.parse(JSON.stringify(array))
      let searchResults = array.filter((group) => group['name'].toLowerCase().includes($event.toLowerCase()))
      searchResults.forEach( (result) => {
        results.push(result)
      })
      return results
    },
    listenerCloseResults() {
      document.addEventListener('click', (event) => {
        const box = document.getElementById('results');
        if (box && !box.contains(event.target) && event.target.id != this.input) {
          this.autocompeleteList = []
        }
      });
    }
  }
}
</script>

<style scoped>

</style>