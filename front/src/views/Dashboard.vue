<template>
  <div>
    <h1>DASHBOARD</h1>
    <p>USER</p>
    <b-card-text>{{ user }}</b-card-text>
    <p>TOUTES LES AGENCES DE LA LICENCE {{type === 'dev' ? 'DEV' : 'COM'}}</p>
    <b-button @click="toggleLicence">CHANGER DE LICENCE</b-button>
    <div v-if="type === 'dev'">
      <b-card-text
        v-for="agency in devAgencies"
        :key="agency.id"
        >{{ agency }}</b-card-text
      >
    </div>
    <div v-else>
      <b-card-text
          v-for="agency in comAgencies"
          :key="agency.id"
      >{{ agency }}</b-card-text
      >
    </div>
    <p>TPZMEMBERS</p>
    <b-card-text v-for="member in tpzMembers" :key="member.id">{{ member }}</b-card-text>
    <b-button :to="{name: 'Projects'}">LES PROJETS</b-button>
  </div>
</template>

<script>
import {getAllTpzMembers} from "../../api/tpzMembers";
import {getUser} from "../../api/users";
import {getTpz} from "../../api/tpzs";

export default {
  name: "Dashboard",
  data() {
    return {
      user:{},
      devAgencies:[],
      comAgencies:[],
      tpzMembers:[],
      type:"",
    };
  },
  created() {
    const userId = JSON.parse(localStorage.getItem("user")).id
    this.fetchInfo(userId)
    this.fetchTpzMembers()
  },
  methods: {
    fetchInfo(id) {
      getUser(id).then((res)=>{
        console.log(res.data.tpzId)
        this.user = res.data
        this.type = res.data.is_dev ? 'dev' : 'com'
        //localStorage.setItem("user", JSON.stringify(res.data)) // store the user in localstorage
        getTpz(res.data.tpzId).then(res=>{
          console.log('toto',res.data.agencies)
          this.devAgencies = res.data.agencies.filter(el=>el.is_dev === true)
          this.comAgencies = res.data.agencies.filter(el=>el.is_dev !== true)
        })
      })
    },
    fetchTpzMembers() {
      getAllTpzMembers().then((res)=>{
         res.data['hydra:member'].forEach(member => {
           this.tpzMembers.push(member)
         })
       })
    },
    toggleLicence() {
      this.type === 'dev' ? this.type = 'com' : this.type = 'dev'
    }
  },
};
</script>

<style></style>
