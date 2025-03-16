import { defineStore } from "pinia";
import api from "../api";

export const useEmployeeStore = defineStore("employee", {
  state: () => ({
    employees: [],
    pagination: {},
  }),

  actions: {
    async fetchEmployees(page = 1) {
      try {
        const response = await api.get(`/employees?page=${page}`);
        this.employees = response.data.data;
        this.pagination = {
          current_page: response.data.meta.current_page,
          last_page: response.data.meta.last_page,
          per_page: response.data.meta.per_page,
          total: response.data.meta.total,
          from: response.data.meta.from,
          to: response.data.meta.to,
          prev_page_url: response.data.meta.prev_page_url,
          next_page_url: response.data.meta.next_page_url
        };
      } catch (error) {
        console.error('Error fetching employees:', error);
        throw error;
      }
    },

    async createEmployee(employee) {
      await api.post("/employees", employee);
      this.fetchEmployees();
    },

    async updateEmployee(id, employee) {
      await api.put(`/employees/${id}`, employee);
      this.fetchEmployees();
    },

    async deleteEmployee(id) {
      await api.delete(`/employees/${id}`);
      this.fetchEmployees();
    },

    async getEmployee(id) {
      const response = await api.get(`/employees/${id}`);
      return response.data;
    },

    async scheduleChange(id, field, newValue, changeDate) {
      await api.post(`/employees/${id}/schedule-change`, { field, new_value: newValue, change_date: changeDate });
    },
  },
});
