<template>
  <div class="home">
    <h1>Students List</h1>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Date of Birth</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Course</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="student in students" :key="student.id">
            <td>{{ student.id }}</td>
            <td>{{ student.name }}</td>
            <td>{{ student.dob }}</td>
            <td>{{ student.email }}</td>
            <td>{{ student.phone }}</td>
            <td>{{ student.course }}</td>
            <td>
              <button class="btn btn-info btn-sm me-1" @click="viewStudent(student)">View</button>
              <button class="btn btn-warning btn-sm me-1" @click="editStudent(student)">Edit</button>
              <button class="btn btn-danger btn-sm" @click="deleteStudent(student.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" ref="viewModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Student Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body" v-if="selectedStudent">
            <p><strong>Name:</strong> {{ selectedStudent.name }}</p>
            <p><strong>Date of Birth:</strong> {{ selectedStudent.dob }}</p>
            <p><strong>Email:</strong> {{ selectedStudent.email }}</p>
            <p><strong>Phone:</strong> {{ selectedStudent.phone }}</p>
            <p><strong>Course:</strong> {{ selectedStudent.course }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" ref="editModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Student</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div v-if="updateError" class="alert alert-danger">
              {{ updateError }}
            </div>
            <form @submit.prevent="handleUpdate" v-if="editForm">
              <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" v-model="editForm.name" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" v-model="editForm.dob" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" v-model="editForm.email" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="tel" class="form-control" v-model="editForm.phone" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Course</label>
                <input type="text" class="form-control" v-model="editForm.course" required>
              </div>
              <button type="submit" class="btn btn-primary">Update</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { computed, onMounted, ref } from 'vue';
import { useStore } from 'vuex';
import { Modal } from 'bootstrap';

export default {
  name: 'Home',
  setup() {
    const store = useStore();
    const viewModal = ref(null);
    const editModal = ref(null);
    const selectedStudent = ref(null);
    const editForm = ref(null);
    const updateError = ref(null);
    
    onMounted(() => {
      store.dispatch('fetchStudents');
    });

    const viewStudent = (student) => {
      selectedStudent.value = student;
      const modal = new Modal(viewModal.value);
      modal.show();
    };

    const editStudent = (student) => {
      editForm.value = { ...student };
      updateError.value = null;
      const modal = new Modal(editModal.value);
      modal.show();
    };

    const handleUpdate = async () => {
      try {
        updateError.value = null;
        console.log('Updating student:', editForm.value);
        await store.dispatch('updateStudent', {
          id: editForm.value.id,
          data: editForm.value
        });
        const modal = Modal.getInstance(editModal.value);
        modal.hide();
      } catch (error) {
        console.error('Failed to update student:', error);
        updateError.value = error.response?.data?.message || 'Failed to update student. Please try again.';
      }
    };

    const deleteStudent = async (id) => {
      if (confirm('Are you sure you want to delete this student?')) {
        try {
          await store.dispatch('deleteStudent', id);
        } catch (error) {
          console.error('Failed to delete student:', error);
        }
      }
    };

    return {
      students: computed(() => store.getters.allStudents),
      viewModal,
      editModal,
      selectedStudent,
      editForm,
      updateError,
      viewStudent,
      editStudent,
      handleUpdate,
      deleteStudent
    };
  }
};
</script> 