
# 📦 Axios API Service - Vue 3 + TypeScript

Proyek ini menggunakan pendekatan modular dan reusable untuk mengintegrasikan API Laravel ke dalam frontend Vue 3 + TypeScript menggunakan Axios. Service ini mendukung operasi CRUD dan dapat digunakan ulang untuk resource apa pun (`posts`, `users`, dll).

---

## 🗂️ Struktur Folder

```
src/
├── api/
│   ├── axios.ts                # Konfigurasi dasar Axios
│   ├── resourceService.ts      # Generic CRUD service reusable
│   └── postsService.ts         # Implementasi spesifik untuk posts
```

---

## ⚙️ Konfigurasi Axios

**`src/api/axios.ts`**

```ts
import axios from "axios";

const api = axios.create({
  baseURL: "http://127.0.0.1:8000/api", // Ganti dengan URL API Laravel kamu
  headers: {
    "Content-Type": "application/json",
  },
});

export default api;
```

---

## ♻️ Generic API Service

**`src/api/resourceService.ts`**

```ts
import api from "./axios";

interface ResourceService<T> {
  getAll: () => Promise<T[]>;
  getById: (id: number) => Promise<T>;
  create: (data: any) => Promise<T>;
  update: (id: number, data: any) => Promise<T>;
  delete: (id: number) => Promise<any>;
}

export function createResourceService<T>(resource: string): ResourceService<T> {
  return {
    async getAll() {
      const res = await api.get(`/${resource}`);
      return res.data;
    },
    async getById(id) {
      const res = await api.get(`/${resource}/${id}`);
      return res.data;
    },
    async create(data) {
      const headers = data instanceof FormData
        ? { "Content-Type": "multipart/form-data" }
        : { "Content-Type": "application/json" };

      const res = await api.post(`/${resource}`, data, { headers });
      return res.data;
    },
    async update(id, data) {
      if (data instanceof FormData) {
        data.append("_method", "PUT");
        const res = await api.post(`/${resource}/${id}`, data, {
          headers: { "Content-Type": "multipart/form-data" },
        });
        return res.data;
      } else {
        const res = await api.put(`/${resource}/${id}`, data);
        return res.data;
      }
    },
    async delete(id) {
      const res = await api.delete(`/${resource}/${id}`);
      return res.data;
    },
  };
}
```

---

## 📄 Contoh Implementasi: Post Service

**`src/api/postsService.ts`**

```ts
import { createResourceService } from "./resourceService";

export interface Post {
  id: number;
  title: string;
  content: string;
  thumbnail: string;
}

const postService = createResourceService<Post>("posts");

export default postService;
```

---

## 🧪 Cara Menggunakan di Komponen

```ts
<script setup lang="ts">
import { ref, onMounted } from "vue";
import postService from "@/api/postsService";

const posts = ref([]);
const loading = ref(false);
const error = ref<string | null>(null);

const fetchPosts = async () => {
  loading.value = true;
  try {
    const data = await postService.getAll();
    posts.value = Array.isArray(data) ? data : [];
  } catch (err) {
    error.value = "Gagal memuat postingan.";
  } finally {
    loading.value = false;
  }
};

onMounted(fetchPosts);
</script>
```

---

## ✅ Keuntungan

- **Reusable**: Bisa digunakan untuk resource apa pun.
- **Type-safe**: Menggunakan TypeScript untuk validasi struktur data.
- **Simple & Clean**: Terpisah dari logic komponen.

---
# 📄 Universal Reusable Table Component (Vue 3 + TypeScript)

## 🧩 Komponen Table Reusable

Komponen `TableVue.vue` ini dibuat **universal dan fleksibel**, sehingga bisa digunakan untuk menampilkan berbagai jenis data dari berbagai tabel (misalnya `post`, `makanan`, `produk`, dll) tanpa perlu menulis ulang tampilan tabel.

---

## ✅ Fitur Utama

- 🔁 **Reusable** untuk berbagai model data
- 📸 Mendukung kolom gambar (dinamis, bisa `thumbnail`, `img_makanan`, dll)
- 🛠️ Tombol `Edit` dan `Delete` dengan URL/fungsi yang bisa disesuaikan
- 📦 Type-safe menggunakan TypeScript
- 📉 Menangani loading, error, dan data kosong

