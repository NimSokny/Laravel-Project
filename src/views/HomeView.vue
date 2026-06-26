<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { ArrowRight, ShieldCheck, Star, Truck, Wrench } from '@lucide/vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BrandPill from '@/components/shop/BrandPill.vue'
import CategoryCard from '@/components/shop/CategoryCard.vue'
import ProductCard from '@/components/shop/ProductCard.vue'
import SectionHeader from '@/components/ui/SectionHeader.vue'
import { fallbackBrands, fallbackCategories, fallbackHero, fallbackProducts, fallbackReviews } from '@/data/fallbacks'
import { assetUrl } from '@/services/api'
import { shopApi } from '@/services/shopApi'
import { useAuthStore } from '@/stores/auth'
import { useCartStore } from '@/stores/cart'
import type { Brand, Category, HeroContent, Product } from '@/types/shop'

const router = useRouter()
const auth = useAuthStore()
const cart = useCartStore()

const loading = ref(true)
const hero = ref<HeroContent>(fallbackHero)
const categories = ref<Category[]>(fallbackCategories)
const featuredProducts = ref<Product[]>(fallbackProducts)
const newArrivals = ref<Product[]>(fallbackProducts)
const brands = ref<Brand[]>(fallbackBrands)
const notice = ref('')

const heroImage = computed(() => assetUrl(hero.value.image, fallbackHero.image ?? ''))
const bestSellingProducts = computed(() =>
  [...featuredProducts.value]
    .sort((a, b) => Number(b.sold_count ?? b.reviews_count ?? 0) - Number(a.sold_count ?? a.reviews_count ?? 0))
    .slice(0, 4),
)

function useListFallback<T>(data: T[], fallback: T[]) {
  return data.length > 0 ? data : fallback
}

async function loadHome() {
  loading.value = true

  const [heroResult, categoriesResult, featuredResult, latestResult, brandsResult] =
    await Promise.allSettled([
      shopApi.getHero(),
      shopApi.getCategories(),
      shopApi.getFeaturedProducts(),
      shopApi.getLatestProducts(),
      shopApi.getBrands(),
    ])

  if (heroResult.status === 'fulfilled') {
    hero.value = {
      ...fallbackHero,
      ...heroResult.value,
    }
  }

  if (categoriesResult.status === 'fulfilled') {
    categories.value = useListFallback(categoriesResult.value, fallbackCategories)
  }

  if (featuredResult.status === 'fulfilled') {
    featuredProducts.value = useListFallback(featuredResult.value, fallbackProducts)
  }

  if (latestResult.status === 'fulfilled') {
    newArrivals.value = useListFallback(latestResult.value, fallbackProducts)
  }

  if (brandsResult.status === 'fulfilled') {
    brands.value = useListFallback(brandsResult.value, fallbackBrands)
  }

  loading.value = false
}

async function addToCart(product: Product) {
  notice.value = ''

  if (!auth.isAuthenticated.value) {
    router.push({ name: 'login', query: { redirect: router.currentRoute.value.fullPath } })
    return
  }

  try {
    await cart.addToCart(product.id)
    notice.value = `${product.name} added to cart.`
  } catch {
    notice.value = cart.state.error
  }
}

onMounted(loadHome)
</script>

