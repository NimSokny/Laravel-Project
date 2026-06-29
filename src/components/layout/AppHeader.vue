<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { LogOut, Menu, Moon, Package, Search, ShoppingCart, Sun, User, X } from '@lucide/vue'
import { useAuthStore } from '@/stores/auth'
import { useCartStore } from '@/stores/cart'
import { useThemeStore } from '@/stores/theme'
import { assetUrl } from '@/services/api'
import logoImage from '@/assets/img/image.png'

const router = useRouter()
const route = useRoute()
const auth = useAuthStore()
const cart = useCartStore()
const theme = useThemeStore()

const isMobileOpen = ref(false)
const searchTerm = ref('')

const navLinks = [
  { label: 'Home', to: '/', name: 'home' },
  { label: 'Products', to: '/products', name: 'products' },
  { label: 'Categories', to: '/categories', name: 'categories' },
  { label: 'Brands', to: '/brands', name: 'brands' },
  { label: 'About', to: '/about', name: 'about' },
  { label: 'Contact', to: '/contact', name: 'contact' },
]

function isActive(name: string) {
  return route.name === name
}

function submitSearch() {
  const search = searchTerm.value.trim()
  router.push({ name: 'products', query: search ? { search } : {} })
  isMobileOpen.value = false
}

async function handleLogout() {
  await auth.logout()
  cart.resetCart()
  router.push({ name: 'home' })
}

onMounted(() => {
  if (auth.isAuthenticated.value) {
    cart.fetchCart()
    auth.loadProfile()
  }
})

watch(
  () => auth.isAuthenticated.value,
  (isAuthenticated) => {
    if (isAuthenticated) {
      cart.fetchCart()
    } else {
      cart.resetCart()
    }
  },
)

watch(
  () => route.fullPath,
  () => {
    isMobileOpen.value = false
  },
)
</script>

