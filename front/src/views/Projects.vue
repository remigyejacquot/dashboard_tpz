<template>
  <div>
    <h1>PROJECTS</h1>
    <p>USER</p>
    <b-card-text>{{ user }}</b-card-text>
    <p>LES MEMBRES DE L'AGENCE</p>
    <b-card-text v-for="agency in agencies" :key="agency.id">{{ agency }}</b-card-text>
    <p>TPZMEMBERS</p>
    <b-card-text v-for="member in tpzMembers" :key="member.id">{{ member }}</b-card-text>
    <b-button :to="{name: 'Projects'}">LES PROJETS</b-button>
  </div>
</template>

<script>
import {getUser} from "../../api/users";
import {getAllMembers} from "../../api/tpzMembers";
import {getUserLicenceAgencies} from "../../api/agencies";

export default {
  name: "Projects",
  data() {
    return {
      user:{},
      tpzMembers:[],
      agencyMembers:[],
    };
  },
  created() {
    const userId = JSON.parse(localStorage.getItem("user")).id
    this.fetchUserInfo(userId)
    this.fetchTpzMembers()
    this.fetchUserLicenceAgencies(userId)
  },
  methods: {
    fetchUserInfo(id) {
      getUser(id).then((res)=>{
        this.user = res.data
        this.agenciesType = res.data.is_dev ? 'dev' : 'com'
        //getAgencyMembers(res.data.)
      })
    },
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
          this.agencies.push(agency)
        })
      })
    },
  },
}
</script>

<style scoped>

</style>
