<script setup lang="ts">
import { computed, onMounted, ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { CheckCircle, PackageCheck, ShieldCheck, ShoppingCart, Star, Truck } from '@lucide/vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import ProductCard from '@/components/shop/ProductCard.vue'
import QuantityStepper from '@/components/shop/QuantityStepper.vue'
import EmptyState from '@/components/ui/EmptyState.vue'
import { fallbackProducts } from '@/data/fallbacks'
import { assetUrl } from '@/services/api'
import { shopApi } from '@/services/shopApi'
import { useAuthStore } from '@/stores/auth'
import { useCartStore } from '@/stores/cart'
import type { Product } from '@/types/shop'
import { discountedPrice, money, percentOff } from '@/utils/format'

const route = useRoute()
const router = useRouter()
const auth = useAuthStore()
const cart = useCartStore()

const loading = ref(true)
const product = ref<Product | null>(null)
const relatedProducts = ref<Product[]>([])
const quantity = ref(1)
const selectedImage = ref('')
const notice = ref('')

const fallbackImage =
  'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1000&q=80'

const finalPrice = computed(() =>
  product.value ? discountedPrice(product.value.price, product.value.discount_price) : 0,
)
const discount = computed(() =>
  product.value ? percentOff(product.value.price, product.value.discount_price) : 0,
)
const stock = computed(() => Number(product.value?.stock ?? 0))
const gallery = computed(() => {
  if (!product.value) {
    return []
  }

  const images = [
    assetUrl(product.value.thumbnail, fallbackImage),
    ...(product.value.images ?? []).map((image) =>
      assetUrl(image.url ?? image.image ?? image.path, fallbackImage),
    ),
  ]

  return [...new Set(images.filter(Boolean))]
})

const specifications = computed(() => {
  const spec = product.value?.specification

  if (!spec) {
    return []
  }

  return spec
    .split(/\r?\n|,/)
    .map((item) => item.trim())
    .filter(Boolean)
})

async function loadProduct() {
  const slug = String(route.params.slug)
  loading.value = true
  notice.value = ''

  try {
    product.value = await shopApi.getProduct(slug)
  } catch {
    product.value = fallbackProducts.find((item) => item.slug === slug) ?? null
  }

  if (product.value) {
    selectedImage.value = gallery.value[0] ?? fallbackImage
    quantity.value = 1
    await loadRelated()
  }

  loading.value = false
}

async function loadRelated() {
  if (!product.value) {
    return
  }

  try {
    const response = await shopApi.getProducts({
      category: product.value.category_id,
      per_page: 4,
    })
    relatedProducts.value = response.data.filter((item) => item.id !== product.value?.id)
  } catch {
    relatedProducts.value = fallbackProducts.filter((item) => item.id !== product.value?.id).slice(0, 4)
  }
}

async function addToCart(targetProduct: Product, targetQuantity = 1) {
  if (!auth.isAuthenticated.value) {
    router.push({ name: 'login', query: { redirect: route.fullPath } })
    return
  }

  try {
    await cart.addToCart(targetProduct.id, targetQuantity)
    notice.value = `${targetProduct.name} added to cart.`
  } catch {
    notice.value = cart.state.error
  }
}

watch(() => route.params.slug, loadProduct)
onMounted(loadProduct)
</script>

<template>
  <main class="py-16 bg-slate-50">
    <div class="container-shell">
      <div v-if="loading" class="grid gap-8 lg:grid-cols-2">
        <div class="aspect-square animate-pulse rounded-xl bg-slate-200" />
        <div class="space-y-4">
          <div class="h-8 w-3/4 animate-pulse rounded bg-slate-200" />
          <div class="h-5 w-1/2 animate-pulse rounded bg-slate-200" />
          <div class="h-32 animate-pulse rounded bg-slate-200" />
        </div>
      </div>

      <EmptyState
        v-else-if="!product"
        title="Product not found"
        message="This item may be unavailable or no longer active."
        action-label="Back to products"
        action-to="/products"
      />

      <template v-else>
        <div class="grid gap-12 lg:grid-cols-[1fr_0.9fr]">
          <section>
            <div class="aspect-square overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
              <img :src="selectedImage" :alt="product.name" class="size-full object-cover" />
            </div>
            <div v-if="gallery.length > 1" class="mt-4 grid grid-cols-4 gap-3">
              <button
                v-for="image in gallery"
                :key="image"
                type="button"
                class="aspect-square overflow-hidden rounded-lg border-2 bg-white transition-all hover:ring-2 hover:ring-sky-500"
                :class="selectedImage === image ? 'border-slate-900 ring-2 ring-sky-500' : 'border-slate-200'"
                @click="selectedImage = image"
              >
                <img :src="image" :alt="product.name" class="size-full object-cover" />
              </button>
            </div>
          </section>

          <section>
            <p class="text-sm font-semibold text-sky-600 uppercase tracking-wide">{{ product.category?.name ?? 'Computer gear' }}</p>
            <h1 class="mt-3 text-3xl font-bold leading-tight text-slate-900 sm:text-4xl font-accent">
              {{ product.name }}
            </h1>
            <div class="mt-4 flex flex-wrap items-center gap-3 text-sm text-slate-600">
              <span class="inline-flex items-center gap-1">
                <Star class="size-4 fill-amber-400 text-amber-400" aria-hidden="true" />
                <span class="font-medium">{{ product.rating ?? '4.7' }}</span> rating
              </span>
              <span class="text-slate-300">|</span>
              <span>{{ product.brand?.name ?? 'Trusted brand' }}</span>
              <span class="text-slate-300">|</span>
              <span :class="stock > 0 ? 'text-emerald-600' : 'text-red-600'">{{ stock > 0 ? `${stock} in stock` : 'Sold out' }}</span>
            </div>

            <div class="mt-6 flex flex-wrap items-end gap-3">
              <p class="text-4xl font-bold text-slate-900">{{ money(finalPrice) }}</p>
              <p v-if="discount" class="pb-1 text-lg font-semibold text-slate-400 line-through">
                {{ money(product.price) }}
              </p>
              <span
                v-if="discount"
                class="rounded-lg bg-orange-500 px-3 py-1 text-sm font-bold text-white shadow-sm"
              >
                Save {{ discount }}%
              </span>
            </div>

            <p class="mt-6 leading-7 text-slate-600">
              {{ product.description ?? 'A reliable product selected for modern computer setups.' }}
            </p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
              <QuantityStepper v-model="quantity" :max="stock || 99" />
              <button
                type="button"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-6 py-3 font-semibold text-white shadow-lg transition-all hover:bg-slate-800 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="stock <= 0"
                @click="addToCart(product, quantity)"
              >
                <ShoppingCart class="size-4" aria-hidden="true" />
                Add to cart
              </button>
              <RouterLink
                to="/checkout"
                class="inline-flex items-center justify-center gap-2 rounded-lg border-2 border-slate-900 bg-white px-6 py-3 font-semibold text-slate-900 shadow-sm transition-all hover:bg-slate-50"
              >
                Buy now
              </RouterLink>
            </div>

            <BaseAlert v-if="notice" variant="success" dismissible class="mt-4">
              {{ notice }}
            </BaseAlert>

            <div class="mt-8 grid gap-4 sm:grid-cols-3">
              <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <Truck class="mb-3 size-6 text-sky-600" aria-hidden="true" />
                <p class="text-sm font-bold text-slate-900">Fast delivery</p>
                <p class="mt-1 text-xs text-slate-600">Local shipping available</p>
              </div>
              <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <ShieldCheck class="mb-3 size-6 text-emerald-600" aria-hidden="true" />
                <p class="text-sm font-bold text-slate-900">{{ product.warranty ?? 'Warranty included' }}</p>
                <p class="mt-1 text-xs text-slate-600">Manufacturer warranty</p>
              </div>
              <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <PackageCheck class="mb-3 size-6 text-amber-600" aria-hidden="true" />
                <p class="text-sm font-bold text-slate-900">Quality checked</p>
                <p class="mt-1 text-xs text-slate-600">Tested before dispatch</p>
              </div>
            </div>
          </section>
        </div>

        <section class="mt-16 grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
          <div class="rounded-xl border border-slate-200 bg-white p-8 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900 font-accent">Specifications</h2>
            <ul class="mt-6 grid gap-4">
              <li
                v-for="item in specifications"
                :key="item"
                class="flex gap-3 text-sm leading-6 text-slate-700"
              >
                <CheckCircle class="mt-0.5 size-5 shrink-0 text-emerald-600" aria-hidden="true" />
                {{ item }}
              </li>
              <li v-if="specifications.length === 0" class="text-sm text-slate-600">
                Specifications are being prepared for this product.
              </li>
            </ul>
          </div>

          <div class="rounded-xl border border-slate-200 bg-white p-8 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900 font-accent">Why buy from us</h2>
            <div class="mt-6 grid gap-4 text-sm leading-6 text-slate-700">
              <p class="flex gap-3">
                <CheckCircle class="mt-0.5 size-5 shrink-0 text-sky-600" aria-hidden="true" />
                We help customers compare real needs, not just model numbers.
              </p>
              <p class="flex gap-3">
                <CheckCircle class="mt-0.5 size-5 shrink-0 text-sky-600" aria-hidden="true" />
                Products can be paired with setup, assembly, and warranty guidance.
              </p>
              <p class="flex gap-3">
                <CheckCircle class="mt-0.5 size-5 shrink-0 text-sky-600" aria-hidden="true" />
                Orders stay aligned with live stock and secure checkout.
              </p>
            </div>
          </div>
        </section>

        <section v-if="relatedProducts.length" class="mt-16">
          <div class="mb-8">
            <p class="text-sm font-semibold text-sky-600 uppercase tracking-wide">Related products</p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900 font-accent">You may also like</h2>
          </div>
          <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <ProductCard
              v-for="item in relatedProducts.slice(0, 4)"
              :key="item.id"
              :product="item"
              @add-to-cart="addToCart"
            />
          </div>
        </section>
      </template>
    </div>
  </main>
</template>
