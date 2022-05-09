<template>
  <div>
    <h1>PROJECTS</h1>
    <p>USER</p>
    <b-card-text>{{ user }}</b-card-text>
    <p>LES MEMBRES DE L'AGENCE</p>
    <b-card-text v-for="agency in agencyMembers" :key="agency.id">{{ agency }}</b-card-text>
    <p>TPZMEMBERS</p>
    <b-card-text v-for="member in tpzMembers" :key="member.id">{{ member }}</b-card-text>
    <b-button :to="{name: 'Projects'}">LES PROJETS</b-button>
  </div>
</template>

<script>
import {getAllMembers} from "../../api/tpzMembers";
import {getUserLicenceAgencies} from "../../api/agencies";

export default {
  name: "Projects",
  data() {
    return {
      user: {},
      tpzMembers:[],
      agencyMembers:[],
    };
  },
  created() {
    console.log('toto',JSON.parse(localStorage.getItem("user")))
    const user = JSON.parse(localStorage.getItem("user"))
    this.user = user
    this.fetchTpzMembers()
    this.fetchUserLicenceAgencies(user['@id'].substr(-1))//retrieve user index from @id
  },
  methods: {
    fetchTpzMembers() {
      getAllMembers().then((res)=>{
        res.data['hydra:member'].forEach(member => {
          this.tpzMembers.push(member)
        })
      })
    },
    fetchUserLicenceAgencies(id) {
      getUserLicenceAgencies(id).then((res)=>{
        res.data.forEach(agency=>{
          this.agencyMembers.push(agency)
        })
      })
    },
  },
}
</script>

<style scoped>

</style>
