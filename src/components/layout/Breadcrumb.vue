<script setup lang="ts">
import { computed } from 'vue'
import { ChevronRight, Home } from '@lucide/vue'
import { useRoute } from 'vue-router'

interface BreadcrumbItem {
  label: string
  to?: string
}

const props = defineProps<{
  items?: BreadcrumbItem[]
}>()

const route = useRoute()

const breadcrumbs = computed(() => {
  if (props.items) {
    return props.items
  }

  // Auto-generate from route
  const pathSegments = route.path.split('/').filter(Boolean)
  const items: BreadcrumbItem[] = [
    { label: 'Home', to: '/' },
  ]

  let currentPath = ''
  pathSegments.forEach((segment, index) => {
    currentPath += `/${segment}`
    const isLast = index === pathSegments.length - 1
    items.push({
      label: segment.charAt(0).toUpperCase() + segment.slice(1),
      to: isLast ? undefined : currentPath,
    })
  })

  return items
})
</script>

<template>
  <nav class="flex items-center gap-2 text-sm" aria-label="Breadcrumb">
    <RouterLink
      v-for="(item, index) in breadcrumbs"
      :key="index"
      :to="item.to || ''"
      class="flex items-center gap-2 transition-colors"
      :class="item.to ? 'text-slate-600 hover:text-sky-600' : 'text-slate-900 font-semibold'"
    >
      <Home v-if="index === 0" class="size-4" aria-hidden="true" />
      <ChevronRight v-else class="size-4 text-slate-400" aria-hidden="true" />
      {{ item.label }}
    </RouterLink>
  </nav>
</template>
