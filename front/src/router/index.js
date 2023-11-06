import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const guest = (to, from, next) => {
  if (!localStorage.getItem("authToken")) {
    return next();
  } else {
    return next("/");
  }
};
const auth = (to, from, next) => {
  if (localStorage.getItem("authToken")) {
    return next();
  } else {
    return next("/login");
  }
};

const routes = [
  {
    path: "/",
    name: "Home",
    component: () => import(/* webpackChunkName: "home" */ "../views/Home.vue")
  },
  {
    path: "/login",
    name: "Login",
    beforeEnter: guest,
    component: () =>
      import(/* webpackChunkName: "login" */ "../views/Auth/Login.vue")
  },
  // {
  //   path: "/register",
  //   name: "Register",
  //   beforeEnter: guest,
  //   component: () =>
  //     import(/* webpackChunkName: "register" */ "../views/Auth/Register.vue")
  // },

  {
    path: "/companies",
    name: "companyIndex",
    component: () =>
      import("../views/company/companyIndex.vue")
  },

  {
    path: "/createCompany",
    name: "createCompany",
   component: () =>
      import("../views/company/companyCreate.vue")
  },

  {
    path: "/companyEdit",
    name: "companyEdit",
    component: () =>
      import("../views/company/companyEdit.vue")
  },


  {
    path: "/employees",
    name: "employeeIndex",
    component: () =>
      import("../views/employee/employeeIndex.vue")
  },

  {
    path: "/employeeCreate",
    name: "employeeCreate",
    component: () =>
      import("../views/employee/employeeCreate.vue")
  },

  {
    path: "/employeeEdit",
    name: "employeeEdit",
    component: () =>
      import("../views/employee/employeeEdit.vue")
  },



  {
    path: "/verify/:hash",
    name: "Verify",
    beforeEnter: auth,
    props: true,
    component: () =>
      import(/* webpackChunkName: "verify" */ "../views/Auth/Verify.vue")
  }
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

export default router;
