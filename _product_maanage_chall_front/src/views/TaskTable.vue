<template>
  <div>
    <h1 class="mb-4">Task Management</h1>

    <div class="mb-3">
      <label class="mr-2">Sort by:</label>
      <div class="d-flex">
        <button @click="sortTasksByDueDate" class="btn btn-sm btn-secondary mr-2">
          Due Date
        </button>
      </div>
    </div>

    <div class="mb-3">
      <label class="mr-2">Filter by Status:</label>
      <div class="d-flex">
        <button @click="filterTasksByStatus('Pending')" class="btn btn-sm btn-secondary mr-2">
          Pending
        </button>
        <button @click="filterTasksByStatus('In Progress')" class="btn btn-sm btn-secondary mr-2">
          In Progress
        </button>
        <button @click="filterTasksByStatus('Completed')" class="btn btn-sm btn-secondary mr-2">
          Completed
        </button>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="thead-dark">
          <tr>
            <th>Task ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Due Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="task in paginatedData" :key="task.id">
            <td>{{ task.id }}</td>
            <td>{{ task.title }}</td>
            <td>{{ task.description }}</td>
            <td>{{ task.status }}</td>
            <td>{{ task.due_date }}</td>
            <td>
              <button @click="editTask(task.id)" class="btn btn-sm btn-warning">
                <i class="fa fa-edit"></i> Edit
              </button>
              <button @click="deleteTask(task.id)" class="btn btn-sm btn-danger ml-2">
                <i class="fa fa-trash"></i> Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <button class="page-link" @click="prevPage" :disabled="currentPage === 1">
            <span aria-hidden="true">&laquo;</span>
          </button>
        </li>
        <li class="page-item">
          <span class="page-link">{{ currentPage }}</span>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <button class="page-link" @click="nextPage" :disabled="currentPage === totalPages">
            <span aria-hidden="true">&raquo;</span>
          </button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      apiUrl: process.env.VUE_APP_API_BASE_URL,
      allData: [],
      filteredData: [],
      itemsPerPage: 10,
      currentPage: 1,
      searchTerm: "",
    };
  },
  computed: {
    totalPages() {
      return Math.ceil((this.filteredData && this.filteredData.length) || 0 / this.itemsPerPage);
    },
    paginatedData() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredData.slice(start, end);
    },
  },

  mounted() {
    this.fetchTaskData();
  },
  methods: {
    fetchTaskData() {
      const accessToken = localStorage.getItem("access_token");
      axios
        .get(`${this.apiUrl}/api/tasks`, {
          headers: {
            Authorization: `Bearer ${accessToken}`,
          },
        })
        .then((response) => {
          this.allData = response.data.tasks;
          this.filterData();
        })
        .catch((error) => {
          console.error("Error fetching task data:", error);
        });
    },
    sortTasksByDueDate() {
      this.filteredData.sort((a, b) => new Date(a.due_date) - new Date(b.due_date));
    },
    filterTasksByStatus(status) {
      this.filteredData = this.allData.filter(task => task.status === status);
    },
    filterData() {
      this.filteredData = this.allData.filter((task) => {
        const searchTerm = this.searchTerm.toLowerCase();
        return (
          task.title.toLowerCase().includes(searchTerm) ||
          task.description.toLowerCase().includes(searchTerm)
        );
      });
    },
    handleSearch() {
      this.currentPage = 1;
      this.filterData();
    },
    editTask(taskId) {
      this.$router.push(`/edit-task/${taskId}`);
    },
    deleteTask(taskId) {
      if (confirm("Are you sure you want to delete this task?")) {
        const accessToken = localStorage.getItem("access_token");
        axios
          .delete(`${this.apiUrl}/api/tasks/${taskId}`, {
            headers: {
              Authorization: `Bearer ${accessToken}`,
            },
          })
          .then(() => {
            console.log(`Task with ID ${taskId} deleted successfully.`);
            this.fetchTaskData();
          })
          .catch((error) => {
            console.error("Error deleting task:", error);
          });
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage += 1;
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage -= 1;
      }
    },
  },
};
</script>

<style>
.mb-4 {
  margin-bottom: 20px;
}

.mb-3 {
  margin-bottom: 15px;
}

.d-flex {
  display: flex;
}

.btn-secondary {
  background-color: #6c757d;
  color: #fff;
}

.table-responsive {
  overflow-x: auto;
}

.table {
  width: 100%;
  border-collapse: collapse;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
  padding: 8px;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: #f7f7f7;
}

.page-item.disabled .page-link {
  color: #6c757d;
  pointer-events: none;
}

.pagination {
  margin-top: 20px;
}

.pagination button {
  margin: 0 5px;
  padding: 5px 10px;
  cursor: pointer;
}
</style>

