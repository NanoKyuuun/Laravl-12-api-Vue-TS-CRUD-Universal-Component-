<script setup lang="ts">
import { defineProps, defineEmits, ref, watch } from 'vue'

const props = defineProps<{
  id: string
  label: string
  modelValue: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

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
    <textarea
      :id="id"
      v-model="localValue"
      class="textarea"
      :placeholder="label"
    ></textarea>
  </fieldset>
</template>

<style scoped></style>
