<script setup lang="ts">
import { onMounted, ref } from 'vue'
import BrandPill from '@/components/shop/BrandPill.vue'
import SectionHeader from '@/components/ui/SectionHeader.vue'
import { fallbackBrands } from '@/data/fallbacks'
import { shopApi } from '@/services/shopApi'
import type { Brand } from '@/types/shop'

const loading = ref(true)
const brands = ref<Brand[]>(fallbackBrands)

async function loadBrands() {
  loading.value = true

  try {
    const response = await shopApi.getBrands()
    brands.value = response.length > 0 ? response : fallbackBrands
  } catch {
    brands.value = fallbackBrands
  } finally {
    loading.value = false
  }
}

onMounted(loadBrands)
</script>

<template>
  <main class="section-band">
    <div class="container-shell">
      <SectionHeader
        eyebrow="Brands"
        title="Shop trusted computer brands"
        description="Filter the catalog by the brands your customers already recognize and trust."
      />

      <div v-if="loading" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="index in 9" :key="index" class="h-24 animate-pulse rounded-lg bg-zinc-200" />
      </div>

      <div v-else class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <BrandPill v-for="brand in brands" :key="brand.id" :brand="brand" />
      </div>
    </div>
  </main>
</template>
