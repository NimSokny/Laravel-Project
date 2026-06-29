<script setup lang="ts">
import { reactive, ref } from 'vue'
import { Mail, MapPin, Phone, Send } from '@lucide/vue'

const form = reactive({
  name: '',
  email: '',
  subject: '',
  message: '',
})

const sent = ref(false)

function submitContact() {
  sent.value = true
  form.name = ''
  form.email = ''
  form.subject = ''
  form.message = ''
}
</script>

<template>
  <main class="section-band">
    <div class="container-shell grid gap-8 lg:grid-cols-[0.85fr_1.15fr]">
      <section>
        <p class="eyebrow">Contact us</p>
        <h1 class="mt-3 page-title font-accent text-white dark:text-white">Talk with the computer shop team</h1>
        <p class="mt-5 text-base leading-7 text-zinc-600 font-accent text-white dark:text-white">
          Ask about product compatibility, custom builds, warranty, stock availability, or an order
          you have already placed.
        </p>

        <div class="mt-8 grid gap-4">
          <a class="surface-card flex gap-4 p-5 transition hover:border-zinc-400" href="tel:+85512345678">
            <Phone class="size-6 shrink-0 text-cyan-700" aria-hidden="true" />
            <span>
              <span class="block font-bold">Phone</span>
              <span class="text-sm text-zinc-600">+855 12 345 678</span>
            </span>
          </a>
          <a
            class="surface-card flex gap-4 p-5 transition hover:border-zinc-400"
            href="mailto:support@computershop.test"
          >
            <Mail class="size-6 shrink-0 text-emerald-700" aria-hidden="true" />
            <span>
              <span class="block font-bold">Email</span>
              <span class="text-sm text-zinc-600">support@computershop.test</span>
            </span>
          </a>
          <div class="surface-card flex gap-4 p-5">
            <MapPin class="size-6 shrink-0 text-amber-700" aria-hidden="true" />
            <span>
              <span class="block font-bold">Address</span>
              <span class="text-sm text-zinc-600">Phnom Penh, Cambodia</span>
            </span>
          </div>
        </div>
      </section>

      <section class="rounded-lg border border-zinc-200 bg-white p-5 sm:p-7">
        <h2 class="text-2xl font-bold text-zinc-950 font-accent">Send a message</h2>
        <p v-if="sent" class="mt-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
          Thanks. Our team will get back to you soon.
        </p>
        <form class="mt-6 grid gap-4" @submit.prevent="submitContact">
          <div class="grid gap-4 sm:grid-cols-2">
            <label class="grid gap-2">
              <span class="form-label">Name</span>
              <input v-model="form.name" class="form-input" required />
            </label>
            <label class="grid gap-2">
              <span class="form-label">Email</span>
              <input v-model="form.email" class="form-input" type="email" required />
            </label>
          </div>
          <label class="grid gap-2">
            <span class="form-label">Subject</span>
            <input v-model="form.subject" class="form-input" required />
          </label>
          <label class="grid gap-2">
            <span class="form-label">Message</span>
            <textarea v-model="form.message" class="form-input min-h-36 resize-y" required />
          </label>
          <button type="submit" class="btn-primary w-fit">
            <Send class="size-4" aria-hidden="true" />
            Send message
          </button>
        </form>
      </section>
    </div>
  </main>
</template>
