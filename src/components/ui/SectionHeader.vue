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
        class="eyebrow mb-2"
        :class="tone === 'dark' ? 'text-cyan-200' : ''"
      >
        {{ eyebrow }}
      </p>
      <h2
        class="text-accent-lg"
        :class="tone === 'dark' ? 'text-white' : 'text-zinc-950'"
      >
        {{ title }}
      </h2>
      <p
        v-if="description"
        class="mt-3 text-base leading-6 sm:text-lg lg:text-xl font-accent"
        :class="tone === 'dark' ? 'text-zinc-300' : 'text-zinc-600'"
      >
        {{ description }}
      </p>
    </div>

    <RouterLink v-if="actionLabel && actionTo" :to="actionTo" class="btn-secondary mx-auto w-fit font-accent">
      {{ actionLabel }}
    </RouterLink>
  </div>
</template>
