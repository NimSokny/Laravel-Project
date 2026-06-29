<script setup lang="ts">
import { computed } from 'vue'

interface Props {
  variant?: 'default' | 'elevated' | 'outlined' | 'flat'
  padding?: 'none' | 'sm' | 'md' | 'lg'
  hoverable?: boolean
  clickable?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  variant: 'default',
  padding: 'md',
  hoverable: false,
  clickable: false,
})

const emit = defineEmits<{
  click: [event: MouseEvent]
}>()

const baseClasses = computed(() => [
  'rounded-xl transition-all duration-200',
  props.hoverable ? 'hover:shadow-lg hover:-translate-y-0.5' : '',
  props.clickable ? 'cursor-pointer' : '',
])

const variantClasses = computed(() => {
  const variants = {
    default: 'bg-white border border-slate-200 shadow-sm dark:bg-slate-800 dark:border-slate-700',
    elevated: 'bg-white shadow-md dark:bg-slate-800',
    outlined: 'bg-white border-2 border-slate-200 dark:bg-slate-800 dark:border-slate-600',
    flat: 'bg-slate-50 dark:bg-slate-800',
  }
  return variants[props.variant]
})

const paddingClasses = computed(() => {
  const paddings = {
    none: '',
    sm: 'p-4',
    md: 'p-6',
    lg: 'p-8',
  }
  return paddings[props.padding]
})

const handleClick = (event: MouseEvent) => {
  if (props.clickable) {
    emit('click', event)
  }
}
</script>

<template>
  <div
    :class="[baseClasses, variantClasses, paddingClasses]"
    @click="handleClick"
  >
    <slot />
  </div>
</template>
