<template>
  <div>

    <div id="content">
      <h1>Dashboard</h1>
      <div class="button-container">
        <button @click="redirectToProductManager" class="btn btn-primary">
          Task Manager
        </button>
        
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
     
    };
  },
  methods: {
    redirectToProductManager() {
      this.$router.push("/ProductTable");
    },
    redirectToUrlShortener() {
      this.$router.push("UrlShortener");
    },
  },
};
</script>
<style scoped>
.button-container {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}
.btn-primary,
.btn-secondary {
  font-size: 16px;
  padding: 12px 24px;
  border-radius: 8px;
  transition: background-color 0.3s, border-color 0.3s, color 0.3s;
}
.btn-primary {
  color: #fff;
  background-color: #007bff;
  border-color: #007bff;
}
.btn-primary:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}
.btn-secondary {
  color: #fff;
  background-color: #6c757d;
  border-color: #6c757d;
}
.btn-secondary:hover {
  background-color: #545b62;
  border-color: #545b62;
}
</style>
