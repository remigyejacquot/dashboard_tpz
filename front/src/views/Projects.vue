<template>
  <div class="row min-vh-100 vw-100 p-0">
    <navSidebar></navSidebar>
    <main class="container bg-light col-10 px-3">
      <section
          class="title-section d-flex justify-content-between align-items-center item-project"
      >
        <div class="d-flex header-section-div flex-column">
          <b-form-select v-model="selectedProject" :options="projects" text-field="text" value-field="value" class="mb-2"></b-form-select>
          <div class="d-flex w-100 justify-content-between align-items-center">
          <b-progress :max="progressProject.max" variant="warning" striped animated class="w-100 me-2">
            <b-progress-bar :value="progressProject.value"/>
          </b-progress>
            <p class="m-0">{{progressProject.value}}%</p>
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
          class="switch-section d-flex justify-content-between align-items-center item-agency"
      >
        <div class="d-flex header-section-div flex-column">
          <h2>{{agency.name}}</h2>
          <ul id="example-1">
            <li v-for="member in agency.users" :key="member.id">
              <div>
              {{ member.firstname }}
              {{ member.lastname }}
                <font-awesome-icon class="icon" icon="fa-solid fa-crown" v-if="member.tpz_role.find(el=>el.role === 'chef d\'agence')"/>
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
      <section class="d-flex flex-column item-tasks">
        <div class="d-flex header-section-div h-auto justify-content-between w-100">
          <h2>Tâches</h2>
          <b-button v-b-modal.addNewTaskModal style="background-color: transparent; border: none">
            <b-icon
                icon="plus-circle-fill"
                style="color: #f96197"
                font-scale="1.5"
                class="icon-btn"/>
          </b-button>
        </div>
        <div>
          <table>
            <tr v-for="task in tasks" :key="task['@id']" @click="setCurrentTask(task)">
              <td class="w-100">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                    <font-awesome-icon
                        v-model="tasks"
                        v-if="task.is_finished"
                        class="icon icon-valid"
                        icon="fa-solid fa-check"
                    />
                    <font-awesome-icon v-else class="icon" icon="fa-solid fa-spinner" />

                    {{task.title}}
                  </div>
                </div>
              </td>
              <td>{{new Date(task.updated_at).toLocaleDateString()}}</td>
            </tr>
          </table>
        </div>
      </section>
      <section class="d-flex flex-column item-subtasks">
        <div class="header-section-div h-auto">
          <h2>{{currentTask.title}}</h2>
          {{currentTask.description}}
          <div class="d-flex align-items-center">
            <b-progress :max="progressTask.max" variant="warning" striped animated class="w-100 me-2">
              <b-progress-bar :value="progressTask.value"/>
            </b-progress>
            <p class="m-0">{{progressTask.value}}%</p>
          </div>
          <b-form-checkbox
              v-for="subtask in subtasks" :key="subtask.value['@id']" :value="subtask.value" @change="toggleSubtasks(subtask)" v-model="finishedSubTasks"
          >
            {{subtask.text}}
          </b-form-checkbox>
        </div>
          <b-button style="background-color: #57C7D4; border: none; width: 30%" @click="addNewSubtask">Ajouter</b-button>
      </section>
      {{newTask}}
    <div>
      <b-modal id="addNewTaskModal" ref="modal" centered title="Ajouter une nouvelle tâche" hide-footer @show="resetModal" @hidden="resetModal" class="custom-modal">
        <form ref="form">
          <b-form-group
              label="Titre"
              label-for="task-title-input"
              invalid-feedback="Le titre est requis"
          >
            <b-form-input
                id="task-title-input"
                v-model="newTask.title"
                required
            ></b-form-input>

          </b-form-group><b-form-group
              label="Description"
              label-for="task-title-input"
              invalid-feedback="La description est requise"
          >
          <b-form-input
              id="task-desc-input"
              v-model="newTask.description"
              required
          ></b-form-input>
          <button class="mt-3 mr-2 grey-button" @click="$bvModal.hide('addNewTaskModal')">Annuler</button>
          <button class="mt-3 valid-button" @click="addNewTask">Ajouter</button>
          </b-form-group>
        </form>
      </b-modal>
    </div>
    </main>
  </div>
</template>

<script>
import NavSidebar from "../components/navSidebar";
import { getAgencyMembers } from "../../api/agencies";
import {updateSubtasks} from "../../api/subtasks";
import {addTask, updateTask} from "../../api/tasks";

class Task {
  title
  description
  isFinished
  project
  subtasks
  createdAt
  updatedAt
  finishedAt

  constructor(title='', description='', isFinished=false, project='', subtasks = [], createdAt= new Date(), updateAt = new Date(), finishedAt= new Date()) {
    this.title = title
    this.description = description
    this.isFinished = isFinished
    this.project = project
    this.subtasks = subtasks
    this.createdAt = createdAt
    this.updatedAt = updateAt
    this.finishedAt = finishedAt
  }
}

