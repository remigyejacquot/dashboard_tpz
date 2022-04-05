<template>
  <div>
    <h1>DASHBOARD</h1>
    <p>AGENCY</p>
    <b-card-text v-for="agency in agencies" :key="agency.id">{{ agency }}</b-card-text>
    <p>TPZMEMBERS</p>
    <b-card-text v-for="member in tpzMembers" :key="member.id">{{ member }}</b-card-text>
  </div>
</template>

<script>
import {getAllAgencies} from "../../api/agencies";
import {getAllMembers} from "../../api/tpzMembers";

export default {
  name: "Dashboard",
  data() {
    return {
      agencies:[],
      tpzMembers:[]
    };
  },
  created() {
    this.fetchAgencies()
    this.fetchTpzMembers()
  },
  methods: {
     fetchAgencies() {
       getAllAgencies().then((res)=>{
        console.log(res.data['hydra:member'])
         res.data['hydra:member'].forEach(agency => {
          this.agencies.push(agency)
         })
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
  },
};
</script>

<style></style>
