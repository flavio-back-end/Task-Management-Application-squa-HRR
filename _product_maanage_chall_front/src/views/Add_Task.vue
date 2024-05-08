<template>
  <div>
    <button @click="openAddTaskForm" class="btn btn-primary">
      Add Task
    </button>

    <div v-if="showAddTaskForm" class="mt-3">
      <h2>Add New Task</h2>
      <form @submit.prevent="submitNewTask" novalidate>
        <div class="form-group">
          <label for="taskTitle">Task Title:</label>
          <input
            type="text"
            v-model="newTask.title"
            class="form-control"
            required
          />
          <!-- Display validation message -->
          <span v-if="!newTask.title" class="text-danger">Title is required</span>
        </div>
        <div class="form-group">
          <label for="taskDescription">Task Description:</label>
          <textarea
            v-model="newTask.description"
            class="form-control"
            required
          ></textarea>
          <!-- Display validation message -->
          <span v-if="!newTask.description" class="text-danger">Description is required</span>
        </div>
        <div class="form-group">
          <label for="taskDueDate">Due Date:</label>
          <input
            type="date"
            v-model="newTask.due_date"
            class="form-control"
            required
          />
          <!-- Display validation message -->
          <span v-if="!newTask.due_date" class="text-danger">Due date is required</span>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
        <button type="button" @click="closeAddTaskForm" class="btn btn-secondary ml-2">Cancel</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      apiUrl: process.env.VUE_APP_API_BASE_URL,
      showAddTaskForm: false,
      newTask: {
        title: "",
        description: "",
        due_date: "",
      },
    };
  },

  methods: {
    openAddTaskForm() {
      this.showAddTaskForm = true;
    },

    closeAddTaskForm() {
      this.showAddTaskForm = false;

      this.newTask = {
        title: "",
        description: "",
        due_date: "",
      };
    },

    submitNewTask() {
      if (this.validateForm()) {
        const accessToken = localStorage.getItem("access_token");

        axios
          .post(`${this.apiUrl}/api/tasks`, this.newTask, {
            headers: {
              Authorization: `Bearer ${accessToken}`,
            },
          })
          .then((response) => {
            console.log("New task added successfully:", response.data);
            this.$router.push("/TaskTable");
            this.closeAddTaskForm();
          })
          .catch((error) => {
            console.error("Error adding new task:", error);
          });
      }
    },

    validateForm() {
      if (!this.newTask.title || !this.newTask.description || !this.newTask.due_date) {
        return false;
      }
      return true;
    },
  },
};
</script>

