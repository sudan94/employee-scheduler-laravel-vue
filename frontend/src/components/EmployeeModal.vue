<template>
  <div class="modal fade show d-block">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            {{ employee?.id ? "Edit Employee" : "Add Employee" }}
          </h5>
          <button type="button" class="btn-close" @click="close"></button>
        </div>

        <div class="modal-body">
          <form @submit.prevent="saveEmployee">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input
                type="text"
                v-model="localEmployee.name"
                class="form-control"
                required
              />
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input
                type="email"
                v-model="localEmployee.email"
                class="form-control"
                required
              />
            </div>

            <div class="mb-3">
              <label class="form-label">Address</label>
              <input
                type="text"
                v-model="localEmployee.address"
                class="form-control"

              />
            </div>
            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input
                type="text"
                v-model="localEmployee.phone"
                class="form-control"

              />
            </div>
            <div class="mb-3">
              <label class="form-label">Job Title</label>
              <input
                type="text"
                v-model="localEmployee.job_title"
                class="form-control"

              />
            </div>

          </form>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success" @click="saveEmployee">
            Save
          </button>
          <button type="button" class="btn btn-secondary" @click="close">
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from "vue";
import { useEmployeeStore } from "../stores/employeeStore";
import { useToast } from 'vue-toastification';

const toast = useToast();
const store = useEmployeeStore();
const emit = defineEmits(["close"]);
const props = defineProps(["employee"]);
const localEmployee = ref(
  props.employee ? { ...props.employee } : { name: "", email: "", job_title: "", address: "", phone: "" }
);

watch(
  () => props.employee,
  (newEmployee) => {
    if (newEmployee) {
      localEmployee.value = { ...newEmployee };
    } else {
      localEmployee.value = { name: "", email: "", job_title: "", address: "", phone: "" };
    }
  },
  { immediate: true }
);

const saveEmployee = async () => {
  if (localEmployee.value.id) {
    await store.updateEmployee(localEmployee.value.id, localEmployee.value);
    toast.success("Employee updated successfully");
  } else {
    await store.createEmployee(localEmployee.value);
    toast.success("Employee created successfully");
  }
  emit("close");
};
const close = () => emit("close");
</script>
