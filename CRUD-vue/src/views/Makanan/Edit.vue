<script setup lang="ts">
import { ref, onMounted } from "vue";
import makananService from "@/services/api/makananService";
import FormVue from "@/components/form/FormVue.vue";
import { useRoute } from "vue-router";

const route = useRoute();
const makananId = ref<number | null>(null);
const formData = ref<any>(null);
const formFields = [
  { type: "Text", id: "name", label: "Name" },
  { type: "AreaText", id: "description", label: "Description" },
  { type: "file", id: "img_makanan", label: "Image" },
  { type: "number", id: "price", label: "Price" },
];

const getDataByid = async () => {
  makananId.value =
    typeof route.params.id === "string" ? parseInt(route.params.id, 10) : null;
  if (makananId.value) {
    try {
      const data = await makananService.getById(makananId.value);
      const makananData = Array.isArray(data) ? data : data ?? null;
      formData.value = {
        name: makananData.makanan.name || "",
        description: makananData.makanan.description || "",
        img_makanan: null, // file input harus manual oleh user
        price: makananData.makanan.price || 0,
      }; // Store the fetched data
      console.log("Fetched makanan data:", formData.value);
    } catch (error) {
      console.error("Error fetching makanan:", error);
    }
  }
};
const submitForm = async () => {
  if (!makananId.value) return;
  const payload = new FormData();

  for (const key in formData.value) {
    // Skip field file jika belum dipilih
    if (key === "img_makanan" && !formData.value[key]) continue;
    payload.append(key, formData.value[key]);
  }

  try {
    await makananService.update(makananId.value, payload);
    alert("Makanan berhasil diperbarui!");
  } catch (error) {
    console.error("Gagal update makanan:", error);
    alert("Gagal memperbarui makanan.");
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
