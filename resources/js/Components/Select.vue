<template>
  <select
    :id="id"
    ref="select"
    :name="name"
    class="pl-3 py-2 pr-8 bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
    :value="modelValue"
    @change="$emit('update:modelValue', $event.target.value)"
  >
    <option v-if="placeholder" value="-" selected>{{ placeholder }}</option>
    <slot v-for="option in options" :data="option" name="option"></slot>
  </select>
</template>

<script setup>
defineEmits(["change", "update:modelValue"])

defineProps({
  id: String,
  name: String,
  placeholder: String,
  options: Array,
  modelValue: [Object, String, Number],
  error: String,
})
</script>
