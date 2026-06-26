<script setup lang="ts">
import { computed, onMounted } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { Trash2 } from '@lucide/vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import QuantityStepper from '@/components/shop/QuantityStepper.vue'
import EmptyState from '@/components/ui/EmptyState.vue'
import { assetUrl } from '@/services/api'
import { useAuthStore } from '@/stores/auth'
import { useCartStore } from '@/stores/cart'
import { money } from '@/utils/format'

const router = useRouter()
const auth = useAuthStore()
const cart = useCartStore()

const items = computed(() => cart.items.value)
const subtotal = computed(() => cart.subtotal.value)

async function updateQuantity(itemId: number, quantity: number) {
  await cart.updateCartItem(itemId, quantity)
}

async function removeItem(itemId: number) {
  await cart.removeCartItem(itemId)
}

function goToCheckout() {
  router.push({ name: 'checkout' })
}

onMounted(() => {
  cart.fetchCart()
})
</script>

<template>
  <main class="py-16 bg-slate-50">
    <div class="container-shell">
      <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
          <p class="text-sm font-semibold text-sky-600 uppercase tracking-wide">Cart</p>
          <h1 class="mt-2 text-3xl font-bold text-slate-900 sm:text-4xl font-accent">Review your items</h1>
        </div>
        <RouterLink
          to="/products"
          class="inline-flex items-center justify-center gap-2 rounded-lg border-2 border-slate-300 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50"
        >
          Continue shopping
        </RouterLink>
      </div>

      <EmptyState
        v-if="!auth.isAuthenticated.value"
        title="Sign in to view your cart"
        message="Your cart is saved with your customer account."
        action-label="Login"
        action-to="/login?redirect=/cart"
      />

      <div v-else-if="cart.state.loading && items.length === 0" class="grid gap-4">
        <div v-for="index in 3" :key="index" class="h-32 animate-pulse rounded-xl bg-slate-200" />
      </div>

      <EmptyState
        v-else-if="items.length === 0"
        title="Your cart is empty"
        message="Add laptops, components, monitors, or accessories before checkout."
        action-label="Shop products"
        action-to="/products"
      />

      <div v-else class="grid gap-8 lg:grid-cols-[1fr_400px]">
        <section class="grid gap-4">
          <article
            v-for="item in items"
            :key="item.id"
            class="grid gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:grid-cols-[140px_1fr_auto] sm:items-center"
          >
            <RouterLink
              :to="{ name: 'product-details', params: { slug: item.product.slug } }"
              class="aspect-square overflow-hidden rounded-lg bg-slate-100"
            >
              <img
                :src="assetUrl(item.product.thumbnail, 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=400&q=80')"
                :alt="item.product.name"
                class="size-full object-cover"
              />
            </RouterLink>

            <div class="min-w-0">
              <p class="text-xs font-semibold text-sky-600 uppercase tracking-wide">{{ item.product.brand?.name ?? 'Computer Shop' }}</p>
              <RouterLink
                :to="{ name: 'product-details', params: { slug: item.product.slug } }"
                class="mt-1 block text-lg font-bold text-slate-900 hover:text-sky-600 transition-colors"
              >
                {{ item.product.name }}
              </RouterLink>
              <p class="mt-2 text-sm text-slate-600">{{ money(item.price) }} each</p>
            </div>

            <div class="flex items-center justify-between gap-4 sm:flex-col sm:items-end">
              <QuantityStepper
                :model-value="item.quantity"
                :max="Number(item.product.stock ?? 99)"
                @update:model-value="updateQuantity(item.id, $event)"
              />
              <p class="text-lg font-bold text-slate-900">{{ money(item.subtotal) }}</p>
              <button
                type="button"
                class="flex size-10 items-center justify-center rounded-lg border-2 border-red-200 text-red-600 transition-all hover:border-red-300 hover:bg-red-50"
                :aria-label="`Remove ${item.product.name}`"
                :title="`Remove ${item.product.name}`"
                @click="removeItem(item.id)"
              >
                <Trash2 class="size-4" aria-hidden="true" />
              </button>
            </div>
          </article>
        </section>

        <aside class="h-fit rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
          <h2 class="text-xl font-bold text-slate-900 font-accent">Order summary</h2>
          <div class="mt-6 grid gap-4 text-sm">
            <div class="flex justify-between">
              <span class="text-slate-600">Subtotal</span>
              <span class="font-semibold text-slate-900">{{ money(subtotal) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-slate-600">Delivery</span>
              <span class="font-semibold text-emerald-600">Included</span>
            </div>
            <div class="border-t border-slate-200 pt-4">
              <div class="flex justify-between text-lg">
                <span class="font-bold text-slate-900">Total</span>
                <span class="font-bold text-slate-900">{{ money(subtotal) }}</span>
              </div>
            </div>
          </div>
          <button
            type="button"
            class="mt-6 w-full rounded-lg bg-slate-900 px-6 py-3 font-semibold text-white shadow-lg transition-all hover:bg-slate-800 hover:shadow-xl"
            @click="goToCheckout"
          >
            Checkout
          </button>
          <BaseAlert v-if="cart.state.error" variant="error" dismissible class="mt-4">
            {{ cart.state.error }}
          </BaseAlert>
        </aside>
      </div>
    </div>
  </main>
</template>
