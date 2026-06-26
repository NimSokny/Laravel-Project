<script setup lang="ts">
import { ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { X, Menu, Home, Package, User, LogOut, Cpu } from '@lucide/vue'
import { useAuthStore } from '@/stores/auth'
import { useCartStore } from '@/stores/cart'

const props = defineProps<{
  isOpen: boolean
}>()

const emit = defineEmits<{
  close: []
}>()

const router = useRouter()
const auth = useAuthStore()
const cart = useCartStore()

const navLinks = [
  { label: 'Home', to: '/', icon: Home },
  { label: 'Products', to: '/products', icon: Package },
  { label: 'Categories', to: '/categories', icon: Cpu },
  { label: 'Brands', to: '/brands', icon: Cpu },
]

function navigate(to: string) {
  router.push(to)
  emit('close')
}

async function handleLogout() {
  await auth.logout()
  cart.resetCart()
  router.push('/')
  emit('close')
}

watch(() => props.isOpen, (isOpen) => {
  if (isOpen) {
    document.body.style.overflow = 'hidden'
  } else {
    document.body.style.overflow = ''
  }
})
</script>

<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="isOpen"
        class="fixed inset-0 z-50 bg-black/50 lg:hidden"
        @click="emit('close')"
      />
    </Transition>

    <Transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="-translate-x-full"
      enter-to-class="translate-x-0"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="translate-x-0"
      leave-to-class="-translate-x-full"
    >
      <aside
        v-if="isOpen"
        class="fixed inset-y-0 left-0 z-50 w-full max-w-sm bg-white shadow-2xl lg:hidden"
      >
        <div class="flex items-center justify-between p-4 border-b border-slate-200">
          <RouterLink to="/" class="flex items-center gap-3" @click="emit('close')">
            <span class="grid size-10 place-items-center rounded-lg bg-slate-900 text-white">
              <Cpu class="size-5" aria-hidden="true" />
            </span>
            <span class="text-lg font-bold text-slate-900">Computer Shop</span>
          </RouterLink>
          <button
            type="button"
            class="p-2 rounded-lg hover:bg-slate-100 transition-colors"
            @click="emit('close')"
            aria-label="Close menu"
          >
            <X class="size-5" aria-hidden="true" />
          </button>
        </div>

        <nav class="p-4 space-y-1">
          <RouterLink
            v-for="link in navLinks"
            :key="link.to"
            :to="link.to"
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-slate-100 transition-colors"
            @click="navigate(link.to)"
          >
            <component :is="link.icon" class="size-5" aria-hidden="true" />
            {{ link.label }}
          </RouterLink>

          <div class="pt-4 mt-4 border-t border-slate-200">
            <RouterLink
              v-if="!auth.isAuthenticated.value"
              to="/login"
              class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-slate-100 transition-colors"
              @click="navigate('/login')"
            >
              <User class="size-5" aria-hidden="true" />
              Login
            </RouterLink>
            <template v-else>
              <RouterLink
                to="/profile"
                class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-slate-100 transition-colors"
                @click="navigate('/profile')"
              >
                <User class="size-5" aria-hidden="true" />
                Profile
              </RouterLink>
              <RouterLink
                to="/orders"
                class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-slate-100 transition-colors"
                @click="navigate('/orders')"
              >
                <Package class="size-5" aria-hidden="true" />
                Orders
              </RouterLink>
              <button
                type="button"
                class="flex items-center gap-3 w-full px-4 py-3 rounded-lg text-slate-700 hover:bg-slate-100 transition-colors"
                @click="handleLogout"
              >
                <LogOut class="size-5" aria-hidden="true" />
                Logout
              </button>
            </template>
          </div>
        </nav>
      </aside>
    </Transition>
  </Teleport>
</template>
