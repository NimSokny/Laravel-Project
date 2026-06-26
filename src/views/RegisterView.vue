<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { User, UserPlus, Upload, X } from '@lucide/vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseInput from '@/components/base/BaseInput.vue'
import { useAuthStore } from '@/stores/auth'
import { useCartStore } from '@/stores/cart'

const router = useRouter()
const auth = useAuthStore()
const cart = useCartStore()

const form = reactive({
  name: '',
  email: '',
  phone: '',
  address: '',
  password: '',
  password_confirmation: '',
})

const profileImage = ref<File | null>(null)
const profileImagePreview = ref<string | null>(null)

function handleProfileImageChange(event: Event) {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  if (file) {
    profileImage.value = file
    profileImagePreview.value = URL.createObjectURL(file)
  }
}

function removeProfileImage() {
  profileImage.value = null
  profileImagePreview.value = null
}

async function submitRegister() {
  const formData = new FormData()
  formData.append('name', form.name)
  formData.append('email', form.email)
  formData.append('password', form.password)
  formData.append('password_confirmation', form.password_confirmation)
  if (form.phone) formData.append('phone', form.phone)
  if (form.address) formData.append('address', form.address)
  if (profileImage.value) formData.append('profile_image', profileImage.value)

  await auth.register(formData)
  await cart.fetchCart()
  router.push({ name: 'home' })
}
</script>

<template>
  <main class="min-h-screen py-16 bg-slate-50">
    <div class="container-shell grid gap-12 lg:grid-cols-[1fr_1fr] lg:items-center">
      <section>
        <p class="text-sm font-semibold text-sky-600 uppercase tracking-wide">Register</p>
        <h1 class="mt-3 text-4xl font-bold text-slate-900 sm:text-5xl font-accent">Create your customer account</h1>
        <p class="mt-5 max-w-xl text-lg leading-relaxed text-slate-600">
          Save your profile details, check out faster, and review your order history after purchase.
        </p>
      </section>

      <section class="mx-auto w-full max-w-xl rounded-2xl border border-slate-200 bg-white p-8 shadow-lg">
        <h2 class="text-2xl font-bold text-slate-900 font-accent">Account details</h2>
        <form class="mt-6 grid gap-5" @submit.prevent="submitRegister">
          <div class="grid gap-5 sm:grid-cols-2">
            <BaseInput
              v-model="form.name"
              label="Name"
              placeholder="Your full name"
              required
              autocomplete="name"
            />
            <BaseInput
              v-model="form.phone"
              type="tel"
              label="Phone"
              placeholder="+855 12 345 678"
              autocomplete="tel"
            />
          </div>
          <BaseInput
            v-model="form.email"
            type="email"
            label="Email"
            placeholder="you@example.com"
            required
            autocomplete="email"
          />
          <BaseInput
            v-model="form.address"
            label="Address"
            placeholder="Your delivery address"
          />
          
          <!-- Profile Image Upload -->
          <div class="space-y-3">
            <label class="block text-sm font-semibold text-slate-700">Profile Image</label>
            <div class="flex items-center gap-4">
              <div v-if="profileImagePreview" class="relative size-20 shrink-0">
                <img
                  :src="profileImagePreview"
                  alt="Profile preview"
                  class="size-20 rounded-full object-cover border-2 border-slate-200"
                />
                <button
                  type="button"
                  class="absolute -top-2 -right-2 flex size-6 items-center justify-center rounded-full bg-red-500 text-white shadow-md hover:bg-red-600 transition-colors"
                  @click="removeProfileImage"
                >
                  <X class="size-3" />
                </button>
              </div>
              <div v-else class="size-20 shrink-0 rounded-full border-2 border-dashed border-slate-300 bg-slate-50 flex items-center justify-center">
                <User class="size-8 text-slate-400" />
              </div>
              <div class="flex-1">
                <label class="inline-flex items-center gap-2 cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:border-slate-400 hover:bg-slate-50">
                  <Upload class="size-4" />
                  <span>{{ profileImage ? profileImage.name : 'Choose image' }}</span>
                  <input
                    type="file"
                    accept="image/*"
                    class="hidden"
                    @change="handleProfileImageChange"
                  />
                </label>
                <p class="mt-2 text-xs text-slate-500">JPG, PNG, GIF up to 5MB</p>
              </div>
            </div>
          </div>

          <div class="grid gap-5 sm:grid-cols-2">
            <BaseInput
              v-model="form.password"
              type="password"
              label="Password"
              placeholder="••••••••"
              required
              autocomplete="new-password"
            />
            <BaseInput
              v-model="form.password_confirmation"
              type="password"
              label="Confirm password"
              placeholder="••••••••"
              required
              autocomplete="new-password"
            />
          </div>
          <BaseAlert v-if="auth.state.error" variant="error" dismissible>
            {{ auth.state.error }}
          </BaseAlert>
          <button
            type="submit"
            class="inline-flex items-center justify-center gap-2 w-full rounded-lg bg-slate-900 px-6 py-3 font-semibold text-white shadow-lg transition-all hover:bg-slate-800 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="auth.state.loading"
          >
            <UserPlus class="size-4" aria-hidden="true" />
            {{ auth.state.loading ? 'Creating account...' : 'Register' }}
          </button>
        </form>
        <p class="mt-6 text-center text-sm text-slate-600">
          Already registered?
          <RouterLink class="font-semibold text-sky-600 hover:text-sky-700 transition-colors" to="/login">
            Login
          </RouterLink>
        </p>
      </section>
    </div>
  </main>
</template>
