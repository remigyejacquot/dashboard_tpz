<template>
  <div>
    <main class="d-flex">
      <section
          class="title-section d-flex justify-content-between align-items-center flex-basis-50"
      >
        <div class="d-flex header-section-div">
          <h2>Project Flyer</h2>
          <p>Barre de progression</p>
        </div>
        <div class="d-flex header-section-div">
          <p>5</p>
          <button class="modify-btn">Modifier</button>
        </div>
      </section>
      <section
          class="switch-section d-flex justify-content-between align-items-center flex-basis-50"
      >
        <div class="d-flex header-section-div">
          <h2>Entreprise machin</h2>
          <ul id="example-1">
            <li v-for="member in agency.users" :key="member.id">
              {{ member.firstname }}
              {{ member.lastname }}
            </li>
          </ul>
        </div>
        <div class="d-flex header-section-div">
          <p>5</p>
          <button class="modify-btn">Modifier</button>
        </div>
      </section>
    </main>
    <h1>PROJECTS</h1>
    <p>USER</p>
    <b-card-text>{{ user }}</b-card-text>
  </div>
</template>

<script>
import { getAgencyMembers } from "../../api/agencies";

export default {
  name: "Projects",
  data() {
    return {
      user: {},
      projects: [],
      agency: {},
    };
  },
  created() {
    const user = JSON.parse(localStorage.getItem("user"));
    this.getAllAgencyMembers(user["agency"].substr(-1)); //retrieve user index from @id
  },
  methods: {
    getAllAgencyMembers(id) {
      getAgencyMembers(id).then((res) => {
        console.log(res.data)
        this.agency = res.data;
        res.data.projects.forEach((project) => {
          this.projects.push(project);
        });
      });
    },
  },
};
</script>

<style scoped>
.flex-basis-50 {
  flex-basis: 50%;
}

main {
  background-color: #e5e5e5;
  padding: 2em;
}

main > section {
  background-color: white;
  margin: 1em;
  padding: 0 1em;
  border-radius: 10px;
}

.header-section-div {
  align-content: center;
  flex-direction: column;
  justify-content: space-between;
  height: 100%;
  padding: 1em;
}

.modify-btn {
  color: #f7b000;
  background: none;
  border: none;
}
</style>
