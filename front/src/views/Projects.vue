<template>
  <div class="row min-vh-100 vw-100 p-0">
    <navSidebar></navSidebar>
    <main class="container bg-light col-10 px-3">
      <section
          class="title-section d-flex justify-content-between align-items-center"
      >
        <div class="d-flex header-section-div">
          <h2>Project Flyer</h2>
          <b-progress :max="progress.max" variant="warning" striped show-progress animated>
            <b-progress-bar :value="progress.value" :label="`${progress.value}%`" style="color: black"/>
          </b-progress>
        </div>
        <div class="d-flex header-section-div justify-content-between align-items-end">
          <b-icon
              icon="plus-circle-fill"
              style="color: #f96197"
              font-scale="1.5"
              @click="()=>{}"
              class="icon-btn"
          >+</b-icon>
          <div>
            <b-icon
                icon="pencil-fill"
                style="color: #f7b000"
                font-scale="1.2"
                @click="()=>{}"
                class="icon-btn"/>
            <button class="modify-btn">Modifier</button>
          </div>
        </div>
      </section>
      <section
          class="switch-section d-flex justify-content-between align-items-center"
      >
        <div class="d-flex header-section-div">
          <h2>{{agency.name}}</h2>
          <ul id="example-1">
            <li v-for="member in agency.users" :key="member.id">
              <div>
              {{ member.firstname }}
              {{ member.lastname }}
                <font-awesome-icon class="crown-icon" icon="fa-solid fa-crown" v-if="member.tpz_role.find(el=>el.role === 'chef d\'agence')"/>
              </div>
            </li>
          </ul>
        </div>
        <div class="d-flex header-section-div justify-content-between align-items-end">
          <b-card-text class="d-flex" style="color: #4D3677">
          <p>{{ agency.users.length }}</p>
          <b-icon
              icon="people-fill"
              style="color: #4D3677"
              font-scale="1.2"
              @click="()=>{}"
              class="icon-btn mx-1"/>
          </b-card-text>
          <div>
            <b-icon
                icon="pencil-fill"
                style="color: #f7b000"
                font-scale="1.2"
                @click="()=>{}"
                class="icon-btn"
            >+</b-icon>
            <button class="modify-btn">Modifier</button>
          </div>
        </div>
      </section>
      <h1>PROJECTS</h1>
      <p>USER</p>
      <b-card-text>{{ agency }}</b-card-text>
    </main>
  </div>
</template>

<script>
import NavSidebar from "../components/navSidebar";
import { getAgencyMembers } from "../../api/agencies";

export default {
  name: "Projects",
  components: { NavSidebar },
  data() {
    return {
      user: {},
      projects: [],
      agency: {
        users:[]
      },
      progress: {
        value:40,
        max:100
      },
    };
  },
  created() {
    const user = JSON.parse(localStorage.getItem("user"));
    this.user = user
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
.container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: auto;
  grid-template-areas:
    "list search"
    "list add";
  justify-items: stretch;
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
  flex-direction: column;
  height: 100%;
  padding: 1em;
}

li {
  list-style: none;
}

.modify-btn {
  color: #f7b000;
  background: none;
  border: none;
}
</style>
