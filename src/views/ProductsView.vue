<script setup lang="ts">
import { computed, onMounted, reactive, ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { SlidersHorizontal, X } from '@lucide/vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseInput from '@/components/base/BaseInput.vue'
import BaseSelect from '@/components/base/BaseSelect.vue'
import ProductCard from '@/components/shop/ProductCard.vue'
import EmptyState from '@/components/ui/EmptyState.vue'
import SectionHeader from '@/components/ui/SectionHeader.vue'
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

const filters = reactive({
  search: '',
  category: '',
  brand: '',
  sort: 'latest' as ProductQuery['sort'],
})

const sortOptions: { value: string; label: string }[] = [
  { value: 'latest', label: 'Latest' },
  { value: 'price_low', label: 'Price: Low to High' },
  { value: 'price_high', label: 'Price: High to Low' },
  { value: 'name_asc', label: 'Name: A to Z' },
]

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
  <main class="py-16 bg-slate-50">
    <div class="container-shell">
      <SectionHeader
        eyebrow="Catalog"
        title="Shop computer products"
        description="Filter by category, brand, and price to compare laptops, desktops, components, monitors, and accessories."
      />

      <div class="grid gap-8 lg:grid-cols-[300px_1fr]">
        <aside class="h-fit rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
          <div class="mb-6 flex items-center justify-between">
            <h2 class="flex items-center gap-2 text-lg font-bold text-slate-900 font-accent">
              <SlidersHorizontal class="size-5 text-sky-600" aria-hidden="true" />
              Filters
            </h2>
            <button
              v-if="activeFilterCount"
              type="button"
              class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-600 hover:text-sky-700 transition-colors"
              @click="clearFilters"
            >
              <X class="size-3.5" aria-hidden="true" />
              Clear all
            </button>
          </div>

          <form class="grid gap-5" @submit.prevent="applyFilters()">
            <BaseInput
              v-model="filters.search"
              type="search"
              label="Search"
              placeholder="Keyboard, laptop..."
              @update:model-value="applyFilters()"
            />

            <BaseSelect
              v-model="filters.category"
              label="Category"
              placeholder="All categories"
              :options="[{ value: '', label: 'All categories' }, ...categories.map(c => ({ value: String(c.id), label: c.name }))]"
              @change="applyFilters()"
            />

            <BaseSelect
              v-model="filters.brand"
              label="Brand"
              placeholder="All brands"
              :options="[{ value: '', label: 'All brands' }, ...brands.map(b => ({ value: String(b.id), label: b.name }))]"
              @change="applyFilters()"
            />

            <BaseSelect
              v-model="filters.sort"
              label="Sort by"
              :options="[{ value: 'latest', label: 'Latest' }, { value: 'price_low', label: 'Price: Low to High' }, { value: 'price_high', label: 'Price: High to Low' }, { value: 'name_asc', label: 'Name: A to Z' }]"
              @change="applyFilters()"
            />
          </form>
        </aside>

        <section>
          <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm font-semibold text-slate-600">
              {{ total }} product{{ total === 1 ? '' : 's' }} found
            </p>
            <BaseAlert v-if="notice" variant="success" dismissible class="sm:w-auto">
              {{ notice }}
            </BaseAlert>
          </div>

          <div v-if="loading" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div v-for="index in 6" :key="index" class="h-96 animate-pulse rounded-xl bg-slate-200" />
          </div>

          <EmptyState
            v-else-if="products.length === 0"
            title="No matching products"
            message="Try a different category, brand, or search term."
            action-label="Reset filters"
            action-to="/products"
          />

          <div v-else class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <ProductCard
              v-for="product in products"
              :key="product.id"
              :product="product"
              @add-to-cart="addToCart"
            />
          </div>

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
        </section>
      </div>
    </div>
  </main>
</template>
