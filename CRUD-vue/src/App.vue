<script setup lang="ts">
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
  <header>
    <div class="navbar bg-base-100 shadow-sm">
      <div class="flex-1">
        <a class="btn btn-ghost text-xl">CRUD</a>
      </div>
      <div class="flex-none">
        <ul class="menu menu-horizontal px-1">
          <li><RouterLink to="/">Home</RouterLink></li>
          <li><RouterLink to="/posts">Posts</RouterLink></li>
          <li><RouterLink to="/makanan">Makanan</RouterLink></li>
        </ul>
      </div>
    </div>
  </header>
  <RouterView />
</template>


<style scoped></style>
