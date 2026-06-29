<script setup lang="ts">
import { onMounted } from 'vue'
import AppFooter from '@/components/layout/AppFooter.vue'
import AppHeader from '@/components/layout/AppHeader.vue'
import { useThemeStore } from '@/stores/theme'

const theme = useThemeStore()

onMounted(() => {
  // Initialize theme on app mount
  theme.setTheme(theme.theme.value)
})
</script>

<template>
  <div class="flex min-h-screen flex-col bg-white dark:bg-slate-900 dark:text-white transition-colors duration-200">
    <AppHeader />
    <RouterView class="flex-1" />
    <AppFooter />
  </div>
</template>
