<script setup lang="ts">
import { defineProps, defineEmits, ref, watch } from 'vue'

const props = defineProps<{
  id: string
  label: string
  modelValue: string
  options: { label: string; value: string }[]
}>()

const emit = defineEmits(["update:modelValue"])
const localValue = ref(props.modelValue)

watch(() => props.modelValue, (val) => {
  localValue.value = val
})

watch(localValue, (val) => {
  emit('update:modelValue', val)
})
</script>

<template>
  <div>
    <label :for="id">{{ label }}</label>
    <select :id="id" v-model="localValue">
      <option v-for="opt in options" :key="opt.value" :value="opt.value">
        {{ opt.label }}
      </option>
    </select>
  </div>
</template>
