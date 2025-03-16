<template>
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-6 rounded w-96">
        <h2 class="text-xl font-bold mb-4">{{ employee.id ? "Edit Employee" : "Create Employee" }}</h2>

        <input v-model="form.name" placeholder="Name" class="border p-2 w-full mb-2" />
        <input v-model="form.email" placeholder="Email" class="border p-2 w-full mb-2" />
        <input v-model="form.phone" placeholder="Phone" class="border p-2 w-full mb-2" />

        <div class="flex justify-end">
          <button @click="$emit('close')" class="bg-gray-300 px-3 py-2 rounded mr-2">Cancel</button>
          <button @click="$emit('save', form.id, form)" class="bg-blue-500 text-white px-3 py-2 rounded">Save</button>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { defineProps, ref, watch } from "vue";

  const props = defineProps(["employee"]);
  const form = ref(props.employee ? { ...props.employee } : { name: "", email: "", phone: "" });

  watch(() => props.employee, (newVal) => {
    if (newVal) form.value = { ...newVal };
  });
  </script>
