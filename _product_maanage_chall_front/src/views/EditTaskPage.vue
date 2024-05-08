<template>
  <div>
    <h1>Edit Task</h1>
    <form @submit.prevent="saveChanges">
      <div class="form-group">
        <label for="taskTitle">Title:</label>
        <input
          type="text"
          id="taskTitle"
          v-model="editedTask.title"
          class="form-control"
          required
        />
      </div>

      <div class="form-group">
        <label for="taskDescription">Task Description:</label>
        <textarea
          id="taskDescription"
          v-model="editedTask.description"
          class="form-control"
        ></textarea>
      </div>

      <div class="form-group">
        <label for="taskDueDate">Due Date:</label>
        <input
          type="date"
          id="taskDueDate"
          v-model="editedTask.due_date"
          class="form-control"
          required
        />
      </div>

      <button type="submit" class="btn btn-primary">Save Changes</button>
      <button @click="cancelEdit" class="btn btn-secondary">Cancel</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      apiUrl: process.env.VUE_APP_API_BASE_URL,
      editedTask: {
        id: null,
        title: "",
        description: "",
        due_date: "",
      },
    };
  },
  mounted() {
    const taskId = this.$route.params.id;
    this.fetchTaskDetails(taskId);
  },
  methods: {
    fetchTaskDetails(taskId) {
      axios.get(`${this.apiUrl}/api/tasks/${taskId}`)
        .then((response) => {
          this.editedTask = response.data.task;
        })
        .catch((error) => {
          console.error("Error fetching task details:", error);
        });
    },
    saveChanges() {
      const taskId = this.editedTask.id;

      axios.put(`${this.apiUrl}/api/tasks/${taskId}`, this.editedTask)
        .then(() => {
          console.log(`Task with ID ${taskId} updated successfully.`);
          // Manually navigate to task list view
          this.$router.push("/task-list");
        })
        .catch((error) => {
          console.error("Error updating task:", error);
        });
    },
    cancelEdit() {
      // Manually navigate to task list view
      this.$router.push("/task-list");
    },
  },
};
</script>
