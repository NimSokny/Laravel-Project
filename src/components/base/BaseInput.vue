<script setup lang="ts">
import { computed } from 'vue'

interface Props {
  modelValue: string | number
  type?: 'text' | 'email' | 'password' | 'number' | 'tel' | 'url' | 'search'
  placeholder?: string
  label?: string
  error?: string
  disabled?: boolean
  readonly?: boolean
  required?: boolean
  icon?: any
  size?: 'sm' | 'md' | 'lg'
  fullWidth?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  type: 'text',
  disabled: false,
  readonly: false,
  required: false,
  size: 'md',
  fullWidth: false,
})

const emit = defineEmits<{
  'update:modelValue': [value: string | number]
  focus: [event: FocusEvent]
  blur: [event: FocusEvent]
}>()

const inputClasses = computed(() => [
  'w-full rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0',
  props.error
    ? 'border-red-300 focus:border-red-500 focus:ring-red-500 bg-red-50 dark:border-red-700 dark:bg-red-900/30'
    : 'border-slate-300 focus:border-sky-500 focus:ring-sky-500 bg-white dark:border-slate-600 dark:bg-slate-800 dark:text-white',
  props.disabled ? 'opacity-50 cursor-not-allowed bg-slate-100 dark:bg-slate-700' : '',
  props.readonly ? 'bg-slate-50 cursor-default dark:bg-slate-700' : '',
  props.size === 'sm' ? 'px-3 py-2 text-sm' : '',
  props.size === 'md' ? 'px-4 py-2.5 text-sm' : '',
  props.size === 'lg' ? 'px-4 py-3 text-base' : '',
  props.icon ? 'pl-10' : '',
])

const labelClasses = computed(() => [
  'block text-sm font-semibold mb-2',
  props.error ? 'text-red-600 dark:text-red-400' : 'text-slate-700 dark:text-slate-300',
])

const handleInput = (event: Event) => {
  const target = event.target as HTMLInputElement
  emit('update:modelValue', target.value)
}

const handleFocus = (event: FocusEvent) => {
  emit('focus', event)
}

const handleBlur = (event: FocusEvent) => {
  emit('blur', event)
}
</script>

<template>
  <div :class="fullWidth ? 'w-full' : ''">
    <label v-if="label" :for="$attrs.id as string" :class="labelClasses">
      {{ label }}
      <span v-if="required" class="text-red-500 ml-1">*</span>
    </label>
    <div class="relative">
      <component
        v-if="icon"
        :is="icon"
        class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-slate-400 pointer-events-none dark:text-slate-500"
        aria-hidden="true"
      />
      <input
        v-bind="$attrs"
        :type="type"
        :value="modelValue"
        :placeholder="placeholder"
        :disabled="disabled"
        :readonly="readonly"
        :required="required"
        :class="inputClasses"
        @input="handleInput"
        @focus="handleFocus"
        @blur="handleBlur"
      />
    </div>
    <p v-if="error" class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ error }}</p>
  </div>
</template>
