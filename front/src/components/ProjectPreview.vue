<template>
  <div
    style="width: 290px; border-radius: 15px"
    class="bg-white p-3 align-items-center d-flex flex-column wrapper-agence"
  >
    <div class="w-100 d-flex justify-content-end" v-if="this.user.roles && this.user.roles.includes('ROLE_ADMIN')">
      <commentary :groupe="agence.name" :agenceId="agence['@id'].replace(/\D/g,'')"></commentary>
    </div>
    <h3 class="mt-2">{{agence.name}}</h3>
    <div class="mb-2 d-flex align-items-center">
      <span> {{ agence.users.length }} </span>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="2"
        width="20px"
        height="20px"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
        />
      </svg>
    </div>
    <div class="mt-1">
      <p class="p-1 m-0 text-center" v-for="membre in agence.users" v-bind:key="membre.id" style="line-height: 15px">
        {{ membre.firstname }} {{ membre.lastname }}
        <font-awesome-icon v-if="membre.tpzRolesArray && membre.tpzRolesArray.includes('chef de projet')" class="crown-icon" icon="fa-solid fa-crown"/>
      </p>
    </div>
    <div class="w-100 d-flex justify-content-center align-items-center" style="min-height: 240px">
      <div @click="slide('previous')" v-if="agence.projects.length > 0" class="d-flex justify-content-center align-items-center" style="height: 100px; margin-top: 55px">
        <font-awesome-icon icon="fa-solid fa-chevron-left"/>
      </div>
      <div class="w-100 d-flex flex-column justify-center align-items-center" :id="'projets-' + agence.name">
        <p class="mb-1 mt-3 text-start" style="width: 200px;">Projet(s): {{agence.projects.length}}</p>
        <div v-for="(projet, index) in agence.projects" v-bind:key="projet.index" :id="agence.name + '-' + index" :data-index="index" :class="'border border-4 rounded rounded-4 card-projet ' + (index !== 0 ? 'inactive' : 'isActive')" style="border-color: rgba(247, 176, 0, 0.57) !important;">
          <div class="border-bottom border-4 p-2 d-flex align-items-center gap-2 justify-content-between" style="border-color: rgba(247, 176, 0, 0.57) !important;">
            <div class="d-flex gap-2 align-items-center">
              <span
                style="width: 10px; height: 10px; background-color: green"
                class="rounded-circle d-inline-block me-2"
              />
              <h5 class="d-inline-block m-0">{{projet.name}}</h5>
            </div>
          </div>
          <div class="p-3">
            <div class="d-flex align-items-center justify-content-between">
              <div class="progress" style="width: 75%">
                <div
                  class="progress-bar"
                  role="progressbar"
                  aria-valuenow="0"
                  aria-valuemin="0"
                  aria-valuemax="100"
                ></div>
              </div>
              <span class="d-block" style="width: 20%">30%</span>
            </div>
            <div class="tasks" v-if="projet.lastTasks !== undefined && projet.lastTasks.length === 2">
              <div class="task d-flex justify-content-between align-items-center" v-for="task in projet.lastTasks" v-bind:key="task.id">
                <div>
                  <p class="m-0 date">{{ new Date(task.updated_at).toLocaleDateString() }}</p>
                  <p class="m-0 title">{{ task.title }}</p>
                </div>
                <font-awesome-icon v-if="task.is_finished" icon="fa-solid fa-check" class="check"/>
                <font-awesome-icon v-else icon="fa-solid fa-spinner" class="load"/>
              </div>
            </div>
            <div class="tasks" v-if="projet.lastTasks !== undefined && projet.lastTasks.length !== 2">
              <div class="task d-flex justify-content-between align-items-center">
                <div>
                  <p class="m-0 date">{{ new Date(projet.lastTasks.updated_at).toLocaleDateString() }}</p>
                  <p class="title m-0">{{ projet.lastTasks.title }}</p>
                </div>
                <font-awesome-icon v-if="projet.lastTasks.is_finished" icon="fa-solid fa-check" class="check"/>
                <font-awesome-icon v-else icon="fa-solid fa-spinner" class="load"/>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div @click="slide('next')" v-if="agence.projects.length > 0" class="d-flex justify-content-center align-items-center" style="height: 100px; margin-top: 55px">
        <font-awesome-icon icon="fa-solid fa-chevron-right"/>
      </div>
    </div>
    <router-link v-if="(this.user.roles && this.user.roles.includes('ROLE_ADMIN')) || agence['@id'] === this.user.agency"
                 :to="{ name: 'Projects', params: { agenceId: agence['@id'].replace(/\D/g,'') } }"
                 class="mt-3 red-button" style="background-color: #6D5A8F !important; padding: 5px 30px !important; font-size: 14px !important;">Voir le détail</router-link>
  </div>
</template>

<script>
import Commentary from "./commentary";

export default {
  name: "ProjectPreview",
  components: {Commentary},
  props : ['agence'],
  data() {
    return {
      user: ''
    }
  },
  created() {
    this.user = JSON.parse(localStorage.getItem("user"))
  },
  methods : {
    slide(to) {
      const projet = document.querySelector('#projets-' + this.agence.name + ' .isActive')
      if(projet) {
        const index = to === 'previous' ? parseInt(projet.getAttribute('data-index')) - 1 : parseInt(projet.getAttribute('data-index')) + 1
        if(index >= 0 && index <= this.agence.projects.length + 1) {
          const toDisplay = document.getElementById(this.agence.name + '-' + index)
          if (toDisplay) {
            projet.classList.remove('isActive')
            projet.classList.add('inactive')
            toDisplay.classList.remove('inactive')
            toDisplay.classList.add('isActive')
          }
        }
      }
    }
  }
};
</script>

<style>
.card-projet {
  width: 230px;
}

.card-projet.inactive {
  display: none;
  animation-delay: 3s;
  border: unset !important;
}

.card-projet.isActive {
  height: unset;
}

.task {
  margin-top: 5px;
  border-top: 1px solid #e1e1e1
}

.date {
  font-size: 15px;
}

.title {
  font-size: 14px;
  line-height: 10px;
}

.check {
  color: #15C377;
}

.load {
  color: #F7B000;
}

.wrapper-agence {
  min-height: 430px;
}

.red-button:hover {
  color: white !important;
}
</style>
