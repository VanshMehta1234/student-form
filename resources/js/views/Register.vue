<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h2>Student Registration</h2>
      </div>
      <div class="card-body">
        <form @submit.prevent="registerStudent">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" v-model="form.name" required>
          </div>
          <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="dob" v-model="form.dob" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" v-model="form.email" required>
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" class="form-control" id="phone" v-model="form.phone" required>
          </div>
          <div class="mb-3">
            <label for="course" class="form-label">Course</label>
            <input type="text" class="form-control" id="course" v-model="form.course" required>
          </div>
          <button type="submit" class="btn btn-primary">Register</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'

export default {
  name: 'Register',
  setup() {
    const router = useRouter()
    const store = useStore()

    const form = reactive({
      name: '',
      dob: '',
      email: '',
      phone: '',
      course: ''
    })

    const registerStudent = async () => {
      try {
        await store.dispatch('registerStudent', form)
        router.push('/')
      } catch (error) {
        console.error('Registration failed:', error)
      }
    }

    return {
      form,
      registerStudent
    }
  }
}
</script> 