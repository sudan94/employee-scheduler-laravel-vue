<template>
    <div class="modal fade show d-block">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ employee?.id ? "Edit Employee" : "Add Employee" }}</h5>
            <button type="button" class="btn-close" @click="close"></button>
          </div>

          <div class="modal-body">
            <form @submit.prevent="saveEmployee">
              <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" v-model="localEmployee.name" class="form-control" required />
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" v-model="localEmployee.email" class="form-control" required />
              </div>
              <div class="mb-3">
                <label class="form-label">Job Title</label>
                <input type="text" v-model="localEmployee.jobtitle" class="form-control" required />
              </div>
            </form>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-success" @click="saveEmployee">Save</button>
            <button type="button" class="btn btn-secondary" @click="close">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, defineProps, defineEmits, watch } from "vue";
  import { useEmployeeStore } from "../stores/employeeStore";

  const store = useEmployeeStore();
  const emit = defineEmits(["close"]);
  const props = defineProps(["employee"]);
  const localEmployee = ref({ name: "", email: "", jobtitle: "" });

  watch(props, () => {
    localEmployee.value = props.employee ? { ...props.employee } : { name: "", email: "", jobtitle: "" };
  });

  const saveEmployee = async () => {
    if (localEmployee.value.id) {
      await store.updateEmployee(localEmployee.value.id, localEmployee.value);
    } else {
      await store.createEmployee(localEmployee.value);
    }
    emit("close");
  };
  const close = () => emit("close");
  </script>
