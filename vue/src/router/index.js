import { createWebHistory, createRouter } from "vue-router";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import DefaultLayout from "../components/DefaultLayout.vue";
import AuthLayout from "../components/AuthLayout.vue";
import Surveys from "../views/Surveys.vue";
import SurveyView from "../views/SurveyView.vue";
import SurveyPublicView from "../views/SurveyPublicView.vue";
import EmployeIndex from "../views/employe/Index.vue";
import EmployeCreate from "../views/employe/Create.vue";
import ClientIndex from "../views/client/Index.vue";
import ClientCreate from "../views/client/Create.vue";
import SurveyDetails from "../views/SurveyDetails.vue";
import SurveyAnswerQuestion from "../views/SurveyAnswerQuestion.vue";
import store from "../store";
const routes = [
    {
        path: "/",
        redirect: "/dashboard",
        name: "Dashboard",
        component: DefaultLayout,
        meta: { requiresAuth: true },
        children: [
            { path: "/dashboard", name: "Dashboard", component: Dashboard },
            { path: "/surveys", name: "Surveys", component: Surveys },
            {
                path: "/surveys/create",
                name: "SurveyCreate",
                component: SurveyView,
            },
            {
                path: "/surveys/:id",
                name: "SurveyUpdate",
                component: SurveyView,
            },
            {
                path: "/employe",
                name: "Employe",
                component: EmployeIndex,
            },
            {
                path: "/employe/create",
                name: "EmployeCreate",
                component: EmployeCreate,
            },
            {
                path: "/employe/update/:id",
                name: "EmployeUpdate",
                component: EmployeCreate,
            },
            {
                path: "/clients",
                name: "ClientIndex",
                component: ClientIndex,
            },
            {
                path: "/client/create",
                name: "ClientCreate",
                component: ClientCreate,
            },
            {
                path: "/client/update/:id",
                name: "ClientUpdate",
                component: ClientCreate,
            },
            {
                path: "/view/survey/:slug",
                name: "SurveyPublicView",
                component: SurveyPublicView,
            },
            {
                path: "/surveysDetails/:id",
                name: "SurveyDetails",
                component: SurveyDetails,
            },
            {
                path: "/questionAnswer",
                name: "SurveyQuestionAnswer",
                component: SurveyAnswerQuestion,
            },
        ],
    },

    {
        path: "/auth",
        name: "Auth",
        redirect: "/login",
        component: AuthLayout,
        meta: { isGuest: true },
        children: [
            {
                path: "/login",
                name: "Login",
                component: Login,
            },
            {
                path: "/register",
                name: "Register",
                component: Register,
            },
        ],
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: "Login" });
    } else if (store.state.user.token && to.meta.isGuest) {
        next({ name: "Dashboard" });
    } else {
        next();
    }
});

export default router;