---

## 🚀 Cara Menggunakan

### 1. **Import dan Gunakan Komponen**

```ts
import Table from "@/components/TableVue.vue";
```

### 2. **Siapkan Props**

| Prop             | Tipe                         | Wajib | Deskripsi |
|------------------|------------------------------|-------|-----------|
| `table`          | `Record<string, any>[]`      | ✅    | Data array (dari API) |
| `kolom`          | `string[]`                   | ✅    | Daftar nama kolom yang akan ditampilkan |
| `loading`        | `boolean`                    | ✅    | Status loading |
| `error`          | `string \| null`             | ✅    | Pesan error (jika ada) |
| `editUrlPrefix`  | `string`                     | ❌    | Prefix URL edit (contoh: `/edit-post`) |
| `onDelete`       | `(id: number) => void`       | ❌    | Fungsi delete berdasarkan `id` |
| `imageColumns`   | `string[]`                   | ❌    | Kolom yang dianggap sebagai gambar |

---

## 📌 Contoh Implementasi

### 📚 Untuk Data Postingan

```vue
<Table
  :table="posts"
  :kolom="['id', 'title', 'content', 'thumbnail']"
  :imageColumns="['thumbnail']"
  :loading="loading"
  :error="error"
  editUrlPrefix="/edit-post"
  :onDelete="deletePost"
/>
```

### 🍔 Untuk Data Makanan

```vue
<Table
  :table="makanan"
  :kolom="['id', 'nama', 'harga', 'img_makanan']"
  :imageColumns="['img_makanan']"
  :loading="loading"
  :error="error"
  editUrlPrefix="/edit-makanan"
  :onDelete="deleteMakanan"
/>
```

---

## 🧠 Tips Tambahan

- Jika tidak ingin reload halaman saat klik `Edit`, ganti `<a :href="...">` dengan penggunaan Vue Router: `router.push(...)`.
- Komponen ini hanya bergantung pada Tailwind CSS. Sesuaikan kelas jika kamu menggunakan framework CSS lain.

---

## 📂 Struktur Folder yang Direkomendasikan

```
src/
├── components/
│   └── TableVue.vue
├── pages/
│   └── Home.vue
├── services/
│   └── api.ts
```

# FormVue Component Documentation

## Deskripsi

`FormVue.vue` adalah komponen form dinamis yang dapat digunakan untuk membuat form dengan berbagai jenis input yang dapat dikonfigurasi melalui `props`. Form ini mendukung binding dua arah (`v-model`) dan event submit yang dapat digunakan untuk menangani pengiriman form ke backend atau proses lainnya.

Komponen ini mendukung berbagai jenis input, termasuk:

- `Text` (input teks)
- `AreaText` (textarea)
- `File` (input file)
- `Number` (input angka)
- `Select` (dropdown)

Form ini dapat diintegrasikan dengan mudah pada halaman Vue lainnya, dengan memberikan array `fields` untuk mendefinisikan input yang akan ditampilkan.

## Struktur Komponen

### `FormVue.vue`

`FormVue` adalah komponen utama yang digunakan untuk merender form dinamis berdasarkan `fields` yang diterima melalui `props`. Komponen ini juga mendukung validasi dan pengiriman data menggunakan `v-model`.

### Props

- `fields` (required): Array objek yang berisi konfigurasi setiap field dalam form. Setiap field memiliki properti `type`, `id`, dan `label`.
- `modelValue` (required): Objek yang berisi data untuk diikatkan ke form menggunakan `v-model`.

### Events

- `update:modelValue`: Mengirimkan pembaruan data ke parent saat ada perubahan nilai pada form.
- `submit`: Mengirimkan event saat form disubmit.

### Contoh Penggunaan

```vue
<template>
  <div>
    <FormVue :fields="formFields" v-model="formData" @submit="submitForm" />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import FormVue from '@/components/form/FormVue.vue';

const formData = ref<any>({});

const formFields = [
  { type: 'Text', id: 'title', label: 'Title' },
  { type: 'AreaText', id: 'content', label: 'Content' },
  { type: 'file', id: 'thumbnail', label: 'Thumbnail' },
];

const submitForm = () => {
  // Logic to handle form submission
  console.log(formData.value);
};
</script>
```

