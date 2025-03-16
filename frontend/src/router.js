import { createRouter, createWebHistory } from "vue-router";
import EmployeeTable from "./components/EmployeeTable.vue";
import FutureChangeTable from "./components/FutureChangeTable.vue";

const routes = [
  { path: "/", component: EmployeeTable },
  { path: "/future-changes", component: FutureChangeTable },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});