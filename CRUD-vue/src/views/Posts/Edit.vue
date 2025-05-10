<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import postService from "@/services/api/postsService";
import FormVue from "../../components/form/FormVue.vue";

const route = useRoute();
const postId = ref<number | null>(null);
const formData = ref<any>(null);
const formFields = [
  { type: "Text", id: "title", label: "Title" },
  { type: "AreaText", id: "content", label: "Content" },
  { type: "file", id: "thumbnail", label: "Thumbnail" },
];

const getDataByid = async () => {
  postId.value =
    typeof route.params.id === "string" ? parseInt(route.params.id, 10) : null;
  if (postId.value) {
    try {
      const data = await postService.getById(postId.value);
      const postData = Array.isArray(data) ? data : data ?? null;
      formData.value = {
        title: postData.post.title || "",
        content: postData.post.content || "",
        thumbnail: null, // file input harus manual oleh user
      }; // Store the fetched data
      console.log("Fetched post data:", formData.value);
    } catch (error) {
      console.error("Error fetching post:", error);
    }
  }
};
const submitForm = async () => {
  if (!postId.value) return;
  const payload = new FormData();

  for (const key in formData.value) {
    // Skip field file jika belum dipilih
    if (key === "thumbnail" && !formData.value[key]) continue;
    payload.append(key, formData.value[key]);
  }

  try {
    await postService.update(postId.value, payload);
    alert("Post berhasil diperbarui!");
  } catch (error) {
    console.error("Gagal update post:", error);
    alert("Gagal memperbarui post.");
  }
};

onMounted(() => {
  getDataByid();
});
</script>
<template>
  <div>
    <h1>Edit View</h1>
    <div class="container mx-auto mt-4">
      <h1 class="text-2xl font-bold">Edit Post</h1>
      <FormVue :fields="formFields" v-model="formData" @submit="submitForm" />
    </div>
  </div>
</template>

<style scoped>
/* Add your styles here */
</style>
