<script setup lang="ts">
import { defineProps } from "vue";

const props = defineProps<{
  table: Record<string, any>[];           // data generik
  kolom: string[];                        // kolom yang ditampilkan
  loading: boolean;                       // status loading
  error: string | null;                   // pesan error
  editUrlPrefix?: string;                 // prefix URL edit, contoh: '/edit-post'
  onDelete?: (id: number) => void;        // fungsi delete dari parent
  imageColumns?: string[];                // nama kolom yang dianggap sebagai gambar
}>();

</script>

<template>
  <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 mt-5">
    <table class="table">
      <!-- Header -->
      <thead>
        <tr>
          <th v-for="col in kolom" :key="col">{{ col }}</th>
          <th>Action</th>
        </tr>
      </thead>

      <!-- Body -->
      <tbody>
        <!-- Loading -->
        <tr v-if="loading">
          <td :colspan="kolom.length + 1" class="text-center">Loading...</td>
        </tr>

        <!-- Error -->
        <tr v-else-if="error">
          <td :colspan="kolom.length + 1" class="text-center text-red-500">{{ error }}</td>
        </tr>

        <!-- Data Rows -->
        <tr v-else v-for="row in table" :key="row.id">
          <td v-for="col in kolom" :key="col">
            <template v-if="props.imageColumns?.includes(col)">
              <img :src="row[col] || 'https://picsum.photos/150/100'" alt="" class="w-24 rounded" />
            </template>
            <template v-else>
              {{ row[col] }}
            </template>
          </td>

          <!-- Tombol Aksi -->
          <td class="text-center">
            <div class="flex justify-center gap-2">
              <a :href="`${editUrlPrefix ?? '/edit'}/${row.id}`">
                <button class="btn btn-sm btn-primary">Edit</button>
              </a>
              <button class="btn btn-sm btn-error" @click="onDelete && onDelete(row.id)">
                Delete
              </button>
            </div>
          </td>
        </tr>

        <!-- Jika data kosong -->
        <tr v-if="table.length === 0 && !loading && !error">
          <td :colspan="kolom.length + 1" class="text-center">No data available</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
/* Tambahan styling opsional */
</style>
