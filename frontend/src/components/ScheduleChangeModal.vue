<template>
    <div class="modal fade show d-block">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Schedule Change</h5>
            <button type="button" class="btn-close" @click="close"></button>
          </div>

          <div class="modal-body">
            <form @submit.prevent="scheduleChange">
              <div class="mb-3">
                <label class="form-label">Field</label>
                <select v-model="field" class="form-control">
                  <option value="name">Name</option>
                  <option value="email">Email</option>
                  <option value="jobtitle">Job Title</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">New Value</label>
                <input type="text" v-model="newValue" class="form-control" required />
              </div>
              <div class="mb-3">
                <label class="form-label">Effective Date</label>
                <input type="date" v-model="changeDate" class="form-control" required />
              </div>
            </form>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" @click="scheduleChange">Schedule</button>
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
