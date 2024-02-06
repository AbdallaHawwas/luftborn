import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import Posts from '../pages/posts/Posts.vue';
import PostDetails from '../pages/posts/PostDetails.vue';
import NewPost from '../pages/posts/NewPost.vue';
import EditPost from '../pages/posts/EditPost.vue';
import Categories from '../pages/categories/Categories.vue';
import Login from '../pages/auth/Login.vue';
import Register from '../pages/auth/Register.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/posts',
    name: 'Posts',
    component: Posts,
  },
  {
    path: '/post/:id',
    name: 'PostDetails',
    component: PostDetails,
  },
  {
    path: '/post/new',
    name: 'NewPost',
    component: NewPost,
  },
  {
    path: '/post/edit/:id',
    name: 'EditPost',
    component: EditPost,
  },
  {
    path: '/categories',
    name: 'Categories',
    component: Categories,
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
  },
  // Add more routes as needed
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
