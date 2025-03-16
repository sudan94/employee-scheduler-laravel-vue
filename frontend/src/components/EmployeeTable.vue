<template>
  <div class="container mt-5">
    <h2 class="mb-4 text-center">Employee Management</h2>

    <button class="btn btn-primary mb-3" @click="openAddModal">
      <i class="bi bi-plus-circle"></i> Add Employee
    </button>

    <table class="table table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Job Title</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="employee in store.employees" :key="employee.id">
          <td>{{ employee.id }}</td>
          <td>{{ employee.name }}</td>
          <td>{{ employee.email }}</td>
          <td>{{ employee.job_title }}</td>
          <td>
            <button class="btn btn-warning btn-sm me-2" @click="openEditModal(employee)">
              <i class="bi bi-pencil-square"></i> Edit
            </button>
            <button class="btn btn-info btn-sm me-2" @click="openScheduleChangeModal(employee)">
              <i class="bi bi-clock"></i> Schedule Change
            </button>
            <button class="btn btn-danger btn-sm" @click="store.deleteEmployee(employee.id)">
              <i class="bi bi-trash"></i> Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <nav v-if="store.pagination.last_page > 1">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: store.pagination.current_page === 1 }">
          <button class="page-link" @click="store.fetchEmployees(store.pagination.current_page - 1)">Previous</button>
        </li>

        <li class="page-item" v-for="page in store.pagination.last_page" :key="page" :class="{ active: page === store.pagination.current_page }">
          <button class="page-link" @click="store.fetchEmployees(page)">{{ page }}</button>
        </li>

        <li class="page-item" :class="{ disabled: store.pagination.current_page === store.pagination.last_page }">
          <button class="page-link" @click="store.fetchEmployees(store.pagination.current_page + 1)">Next</button>
        </li>
      </ul>
    </nav>

    <!-- Modals -->
    <EmployeeModal v-if="showModal" :employee="selectedEmployee" @close="showModal = false" />
    <ScheduleChangeModal v-if="showScheduleModal" :employee="selectedEmployee" @close="showScheduleModal = false" />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useEmployeeStore } from "../stores/employeeStore";
import EmployeeModal from "./EmployeeModal.vue";
import ScheduleChangeModal from "./ScheduleChangeModal.vue";

const store = useEmployeeStore();
const showModal = ref(false);
const showScheduleModal = ref(false);
const selectedEmployee = ref(null);

onMounted(() => {
  store.fetchEmployees();
});

const openAddModal = () => {
  selectedEmployee.value = null;
  showModal.value = true;
};

const openEditModal = (employee) => {
  selectedEmployee.value = { ...employee };
  showModal.value = true;
};

const openScheduleChangeModal = (employee) => {
  selectedEmployee.value = { ...employee };
  showScheduleModal.value = true;
};
</script>

<style>
/* Add spacing between buttons */
.btn {
  margin-right: 5px;
}
</style>
