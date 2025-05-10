<script setup lang="ts">
import { ref, onMounted } from "vue";
import postService from "@/services/api/postsService";
import Table from "../../components/TableVue.vue";

// Definisikan interface untuk struktur data postingan Anda
interface Post {
  id: number;
  title: string;
  content: string;
  thumbnail: string;
}

const posts = ref<Post[]>([]);
const loading = ref(false);
const error = ref<string | null>(null);

const fetchPosts = async () => {
  loading.value = true;
  error.value = null;
  try {
    const data = await postService.getAll();
    console.log("Data fetched:", data);
    posts.value = Array.isArray(data.posts) ? data.posts : [];
  } catch (err: any) {
    error.value = "Gagal memuat data postingan.";
  } finally {
    loading.value = false;
  }
};
const deletePost = async (id: number) => {
  if (confirm("Apakah kamu yakin ingin menghapus data ini?")) {
    try {
      await postService.delete(id);
      fetchPosts(); // Refresh data setelah penghapusan
    } catch (err) {
      console.error("Gagal menghapus post:", err);
    }
  }
};

onMounted(() => {
  fetchPosts();
});
</script>

<template>
  <div class="container mx-auto mt-4">
    <div class="flex justify-between items-center mb-4">
      <a href="/post/create" class="btn btn-primary">Create Post</a>
      <h1 class="text-2xl font-bold">CRUD Simple</h1>
    </div>
    <Table
      :table="posts"
      :loading="loading"
      :error="error"
      :kolom="['id', 'title', 'content', 'thumbnail']"
      :imageColumns="['thumbnail']"
      editUrlPrefix="post/edit"
      :onDelete="deletePost"
    />
  </div>
</template>

<style scoped></style>