### File Input Handling

FormVue juga mendukung input file dengan komponen `File.vue`, yang memungkinkan pengguna untuk memilih file dan mengirimkannya dalam form data.

### `File.vue`

```vue
<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  id: String,
  label: String,
  modelValue: File | null,
});

const emit = defineEmits(['update:modelValue']);

function handleFileChange(event: Event) {
  const target = event.target as HTMLInputElement;
  const file = target.files?.[0] || null;
  emit('update:modelValue', file);
}
</script>

<template>
  <fieldset class="fieldset">
    <legend :for="id" class="fieldset-legend">{{ label }}</legend>
    <input
      :id="id"
      type="file"
      class="file-input"
      @change="handleFileChange"
    />
  </fieldset>
</template>
```

### Text Input Handling

Komponen input seperti `Text.vue` dan `AreaText.vue` menangani input teks dan textarea, dengan binding dua arah menggunakan `v-model`.

### `Text.vue`

```vue
<script setup lang="ts">
import { defineProps, defineEmits, ref, watch } from 'vue';

const props = defineProps({
  id: String,
  label: String,
  modelValue: String,
});

const emit = defineEmits(['update:modelValue']);
const localValue = ref(props.modelValue);

watch(() => props.modelValue, (val) => {
  localValue.value = val;
});

watch(localValue, (val) => {
  emit('update:modelValue', val);
});
</script>

<template>
  <fieldset class="fieldset">
    <legend :for="id" class="fieldset-legend">{{ label }}</legend>
    <input :id="id" v-model="localValue" type="text" class="input" />
  </fieldset>
</template>
```

## Penggunaan di Halaman Lain

### Create View

Berikut adalah contoh penggunaan `FormVue` di halaman untuk membuat postingan baru. Data form disimpan dalam `formData` dan dikirim ke server setelah disubmit.

```vue
<template>
  <div>
    <h1>Create Post</h1>
    <FormVue :fields="formFields" v-model="formData" @submit="submitForm" />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import postService from '@/services/api/postsService';
import FormVue from '@/components/form/FormVue.vue';

const formData = ref<any>({}); // Inisialisasi formData
const formFields = [
  { type: 'Text', id: 'title', label: 'Title' },
  { type: 'AreaText', id: 'content', label: 'Content' },
  { type: 'file', id: 'thumbnail', label: 'Thumbnail' },
];

const router = useRouter();

const submitForm = async () => {
  const payload = new FormData();
  for (const key in formData.value) {
    if (key === 'thumbnail' && !formData.value[key]) continue;
    payload.append(key, formData.value[key]);
  }

  try {
    await postService.create(payload); // Panggil API createPost
    alert('Post berhasil dibuat!');
    router.push({ name: 'posts' }); // Redirect to posts page
  } catch (error) {
    console.error('Gagal membuat post:', error);
    alert('Gagal membuat post.');
  }
};
</script>
```

### Edit View

Penggunaan `FormVue` untuk mengedit postingan sangat mirip dengan halaman create, namun form ini akan berisi data yang telah ada dan memungkinkan pengeditan.

```vue
<template>
  <div>
    <h1>Edit Post</h1>
    <FormVue :fields="formFields" v-model="formData" @submit="submitForm" />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import postService from '@/services/api/postsService';
import FormVue from '@/components/form/FormVue.vue';

const formData = ref<any>({}); // Inisialisasi formData
const formFields = [
  { type: 'Text', id: 'title', label: 'Title' },
  { type: 'AreaText', id: 'content', label: 'Content' },
  { type: 'file', id: 'thumbnail', label: 'Thumbnail' },
];

const router = useRouter();

const submitForm = async () => {
  const payload = new FormData();
  for (const key in formData.value) {
    if (key === 'thumbnail' && !formData.value[key]) continue;
    payload.append(key, formData.value[key]);
  }

  try {
    await postService.update(payload); // Panggil API updatePost
    alert('Post berhasil diperbarui!');
    router.push({ name: 'posts' }); // Redirect to posts page
  } catch (error) {
    console.error('Gagal memperbarui post:', error);
    alert('Gagal memperbarui post.');
  }
};
</script>
```