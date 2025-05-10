import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/home.vue";
import PostView from "../views/Posts/Index.vue";
import PostCreate from "../views/Posts/Create.vue";
import PostEdit from "../views/Posts/Edit.vue";
import MakananView from "@/views/Makanan/Index.vue";
import MakananCreate from "@/views/Makanan/Create.vue";
import MakananEdit from "@/views/Makanan/Edit.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/posts",
      name: "posts",
      component: PostView,
    },
    {
      path: "/post/create",
      name: "PostCreate",
      component: PostCreate,
    },
    {
      path: "/post/edit/:id",
      name: "PostEdit",
      component: PostEdit,
    },
    {
      path: "/makanan",
      name: "makanan",
      component: MakananView,
    },
    {
      path: "/makanan/create",
      name: "makananCreate",
      component: MakananCreate,
    },
    {
      path: "/makanan/edit/:id",
      name: "makananEdit",
      component: MakananEdit,
    },
  ],
});

export default router;
