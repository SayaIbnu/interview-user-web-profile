import { defineStore } from "pinia";
import api from "../services/api";

export const useAuthStore = defineStore('auth',{
  state: () => ({
    user: JSON.parse(localStorage.getItem('user')) || null,
    token: localStorage.getItem('token') || null
  }),

  getters: {
    isAuthenticated: (state) => !!state.token
  },

  actions: {
    async login(payload){
      const res = await api.post('/admin/login', payload)

      const data = res.data.data

      this.token = data.access_token
      this.user  = data.user

      localStorage.setItem('token', this.token)
      localStorage.setItem('user', JSON.stringify(this.user))
    },

    logout() {
      this.token = null
      this.user = null

      localStorage.removeItem('token')
      localStorage.removeItem('user')
    }
  }
})