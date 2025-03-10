import { createStore } from 'vuex';
import axios from 'axios';

// Configure axios to include CSRF token
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

export default createStore({
  state: {
    students: []
  },
  mutations: {
    SET_STUDENTS(state, students) {
      state.students = students;
    },
    ADD_STUDENT(state, student) {
      state.students.push(student);
    },
    UPDATE_STUDENT(state, updatedStudent) {
      const index = state.students.findIndex(s => s.id === updatedStudent.id);
      if (index !== -1) {
        state.students.splice(index, 1, updatedStudent);
      }
    },
    DELETE_STUDENT(state, studentId) {
      state.students = state.students.filter(s => s.id !== studentId);
    }
  },
  actions: {
    async fetchStudents({ commit }) {
      try {
        const response = await axios.get('/api/students');
        commit('SET_STUDENTS', response.data);
      } catch (error) {
        console.error('Error fetching students:', error.response?.data || error.message);
        throw error;
      }
    },
    async registerStudent({ commit }, studentData) {
      try {
        const response = await axios.post('/api/students', studentData);
        commit('ADD_STUDENT', response.data);
        return response.data;
      } catch (error) {
        console.error('Error registering student:', error.response?.data || error.message);
        throw error;
      }
    },
    async updateStudent({ commit }, { id, data }) {
      try {
        console.log('Sending update request for student:', id, 'with data:', data);
        const response = await axios.put(`/api/students/${id}`, data);
        console.log('Update response:', response.data);
        commit('UPDATE_STUDENT', response.data);
        return response.data;
      } catch (error) {
        console.error('Error updating student:', error.response?.data || error.message);
        throw error;
      }
    },
    async deleteStudent({ commit }, id) {
      try {
        await axios.delete(`/api/students/${id}`);
        commit('DELETE_STUDENT', id);
      } catch (error) {
        console.error('Error deleting student:', error.response?.data || error.message);
        throw error;
      }
    }
  },
  getters: {
    allStudents: state => state.students
  }
}); 