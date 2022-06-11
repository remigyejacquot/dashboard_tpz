<template>
<div class="row vh-100 vw-100 p-0">
<navSidebar></navSidebar>
  <div class="container bg-light col-10 px-3">
    <div class="justify-content-between d-flex" style="height: 100px">
      <div
        class="rounded-lg d-flex bg-white mt-4 align-items-center justify-content-between p-3"
        style="width: 49%; border-radius: 15px"
      >
        <h1 style="font-size: 20px" class="m-0">Gestion des projets</h1>
        <span></span>
      </div>
      <div
        :class="'d-flex mt-4 align-items-center justify-content-between p-3 ' + (this.isDisplay === 'communication' ? 'orange-bg' : 'purple-bg')"
        style="width: 49%; border-radius: 15px;"
      >
        <div class="d-flex flex-column">
          <div>
            <h2
              style="font-size: 24px; font-weight: bold"
              class="text-white p-0 m-0"
            >
              Licence {{isDisplay}}
            </h2>
            <div :style="this.isDisplay === 'developpement' ? 'color: white' : ''">
              <span>{{ isDisplay === 'communication' ? comAgencies.length : devAgencies.length }} groupes</span>
            </div>
          </div>
        </div>
        <div>
          <div
            @click="toggleLicence"
            style="height: 30px; border-radius: 10px; border: solid white 2px"
            class="d-flex align-items-center"
          >
            <span
              :class="'h-100 text-center ' + (this.isDisplay === 'communication' ? 'active' : 'desactive')"
              id="communication-switch"
              style="border-radius: 5px 0 0 5px; color: #f7b000;"
              @click="changeDisplay"
              >com</span
            >
            <span
              :class="'h-100 text-center ' + (this.isDisplay === 'developpement' ? 'active' : 'desactive')"
              id="developpement-switch"
              style="border-radius: 0 5px 5px 0; color: #4D3677;"
              @click="changeDisplay"
              >dev</span
            >
          </div>
        </div>
      </div>
    </div>
    <section class="bg-white p-5 mt-4" style="border-radius: 15px">
      <h2 style="font-size: 28px; font-weight: bold" class="mb-4">
        Membres du bureau
      </h2>
      <div class="d-flex flex-row justify-content-around w-100">
        <div class="col-5">
          <h4
            style="
              color: rgba(77, 54, 119, 1);
              font-size: 18px;
              font-weight: bolder;
            "
          >
            Licence développement
          </h4>
          <ul style="list-style: none" class="p-0 m-0">
            <li
              style="
                border-radius: 10px;
                color: white;
                background-color: rgba(77, 54, 119, 0.82);
                height: 35px;
              "
              class="d-flex justify-content-between align-items-center p-2 mb-2"
            >
              <div class="d-flex flex-row align-items-center w-100">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  style="width: 30px; height: 30px; margin-right: 5px"
                  viewBox="0 0 20 20"
                  fill="white"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                    clip-rule="evenodd"
                  />
                </svg>
                <template v-for="deskUser in deskMembers">
                  <span class="d-flex justify-content-between w-100" v-if="(deskUser.tpzRolesArray.includes('president') || deskUser.tpzRolesArray.includes('vice-president') ) && deskUser.is_dev" v-bind:key="deskUser.id">
                    {{ deskUser.firstname }} {{ deskUser.lastname }}
                    <span> {{deskUser.tpzRolesArray.includes('president') ? 'Président' : 'Vice-président'}} </span>
                  </span>
                </template>
              </div>
            </li>
            <li
              style="
                border-radius: 10px;
                background-color: rgba(249, 245, 255, 1);
                height: 35px;
              "
              class="d-flex justify-content-between align-items-center p-2 mb-2"
            >
              <div class="d-flex flex-row align-items-center w-100">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  style="width: 30px; height: 30px; margin-right: 5px"
                  viewBox="0 0 20 20"
                  fill="black"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                    clip-rule="evenodd"
                  />
                </svg>
                <template v-for="deskUser in deskMembers">
                  <span class="d-flex justify-content-between w-100" v-if="(deskUser.tpzRolesArray.includes('tresorier') || deskUser.tpzRolesArray.includes('vice-tresorier')) && deskUser.is_dev" v-bind:key="deskUser.id">
                    {{ deskUser.firstname }} {{ deskUser.lastname }}
                    <span> {{deskUser.tpzRolesArray.includes('tresorier') ? 'Trésorier' : 'Vice-trésorier'}} </span>
                  </span>
                </template>
              </div>
            </li>
            <li
              style="
                border-radius: 10px;
                background-color: rgba(249, 245, 255, 1);
                height: 35px;
              "
              class="d-flex justify-content-between align-items-center p-2 mb-2"
            >
              <div class="d-flex flex-row align-items-center w-100">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  style="width: 30px; height: 30px; margin-right: 5px"
                  viewBox="0 0 20 20"
                  fill="black"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                    clip-rule="evenodd"
                  />
                </svg>
                <template v-for="deskUser in deskMembers">
                  <span class="d-flex justify-content-between w-100" v-if="(deskUser.tpzRolesArray.includes('secretaire') || deskUser.tpzRolesArray.includes('vice-secretaire')) && deskUser.is_dev" v-bind:key="deskUser.id">
                    {{ deskUser.firstname }} {{ deskUser.lastname }}
                    <span> {{deskUser.tpzRolesArray.includes('secretaire') ? 'Secrétaire' : 'Vice-secrétaire'}} </span>
                  </span>
                </template>
              </div>
            </li>
          </ul>
        </div>
        <div class="col-5">
          <h4 style="color: rgba(247, 176, 0, 0.57); font-size: 18px; font-weight: bolder">
            Licence communication
          </h4>
          <ul style="list-style: none" class="p-0 m-0">
            <li
              style="
                border-radius: 10px;
                color: white;
                background-color: rgba(247, 176, 0, 0.57);
                height: 35px;
              "
              class="d-flex justify-content-between align-items-center p-2 mb-2"
            >
              <div class="d-flex flex-row align-items-center w-100">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  style="width: 30px; height: 30px; margin-right: 5px"
                  viewBox="0 0 20 20"
                  fill="white"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                    clip-rule="evenodd"
                  />
                </svg>
                <template v-for="deskUser in deskMembers">
                  <span class="d-flex justify-content-between w-100" v-if="(deskUser.tpzRolesArray.includes('president') || deskUser.tpzRolesArray.includes('vice-president') ) && !deskUser.is_dev" v-bind:key="deskUser.id">
                    {{ deskUser.firstname }} {{ deskUser.lastname }}
                    <span> {{deskUser.tpzRolesArray.includes('president') ? 'Président' : 'Vice-président'}} </span>
                  </span>
                </template>
              </div>
            </li>
            <li
              style="
                border-radius: 10px;
                background-color: rgba(255, 242, 208, 0.57);
                height: 35px;
              "
              class="d-flex justify-content-between align-items-center p-2 mb-2"
            >
              <div class="d-flex flex-row align-items-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  style="width: 30px; height: 30px; margin-right: 5px"
                  viewBox="0 0 20 20"
                  fill="black"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                    clip-rule="evenodd"
                  />
                </svg>
                <template v-for="deskUser in deskMembers">
                  <span class="d-flex justify-content-between w-100" v-if="(deskUser.tpzRolesArray.includes('tresorier') || deskUser.tpzRolesArray.includes('vice-tresorier')) && !deskUser.is_dev" v-bind:key="deskUser.id">
                    {{ deskUser.firstname }} {{ deskUser.lastname }}
                    <span> {{deskUser.tpzRolesArray.includes('tresorier') ? 'Trésorier' : 'Vice-trésorier'}} </span>
                  </span>
                </template>
              </div>
            </li>
            <li
              style="
                border-radius: 10px;
                background-color: rgba(255, 242, 208, 0.57);
                height: 35px;
              "
              class="d-flex justify-content-between align-items-center p-2 mb-2"
            >
              <div class="d-flex flex-row align-items-center w-100">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  style="width: 30px; height: 30px; margin-right: 5px"
                  viewBox="0 0 20 20"
                  fill="black"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                    clip-rule="evenodd"
                  />
                </svg>
                <template v-for="deskUser in deskMembers">
                  <span class="d-flex justify-content-between w-100" v-if="(deskUser.tpzRolesArray.includes('secretaire') || deskUser.tpzRolesArray.includes('vice-secretaire')) && !deskUser.is_dev" v-bind:key="deskUser.id">
                    {{ deskUser.firstname }} {{ deskUser.lastname }}
                    <span> {{deskUser.tpzRolesArray.includes('secretaire') ? 'Secrétaire' : 'Vice-secrétaire'}} </span>
                  </span>
                </template>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </section>
    <section class="d-flex gap-4 mt-4 d-flex flex-wrap">
      <project-preview v-for="agence in agenciesToDisplay" v-bind:key="agence.id" :agence="agence"/>
    </section>
    <!--    <h1>DASHBOARD</h1>-->
    <!--    <p>USER</p>-->
    <!--    <b-card-text>{{ user }}</b-card-text>-->
    <!--    <p>TOUTES LES AGENCES DE LA LICENCE {{user.is_dev ? 'DEV' : 'COM'}}</p>-->
    <!--    <b-button @click="toggleLicence">CHANGER DE LICENCE</b-button>-->
    <!--    <b-card-text v-for="agency in agencies" :key="agency.id">{{ agency }}</b-card-text>-->
    <!--    <p>TPZMEMBERS</p>-->
    <!--    <b-card-text v-for="member in tpzMembers" :key="member.id">{{ member }}</b-card-text>-->
    <!--    <b-button :to="{name: 'Projects'}">LES PROJETS</b-button>-->
  </div>
  </div>
