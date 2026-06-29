<script setup lang="ts">
import { Minus, Plus } from '@lucide/vue'

const props = withDefaults(
  defineProps<{
    modelValue: number
    min?: number
    max?: number
  }>(),
  {
    min: 1,
    max: 99,
  },
)

const emit = defineEmits<{
  'update:modelValue': [value: number]
}>()

function update(value: number) {
  const nextValue = Math.min(props.max, Math.max(props.min, value))
  emit('update:modelValue', nextValue)
}
</script>

<template>
  <div class="grid h-11 w-32 grid-cols-3 overflow-hidden rounded-md border border-zinc-300 bg-white dark:border-slate-600 dark:bg-slate-800">
    <button
      type="button"
      class="grid place-items-center text-zinc-700 transition hover:bg-zinc-100 disabled:text-zinc-300 dark:text-slate-300 dark:hover:bg-slate-700 dark:disabled:text-slate-500"
      :disabled="modelValue <= min"
      aria-label="Decrease quantity"
      @click="update(modelValue - 1)"
    >
      <Minus class="size-4" aria-hidden="true" />
    </button>
    <input
      class="w-full border-x border-zinc-300 text-center text-sm font-semibold outline-none dark:border-slate-600 dark:bg-slate-800 dark:text-white"
      :value="modelValue"
      inputmode="numeric"
      aria-label="Quantity"
      @input="update(Number(($event.target as HTMLInputElement).value || min))"
    />
    <button
      type="button"
      class="grid place-items-center text-zinc-700 transition hover:bg-zinc-100 disabled:text-zinc-300 dark:text-slate-300 dark:hover:bg-slate-700 dark:disabled:text-slate-500"
      :disabled="modelValue >= max"
      aria-label="Increase quantity"
      @click="update(modelValue + 1)"
    >
      <Plus class="size-4" aria-hidden="true" />
    </button>
  </div>
</template>
