import Vue from 'vue';
import Router from 'vue-router';
import LoginView from '../views/LoginView.vue';
import RegisterView from '../views/RegisterView.vue';
import DashboardView from '../views/DashboardView.vue';
import TaskTable from '../views/TaskTable.vue';
import Add_Task from '../views/Add_Task.vue';
import EditTaskPage from '../views/EditTaskPage.vue';
import axios from 'axios';

Vue.use(Router);

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView,
    },
    {
      path: '/DashboardView',
      name: 'DashboardView',
      component: DashboardView,
      meta: {
        authRequired: true,
      },
    },
    {
      path: '/TaskTable',
      name: 'TaskTable',
      component: TaskTable,
      meta: {
        authRequired: true,
      },
    },
    {
      path: '/Add_Task',
      name: 'Add_Add_Task',
      component: Add_Task,
      meta: {
        authRequired: true,
      },
    },
    {
      path: '/EditTaskPage',
      name: 'EditTaskPage',
      component: EditTaskPage,
      meta: {
        authRequired: true,
      },
    },
  ],
});

router.beforeEach((to, from, next) => {
  const accessToken = localStorage.getItem('access_token');

  if (to.matched.some((record) => record.meta.authRequired)) {
    if (accessToken) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${accessToken}`;
      next();
    } else {
      alert('You must be logged in to access this area');
      router.push('/');
    }
  } else {
    next();
  }
});

export default router;