export default {
  name: "Projects",
  components: { NavSidebar },
  data() {
    return {
      user: {},
      agency: {
        users:[]
      },
      selectedProject: {},
      finishedTasks: [],
      finishedSubTasks: [],
      projects: [],
      tasks:[],
      subtasks:[],
      currentTask:{},
      progressProject: {
        value:0,
        max:100
      },
      progressTask: {
        value:0,
        max:100
      },
      newTask: new Task()
    };
  },
  created() {
    const user = JSON.parse(localStorage.getItem("user"));
    this.user = user
    this.getAllAgencyMembers(user["agency"].substr(-1)); //retrieve user index from @id
  },
  watch: {
    selectedProject(currentProject) {
      this.tasks=[]
      this.finishedTasks = []
      currentProject.tasks.forEach((task)=>{
        this.tasks.push(task)
        if(task.is_finished){
          this.finishedTasks.push(task)
        }
      })
      this.progressProject.value = Math.floor((this.finishedTasks.length/currentProject.tasks.length)*100)
      //make shallow copy of currentProject array
      this.currentTask = [...currentProject.tasks].shift()
    },
    currentTask(task) {
      this.subtasks = []
      this.progressTask.value = 0
      this.finishedSubTasks = []
      task.subtasks.forEach((subtask) => {
        this.subtasks.push({
          value: subtask,
          text: subtask.title
        })
        if (subtask.is_finished) {
          this.finishedSubTasks.push(subtask)
        }
      })
      if (this.finishedSubTasks.length === task.subtasks.length && task.subtasks.length !== 0) {
        task.is_finished = true

      } else {
        task.is_finished = false
      }
      this.progressTask.value = Math.floor((this.finishedSubTasks.length / task.subtasks.length) * 100) || 0
      this.progressProject.value = Math.floor((this.finishedTasks.length / this.tasks.length) * 100) || 0
    },
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
        this.selectedProject = res.data.projects.shift()
      });
    },
    addNewTask(e){
      e.preventDefault()
      this.newTask.project = this.selectedProject['@id']
      addTask(this.newTask).then(res=>{
        this.tasks.push(res.data)
        this.$bvModal.hide('addNewTaskModal')
        this.progressProject.value = Math.floor((this.finishedTasks.length/this.tasks.length)*100)
      }).catch(err=>{
        console.log(err)
      })
    },
    setCurrentTask(task) {
      this.currentTask = task
    },
    toggleSubtasks(subtask){
      if(this.finishedSubTasks.find(el=>el['@id'] === subtask.value['@id'])){
        updateSubtasks(subtask.value['@id'].substr(-1), {
          isFinished : true
        }).then(res=>{
         subtask.value.is_finished = res.data.isFinished
        })
      } else {
        updateSubtasks(subtask.value['@id'].substr(-1), {
          isFinished : false
        }).then(res=>{
          subtask.value.is_finished = res.data.isFinished

        })
      }
      this.progressTask.value = Math.floor((this.finishedSubTasks.length/this.subtasks.length)*100)
      if(this.finishedSubTasks.length === this.currentTask.subtasks.length && this.currentTask.subtasks.length !== 0) {
        updateTask(this.currentTask['@id'].substr(-1),{
          isFinished: true
        }).then(res=>{
          this.currentTask.is_finished = true
          if(!this.finishedTasks.some(el=>el['@id'] === this.currentTask['@id'])){
            this.finishedTasks.push(this.currentTask)
          }
          this.progressProject.value = Math.floor((this.finishedTasks.length/this.tasks.length)*100)
          console.log(res)
        }).catch(err=>{
          console.log(err)
        })
      } else {
          updateTask(this.currentTask['@id'].substr(-1), {
            isFinished: false
          }).then(res=>{
            this.currentTask.is_finished = false
            console.log('debug',this.finishedTasks.filter(el=>el['@id'] !== this.currentTask['@id']))
            this.finishedTasks = this.finishedTasks.filter(el=>el['@id'] !== this.currentTask['@id'])
            this.progressProject.value = Math.floor((this.finishedTasks.length/this.tasks.length)*100)

            console.log(res)
          }).catch(err=>{
            console.log(err)
          })
      }
      console.log(this.finishedTasks.length)
    },
    addNewSubtask(){
    },
    resetModal() {
      this.newTask = new Task()
    },
  },
};
</script>

<style scoped>
@import '../assets/css/modal.css';
.container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: auto;
  grid-template-areas:
    "project agency"
    "tasks subtasks"
    "tasks subtasks";
  justify-items: stretch;
}

item-project {
  grid-area: project;
}
item-agency {
  grid-area: agency;
}
item-tasks {
  grid-area: tasks;
}
item-subtasks {
  grid-area: subtasks;
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
  border: 1px solid #FAD26E;
  padding: .5em
}

tr:hover {
  background-color: #FAD26E20;
}

.icon {
  color:#f7b000;
  margin: .5em;
}
.icon-valid {
  color: green;
}
</style>
