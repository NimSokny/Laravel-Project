<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import EmptyState from '@/components/ui/EmptyState.vue'
import { getApiErrorMessage } from '@/services/api'
import { shopApi } from '@/services/shopApi'
import type { Order } from '@/types/shop'
import { dateLabel, money } from '@/utils/format'

const route = useRoute()

const loading = ref(true)
const error = ref('')
const orders = ref<Order[]>([])
const placedOrder = computed(() => String(route.query.placed ?? ''))

async function loadOrders() {
  loading.value = true
  error.value = ''

  try {
    const response = await shopApi.getOrders()
    orders.value = response.data
  } catch (caughtError) {
    error.value = getApiErrorMessage(caughtError, 'Unable to load your orders.')
  } finally {
    loading.value = false
  }
}

onMounted(loadOrders)
</script>

<template>
  <main class="section-band">
    <div class="container-shell">
      <div class="mb-8">
        <p class="eyebrow">Orders</p>
        <h1 class="mt-2 page-title font-accent">Order history</h1>
      </div>

      <p
        v-if="placedOrder"
        class="mb-5 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800"
      >
        Order {{ placedOrder }} placed successfully.
      </p>

      <p v-if="error" class="mb-5 rounded-md bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">
        {{ error }}
      </p>

      <div v-if="loading" class="grid gap-4">
        <div v-for="index in 3" :key="index" class="h-32 animate-pulse rounded-lg bg-zinc-200" />
      </div>

      <EmptyState
        v-else-if="orders.length === 0"
        title="No orders yet"
        message="Your completed checkout orders will appear here."
        action-label="Shop products"
        action-to="/products"
      />

      <section v-else class="grid gap-4">
        <article
          v-for="order in orders"
          :key="order.id"
          class="rounded-lg border border-zinc-200 bg-white p-5"
        >
          <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
            <div>
              <h2 class="text-lg font-bold text-zinc-950">{{ order.order_number }}</h2>
              <p class="mt-1 text-sm text-zinc-600">{{ dateLabel(order.created_at) }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
              <span class="rounded-md bg-cyan-50 px-3 py-1 text-xs font-bold text-cyan-800">
                {{ order.order_status }}
              </span>
              <span class="rounded-md bg-amber-50 px-3 py-1 text-xs font-bold text-amber-800">
                {{ order.payment_status }}
              </span>
            </div>
          </div>

          <div class="mt-5 grid gap-3">
            <div
              v-for="item in order.items ?? []"
              :key="item.id"
              class="flex items-center justify-between gap-4 text-sm"
            >
              <span class="text-zinc-600">
                {{ item.product?.name ?? 'Product' }} x {{ item.quantity }}
              </span>
              <span class="font-bold">{{ money(item.subtotal) }}</span>
            </div>
          </div>

          <div class="mt-5 flex flex-col gap-2 border-t border-zinc-200 pt-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-zinc-600">Payment: {{ order.payment_method }}</p>
            <p class="text-lg font-bold text-zinc-950">{{ money(order.total_price) }}</p>
          </div>
        </article>
      </section>
    </div>
  </main>
</template>
