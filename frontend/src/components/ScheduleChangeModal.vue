<template>
    <div class="modal fade show d-block">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Schedule Change</h5>
            <button type="button" class="btn-close" @click="close"></button>
          </div>

          <div class="modal-body">
            <form @submit.prevent="handleSubmit">
              <div class="mb-3">
                <label class="form-label">Select Field</label>
                <select v-model="field" class="form-control" required :class="{ 'is-invalid': errors.field }">
                  <option value="name">Name</option>
                  <option value="email">Email</option>
                  <option value="job_title">Job Title</option>
                  <option value="address">Address</option>
                  <option value="phone">Phone</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">New Value</label>
                <input type="text" v-model="newValue" class="form-control" required :class="{ 'is-invalid': errors.newValue }" />
              </div>
              <div class="mb-3">
                <label class="form-label">Effective Date</label>
                <input type="date" v-model="changeDate" class="form-control" required :class="{ 'is-invalid': errors.changeDate }" />
              </div>
            </form>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" @click="handleSubmit">Schedule</button>
            <button type="button" class="btn btn-secondary" @click="close">Cancel</button>
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
const errors = ref({});
const localEmployee = ref({ field: "", newValue: "", changeDate: "" });

const field = ref('name');
const newValue = ref('');
const changeDate = ref('');

const validateForm = () => {
  errors.value = {};
  let isValid = true;

  if (!field.value) {
    errors.value.field = true;
    isValid = false;
  }

  if (!newValue.value) {
    errors.value.newValue = true;
    isValid = false;
  }

  if (!changeDate.value) {
    errors.value.changeDate = true;
    isValid = false;
  }

  return isValid;
};

const handleSubmit = async () => {
  if (!validateForm()) {
    toast.error("Please fill in all required fields");
    return;
  }
  try {
    await store.scheduleChange(props.employee.id, field.value, newValue.value, changeDate.value);
    close();
    toast.success("Saved scheduled change successfully");
  } catch (error) {
    console.error('Error scheduling change:', error);
  }
};

watch(props, () => {
  localEmployee.value = props.employee ? { ...props.employee } : { name: "", email: "", jobtitle: "" };
});

const close = () => emit("close");
</script>
