import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
/* import specific icons */
import {faUsers, faUserTie, faUsersGear, faUserPen, faPen, faChalkboardUser, faUserGroup, faGear, faCrown, faArrowRightFromBracket } from '@fortawesome/free-solid-svg-icons'
/* import font awesome icon component */
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

library.add(faUsers, faUserTie, faUsersGear, faUserPen, faPen)

Vue.component('font-awesome-icon', FontAwesomeIcon)

// Import Bootstrap an BootstrapVue CSS files (order is important)
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

/* add icons to the library */
library.add(faChalkboardUser, faUserGroup, faGear, faCrown, faUserTie,faArrowRightFromBracket)
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.config.productionTip = false;
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);


new Vue({
  router,
  render: (h) => h(App),
}).$mount("#app");
