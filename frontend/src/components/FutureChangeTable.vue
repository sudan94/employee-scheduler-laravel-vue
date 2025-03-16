<template>
    <div class="container-fluid mt-5">
      <h2 class="mb-4 text-center">Future Changes</h2>


      <table class="table table-striped">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Field</th>
            <th>Old Value</th>
            <th>New Value</th>
            <th>Effective Date</th>
            <th>Processed At</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="employee in store.employees" :key="employee.id">
            <td>{{ employee.id }}</td>
            <td>{{ employee.name }}</td>
            <td>{{ employee.field }}</td>
            <td>{{ employee.old_value }}</td>
            <td>{{ employee.new_value }}</td>
            <td>{{ employee.effective_date }}</td>
            <td>{{ employee.processed_at ? new Date(employee.processed_at).toLocaleString() : 'Not processed' }}</td>

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

    </div>
  </template>

  <script setup>
  import { ref, onMounted, computed } from "vue";
  import { useEmployeeStore } from "../stores/employeeStore";

  const store = useEmployeeStore();

  onMounted(() => {
    store.fetchFutureChanges();
  });


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
