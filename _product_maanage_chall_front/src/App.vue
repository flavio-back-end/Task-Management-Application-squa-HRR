<template>
  <div class="background"></div>
  <div class="navbar">
    <nav class="nav">
      <div class="nav-el" id="name_task">
        <span v-if="user">Welcome, {{ user.name }}</span>
      </div>
      <div class="nav-el">
        <button v-if="user" @click="logout" class="btn btn-danger btn-pers">
          Logout
        </button>
        <button v-if="!user" @click="moveToRegister" class="btn btn-primary btn-pers">
          Register
        </button>
      </div>
    </nav>
  </div>
  <router-view id="content" />
</template>


<script>
import axios from "axios";

export default {
  data() {
    return {
      user: null,
      loadingUser: true,
      apiUrl: process.env.VUE_APP_API_BASE_URL, 
    };
  },
  mounted() {
    this.fetchUserInfo();
  },
  methods: {
    async fetchUserInfo() {
      const accessToken = localStorage.getItem("access_token");
      try {
        const response = await axios.get(`${this.apiUrl}/api/dashboard`, {
          headers: {
            Authorization: `Bearer ${accessToken}`,
          },
        });
        this.user = response.data.user;
      } catch (error) {
        console.error("Failed to fetch user information:", error);
      } finally {
        this.loadingUser = false;
      }
    },
    async logout() {
      const accessToken = localStorage.getItem("access_token");
      try {
        await axios.post(`${this.apiUrl}/api/logout`, null, {
          headers: {
            Authorization: `Bearer ${accessToken}`,
          },
        });
        this.user = null;
        localStorage.removeItem("access_token");
        this.$router.push("/");
      } catch (error) {
        console.error("Logout failed:", error);
      }
    },
    moveToRegister() {
      this.$router.push("/RegisterView"); 
    },
  },
};
</script>

<style>

#content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  border: 1px solid lightgray;
  padding: 4rem 4rem;
  border-radius: 5px;
  background: #fefefe;
}
.background {
  width: 100vw;
  height: 100vh;
  position: absolute;
  background: rgb(250, 250, 250);
}
.navbar {
  background: #fafafa;
  position: absolute;
  top: 0;
  width: 100vw;
  height: 70px;
  box-shadow: 6.7px 6.7px 5.3px rgba(0, 0, 0, 0.028),
    22.3px 22.3px 17.9px rgba(0, 0, 0, 0.042),
    100px 100px 80px rgba(0, 0, 0, 0.07);
}
.nav {
  width: 80%;
  min-width: 400px;
  margin: auto;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  background: #fafafa;
}
#name_task {
  font-weight: 700;
}
.container {
  width: 400px;
  max-width: 95%;
}
.input {
  display: flex;
  flex-direction: column;
  margin-bottom: 15px;
}
.input > label {
  text-align: start;
}
.input > input {
  margin-top: 6px;
  height: 38px !important;
}
/* From uiverse.io */
.btn-pers {
  position: relative;
  left: 50%;
  padding: 1em 2.5em;
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 2.5px;
  font-weight: 700;
  color: #000;
  background-color: #fff;
  border: none;
  border-radius: 45px;
  box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease 0s;
  cursor: pointer;
  outline: none;
  transform: translateX(-50%);
}
.btn-pers:hover {
  background-color: #198754;
  box-shadow: 0px 15px 20px rgba(46, 229, 157, 0.4);
  color: #fff;
  transform: translate(-50%, -7px);
}
.btn-pers:active {
  transform: translate(-50%, -1px);
}
/*  */
.alternative-option {
  text-align: center;
}
.alternative-option > span {
  color: #0d6efd;
  cursor: pointer;
}
#sign_out {
  position: relative;
  left: 50%;
  transform: translateX(-50%);
}
</style>
