<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import makananService from '@/services/api/makananService';
import FormVue from '@/components/form/FormVue.vue';

const formData = ref<any>({}); // Inisialisasi formData sebagai objek kosong
const formFields = [
  { type: 'Text', id: 'name', label: 'Name' },
  { type: 'AreaText', id: 'description', label: 'Description' },
  { type: 'file', id: 'img_makanan', label: 'Image' },
  { type: 'number', id: 'price', label: 'Price' },
];
const router = useRouter();
const submitForm = async () => {
const payload = new FormData();

  for (const key in formData.value) {
    if (key === 'img_makanan' && !formData.value[key]) continue;
    payload.append(key, formData.value[key]);
  }
  try {
    await makananService.create(payload); // Panggil fungsi createMakanan
    alert('Makanan berhasil dibuat!');
    // Redirect atau lakukan tindakan lain setelah berhasil membuat makanan
    router.push({ name: 'makanan' }); // Redirect to home after post creation
  } catch (error) {
    console.error('Gagal membuat makanan:', error);
    alert('Gagal membuat makanan.');
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