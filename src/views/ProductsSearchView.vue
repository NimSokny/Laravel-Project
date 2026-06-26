<script setup lang="ts">
import { computed, onMounted, reactive, ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { Search, SlidersHorizontal, X } from '@lucide/vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import ProductCard from '@/components/shop/ProductCard.vue'
import EmptyState from '@/components/ui/EmptyState.vue'
import { fallbackBrands, fallbackCategories, fallbackProducts } from '@/data/fallbacks'
import { shopApi } from '@/services/shopApi'
import { useAuthStore } from '@/stores/auth'
import { useCartStore } from '@/stores/cart'
import type { Brand, Category, Product, ProductQuery } from '@/types/shop'

const route = useRoute()
const router = useRouter()
const auth = useAuthStore()
const cart = useCartStore()

const loading = ref(false)
const products = ref<Product[]>([])
const categories = ref<Category[]>(fallbackCategories)
const brands = ref<Brand[]>(fallbackBrands)
const total = ref(fallbackProducts.length)
const currentPage = ref(1)
const lastPage = ref(1)
const notice = ref('')
const showFilters = ref(false)

const filters = reactive({
  search: '',
  category: '',
  brand: '',
  sort: 'latest' as ProductQuery['sort'],
})

const activeFilterCount = computed(
  () => [filters.search, filters.category, filters.brand].filter(Boolean).length,
)

function syncFiltersFromRoute() {
  filters.search = String(route.query.search ?? '')
  filters.category = String(route.query.category ?? '')
  filters.brand = String(route.query.brand ?? '')
  filters.sort = (route.query.sort as ProductQuery['sort']) || 'latest'
  currentPage.value = Number(route.query.page ?? 1)
}

function cleanQuery(page = 1) {
  return {
    ...(filters.search ? { search: filters.search } : {}),
    ...(filters.category ? { category: filters.category } : {}),
    ...(filters.brand ? { brand: filters.brand } : {}),
    ...(filters.sort && filters.sort !== 'latest' ? { sort: filters.sort } : {}),
    ...(page > 1 ? { page } : {}),
  }
}

function applyFilters(page = 1) {
  router.push({ name: 'products', query: cleanQuery(page) })
}

function clearFilters() {
  filters.search = ''
  filters.category = ''
  filters.brand = ''
  filters.sort = 'latest'
  applyFilters()
}

function fallbackFilteredProducts() {
  let result = [...fallbackProducts]

  if (filters.search) {
    const search = filters.search.toLowerCase()
    result = result.filter((product) => product.name.toLowerCase().includes(search))
  }

  if (filters.category) {
    result = result.filter((product) => String(product.category_id) === filters.category)
  }

  if (filters.brand) {
    result = result.filter((product) => String(product.brand_id) === filters.brand)
  }

  if (filters.sort === 'price_low') {
    result.sort((a, b) => Number(a.discount_price ?? a.price) - Number(b.discount_price ?? b.price))
  }

  if (filters.sort === 'price_high') {
    result.sort((a, b) => Number(b.discount_price ?? b.price) - Number(a.discount_price ?? a.price))
  }

  if (filters.sort === 'name_asc') {
    result.sort((a, b) => a.name.localeCompare(b.name))
  }

  return result
}

async function loadFilters() {
  const [categoriesResult, brandsResult] = await Promise.allSettled([
    shopApi.getCategories(),
    shopApi.getBrands(),
  ])

  if (categoriesResult.status === 'fulfilled' && categoriesResult.value.length > 0) {
    categories.value = categoriesResult.value
  }

  if (brandsResult.status === 'fulfilled' && brandsResult.value.length > 0) {
    brands.value = brandsResult.value
  }
}

async function loadProducts() {
  loading.value = true
  notice.value = ''

  try {
    const response = await shopApi.getProducts({
      search: filters.search || undefined,
      category: filters.category || undefined,
      brand: filters.brand || undefined,
      sort: filters.sort,
      page: currentPage.value,
      per_page: 12,
    })

    products.value = response.data.length > 0 ? response.data : fallbackFilteredProducts()
    total.value = response.total || products.value.length
    currentPage.value = response.current_page
    lastPage.value = response.last_page
  } catch {
    const fallback = fallbackFilteredProducts()
    products.value = fallback
    total.value = fallback.length
    lastPage.value = 1
  } finally {
    loading.value = false
  }
}

async function addToCart(product: Product) {
  if (!auth.isAuthenticated.value) {
    router.push({ name: 'login', query: { redirect: route.fullPath } })
    return
  }

  try {
    await cart.addToCart(product.id)
    notice.value = `${product.name} added to cart.`
  } catch {
    notice.value = cart.state.error
  }
}

watch(
  () => route.query,
  () => {
    syncFiltersFromRoute()
    loadProducts()
  },
  { immediate: true },
)

onMounted(loadFilters)
</script>

<template>
  <main class="min-h-screen bg-slate-50">
    <!-- Sticky Search Header -->
    <div class="sticky top-0 z-40 border-b border-slate-200 bg-white shadow-sm">
      <div class="container-shell py-4">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
          <!-- Search Bar -->
          <div class="relative flex-1 max-w-2xl">
            <Search class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-slate-400" aria-hidden="true" />
            <input
              v-model="filters.search"
              type="search"
              placeholder="Search products..."
              class="w-full rounded-xl border border-slate-300 bg-slate-50 pl-12 pr-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20"
              @input="applyFilters()"
            />
            <button
              v-if="filters.search"
              type="button"
              class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg bg-slate-200 p-1.5 text-slate-500 hover:bg-slate-300 transition-colors"
              @click="filters.search = ''; applyFilters()"
            >
              <X class="size-4" aria-hidden="true" />
            </button>
          </div>

          <!-- Filter Toggle & Sort -->
          <div class="flex items-center gap-3">
            <button
              type="button"
              class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50"
              @click="showFilters = !showFilters"
            >
              <SlidersHorizontal class="size-4" aria-hidden="true" />
              Filters
              <span v-if="activeFilterCount" class="rounded-full bg-sky-500 px-2 py-0.5 text-xs font-bold text-white">
                {{ activeFilterCount }}
              </span>
            </button>

            <select
              v-model="filters.sort"
              class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20"
              @change="applyFilters()"
            >
              <option value="latest">Latest</option>
              <option value="price_low">Price: Low to High</option>
              <option value="price_high">Price: High to Low</option>
              <option value="name_asc">Name: A to Z</option>
            </select>
          </div>
        </div>

        <!-- Expandable Filters -->
        <div v-if="showFilters" class="mt-4 grid gap-4 sm:grid-cols-3">
          <select
            v-model="filters.category"
            class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20"
            @change="applyFilters()"
          >
            <option value="">All Categories</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>

          <select
            v-model="filters.brand"
            class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20"
            @change="applyFilters()"
          >
            <option value="">All Brands</option>
            <option v-for="brand in brands" :key="brand.id" :value="brand.id">
              {{ brand.name }}
            </option>
          </select>

          <button
            v-if="activeFilterCount"
            type="button"
            class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-sky-600 shadow-sm transition-all hover:bg-slate-50"
            @click="clearFilters"
          >
            <X class="size-4" aria-hidden="true" />
            Clear all filters
          </button>
        </div>
      </div>
    </div>

    <!-- Products Section -->
    <div class="container-shell py-8">
      <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold text-slate-900 font-accent">
          {{ total }} product{{ total === 1 ? '' : 's' }} found
        </h1>
        <BaseAlert v-if="notice" variant="success" dismissible class="sm:w-auto">
          {{ notice }}
        </BaseAlert>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <div v-for="index in 8" :key="index" class="h-96 animate-pulse rounded-xl bg-slate-200" />
      </div>

      <!-- Empty State -->
      <EmptyState
        v-else-if="products.length === 0"
        title="No matching products"
        message="Try a different search term or filter."
        action-label="Reset filters"
        action-to="/products"
      />

      <!-- Products Grid -->
      <div v-else class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <ProductCard
          v-for="product in products"
          :key="product.id"
          :product="product"
          @add-to-cart="addToCart"
        />
      </div>

      <!-- Pagination -->
      <div v-if="lastPage > 1" class="mt-10 flex items-center justify-center gap-3">
        <button
          type="button"
          class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed"
          :disabled="currentPage <= 1"
          @click="applyFilters(currentPage - 1)"
        >
          Previous
        </button>
        <span class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-bold text-slate-900 shadow-sm">
          {{ currentPage }} / {{ lastPage }}
        </span>
        <button
          type="button"
          class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed"
          :disabled="currentPage >= lastPage"
          @click="applyFilters(currentPage + 1)"
        >
          Next
        </button>
      </div>
    </div>
  </main>
</template>
