<script setup lang="ts">
import { ref, defineProps,defineEmits, watch } from 'vue'
import AreaText from './input/AreaText.vue';
import File from './input/File.vue';
import Text from './input/Text.vue';
import Select from './input/Select.vue';
import Number from './input/Number.vue';

const emit = defineEmits(['update:modelValue', 'submit'])

const props = defineProps<{
  fields: {
    type: string
    id: string
    label: string
    }[]
  modelValue: Record<string, any> 
}>()

const componentMap: Record<string, any> = {
  Text: Text,
  AreaText: AreaText,
  file: File,
  select: Select,
  number: Number,
}

const form = ref<Record<string, any>>({})

watch(() => props.modelValue, (newVal) => {
  form.value = { ...newVal }
}, { immediate: true, deep: true })

watch(form, (newVal) => {
  emit('update:modelValue', newVal)
}, { deep: true })

function getComponent(type: string) {
  return componentMap[type] || 'div' // fallback
}
function handleSubmit(e: Event) {
  e.preventDefault()
  emit('submit') // <-- kirim event ke parent
}
</script>
<template>
  <form @submit="handleSubmit">
    <component
      v-for="field in fields"
      :key="field.id"
      :is="getComponent(field.type)"
      v-bind="field"
      v-model="form[field.id]"
    />
    <button type="submit">Save</button>
  </form>
</template>
<style scoped></style>
