<script setup lang="ts">
import { defineProps, defineEmits } from 'vue'
defineProps<{
  id: string;
  label: string;
  modelValue: File | null;
}>();
const emit = defineEmits(["update:modelValue"]);
function handleFileChange(event: Event) {
  const target = event.target as HTMLInputElement;
  const file = target.files?.[0] || null;
  emit("update:modelValue", file);
}
</script>
<template>
  <fieldset class="fieldset">
    <legend :for="id" class="fieldset-legend">{{ label }}</legend>
    <input
      :id="id"
      @change="handleFileChange"
      type="file"
      class="file-input validator"
    />
  </fieldset>
</template>
<style scoped></style>
