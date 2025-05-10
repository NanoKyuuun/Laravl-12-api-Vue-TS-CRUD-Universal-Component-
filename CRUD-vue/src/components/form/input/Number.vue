<script setup lang="ts">
import { defineProps, defineEmits, ref, watch } from 'vue'

const props = defineProps<{
  id: string
  label: string
  modelValue: string
}>()

const emit = defineEmits(['update:modelValue'])
const localValue = ref(props.modelValue)

watch(() => props.modelValue, (val) => {
  localValue.value = val
})

watch(localValue, (val) => {
  emit('update:modelValue', val)
})
</script>

<template>
  <fieldset class="fieldset">
    <legend :for="id" class="fieldset-legend">{{ label }}</legend>
    <input :id="id" v-model="localValue" type="number" class="input validator" />
  </fieldset>
</template>
<style scoped></style>