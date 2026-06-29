<script setup lang="ts">
import { PackageSearch } from '@lucide/vue'

defineProps<{
  title: string
  message: string
  actionLabel?: string
  actionTo?: string
}>()
</script>

<template>
  <div class="surface-card flex min-h-72 flex-col items-center justify-center px-6 py-12 text-center dark:bg-slate-800">
    <PackageSearch class="mb-4 size-12 text-cyan-700 dark:text-cyan-400" aria-hidden="true" />
    <h2 class="text-xl font-bold text-zinc-950 font-accent dark:text-slate-100">{{ title }}</h2>
    <p class="mt-2 max-w-md text-sm leading-6 text-zinc-600 dark:text-slate-300">{{ message }}</p>
    <RouterLink v-if="actionLabel && actionTo" :to="actionTo" class="btn-primary mt-6">
      {{ actionLabel }}
    </RouterLink>
  </div>
</template>
