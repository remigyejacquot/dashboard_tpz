<template>
  <div>
    <h1>DASHBOARD</h1>
    <b-card-text v-for="agency in agencies" :key="agency.id">{{ agency.name }}</b-card-text>
  </div>
</template>

<script>
import {getAllAgencies} from "../../api/agencies";

export default {
  name: "Dashboard",
  data() {
    return {
      agencies:[]
    };
  },
  created() {
    this.fetchAgencies()
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
  },
};
</script>

<style></style>
