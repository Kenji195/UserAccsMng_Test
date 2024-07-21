import Login from "@/components/LoginForm.vue";
import SignUpForm from "@/components/SignUpForm.vue";
import MainDashboard from "../components/MainDashboard.vue";
import AddUserForm from "../components/AddUserForm.vue";
import EditUserForm from "@/components/EditUserForm.vue";
import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        name: 'LoginForm',
        path: '/LoginForm',
        component: Login
    },
    {
        name: 'SignUpForm',
        path: '/SignUpForm',
        component: SignUpForm
    },
    {
        name: 'MainDashboard',
        path: '/',
        component: MainDashboard
    },
    {
        name: 'AddUserForm',
        path: '/AddUser',
        component: AddUserForm
    },
    {
        name: 'EditUserForm',
        path: '/EditUser/:id?',
        component: EditUserForm
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;