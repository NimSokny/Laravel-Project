<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { LogIn } from '@lucide/vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseInput from '@/components/base/BaseInput.vue'
import { useAuthStore } from '@/stores/auth'
import { useCartStore } from '@/stores/cart'

const route = useRoute()
const router = useRouter()
const auth = useAuthStore()
const cart = useCartStore()

const form = reactive({
  email: '',
  password: '',
})

const emailReadonly = ref(true)
const passwordReadonly = ref(true)

function handleEmailFocus() {
  emailReadonly.value = false
}

function handlePasswordFocus() {
  passwordReadonly.value = false
}

async function submitLogin() {
  await auth.login(form)
  
  // Check if user is admin and redirect to admin dashboard
  const roleName = auth.state.user?.role?.name || auth.state.user?.role_name
  if (roleName === 'admin') {
    // Redirect to admin dashboard with API token for session creation
    window.location.href = `http://127.0.0.1:8000/admin/auth/token-login?token=${auth.state.token}`
    return
  }
  
  await cart.fetchCart()

  const redirect = String(route.query.redirect ?? '/')
  router.push(redirect.startsWith('/') ? redirect : '/')
}
</script>

<template>
  <main class="min-h-screen py-16 bg-slate-50">
    <div class="container-shell grid gap-12 lg:grid-cols-[1fr_1fr] lg:items-center">
      <section>
        <p class="text-sm font-semibold text-sky-600 uppercase tracking-wide">Login</p>
        <h1 class="mt-3 text-4xl font-bold text-slate-900 sm:text-5xl font-accent">Welcome back</h1>
        <p class="mt-5 max-w-xl text-lg leading-relaxed text-slate-600">
          Sign in to manage your cart, checkout, profile, and order history.
        </p>
      </section>

      <section class="mx-auto w-full max-w-md rounded-2xl border border-slate-200 bg-white p-8 shadow-lg">
        <h2 class="text-2xl font-bold text-slate-900 font-accent">Customer login</h2>
        <form class="mt-6 grid gap-5" @submit.prevent="submitLogin">
          <BaseInput
            v-model="form.email"
            type="email"
            label="Email"
            placeholder="you@example.com"
            required
            autocomplete="off"
            :readonly="emailReadonly"
            @focus="handleEmailFocus"
          />
          <BaseInput
            v-model="form.password"
            type="password"
            label="Password"
            placeholder="••••••••"
            required
            autocomplete="off"
            :readonly="passwordReadonly"
            @focus="handlePasswordFocus"
          />
          <BaseAlert v-if="auth.state.error" variant="error" dismissible>
            {{ auth.state.error }}
          </BaseAlert>
          <button
            type="submit"
            class="inline-flex items-center justify-center gap-2 w-full rounded-lg bg-slate-900 px-6 py-3 font-semibold text-white shadow-lg transition-all hover:bg-slate-800 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="auth.state.loading"
          >
            <LogIn class="size-4" aria-hidden="true" />
            {{ auth.state.loading ? 'Signing in...' : 'Login' }}
          </button>
        </form>
        <p class="mt-6 text-center text-sm text-slate-600">
          New customer?
          <RouterLink class="font-semibold text-sky-600 hover:text-sky-700 transition-colors" to="/register">
            Create an account
          </RouterLink>
        </p>
      </section>
    </div>
  </main>
</template>
