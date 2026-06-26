<script setup lang="ts">
import { CheckCircle, Cpu, ShieldCheck, Wrench } from '@lucide/vue'
</script>

<template>
  <main>
    <section class="section-band bg-white">
      <div class="container-shell grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
        <div>
          <p class="eyebrow">About us</p>
          <h1 class="mt-3 page-title font-accent">Computer advice, hardware, and service in one place</h1>
          <p class="mt-5 text-base leading-7 text-zinc-600">
            Computer Shop helps customers choose the right device or component for their real
            workload. From student laptops to gaming desktops and office upgrades, the team keeps
            the buying experience clear, practical, and support-focused.
          </p>
          <div class="mt-8 grid gap-3 sm:grid-cols-3">
            <div class="rounded-lg border border-zinc-200 bg-zinc-50 p-4">
              <Cpu class="mb-3 size-6 text-cyan-700" aria-hidden="true" />
              <p class="text-sm font-bold">Hardware</p>
            </div>
            <div class="rounded-lg border border-zinc-200 bg-zinc-50 p-4">
              <Wrench class="mb-3 size-6 text-amber-700" aria-hidden="true" />
              <p class="text-sm font-bold">Service</p>
            </div>
            <div class="rounded-lg border border-zinc-200 bg-zinc-50 p-4">
              <ShieldCheck class="mb-3 size-6 text-emerald-700" aria-hidden="true" />
              <p class="text-sm font-bold">Warranty</p>
            </div>
          </div>
        </div>

        <div class="overflow-hidden rounded-lg border border-zinc-200">
          <img
            src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1200&q=80"
            alt="Computer shop team working with laptops"
            class="aspect-[4/3] size-full object-cover"
          />
        </div>
      </div>
    </section>

    <section class="section-band">
      <div class="container-shell grid gap-6 md:grid-cols-3">
        <article class="rounded-lg border border-zinc-200 bg-white p-6">
          <h2 class="text-xl font-bold text-zinc-950 font-accent">Practical recommendations</h2>
          <p class="mt-3 text-sm leading-6 text-zinc-600">
            Customers can compare devices by category, brand, price, stock, warranty, and the work
            they actually need to finish.
          </p>
        </article>
        <article class="rounded-lg border border-zinc-200 bg-white p-6">
          <h2 class="text-xl font-bold text-zinc-950 font-accent">Connected operations</h2>
          <p class="mt-3 text-sm leading-6 text-zinc-600">
            Inventory, customer orders, and service notes stay organized so staff can move quickly
            from product advice to fulfillment.
          </p>
        </article>
        <article class="rounded-lg border border-zinc-200 bg-white p-6">
          <h2 class="text-xl font-bold text-zinc-950 font-accent">Support after purchase</h2>
          <p class="mt-3 text-sm leading-6 text-zinc-600">
            Profile, order history, warranty notes, and contact paths keep customer service close to
            the shopping journey.
          </p>
        </article>
      </div>
    </section>

    <section class="section-band bg-white">
      <div class="container-shell">
        <div class="max-w-3xl">
          <p class="eyebrow">Values</p>
          <h2 class="mt-2 text-3xl font-bold text-zinc-950 font-accent">Built for confidence</h2>
        </div>
        <div class="mt-8 grid gap-4 md:grid-cols-2">
          <p class="flex gap-3 rounded-lg border border-zinc-200 p-4 text-sm leading-6 text-zinc-700">
            <CheckCircle class="mt-0.5 size-5 shrink-0 text-emerald-700" aria-hidden="true" />
            Clear product information with price, stock, brand, warranty, and specifications.
          </p>
          <p class="flex gap-3 rounded-lg border border-zinc-200 p-4 text-sm leading-6 text-zinc-700">
            <CheckCircle class="mt-0.5 size-5 shrink-0 text-emerald-700" aria-hidden="true" />
            Buying support for customers shopping on phones, tablets, and desktop monitors.
          </p>
          <p class="flex gap-3 rounded-lg border border-zinc-200 p-4 text-sm leading-6 text-zinc-700">
            <CheckCircle class="mt-0.5 size-5 shrink-0 text-emerald-700" aria-hidden="true" />
            Customer accounts for faster checkout and easier order follow-up.
          </p>
          <p class="flex gap-3 rounded-lg border border-zinc-200 p-4 text-sm leading-6 text-zinc-700">
            <CheckCircle class="mt-0.5 size-5 shrink-0 text-emerald-700" aria-hidden="true" />
            Room for services such as custom builds, maintenance plans, and seasonal bundles.
          </p>
        </div>
      </div>
    </section>
  </main>
</template>
