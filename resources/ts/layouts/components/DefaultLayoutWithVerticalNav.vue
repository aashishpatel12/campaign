<script lang="ts" setup>
import navItems from '@/navigation/vertical'
import { useRoute } from 'vue-router'
import avatar1 from '@images/avatars/avatar-1.png'
import { useTheme } from 'vuetify'
import logo from '@images/figma/Isolation_Mode.png'
// Components
import Footer from '@/layouts/components/Footer.vue'
import UserProfile from '@/layouts/components/UserProfile.vue'

// @layouts plugin
import { VerticalNavLayout } from '@layouts'

const route = useRoute()
const theme = useTheme()

// Breadcrumb logic
const breadcrumb = computed(() => {
  const path = route.path
  if (path === '/' || path === '/campaign' || path === '/campaign/') {
    return { isHome: true, parent: 'Campaign', current: '' }
  }
  
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

const toggleTheme = (val: 'light' | 'dark') => {
  theme.global.name.value = val
}
</script>

<template>
  <VerticalNavLayout :nav-items="navItems">
    <!-- 👉 navbar -->
    <template #navbar="{ toggleVerticalOverlayNavActive }">
      <div class="d-flex h-100 align-center w-100">
        <IconBtn
          id="vertical-nav-toggle-btn"
          class="ms-n3 d-lg-none"
          @click="toggleVerticalOverlayNavActive(true)"
        >
          <VIcon size="26" icon="tabler-menu-2" />
        </IconBtn>

        <!-- Left Side: Breadcrumbs -->
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

        <!-- Right Side: User Name & Profile -->
        <div class="d-flex align-center gap-3">
          <div class="text-end d-none d-sm-block">
            <div class="text-body-2 font-weight-bold text-high-emphasis leading-tight">John Doe</div>
            <div class="text-caption text-disabled leading-tight">Admin</div>
          </div>
          <UserProfile />
        </div>
      </div>
    </template>

    <!-- 👉 Vertical Nav Header override -->
    <!-- <template #vertical-nav-header>
        <div class="d-flex align-start gap-1 py-4 w-100  mt-2 hover:cursor-pointer"">
              <VImg :src="logo" style="width: 25.44px; height: 25.44px;" />
             <span class="text-h6 font-weight-bold text-high-emphasis">Frontend Task</span>
             <VSpacer />
             <VIcon icon="tabler-layout-sidebar-left-collapse" size="20" class="text-disabled cursor-pointer" />
        </div>
    </template> -->
    <template #vertical-nav-header>
  <div class="sidebar-header">
    <div class="sidebar-header__left">
      <VImg
        :src="logo"
        width="24"
        height="24"
        contain
      />

      <span class="sidebar-title">
        Frontend Task
      </span>
    </div>

    <VIcon
      icon="tabler-layout-sidebar-left-collapse"
      size="18"
      class="sidebar-collapse-icon"
    />
  </div>
</template>

    <!-- 👉 Sidebar Bottom Content -->
    <template #after-vertical-nav-items>
        <div class="sidebar-footer px-4 pb-6 mt-auto">
             <!-- User Profile Card -->
             <div class="user-sidebar-card pa-4 rounded-lg mb-4">
                 <div class="d-flex align-center gap-3 mb-4">
                    <VBadge dot location="bottom right" color="success" offset-x="3" offset-y="3" bordered>
                         <VAvatar size="38">
                            <VImg :src="avatar1" />
                         </VAvatar>
                    </VBadge>
                    <div class="flex-grow-1">
                        <div class="text-body-2 font-weight-bold leading-tight">John Doe</div>
                        <div class="text-caption text-disabled leading-tight">Admin</div>
                    </div>
                    <IconBtn size="small" class="bg-light-primary rounded-lg">
                        <VIcon icon="tabler-logout-2" size="18" class="text-disabled" />
                    </IconBtn>
                 </div>
                 <div>
                    <div class="text-caption text-disabled font-weight-medium">Email</div>
                    <div class="text-caption text-medium-emphasis font-weight-semibold">johndoe@gmail.com</div>
                 </div>
             </div>

             <!-- Theme Switcher -->
             <div class="theme-switcher-pill d-flex align-center pa-1 rounded-pill">
                  <div 
                    class="theme-opt flex-grow-1 d-flex align-center justify-center gap-2 py-1 cursor-pointer transition-all rounded-pill" 
                    :class="{ 'active': theme.global.name.value === 'light' }"
                    @click="toggleTheme('light')"
                  >
                    <VIcon icon="tabler-sun" size="16" />
                    <span class="text-caption font-weight-bold">Light</span>
                  </div>
                  <div 
                    class="theme-opt flex-grow-1 d-flex align-center justify-center gap-2 py-1 cursor-pointer transition-all rounded-pill" 
                    :class="{ 'active': theme.global.name.value === 'dark' }"
                    @click="toggleTheme('dark')"
                  >
                    <VIcon icon="tabler-moon" size="16" />
                    <span class="text-caption font-weight-bold">Dark</span>
                  </div>
             </div>
        </div>
    </template>

    <!-- 👉 Pages -->
    <slot />

    <!-- 👉 Footer -->
    <template #footer>
      <Footer />
    </template>
  </VerticalNavLayout>
</template>

<style lang="scss">
@use "@configured-variables" as variables;

.leading-tight { line-height: 1.2; }

.layout-vertical-nav {
  // Nav Link Overrides
  .nav-link {
    // margin-inline: 16px !important;
    margin-block: 4px !important;
    
    a {
      border-radius: 8px !important;
      padding-inline: 12px !important;
      height: 42px !important;
      
      &.router-link-active {
        background: linear-gradient(135deg, #8ba6ff 0%, #3666ee 100%) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(54, 102, 238, 0.3) !important;
        
        .nav-item-icon, .nav-item-title { color: white !important; }
      }
    }
  }

  .user-sidebar-card {
    background-color: rgba(var(--v-theme-on-surface), 0.04);
  }

  .theme-switcher-pill {
    background-color: rgba(var(--v-theme-on-surface), 0.08);
    .theme-opt {
        color: rgba(var(--v-theme-on-surface), 0.6);
        &.active {
            background-color: rgb(var(--v-theme-surface));
            color: #3666ee;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    }
  }
}
.layout-vertical-nav {

.sidebar-header {
  display: flex;
  align-items: center;
  justify-content: space-between;

  width: 100%;
  height: 54px;
  margin-top: 6px;
  background: rgb(var(--v-theme-surface));

  cursor: pointer;
}

.sidebar-header__left {
  display: flex;
  align-items: center;
  gap: 10px;
}

.sidebar-title {
font-family: TT Fors Trial;
font-weight: 600;
font-style: DemiBold;
font-size: 17.13px;
leading-trim: CAP_HEIGHT;
line-height: 100%;
letter-spacing: 0%;
color: #00002B;
 .v-theme--dark & {
    color: white;
  }

}

.sidebar-collapse-icon {
  color: rgba(var(--v-theme-on-surface), 0.45);
}
}
</style>
