<script lang="ts" setup>
import navItems from '@/navigation/horizontal'
import { useRoute } from 'vue-router'

// Components
import Footer from '@/layouts/components/Footer.vue'
import UserProfile from '@/layouts/components/UserProfile.vue'

// @layouts plugin
import { HorizontalNavLayout } from '@layouts'

const route = useRoute()

// Breadcrumb logic
const breadcrumb = computed(() => {
  const path = route.path
  if (path === '/' || path === '/campaign' || path === '/campaign/') {
    return { isHome: true, parent: 'Campaign', current: '' }
  }
  
  // Mapping for other pages
  const titles: Record<string, string> = {
    '/campaign/standard': 'Standard Workflow',
    '/campaign/advance-campaign': 'Advance Campaign',
    '/campaign/create-type': 'Select Workflow',
  }

  return { 
    isHome: false, 
    parent: 'Campaign', 
    current: titles[path] || route.meta.title || 'Advance Campaign' 
  }
})
</script>

<template>
  <HorizontalNavLayout :nav-items="navItems">
    <!-- 👉 navbar -->
    <template #navbar>
      <div class="d-flex h-100 align-center w-100 px-4">
        <!-- Breadcrumbs -->
        <div class="d-flex align-center gap-2">
          <template v-if="breadcrumb.isHome">
            <VIcon icon="tabler-home" size="20" color="primary" />
            <VIcon icon="tabler-chevron-right" size="18" class="text-disabled" />
            <span class="text-body-1 text-disabled">Campaign</span>
          </template>
          <template v-else>
            <span class="text-body-1 text-primary cursor-pointer" @click="$router.push('/campaign')">Campaign</span>
            <VIcon icon="tabler-chevron-right" size="18" class="text-disabled" />
            <span class="text-body-1 text-high-emphasis font-weight-medium">{{ breadcrumb.current }}</span>
          </template>
        </div>

        <VSpacer />

        <!-- User Profile -->
        <div class="d-flex align-center gap-3">
          <div class="text-end d-none d-sm-block">
            <div class="text-body-2 font-weight-bold text-high-emphasis leading-tight">John Doe</div>
            <div class="text-caption text-disabled leading-tight">Admin</div>
          </div>
          <UserProfile />
        </div>
      </div>
    </template>

    <!-- 👉 Pages -->
    <slot />

    <!-- 👉 Footer -->
    <template #footer>
      <Footer />
    </template>
  </HorizontalNavLayout>
</template>

<style lang="scss" scoped>
.leading-tight { line-height: 1.2; }
</style>
