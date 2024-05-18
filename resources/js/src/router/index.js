import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: "Layout",
        component: () => import("../components/Layout.vue"),
        children: [
            {
                path: "",
                name: "Home",
                component: () => import("../pages/Dashboard.vue"),
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
