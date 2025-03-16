import { createRouter, createWebHistory } from "vue-router";
import EmployeeTable from "./components/EmployeeTable.vue";

const routes = [
  { path: "/", component: EmployeeTable },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});