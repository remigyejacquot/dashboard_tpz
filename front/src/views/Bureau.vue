<template>
  <div>
    <div>
      <autocomplete-users v-bind:options="suggestions"  input="president" placeholder="Président"></autocomplete-users>
      <autocomplete-users v-bind:options="suggestions"  input="vice-president" placeholder="Vice-président"></autocomplete-users>
      <autocomplete-users v-bind:options="suggestions"  input="tresorier" placeholder="Trésorier"></autocomplete-users>
      <autocomplete-users v-bind:options="suggestions"  input="vice-tresorier" placeholder="Vice-trésorier"></autocomplete-users>
      <autocomplete-users v-bind:options="suggestions"  input="secretaire" placeholder="Secrétaire"></autocomplete-users>
      <autocomplete-users v-bind:options="suggestions"  input="vice-secretaire" placeholder="Vice-secrétaire"></autocomplete-users>
    </div>
  </div>
</template>

<script>
import AutocompleteUsers from "../components/autocompleteUsers";
import {getUsers} from "../../api/users";

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
  },
  methods : {
    async getUsersData() {
      await getUsers(1).then((res) => {
        this.suggestions = res.data
      })
    }
  }
}
</script>

<style scoped>

</style>