<script setup lang="ts">
import { computed } from 'vue'
import { Eye, ShoppingCart, Star } from '@lucide/vue'
import { assetUrl } from '@/services/api'
import type { Product } from '@/types/shop'
import { discountedPrice, money, percentOff } from '@/utils/format'

const props = defineProps<{
  product: Product
}>()

const emit = defineEmits<{
  addToCart: [product: Product]
}>()

const fallbackImage =
  'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80'

const image = computed(() => {
  const firstImage = props.product.images?.[0]
  return assetUrl(
    props.product.thumbnail ?? firstImage?.url ?? firstImage?.image ?? firstImage?.path,
    fallbackImage,
  )
})

const finalPrice = computed(() => discountedPrice(props.product.price, props.product.discount_price))
const discount = computed(() => percentOff(props.product.price, props.product.discount_price))
const inStock = computed(() => Number(props.product.stock ?? 0) > 0)
</script>

<template>
  <article class="group flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
    <RouterLink
      :to="{ name: 'product-details', params: { slug: product.slug } }"
      class="relative block aspect-[4/3] overflow-hidden bg-slate-100"
    >
      <img
        :src="image"
        :alt="product.name"
        class="size-full object-cover transition duration-500 group-hover:scale-105"
        loading="lazy"
      />
      <span
        v-if="discount"
        class="absolute left-3 top-3 rounded-lg bg-orange-500 px-2.5 py-1 text-xs font-bold text-white shadow-sm"
      >
        {{ discount }}% OFF
      </span>
      <span
        class="absolute right-3 top-3 rounded-lg px-2.5 py-1 text-xs font-bold shadow-sm"
        :class="inStock ? 'bg-emerald-500 text-white' : 'bg-slate-900 text-white'"
      >
        {{ inStock ? 'In stock' : 'Sold out' }}
      </span>
      <div class="absolute inset-0 bg-black/0 opacity-0 transition-all duration-300 group-hover:bg-black/5 group-hover:opacity-100" />
    </RouterLink>

    <div class="flex flex-1 flex-col p-5">
      <p class="text-xs font-semibold text-sky-600 uppercase tracking-wide">
        {{ product.category?.name ?? 'Computer gear' }}
      </p>
      <RouterLink
        :to="{ name: 'product-details', params: { slug: product.slug } }"
        class="mt-2 line-clamp-2 min-h-12 text-base font-bold leading-6 text-slate-900 transition-colors hover:text-sky-600"
      >
        {{ product.name }}
      </RouterLink>

      <div class="mt-3 flex items-center gap-2 text-sm text-slate-600">
        <Star class="size-4 fill-amber-400 text-amber-400" aria-hidden="true" />
        <span class="font-bold">{{ product.rating ?? '4.7' }}</span>
        <span class="text-slate-300">/</span>
        <span class="font-bold">{{ product.brand?.name ?? 'Trusted brand' }}</span>
      </div>

      <div class="mt-4 flex items-end gap-2">
        <p class="text-xl font-bold text-slate-900">{{ money(finalPrice) }}</p>
        <p
          v-if="discount"
          class="pb-0.5 text-sm font-semibold text-slate-400 line-through"
        >
          {{ money(product.price) }}
        </p>
      </div>

      <div class="mt-5 grid grid-cols-[1fr_44px] gap-2">
        <button
          type="button"
          class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed"
          :disabled="!inStock"
          @click="emit('addToCart', product)"
        >
          <ShoppingCart class="size-4 shrink-0" aria-hidden="true" />
          <span class="truncate">Add</span>
        </button>
        <RouterLink
          :to="{ name: 'product-details', params: { slug: product.slug } }"
          class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-2.5 py-2.5 text-slate-600 shadow-sm transition-all hover:bg-slate-50 hover:border-slate-400"
          :aria-label="`View ${product.name}`"
          :title="`View ${product.name}`"
        >
          <Eye class="size-4" aria-hidden="true" />
        </RouterLink>
      </div>
    </div>
  </article>
</template>
