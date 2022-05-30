<template>
  <div class="container bg-light">
    <div class="justify-content-between d-flex" style="height: 100px">
      <div
        class="rounded-lg d-flex bg-white mt-4 align-items-center justify-content-between p-3"
        style="width: 49%; border-radius: 15px"
      >
        <h1 style="font-size: 24px">Gestion des projets</h1>
        <span v-if="user.tpzId">{{ user.tpzId }}</span>
      </div>
      <div
        class="d-flex mt-4 align-items-center justify-content-between p-3"
        style="width: 49%; border-radius: 15px; background-color: #f7b000"
      >
        <div class="d-flex flex-column">
          <div>
            <h2
              style="font-size: 24px; font-weight: bold"
              class="text-white p-0 m-0"
            >
              Licence communication
            </h2>
            <div>
              <span>5 groupes</span><span> | </span><span>24 élèves</span>
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
              class="bg-white h-100 text-center"
              style="
                border-radius: 5px 0 0 5px;
                width: 50px;
                cursor: pointer;
                color: #f7b000;
              "
              >com</span
            >
            <span
              class="text-white h-100 text-center"
              style="border-radius: 0 5px 5px 0; width: 50px; cursor: pointer"
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
      <div class="d-flex flex-row justify-content-around w-75">
        <div style="width: 40%">
          <h4
            style="
              color: rgba(77, 54, 119, 1);
              font-size: 18px;
              font-weight: bolder;
            "
          >
            Licence Communication
          </h4>
          <ul style="list-style: none" class="p-0 m-0">
            <li
              style="
                border-radius: 10px;
                color: white;
                background-color: rgba(77, 54, 119, 1);
                height: 35px;
              "
              class="d-flex justify-content-between align-items-center p-2 mb-2"
            >
              <div class="d-flex flex-row align-items-center">
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
                  <span v-if="deskUser.tpzRolesArray.includes('président', 'vice-président') && !deskUser.is_dev" v-bind:key="deskUser.id">
                    {{ user.firstname }} {{ user.lastname }}
                  </span>
                </template>
              </div>
              <span> Président </span>
            </li>
            <li
              style="
                border-radius: 10px;
                background-color: rgba(77, 54, 120, 0.2);
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
                  <span v-if="deskUser.tpzRolesArray.includes('trésorier', 'vice-trésorier') && !deskUser.is_dev" v-bind:key="deskUser.id">
                    {{ user.firstname }} {{ user.lastname }}
                  </span>
                </template>
              </div>
              <span> Trésorier </span>
            </li>
            <li
              style="
                border-radius: 10px;
                background-color: rgba(77, 54, 120, 0.2);
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
                  <span v-if="deskUser.tpzRolesArray.includes('secrétaire', 'vice-secrétaire') && !deskUser.is_dev" v-bind:key="deskUser.id">
                    {{ user.firstname }} {{ user.lastname }}
                  </span>
                </template>
              </div>
              <span> Secrétaire </span>
            </li>
          </ul>
        </div>
        <div style="width: 40%">
          <h4 style="color: #f7b000; font-size: 18px; font-weight: bolder">
            Licence développement
          </h4>
          <ul style="list-style: none" class="p-0 m-0">
            <li
              style="
                border-radius: 10px;
                color: white;
                background-color: #f7b000;
                height: 35px;
              "
              class="d-flex justify-content-between align-items-center p-2 mb-2"
            >
              <div class="d-flex flex-row align-items-center">
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
                  <span v-if="deskUser.tpzRolesArray.includes('président', 'vice-président') && deskUser.is_dev" v-bind:key="deskUser.id">
                    {{ user.firstname }} {{ user.lastname }}
                  </span>
                </template>
              </div>
              <span> Président </span>
            </li>
            <li
              style="
                border-radius: 10px;
                background-color: rgba(245, 175, 0, 0.42);
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
                  <span v-if="deskUser.tpzRolesArray.includes('trésorier', 'vice-trésorier') && !deskUser.is_dev" v-bind:key="deskUser.id">
                    {{ user.firstname }} {{ user.lastname }}
                  </span>
                </template>
              </div>
              <span> Trésorier </span>
            </li>
            <li
              style="
                border-radius: 10px;
                background-color: rgba(245, 175, 0, 0.42);
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
                <span> John Doe 3 </span>
              </div>
              <span> Secrétaire </span>
            </li>
          </ul>
        </div>
      </div>
    </section>
    <section class="d-flex gap-4 mt-4">
      <project-preview />
      <project-preview />
      <project-preview />
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
</template>

<script>
import { getAllTpzMembers } from "../../api/tpzMembers";
import { getUser } from "../../api/users";
import { getTpz } from "../../api/tpzs";
import ProjectPreview from "../components/ProjectPreview";
import {getMembresBureau} from "../../api/gestion";

export default {
  name: "Dashboard",
  components: { ProjectPreview },
  data() {
    return {
      user: {},
      devAgencies: [],
      comAgencies: [],
      tpzMembers: [],
      deskMembers: [],
      type: "",
    };
  },
  created() {
    const userId =
      JSON.parse(localStorage.getItem("user")).id ||
      JSON.parse(localStorage.getItem("user"))["@id"].substr(-1);
    this.fetchInfo(userId);
    console.log(userId);
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
  },
};
</script>

<style></style>
