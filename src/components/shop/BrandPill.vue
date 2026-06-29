<script setup lang="ts">
import { computed } from 'vue'
import { Cpu } from '@lucide/vue'
import { assetUrl } from '@/services/api'
import type { Brand } from '@/types/shop'

const props = defineProps<{
  brand: Brand
}>()

const fallbackLogo = ''
const logoUrl = computed(() => assetUrl(props.brand.logo, fallbackLogo))
const hasLogo = computed(() => !!props.brand.logo)
</script>

<template>
  <RouterLink
    :to="{ name: 'products', query: { brand: brand.id } }"
    class="surface-card flex min-h-24 items-center gap-4 p-4 transition hover:-translate-y-0.5 hover:border-zinc-400 dark:border-slate-600 dark:bg-slate-800"
  >
    <div v-if="hasLogo" class="size-12 shrink-0 overflow-hidden rounded-md bg-white dark:bg-slate-700">
      <img
        :src="logoUrl"
        :alt="brand.name"
        class="size-full object-contain"
        loading="lazy"
      />
    </div>
    <div v-else class="grid size-12 shrink-0 place-items-center rounded-md bg-zinc-950 text-white dark:bg-slate-600 dark:text-slate-200">
      <Cpu class="size-6" aria-hidden="true" />
    </div>
    <div class="min-w-0">
      <h3 class="truncate text-base font-bold text-zinc-950 dark:text-slate-100">{{ brand.name }}</h3>
      <p class="mt-1 line-clamp-2 text-sm leading-5 text-zinc-600 dark:text-slate-300">
        {{ brand.description ?? 'Computer hardware and accessories' }}
      </p>
    </div>
  </RouterLink>
</template>
