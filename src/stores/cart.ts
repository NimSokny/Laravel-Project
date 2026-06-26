import { computed, reactive } from 'vue'
import { getApiErrorMessage } from '@/services/api'
import { shopApi } from '@/services/shopApi'
import { useAuthStore } from '@/stores/auth'
import type { Cart } from '@/types/shop'

interface CartState {
  cart: Cart | null
  loading: boolean
  error: string
}

const emptyCart: Cart = {
  id: null,
  items: [],
  total: 0,
  items_count: 0,
}

const state = reactive<CartState>({
  cart: emptyCart,
  loading: false,
  error: '',
})

function requireAuth() {
  const auth = useAuthStore()

  if (!auth.isAuthenticated.value) {
    state.error = 'Please sign in to use your cart.'
    throw new Error(state.error)
  }
}

async function fetchCart() {
  const auth = useAuthStore()

  if (!auth.isAuthenticated.value) {
    state.cart = emptyCart
    return
  }

  state.loading = true
  state.error = ''

  try {
    state.cart = await shopApi.getCart()
  } catch (error) {
    state.error = getApiErrorMessage(error, 'Unable to load your cart.')
  } finally {
    state.loading = false
  }
}

async function addToCart(productId: number, quantity = 1) {
  requireAuth()
  state.loading = true
  state.error = ''

  try {
    state.cart = await shopApi.addToCart(productId, quantity)
  } catch (error) {
    state.error = getApiErrorMessage(error, 'Unable to add this item to your cart.')
    throw error
  } finally {
    state.loading = false
  }
}

async function updateCartItem(itemId: number, quantity: number) {
  requireAuth()
  state.loading = true
  state.error = ''

  try {
    state.cart = await shopApi.updateCartItem(itemId, quantity)
  } catch (error) {
    state.error = getApiErrorMessage(error, 'Unable to update your cart.')
    throw error
  } finally {
    state.loading = false
  }
}

async function removeCartItem(itemId: number) {
  requireAuth()
  state.loading = true
  state.error = ''

  try {
    state.cart = await shopApi.removeCartItem(itemId)
  } catch (error) {
    state.error = getApiErrorMessage(error, 'Unable to remove this item.')
    throw error
  } finally {
    state.loading = false
  }
}

function resetCart() {
  state.cart = emptyCart
  state.error = ''
}

export function useCartStore() {
  return {
    state,
    items: computed(() => state.cart?.items ?? []),
    itemCount: computed(() => state.cart?.items_count ?? 0),
    subtotal: computed(() => Number(state.cart?.total ?? 0)),
    fetchCart,
    addToCart,
    updateCartItem,
    removeCartItem,
    resetCart,
  }
}
