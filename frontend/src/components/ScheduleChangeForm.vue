<template>
    <div v-if="show">
      <div class="modal-backdrop"></div>
      <div class="modal">
        <h2>Schedule Change</h2>
        <form @submit.prevent="submitScheduleChange">
          <div class="mb-3">
            <label for="field">Field to Change</label>
            <select v-model="field" class="form-control">
              <option value="name">Name</option>
              <option value="email">Email</option>
              <option value="address">Address</option>
              <option value="jobtitle">Job Title</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="newValue">New Value</label>
            <input type="text" v-model="newValue" class="form-control" />
          </div>

          <div class="mb-3">
            <label for="changeDate">Effective Date</label>
            <input type="date" v-model="changeDate" class="form-control" />
          </div>

          <button type="submit" class="btn btn-primary">Schedule Change</button>
          <button type="button" class="btn btn-secondary" @click="closeModal">
            Cancel
          </button>
        </form>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, defineProps, defineEmits } from "vue";

  const props = defineProps(["show", "employeeId"]);
  const emit = defineEmits(["close", "scheduleChange"]);

  const field = ref("");
  const newValue = ref("");
  const changeDate = ref("");

  const submitScheduleChange = () => {
    emit("scheduleChange", {
      id: props.employeeId,
      field: field.value,
      newValue: newValue.value,
      changeDate: changeDate.value,
    });
    closeModal();
  };

  const closeModal = () => {
    emit("close");
  };
  </script>

  <style scoped>
  /* Basic modal styles */
  .modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
  }

  .modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  }
  </style>
