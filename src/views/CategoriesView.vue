<script setup lang="ts">
import { onMounted, ref } from 'vue'
import CategoryCard from '@/components/shop/CategoryCard.vue'
import SectionHeader from '@/components/ui/SectionHeader.vue'
import { fallbackCategories } from '@/data/fallbacks'
import { shopApi } from '@/services/shopApi'
import type { Category } from '@/types/shop'

const loading = ref(true)
const categories = ref<Category[]>(fallbackCategories)

async function loadCategories() {
  loading.value = true

  try {
    const response = await shopApi.getCategories()
    categories.value = response.length > 0 ? response : fallbackCategories
  } catch {
    categories.value = fallbackCategories
  } finally {
    loading.value = false
  }
}

onMounted(loadCategories)
</script>

<template>
  <main class="section-band">
    <div class="container-shell">
      <SectionHeader
        eyebrow="Categories"
        title="Find the right computer hardware"
        description="Browse product groups for gaming, work, study, upgrades, and complete setups."
      />

      <div v-if="loading" class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div v-for="index in 8" :key="index" class="h-72 animate-pulse rounded-lg bg-zinc-200" />
      </div>

      <div v-else class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <CategoryCard v-for="category in categories" :key="category.id" :category="category" />
      </div>
    </div>
  </main>
</template>
