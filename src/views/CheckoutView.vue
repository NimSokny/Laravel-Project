<script setup lang="ts">
import { computed, onMounted, reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { CreditCard, MapPin } from '@lucide/vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseInput from '@/components/base/BaseInput.vue'
import EmptyState from '@/components/ui/EmptyState.vue'
import { getApiErrorMessage } from '@/services/api'
import { shopApi } from '@/services/shopApi'
import { useAuthStore } from '@/stores/auth'
import { useCartStore } from '@/stores/cart'
import type { CheckoutPayload } from '@/types/shop'
import { money } from '@/utils/format'

const router = useRouter()
const auth = useAuthStore()
const cart = useCartStore()

const submitting = ref(false)
const error = ref('')

const paymentMethods: CheckoutPayload['payment_method'][] = ['Cash', 'ABA', 'ACLEDA', 'Wing']

const form = reactive<CheckoutPayload>({
  shipping_address: '',
  payment_method: 'Cash',
})

const items = computed(() => cart.items.value)
const subtotal = computed(() => cart.subtotal.value)

async function submitOrder() {
  submitting.value = true
  error.value = ''

  try {
    const order = await shopApi.checkout(form)
    cart.resetCart()
    router.push({ name: 'orders', query: { placed: order.order_number } })
  } catch (caughtError) {
    error.value = getApiErrorMessage(caughtError, 'Unable to place your order.')
  } finally {
    submitting.value = false
  }
}

onMounted(async () => {
  await cart.fetchCart()

  if (auth.state.user?.address) {
    form.shipping_address = auth.state.user.address
  }
})
</script>

<template>
  <main class="py-16 bg-slate-50">
    <div class="container-shell">
      <div class="mb-8">
        <p class="text-sm font-semibold text-sky-600 uppercase tracking-wide">Checkout</p>
        <h1 class="mt-2 text-3xl font-bold text-slate-900 sm:text-4xl font-accent">Complete your order</h1>
      </div>

      <EmptyState
        v-if="items.length === 0 && !cart.state.loading"
        title="No items to checkout"
        message="Add products to your cart before placing an order."
        action-label="Shop products"
        action-to="/products"
      />

      <div v-else class="grid gap-8 lg:grid-cols-[1fr_400px]">
        <form class="grid gap-8" @submit.prevent="submitOrder">
          <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="flex items-center gap-2 text-xl font-bold text-slate-900 font-accent">
              <MapPin class="size-5 text-sky-600" aria-hidden="true" />
              Shipping details
            </h2>
            <BaseInput
              v-model="form.shipping_address"
              label="Delivery address"
              placeholder="House number, street, city, phone note"
              required
              class="mt-5 min-h-32"
            />
          </section>

          <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="flex items-center gap-2 text-xl font-bold text-slate-900 font-accent">
              <CreditCard class="size-5 text-emerald-600" aria-hidden="true" />
              Payment method
            </h2>
            <div class="mt-5 grid gap-3 sm:grid-cols-4">
              <label
                v-for="method in paymentMethods"
                :key="method"
                class="grid min-h-14 cursor-pointer place-items-center rounded-xl border-2 px-3 text-sm font-semibold transition-all"
                :class="
                  form.payment_method === method
                    ? 'border-slate-900 bg-slate-900 text-white shadow-md'
                    : 'border-slate-200 bg-white text-slate-700 hover:border-slate-400 hover:bg-slate-50'
                "
              >
                <input v-model="form.payment_method" class="sr-only" type="radio" :value="method" />
                {{ method }}
              </label>
            </div>
          </section>

          <BaseAlert v-if="error" variant="error" dismissible>
            {{ error }}
          </BaseAlert>

          <button
            type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-8 py-3 font-semibold text-white shadow-lg transition-all hover:bg-slate-800 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="submitting || cart.state.loading"
          >
            {{ submitting ? 'Placing order...' : 'Place order' }}
          </button>
        </form>

        <aside class="h-fit rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
          <h2 class="text-xl font-bold text-slate-900 font-accent">Order summary</h2>
          <div class="mt-5 grid gap-4">
            <div
              v-for="item in items"
              :key="item.id"
              class="flex items-start justify-between gap-3 text-sm"
            >
              <span class="text-slate-600">{{ item.product.name }} x {{ item.quantity }}</span>
              <span class="font-semibold text-slate-900">{{ money(item.subtotal) }}</span>
            </div>
          </div>
          <div class="mt-6 border-t border-slate-200 pt-4">
            <div class="flex justify-between text-lg">
              <span class="font-bold text-slate-900">Total</span>
              <span class="font-bold text-slate-900">{{ money(subtotal) }}</span>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </main>
</template>
