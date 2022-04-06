<template>
  <div>
    <h1>DASHBOARD</h1>
    <p>USER</p>
    <b-card-text>{{ user }}</b-card-text>
    <p>TOUTES LES AGENCES DE LA LICENCE {{user.is_dev ? 'DEV' : 'COM'}}</p>
    <b-card-text v-for="agency in agencies" :key="agency.id">{{ agency }}</b-card-text>
    <p>TPZMEMBERS</p>
    <b-card-text v-for="member in tpzMembers" :key="member.id">{{ member }}</b-card-text>
    <b-button :to="{name: 'projects'}">LES PROJETS</b-button>
  </div>
</template>

<script>
import {getUserLicenceAgencies} from "../../api/agencies";
import {getAllMembers} from "../../api/tpzMembers";
import {getUser} from "../../api/users";

export default {
  name: "Dashboard",
  data() {
    return {
      user:{},
      agencies:[],
      tpzMembers:[],
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
        console.log(res.data)
        this.user = res.data
      })
    },
    fetchTpzMembers() {
       getAllMembers().then((res)=>{
         console.log(res.data['hydra:member'])
         res.data['hydra:member'].forEach(member => {
           this.tpzMembers.push(member)
         })
       })
    },
    fetchUserLicenceAgencies(id) {
      getUserLicenceAgencies(id).then((res)=>{
        console.log(res.data)
         res.data.forEach(agency=>{
           this.agencies.push(agency)
         })
      })
    },
    fetchProjects() {

    }
  },
};
</script>

<style></style>
