<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import postService from "@/services/api/postsService";
import FormVue from "@/components/form/FormVue.vue";

const formData = ref<any>({}); // Inisialisasi formData sebagai objek kosong
const formFields = [
  { type: "Text", id: "title", label: "Title" },
  { type: "AreaText", id: "content", label: "Content" },
  { type: "file", id: "thumbnail", label: "Thumbnail" },
];
const router = useRouter();

const submitForm = async () => {
  const payload = new FormData();

  for (const key in formData.value) {
    if (key === "thumbnail" && !formData.value[key]) continue;
    payload.append(key, formData.value[key]);
  }

  try {
    await postService.create(payload); // Panggil fungsi createPost
    alert("Post berhasil dibuat!");
    // Redirect atau lakukan tindakan lain setelah berhasil membuat post
    router.push({ name: 'posts' }); // Redirect to home after post creation
  } catch (error) {
    console.error("Gagal membuat post:", error);
    alert("Gagal membuat post.");
  }
};
</script>

<template>
  <div>
    <h1>Create View</h1>
    <div class="container mx-auto mt-4">
      <h1 class="text-2xl font-bold">Create Post</h1>
      <FormVue :fields="formFields" v-model="formData" @submit="submitForm" />
    </div>
  </div>
</template>

<style scoped></style>