</template>

<script>
import NavSidebar from "../components/navSidebar";
import { getAllTpzMembers } from "../../api/tpzMembers";
import { getUser } from "../../api/users";
import { getTpz } from "../../api/tpzs";
import ProjectPreview from "../components/ProjectPreview";
import {getMembresBureau} from "../../api/gestion";

export default {
  name: "Dashboard",
  components: { ProjectPreview, NavSidebar},
  data() {
    return {
      user: {},
      devAgencies: [],
      comAgencies: [],
      tpzMembers: [],
      deskMembers: [],
      agenciesToDisplay : [],
      type: "",
      isDisplay : "communication"
    };
  },
  created() {
    const userId =
      JSON.parse(localStorage.getItem("user")).id ||
      JSON.parse(localStorage.getItem("user"))["@id"].substr(-1);
    this.fetchInfo(userId);
    this.fetchTpzMembers();
  },
  methods: {
    fetchInfo(id) {
      getUser(id).then((res) => {
        this.user = res.data;
        this.type = res.data.is_dev ? "dev" : "com";
        localStorage.setItem("user", JSON.stringify(res.data));
        localStorage.setItem("tpzId", JSON.stringify(res.data.tpzId)); // store the user in localstorage
        if (res.data.tpzId) {
          getTpz(res.data.tpzId).then((res) => {
            this.devAgencies = res.data.agencies.filter(
              (el) => el.is_dev === true
            );
            this.comAgencies = res.data.agencies.filter(
              (el) => el.is_dev !== true
            );
            this.agenciesToDisplay = this.comAgencies
          });
          getMembresBureau(res.data.tpzId).then((res) => {
            this.deskMembers = res.data
          })
        }
      });
    },
    fetchTpzMembers() {
      getAllTpzMembers().then((res) => {
        res.data["hydra:member"].forEach((member) => {
          this.tpzMembers.push(member);
        });
      });
    },
    toggleLicence() {
      this.type === "dev" ? (this.type = "com") : (this.type = "dev");
    },
    changeDisplay() {
      this.isDisplay = this.isDisplay === 'communication' ? 'developpement' : 'communication'
      this.agenciesToDisplay = this.isDisplay === 'communication' ? this.comAgencies : this.devAgencies
    }
  },
};
</script>

<style>
.active {
  background-color: white;
  width: 50px;
  cursor: pointer;
}

.desactive {
  color : white !important;
  background-color: transparent;
  width: 50px;
  cursor: pointer;
}

.purple-bg {
  background-color: rgba(77, 54, 119, 0.82);
}

.orange-bg {
  background-color: rgba(247, 176, 0, 0.57);
}


.orange-light {
  background-color: rgba(255, 242, 208, 0.57);
}

.purple-light {
  background-color: rgba(249, 245, 255, 1);
}

</style>
