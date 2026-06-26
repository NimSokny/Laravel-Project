<script setup lang="ts">
import { computed } from 'vue'

interface Props {
  variant?: 'default' | 'primary' | 'success' | 'warning' | 'danger' | 'info'
  size?: 'sm' | 'md' | 'lg'
  dot?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  variant: 'default',
  size: 'md',
  dot: false,
})

const baseClasses = computed(() => [
  'inline-flex items-center font-semibold',
  props.dot ? 'gap-1.5' : '',
])

const variantClasses = computed(() => {
  const variants = {
    default: 'bg-slate-100 text-slate-700',
    primary: 'bg-sky-100 text-sky-700',
    success: 'bg-emerald-100 text-emerald-700',
    warning: 'bg-amber-100 text-amber-700',
    danger: 'bg-red-100 text-red-700',
    info: 'bg-blue-100 text-blue-700',
  }
  return variants[props.variant]
})

const sizeClasses = computed(() => {
  const sizes = {
    sm: props.dot ? 'px-2 py-0.5 text-xs' : 'px-2 py-0.5 text-xs rounded',
    md: props.dot ? 'px-2.5 py-1 text-xs' : 'px-2.5 py-1 text-xs rounded-md',
    lg: props.dot ? 'px-3 py-1.5 text-sm' : 'px-3 py-1.5 text-sm rounded-lg',
  }
  return sizes[props.size]
})
</script>

<template>
  <span :class="[baseClasses, variantClasses, sizeClasses]">
    <span v-if="dot" class="size-1.5 rounded-full bg-current" />
    <slot />
  </span>
</template>
