import Vue from "vue";
import VueRouter from "vue-router";
import Login from "../views/Login";
import Dashboard from "../views/Dashboard";
import ResetPassword from "../views/ResetPassword";
import Projects from "../views/Projects";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Login",
    component: Login,
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
    component: ResetPassword,
    meta: { requiresAuth: true },
  }
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
