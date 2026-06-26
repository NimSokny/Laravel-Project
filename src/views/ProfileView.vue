<script setup lang="ts">
import { onMounted, reactive, ref, watch } from 'vue'
import { Package, Save } from '@lucide/vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseInput from '@/components/base/BaseInput.vue'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const saved = ref(false)

const form = reactive({
  name: '',
  phone: '',
  address: '',
})

function fillForm() {
  form.name = auth.state.user?.name ?? ''
  form.phone = auth.state.user?.phone ?? ''
  form.address = auth.state.user?.address ?? ''
}

async function submitProfile() {
  saved.value = false
  await auth.updateProfile({
    name: form.name,
    phone: form.phone,
    address: form.address,
  })
  saved.value = true
}

watch(() => auth.state.user, fillForm, { immediate: true })

onMounted(async () => {
  await auth.loadProfile()
  fillForm()
})
</script>

<template>
  <main class="py-16 bg-slate-50">
    <div class="container-shell grid gap-8 lg:grid-cols-[320px_1fr]">
      <aside class="h-fit rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-semibold text-sky-600 uppercase tracking-wide">Account</p>
        <h1 class="mt-3 text-2xl font-bold text-slate-900 font-accent">{{ auth.state.user?.name }}</h1>
        <p class="mt-2 text-sm text-slate-600">{{ auth.state.user?.email }}</p>
        <RouterLink
          to="/orders"
          class="mt-6 inline-flex items-center justify-center gap-2 w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50"
        >
          <Package class="size-4" aria-hidden="true" />
          Order history
        </RouterLink>
      </aside>

      <section class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
        <h2 class="text-2xl font-bold text-slate-900 font-accent">Profile details</h2>
        <form class="mt-6 grid gap-5" @submit.prevent="submitProfile">
          <BaseInput
            v-model="form.name"
            label="Name"
            placeholder="Your full name"
            required
          />
          <div class="grid gap-5 sm:grid-cols-2">
            <BaseInput
              :model-value="auth.state.user?.email || ''"
              label="Email"
              disabled
              class="bg-slate-50 text-slate-500"
            />
            <BaseInput
              v-model="form.phone"
              type="tel"
              label="Phone"
              placeholder="+855 12 345 678"
            />
          </div>
          <BaseInput
            v-model="form.address"
            label="Address"
            placeholder="Your delivery address"
          />
          <BaseAlert v-if="saved" variant="success" dismissible>
            Profile updated successfully.
          </BaseAlert>
          <BaseAlert v-if="auth.state.error" variant="error" dismissible>
            {{ auth.state.error }}
          </BaseAlert>
          <button
            type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-6 py-3 font-semibold text-white shadow-lg transition-all hover:bg-slate-800 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="auth.state.loading"
          >
            <Save class="size-4" aria-hidden="true" />
            {{ auth.state.loading ? 'Saving...' : 'Save profile' }}
          </button>
        </form>
      </section>
    </div>
  </main>
</template>
