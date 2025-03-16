<template>
  <div class="container-fluid mt-5">
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
          <th>Address</th>
          <th>Phone</th>
          <th>Job Title</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="employee in store.employees" :key="employee.id">
          <td>{{ employee.id }}</td>
          <td>{{ employee.name }}</td>
          <td>{{ employee.email }}</td>
          <td>{{ employee.address }}</td>
          <td>{{ employee.phone }}</td>
          <td>{{ employee.job_title }}</td>
          <td>
            <button class="btn btn-warning btn-sm me-2" title="Edit" @click="openEditModal(employee)">
              <i class="bi bi-pencil-square"></i>
            </button>
            <button class="btn btn-info btn-sm me-2" title="Schedule Change" @click="openScheduleChangeModal(employee)">
              <i class="bi bi-clock"></i>
            </button>
            <button class="btn btn-danger btn-sm" title="Delete" @click="openEmployeeDeleteModal(employee)">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <nav v-if="store.pagination.last_page > 1" class="d-flex justify-content-end">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: store.pagination.current_page === 1 }">
          <button class="page-link" @click="store.fetchEmployees(store.pagination.current_page - 1)">Previous</button>
        </li>

        <!-- First page -->
        <li class="page-item" :class="{ active: 1 === store.pagination.current_page }">
          <button class="page-link" @click="store.fetchEmployees(1)">1</button>
        </li>

        <!-- Left ellipsis -->
        <li class="page-item disabled" v-if="store.pagination.current_page > 3">
          <span class="page-link">...</span>
        </li>

        <!-- Pages around current page -->
        <li class="page-item" v-for="page in visiblePages" :key="page"
            :class="{ active: page === store.pagination.current_page }">
          <button class="page-link" @click="store.fetchEmployees(page)">{{ page }}</button>
        </li>

        <!-- Right ellipsis -->
        <li class="page-item disabled" v-if="store.pagination.current_page < store.pagination.last_page - 2">
          <span class="page-link">...</span>
        </li>

        <!-- Last page -->
        <li class="page-item" v-if="store.pagination.last_page > 1"
            :class="{ active: store.pagination.last_page === store.pagination.current_page }">
          <button class="page-link" @click="store.fetchEmployees(store.pagination.last_page)">
            {{ store.pagination.last_page }}
          </button>
        </li>

        <li class="page-item" :class="{ disabled: store.pagination.current_page === store.pagination.last_page }">
          <button class="page-link" @click="store.fetchEmployees(store.pagination.current_page + 1)">Next</button>
        </li>
      </ul>
    </nav>


    <!-- Modals -->
    <EmployeeModal v-if="showModal" :employee="selectedEmployee" @close="showModal = false" />
    <ScheduleChangeModal v-if="showScheduleModal" :employee="selectedEmployee" @close="showScheduleModal = false" />
    <EmployeeDeleteModal v-if="showDeleteModal" :employee="selectedEmployee" @close="showDeleteModal = false" />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useEmployeeStore } from "../stores/employeeStore";
import EmployeeModal from "./EmployeeModal.vue";
import ScheduleChangeModal from "./ScheduleChangeModal.vue";
import EmployeeDeleteModal from "./EmployeeDeleteModal.vue";

const store = useEmployeeStore();
const showModal = ref(false);
const showScheduleModal = ref(false);
const showDeleteModal = ref(false);
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

const openEmployeeDeleteModal = (employee) => {
  selectedEmployee.value = { ...employee };
  showDeleteModal.value = true;
};

const visiblePages = computed(() => {
  const current = store.pagination.current_page;
  const last = store.pagination.last_page;
  const delta = 1; // Number of pages to show on each side of current page

  let pages = [];

  for (let i = Math.max(2, current - delta); i <= Math.min(last - 1, current + delta); i++) {
    pages.push(i);
  }

  return pages;
});

</script>

<style scoped>
/* Add spacing between buttons */
.btn {
  margin-right: 5px;
}
.pagination {
  margin-bottom: 20px;
  margin-right: 20px;
}
</style>
