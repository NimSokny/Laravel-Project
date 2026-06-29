<script setup lang="ts">
import { computed } from 'vue'
import { ArrowRight } from '@lucide/vue'
import { assetUrl } from '@/services/api'
import type { Category } from '@/types/shop'

const props = defineProps<{
  category: Category
}>()

const image = computed(() =>
  assetUrl(
    props.category.image,
    'https://images.unsplash.com/photo-1516321497487-e288fb19713f?auto=format&fit=crop&w=800&q=80',
  ),
)
</script>

<template>
  <RouterLink
    :to="{ name: 'products', query: { category: category.id } }"
    class="group block overflow-hidden bg-white border-2 border-slate-200 shadow-sm transition-all duration-300 hover:border-sky-500 hover:shadow-xl hover:-translate-y-1 dark:border-slate-600 dark:bg-slate-800 dark:hover:border-sky-400"
    style="border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;"
  >
    <div class="aspect-[5/3] overflow-hidden bg-slate-100 dark:bg-slate-700" style="border-radius: 55% 45% 35% 65% / 55% 35% 65% 45%;">
      <img
        :src="image"
        :alt="category.name"
        class="size-full object-cover transition duration-500 group-hover:scale-110"
        loading="lazy"
      />
    </div>
    <div class="p-6 text-center">
      <h3 class="text-lg font-bold text-slate-900 font-accent dark:text-slate-100">{{ category.name }}</h3>
      <p v-if="category.products_count !== undefined" class="mt-2 text-xs font-bold text-slate-500 dark:text-slate-400">
        {{ category.products_count }} products
      </p>
      <div class="mt-3 flex items-center justify-center gap-2 text-sky-600 opacity-0 transition-opacity duration-300 group-hover:opacity-100 dark:text-sky-400">
        <span class="text-sm font-semibold">View products</span>
        <ArrowRight class="size-4 transition-transform group-hover:translate-x-1" aria-hidden="true" />
      </div>
    </div>
  </RouterLink>
</template>
