<template>
  <div class="row min-vh-100 vw-100 p-0">
    <navSidebar></navSidebar>
    <main class="container bg-light col-10 px-3">
      <section
          class="title-section d-flex justify-content-between align-items-center"
      >
        <div class="d-flex header-section-div flex-column">
          <b-form-select v-model="selected" :options="projects" text-field="text" value-field="value" class="mb-2"></b-form-select>
          <div class="d-flex w-100 justify-content-between align-items-center">
          <b-progress :max="progress.max" variant="warning" striped animated class="w-100 me-2">
            <b-progress-bar :value="progress.value"/>
          </b-progress>
            <p class="m-0">{{progress.value}}%</p>
          </div>
        </div>
        <div class="d-flex header-section-div flex-column justify-content-between align-items-end">
          <b-icon
              icon="plus-circle-fill"
              style="color: #f96197"
              font-scale="1.5"
              @click="()=>{}"
              class="icon-btn"/>
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
        <div class="d-flex header-section-div flex-column">
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
        <div class="d-flex header-section-div flex-column justify-content-between align-items-end">
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
                class="icon-btn"/>
            <button class="modify-btn">Modifier</button>
          </div>
        </div>
      </section>
      <section class="d-flex flex-column">
        <div class="d-flex header-section-div h-auto justify-content-between w-100">
          <h2>Tâches</h2>
          <b-icon
              icon="plus-circle-fill"
              style="color: #f96197"
              font-scale="1.5"
              @click="()=>{}"
              class="icon-btn"/>
        </div>
        <div>
          <table>
            <tr v-for="task in tasks" :key="task['@id']" @click="setCurrentTask(task)">
              <td class="w-100">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                  <b-icon
                      v-if="task.is_finished"
                      icon="check"
                      style="color: green"
                      font-scale="2"
                      @click="()=>{}"
                      class="icon-btn"
                  />
                  <b-icon
                      v-else
                      icon="dash"
                      style="color: black"
                      font-scale="2"
                      @click="()=>{}"
                      class="icon-btn"
                  />
                  {{task.title}}
                  </div>
                  <div>
                    <b-icon
                        icon="plus-circle-fill"
                        style="color:#FAD26E"
                        font-scale="1.5"
                        @click="()=>{}"
                        class="icon-btn"/>
                  </div>
                </div>
              </td>
              <td>{{new Date(task.updated_at).toLocaleDateString()}}</td>
            </tr>
          </table>
        </div>
      </section>
      <section>
        {{currentTask.title}}
        {{currentTask.description}}
        {{currentTask.subtasks}}
      </section>
      <b-card-text>{{ projects }}</b-card-text>
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
      agency: {
        users:[]
      },
      selected: {},
      projects: [],
      tasks:[],
      currentTask:{},
      progress: {
        value:0,
        max:100
      },
    };
  },
  created() {
    const user = JSON.parse(localStorage.getItem("user"));
    this.user = user
    this.getAllAgencyMembers(user["agency"].substr(-1)); //retrieve user index from @id
  },
  watch: {
    selected(currentProject) {
      const totalProgress = (currentProject.tasks.filter(el=>el.is_finished === true).length/currentProject.tasks.length)*100
      this.progress.value = totalProgress
      this.tasks=[]
      currentProject.tasks.forEach((task)=>{
        this.tasks.push(task)
      })
      this.currentTask = currentProject.tasks.shift()
    }
  },
  methods: {
    getAllAgencyMembers(id) {
      getAgencyMembers(id).then((res) => {
        this.agency = res.data;
        res.data.projects.forEach((project) => {
          //Useful to display in the select
          this.projects.push({
            value:project,
            text:project.name
          });
        });
        this.selected = res.data.projects.shift()
      });
    },
    setCurrentTask(task) {
      this.currentTask = task
    }
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

h2 {
  color: #FAD26E;
}

.header-section-div {
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

td {
  border: 1px solid black;
  padding: .5em
}

tr:hover {
  background-color: #FAD26E;
}
</style>