<template>
  <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur-md shadow-sm dark:border-slate-700 dark:bg-slate-900/95 dark:text-white">
    <div class="container-shell">
      <!-- Main header -->
      <div class="flex min-h-20 items-center gap-8 py-4">
        <!-- Logo -->
        <RouterLink to="/" class="flex shrink-0 items-center gap-3" aria-label="TOPNOTCH Computer Solutions home">
          <img :src="logoImage" alt="TOPNOTCH Computer Solutions" class="h-12 w-auto object-contain" />
        </RouterLink>

        <!-- Desktop Navigation -->
        <nav class="hidden items-center gap-1 lg:flex" aria-label="Main navigation">
          <RouterLink
            v-for="link in navLinks"
            :key="link.to"
            :to="link.to"
            class="relative px-4 py-2.5 text-lg font-semibold text-slate-600 transition-all duration-200 hover:text-sky-600 before:absolute before:bottom-0 before:left-1/2 before:h-0.5 before:w-0 before:-translate-x-1/2 before:bg-sky-600 before:transition-all before:duration-200 hover:before:w-8 font-accent dark:text-slate-300 dark:hover:text-sky-400"
            :class="isActive(link.name) ? 'text-sky-600 before:w-8 dark:text-sky-400' : ''"
          >
            {{ link.label }}
          </RouterLink>
        </nav>

        <!-- Spacer -->
        <div class="flex-1" />

        <!-- Search Bar -->
        <form class="hidden w-full max-w-md xl:block" role="search" @submit.prevent="submitSearch">
          <label class="relative block group">
            <Search class="pointer-events-none absolute left-4 top-1/2 size-4 -translate-y-1/2 text-slate-400 group-focus-within:text-sky-500 transition-colors" />
            <input
              v-model="searchTerm"
              class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 pl-11 text-base transition-all duration-200 focus:border-sky-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:shadow-sm font-accent dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:border-sky-400 dark:focus:bg-slate-700"
              type="search"
              placeholder="Search laptops, GPUs, monitors..."
            />
          </label>
        </form>

        <!-- Right Actions -->
        <div class="flex items-center gap-3">
          <!-- Theme Toggle -->
          <button
            type="button"
            class="group relative flex size-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition-all duration-200 hover:border-sky-500 hover:text-sky-600 hover:shadow-md dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:border-sky-400 dark:hover:text-sky-400"
            aria-label="Toggle theme"
            title="Toggle theme"
            @click="theme.toggleTheme"
          >
            <Sun v-if="theme.isDark()" class="size-5 transition-transform group-hover:rotate-45" aria-hidden="true" />
            <Moon v-else class="size-5 transition-transform group-hover:-rotate-12" aria-hidden="true" />
          </button>

          <!-- Cart -->
          <RouterLink
            to="/cart"
            class="group relative flex size-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition-all duration-200 hover:border-sky-500 hover:text-sky-600 hover:shadow-md dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:border-sky-400 dark:hover:text-sky-400"
            aria-label="Cart"
            title="Cart"
          >
            <ShoppingCart class="size-5 transition-transform group-hover:scale-110" aria-hidden="true" />
            <span
              v-if="cart.itemCount.value > 0"
              class="absolute -right-2 -top-2 flex size-5 items-center justify-center rounded-full bg-gradient-to-br from-orange-500 to-orange-600 text-xs font-bold text-white shadow-md animate-pulse"
            >
              {{ cart.itemCount.value }}
            </span>
          </RouterLink>

          <!-- Auth Buttons -->
          <div class="hidden md:flex md:items-center md:gap-3">
            <RouterLink
              v-if="!auth.isAuthenticated.value"
              to="/login"
              class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-base font-semibold text-slate-700 shadow-sm transition-all duration-200 hover:border-slate-400 hover:bg-slate-50 hover:shadow-md font-accent dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-slate-500 dark:hover:bg-slate-700"
            >
              <User class="size-4" aria-hidden="true" />
              Login
            </RouterLink>

            <template v-else>
              <RouterLink
                to="/profile"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-lg font-semibold text-slate-700 shadow-sm transition-all duration-200 hover:border-slate-400 hover:bg-slate-50 hover:shadow-md font-accent dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-slate-500 dark:hover:bg-slate-700"
              >
                <img
                  v-if="auth.state.user?.profile_image"
                  :src="assetUrl(auth.state.user.profile_image)"
                  :alt="auth.state.user.name"
                  class="size-8 rounded-full object-cover"
                />
                <User v-else class="size-5" aria-hidden="true" />
                {{ auth.state.user?.name || 'Account' }}
              </RouterLink>
              <button
                type="button"
                class="flex size-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition-all duration-200 hover:border-red-300 hover:text-red-600 hover:shadow-md hover:rotate-90 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:border-red-400 dark:hover:text-red-400"
                aria-label="Log out"
                title="Log out"
                @click="handleLogout"
              >
                <LogOut class="size-5 transition-transform" aria-hidden="true" />
              </button>
            </template>
          </div>

          <!-- Mobile Menu Button -->
          <button
            type="button"
            class="flex size-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition-all duration-200 hover:border-sky-500 hover:text-sky-600 hover:shadow-md lg:hidden dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:border-sky-400 dark:hover:text-sky-400"
            :aria-label="isMobileOpen ? 'Close menu' : 'Open menu'"
            @click="isMobileOpen = !isMobileOpen"
          >
            <X v-if="isMobileOpen" class="size-5" aria-hidden="true" />
            <Menu v-else class="size-5" aria-hidden="true" />
          </button>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div v-if="isMobileOpen" class="border-t border-slate-200 py-6 lg:hidden dark:border-slate-700">
        <form class="mb-6" role="search" @submit.prevent="submitSearch">
          <label class="relative block group">
            <Search class="pointer-events-none absolute left-4 top-1/2 size-4 -translate-y-1/2 text-slate-400 group-focus-within:text-sky-500 transition-colors" />
            <input
              v-model="searchTerm"
              class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pl-11 text-base transition-all duration-200 focus:border-sky-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 font-accent dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:border-sky-400 dark:focus:bg-slate-700"
              type="search"
              placeholder="Search products..."
            />
          </label>
        </form>

        <nav class="grid gap-1" aria-label="Mobile navigation">
          <RouterLink
            v-for="link in navLinks"
            :key="link.to"
            :to="link.to"
            class="flex items-center justify-between rounded-xl px-4 py-3 text-lg font-semibold transition-all duration-200 font-accent"
            :class="isActive(link.name) ? 'bg-sky-50 text-sky-600 dark:bg-sky-900/30 dark:text-sky-400' : 'text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800'"
          >
            {{ link.label }}
            <svg v-if="isActive(link.name)" class="size-4 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </RouterLink>

          <div class="my-2 border-t border-slate-200 dark:border-slate-700" />

          <!-- Theme Toggle Mobile -->
          <button
            type="button"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-lg font-semibold text-slate-700 hover:bg-slate-50 transition-all duration-200 font-accent dark:text-slate-300 dark:hover:bg-slate-800"
            @click="theme.toggleTheme"
          >
            <Sun v-if="theme.isDark()" class="size-5" aria-hidden="true" />
            <Moon v-else class="size-5" aria-hidden="true" />
            {{ theme.isDark() ? 'Light mode' : 'Dark mode' }}
          </button>

          <div class="my-2 border-t border-slate-200 dark:border-slate-700" />

          <RouterLink
            :to="auth.isAuthenticated.value ? '/profile' : '/login'"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-lg font-semibold text-slate-700 hover:bg-slate-50 transition-all duration-200 font-accent dark:text-slate-300 dark:hover:bg-slate-800"
          >
            <img
              v-if="auth.isAuthenticated.value && auth.state.user?.profile_image"
              :src="assetUrl(auth.state.user.profile_image)"
              :alt="auth.state.user.name"
              class="size-8 rounded-full object-cover"
            />
            <User v-else class="size-5" aria-hidden="true" />
            {{ auth.isAuthenticated.value ? (auth.state.user?.name || 'My Profile') : 'Sign In' }}
          </RouterLink>

          <RouterLink
            v-if="auth.isAuthenticated.value"
            to="/orders"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-base font-semibold text-slate-700 hover:bg-slate-50 transition-all duration-200 font-accent dark:text-slate-300 dark:hover:bg-slate-800"
          >
            <Package class="size-4" aria-hidden="true" />
            My Orders
          </RouterLink>

          <RouterLink
            to="/cart"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-base font-semibold text-slate-700 hover:bg-slate-50 transition-all duration-200 font-accent dark:text-slate-300 dark:hover:bg-slate-800"
          >
            <ShoppingCart class="size-4" aria-hidden="true" />
            Cart
            <span v-if="cart.itemCount.value > 0" class="ml-auto rounded-full bg-orange-500 px-2 py-0.5 text-xs font-bold text-white">
              {{ cart.itemCount.value }}
            </span>
          </RouterLink>

          <button
            v-if="auth.isAuthenticated.value"
            type="button"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-left text-sm font-semibold text-red-600 hover:bg-red-50 transition-all duration-200 dark:hover:bg-red-900/30"
            @click="handleLogout"
          >
            <LogOut class="size-4" aria-hidden="true" />
            Logout
          </button>
        </nav>
      </div>
    </div>
  </header>
</template>
