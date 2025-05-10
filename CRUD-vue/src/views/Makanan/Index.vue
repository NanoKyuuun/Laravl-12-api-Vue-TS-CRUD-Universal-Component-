<script setup lang="ts">
import { ref, onMounted } from "vue";
import makananService from "@/services/api/makananService";
import Table from "../../components/TableVue.vue";

interface Makanans {
  id: number;
  name: string;
  description: string;
  img_makanan: string;
  price: number;
}

const makanans = ref<Makanans[]>([]);
const loading = ref(false);
const error = ref<string | null>(null);

const fetchMakanan = async () => {
  loading.value = true;
  error.value = null;
  try {
    const data = await makananService.getAll();
    console.log("Data fetched:", data);
    makanans.value = Array.isArray(data.makanans) ? data.makanans : [];
  } catch (err: any) {
    error.value = "Gagal memuat data makanan.";
  } finally {
    loading.value = false;
  }
};

const deleteMakanan = async (id: number) => {
  if (confirm("Apakah kamu yakin ingin menghapus data ini?")) {
    try {
      await makananService.delete(id);
      fetchMakanan(); // Refresh data setelah penghapusan
    } catch (err) {
      console.error("Gagal menghapus makanan:", err);
    }
  }
};

onMounted(() => {
  fetchMakanan();
});

</script>
<template>
  <div class="container mx-auto mt-4">
    <div class="flex justify-between items-center mb-4">
      <a href="/makanan/create" class="btn btn-primary">Create Makanan</a>
      <h1 class="text-2xl font-bold">CRUD Simple</h1>
    </div>
    <Table
      :table="makanans"
      :loading="loading"
      :error="error"
      :kolom="['id', 'name', 'description', 'img_makanan', 'price']"
      :imageColumns="['img_makanan']"
      editUrlPrefix="makanan/edit"
      :onDelete="deleteMakanan"
    />
  </div>
</template>

<style scoped></style>
