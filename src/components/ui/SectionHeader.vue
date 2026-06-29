<script setup lang="ts">
defineProps<{
  eyebrow?: string
  title: string
  description?: string
  actionLabel?: string
  actionTo?: string
  tone?: 'light' | 'dark'
}>()
</script>

<template>
  <div class="mb-7 flex flex-col gap-4 text-center sm:mb-9">
    <div class="max-w-2xl mx-auto">
      <p
        v-if="eyebrow"
        class="eyebrow mb-2 text-sky-600 dark:text-sky-400"
      >
        {{ eyebrow }}
      </p>
      <h2
        class="text-accent-lg text-slate-900 dark:text-slate-100"
      >
        {{ title }}
      </h2>
      <p
        v-if="description"
        class="mt-3 text-base leading-6 sm:text-lg lg:text-xl font-accent text-slate-600 dark:text-slate-300"
      >
        {{ description }}
      </p>
    </div>

    <RouterLink v-if="actionLabel && actionTo" :to="actionTo" class="btn-secondary mx-auto w-fit font-accent">
      {{ actionLabel }}
    </RouterLink>
  </div>
</template>
