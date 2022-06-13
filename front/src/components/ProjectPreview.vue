<template>
  <div
    style="width: 290px; border-radius: 15px"
    class="bg-white p-3 align-items-center d-flex flex-column wrapper-agence"
  >
    <div class="w-100 d-flex justify-content-end" v-if="this.user.roles && this.user.roles.includes('ROLE_ADMIN')">
      <commentary :groupe="agence.name" :agenceId="agence['@id'].replace(/\D/g,'')"></commentary>
    </div>
    <h3 class="mt-2 fw-bold" style="color: rgba(250, 210, 110, 1)">{{agence.name}}</h3>
    <div class="mb-2 d-flex align-items-center">
      <span style="color:rgba(77, 54, 119, 0.82);"> {{ agence.users.length }} </span>
      <font-awesome-icon icon="fa-solid fa-user-group" style="color:rgba(77, 54, 119, 0.82);"/>
    </div>
    <div class="mt-1">
      <p class="p-1 m-0 text-center" v-for="membre in agence.users" v-bind:key="membre.id" style="line-height: 15px" id="membres-liste-wrapper">
        {{ membre.firstname }} {{ membre.lastname }}
        <font-awesome-icon v-if="membre.tpzRolesArray && membre.tpzRolesArray.includes('chef de projet')" class="crown-icon" icon="fa-solid fa-crown"/>
      </p>
    </div>
    <div class="w-100 d-flex justify-content-center align-items-center" style="min-height: 240px">
      <div @click="slide('previous')" v-if="agence.projects.length > 0" class="d-flex justify-content-center align-items-center" style="height: 100px; margin-top: 55px">
        <font-awesome-icon icon="fa-solid fa-chevron-left"/>
      </div>
      <div class="w-100 d-flex flex-column justify-center align-items-center" :id="'projets-' + agence.name">
        <p class="mb-1 mt-3 text-start" style="width: 200px; color:rgba(77, 54, 119, 0.82); font-size: 18px">Projet(s): {{agence.projects.length}}</p>
        <div v-for="(projet, index) in agence.projects" v-bind:key="projet.index" :id="agence.name + '-' + index" :data-index="index" :class="'border border-4 rounded rounded-4 card-projet ' + (index !== 0 ? 'inactive' : 'isActive')" style="border-color: rgba(247, 176, 0, 0.57) !important;">
          <div class="border-bottom border-4 p-2 d-flex align-items-center gap-2 justify-content-between" style="border-color: rgba(247, 176, 0, 0.57) !important;">
            <div class="d-flex gap-2 align-items-center">
              <span
                style="width: 10px; height: 10px; cursor: pointer" id="tooltip-date"
                :class="'rounded-circle d-inline-block me-2 ' + checkUpdate(projet.updated_at)"
              />
              <b-tooltip target="tooltip-date" triggers="hover">
                Mis à jour le : {{ new Date(projet.updated_at).toLocaleDateString() }}
              </b-tooltip>
              <h5 class="d-inline-block m-0">{{projet.name}}</h5>
            </div>
          </div>
          <div class="p-3">
            <div class="d-flex w-100 justify-content-between align-items-center">
              <b-progress :max="100" class="w-100 me-2">
                <b-progress-bar class="bg-bleu" :value="projet.avancementNumber"/>
              </b-progress>
              <p class="m-0 blue">{{projet.avancementNumber}}%</p>
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
                  <p class="title m-0">{{ projet.lastTasks.title }}}</p>
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
    },
    checkUpdate(date) {
      const today = new Date()
      const toCheck1 = new Date(date)
      const toCheck2 = new Date(date)
      toCheck1.setDate(toCheck1.getDate() + 2 * 7)
      toCheck2.setDate(toCheck2.getDate() + 3 * 7)
      if(today < toCheck1) {
        return 'green'
      } else if (today > toCheck1  && today < toCheck2) {
        return 'orange'
      } else {
        return'red'
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

.rounded-circle.green {
  background-color:  #15C377;
}

.rounded-circle.orange {
  background-color: #fa9e1e;
}

.rounded-circle.red {
  background-color: #F03E3E;
}

.load {
  color: #F7B000;
}

.wrapper-agence {
  min-height: 550px;
}

.red-button:hover {
  color: white !important;
}
.blue {
  color: #57C7D4
}

.bg-bleu {
  background-color: #57C7D4 !important;
}
#membres-liste-wrapper {
  min-height: 100px;
}
</style>
