import Vue from "vue";
import VueRouter from "vue-router";
import Login from "../views/Login";
import Dashboard from "../views/Dashboard";
import ResetPassword from "../views/ResetPassword";
import Projects from "../views/Projects";
import Gestion from "../views/Gestion";
import Groupes from "../views/Groupes";
import GestionEtudiants from "../views/GestionEtudiants";
import Bureau from "../views/Bureau";
import "../assets/css/main.css";
import GestionProfesseurs from "../views/GestionProfesseurs";
import Register from "../views/Register";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Login",
    component: Login,
  },
  {
    path: "/register",
    name: "Register",
    component: Register,
  },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: Dashboard,
    props: true,
    meta: { requiresAuth: true },
  },
  {
    path: "/projects",
    name: "Projects",
    component: Projects,
    meta: { requiresAuth: true },
  },
  {
    path: "/resetpassword",
    name: "ResetPassword",
    component: ResetPassword
  },
  {
    path: "/gestion",
    name: "Gestion",
    component: Gestion,
    meta: { requiresAuth: true },
    children: [
      {
        path: '/gestion/groupes',
        name: 'Groupes',
        component: Groupes
      },
      {
        path: '/gestion/bureau',
        name: 'Bureau',
        component: Bureau
      },
      {
        path:'/gestion/etudiants',
        name: 'GestionEtudiants',
        component: GestionEtudiants
      },{
        path:'/gestion/professeurs',
        name: 'GestionProfesseurs',
        component: GestionProfesseurs
      },
    ]
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!localStorage.getItem("user")) {
      next({
        name: "Login",
      });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;
