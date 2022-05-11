<template>
  <div>
    <b-form-group id="input" v-bind:label="placeholder" v-bind:label-for="input">
      <b-form-input v-bind:id="input" v-model="user" type="text" v-bind:placeholder="placeholder" required v-on:update="onChange($event)"></b-form-input>
      <div v-bind:class="(autocompeleteList.length === 0) ? 'd-none' : ''">
        <ul id="results">
          <p>Veuillez selectionner l'étudiant</p>
          <li v-for="(item) in autocompeleteList" :key="item.id" @click="updateField(item)" class="autocomplete-result" :style="{'cursor': 'pointer'}">
              {{ item.nom }} {{ item.prenom }}
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
  methods : {
    onChange($event) {
      let searchResults = this.options.filter((group) => group['nom'].toLowerCase().startsWith($event.toLowerCase()) || group['prenom'].toLowerCase().startsWith($event.toLowerCase()) )
      let results = []
      searchResults.forEach( (result) => {
        results.push(result)
      })
      this.autocompeleteList = results
    },
    updateField(item){
      this.user = item.nom + ' ' + item.prenom
      this.id = item.id
      this.autocompeleteList = []
    }
  }
}
</script>

<style scoped>

</style>