<template>
  <main>
    <section
      class="relative flex min-h-[600px] items-center overflow-hidden bg-slate-900 sm:min-h-[700px]"
      :style="{ backgroundImage: `linear-gradient(90deg, rgba(15,23,42,.95), rgba(15,23,42,.7), rgba(15,23,42,.3)), url(${heroImage})` }"
    >
      <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent" />
      <div class="container-shell relative z-10 py-20 text-white">
        <div class="max-w-3xl">
          <p class="mb-4 inline-flex items-center rounded-full bg-sky-500/20 px-4 py-1.5 text-sm font-bold text-sky-300 backdrop-blur-sm">
            <span class="mr-2">✨</span>
            Computer Shop
          </p>
          <h1 class="text-4xl font-bold leading-tight sm:text-5xl lg:text-6xl font-accent">
            {{ hero.title }}
          </h1>
          <p class="mt-6 max-w-2xl text-lg leading-relaxed text-slate-200 sm:text-xl">
            {{ hero.subtitle }}
          </p>
          <div class="mt-8 flex flex-col gap-3 sm:flex-row">
            <RouterLink
              :to="hero.button_link || '/products'"
              class="inline-flex items-center justify-center gap-2 rounded-lg bg-sky-500 px-6 py-3 font-semibold text-white shadow-lg transition-all hover:bg-sky-600 hover:shadow-xl sm:px-8 sm:py-4"
            >
              {{ hero.button_text || 'Shop products' }}
              <ArrowRight class="size-4" aria-hidden="true" />
            </RouterLink>
            <RouterLink
              to="/categories"
              class="inline-flex items-center justify-center gap-2 rounded-lg border-2 border-white/30 bg-white/10 px-6 py-3 font-semibold text-white backdrop-blur-sm transition-all hover:bg-white/20 sm:px-8 sm:py-4"
            >
              Browse categories
            </RouterLink>
          </div>
        </div>
      </div>
    </section>

    <!-- Brand Carousel Section -->
    <section class="py-12 bg-white overflow-hidden">
      <div class="container-shell mb-8">
        <h2 class="text-accent-md text-center text-slate-900">Trusted by Top Brands</h2>
      </div>
      <div class="relative">
        <div class="flex animate-scroll gap-12 px-8">
          <!-- Brand items - duplicated for seamless scroll -->
          <div v-for="brand in [...brands, ...brands, ...brands]" :key="brand.id" class="flex-shrink-0">
            <RouterLink
              :to="{ name: 'products', query: { brand: brand.id } }"
              class="flex items-center gap-3 px-6 py-4 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-sky-300 transition-all duration-300"
            >
              <div class="size-12 shrink-0 overflow-hidden rounded-lg bg-white flex items-center justify-center">
                <img
                  v-if="brand.logo"
                  :src="assetUrl(brand.logo)"
                  :alt="brand.name"
                  class="size-full object-contain"
                  loading="lazy"
                />
                <Cpu v-else class="size-6 text-slate-400" aria-hidden="true" />
              </div>
              <span class="text-lg font-semibold text-slate-700">{{ brand.name }}</span>
            </RouterLink>
          </div>
        </div>
      </div>
    </section>

    <section class="border-b border-slate-200 bg-white py-6">
      <div class="container-shell grid gap-4 sm:grid-cols-3">
        <div class="flex items-center gap-3 rounded-lg bg-slate-50 px-4 py-3">
          <Truck class="size-6 text-sky-600" aria-hidden="true" />
          <p class="text-base font-semibold text-slate-800 font-accent">Fast local delivery</p>
        </div>
        <div class="flex items-center gap-3 rounded-lg bg-slate-50 px-4 py-3">
          <ShieldCheck class="size-6 text-emerald-600" aria-hidden="true" />
          <p class="text-base font-semibold text-slate-800 font-accent">Warranty-backed products</p>
        </div>
        <div class="flex items-center gap-3 rounded-lg bg-slate-50 px-4 py-3">
          <Wrench class="size-6 text-amber-600" aria-hidden="true" />
          <p class="text-base font-semibold text-slate-800 font-accent">Build and service support</p>
        </div>
      </div>
    </section>

    <section class="py-16 bg-slate-50">
      <div class="container-shell">
        <SectionHeader
          eyebrow="Shop by need"
          title="Popular categories"
          description="Find the right hardware faster with focused sections for everyday buyers and serious builders."
          action-label="All categories"
          action-to="/categories"
        />
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <CategoryCard
            v-for="category in categories.slice(0, 4)"
            :key="category.id"
            :category="category"
          />
        </div>
      </div>
    </section>

    <section class="py-16 bg-white">
      <div class="container-shell">
        <SectionHeader
          eyebrow="Featured"
          title="Recommended computer gear"
          description="Balanced picks for gaming, design work, office upgrades, and home setups."
          action-label="View products"
          action-to="/products"
        />
        <BaseAlert v-if="notice" variant="success" dismissible class="mb-6">
          {{ notice }}
        </BaseAlert>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <ProductCard
            v-for="product in featuredProducts.slice(0, 8)"
            :key="product.id"
            :product="product"
            @add-to-cart="addToCart"
          />
        </div>
      </div>
    </section>

    <section class="py-16 bg-slate-50">
      <div class="container-shell">
        <SectionHeader
          eyebrow="Fresh stock"
          title="New arrivals"
          description="Recently added laptops, displays, components, and accessories."
        />
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <ProductCard
            v-for="product in newArrivals.slice(0, 4)"
            :key="product.id"
            :product="product"
            @add-to-cart="addToCart"
          />
        </div>
      </div>
    </section>

    <section class="py-16 bg-slate-900 text-white">
      <div class="container-shell">
        <SectionHeader
          eyebrow="Reviews"
          title="Customers building with confidence"
          description="Practical advice, clean assembly, and support after the sale."
          tone="dark"
        />
        <div class="grid gap-6 md:grid-cols-3">
          <article
            v-for="review in fallbackReviews"
            :key="review.name"
            class="rounded-xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm"
          >
            <div class="mb-4 flex gap-1 text-amber-400">
              <Star
                v-for="index in review.rating"
                :key="index"
                class="size-4 fill-current"
                aria-hidden="true"
              />
            </div>
            <p class="text-sm leading-6 text-slate-200 font-accent">"{{ review.quote }}"</p>
            <div class="mt-5">
              <p class="font-bold">{{ review.name }}</p>
              <p class="text-sm text-slate-400 font-accent">{{ review.role }}</p>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="py-16 bg-sky-50">
      <div class="container-shell">
        <div class="mx-auto max-w-2xl text-center">
          <h2 class="text-accent-lg text-slate-900">Stay in the loop</h2>
          <p class="mt-4 text-slate-600 font-accent">Subscribe to our newsletter for exclusive deals, new arrivals, and tech tips.</p>
          <form class="mt-8 flex gap-3 sm:flex-row">
            <input
              type="email"
              placeholder="Enter your email"
              class="flex-1 rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500 font-accent"
              required
            />
            <button
              type="submit"
              class="rounded-lg bg-sky-500 px-6 py-3 font-semibold text-white shadow-lg transition-all hover:bg-sky-600 hover:shadow-xl"
            >
              Subscribe
            </button>
          </form>
        </div>
      </div>
    </section>

    <BaseAlert v-if="loading" variant="info" class="fixed bottom-5 right-5 z-50">
      Loading shop data...
    </BaseAlert>
  </main>
</template>
