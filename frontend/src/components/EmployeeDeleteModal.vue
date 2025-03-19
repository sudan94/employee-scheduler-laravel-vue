<template>
  <div class="modal fade show d-block">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Employee</h5>
          <button type="button" class="btn-close" @click="close"></button>
        </div>

        <div class="modal-body">
          <form @submit.prevent="deleteEmployee">
            <p>Are you sure you want to delete this employee?</p>
          </form>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-danger" @click="deleteEmployee">
            Delete
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


const deleteEmployee = async () => {
  if (!localEmployee.value?.id) {
    console.error('No employee ID found');
    return;
  }
  await store.deleteEmployee(localEmployee.value.id);
  emit("close");
  toast.success("Employee deleted successfully");
};
const close = () => emit("close");
</script>
