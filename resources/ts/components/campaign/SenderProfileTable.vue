<script setup lang="ts">
import avatar1 from '@images/avatars/avatar-1.png'

const search = ref('')
const itemsPerPage = ref(10)

const accounts = [
  {
    name: 'Edgar Jones',
    connections: '1,250 connections',
    health: 72,
    dailyLimits: 'Invites: 40 / day',
    accountType: 'Premium',
    status: 'Connected',
    avatar: avatar1
  }
]
</script>

<template>
  <div class="sender-profile-table mt-4">
    <!-- Search and Filter Bar -->
    <div class="d-flex align-center justify-space-between mb-6">
      <div class="d-flex align-center gap-2">
        <span class="text-body-2 text-disabled">Show</span>
        <VSelect
          v-model="itemsPerPage"
          :items="[10, 25, 50]"
          density="compact"
          variant="plain"
          hide-details
          style="width: 60px"
        />
      </div>
      
      <VTextField
        v-model="search"
        placeholder="Search"
        prepend-inner-icon="tabler-search"
        density="compact"
        variant="outlined"
        hide-details
        style="max-width: 250px"
        class="search-input"
      />
    </div>

    <!-- Table -->
    <VTable class="custom-table border-t">
      <thead>
        <tr>
          <th style="width: 48px"><VCheckbox hide-details /></th>
          <th class="text-overline">NAME</th>
          <th class="text-overline text-center">HEALTH</th>
          <th class="text-overline">DAILY LIMITS</th>
          <th class="text-overline">ACCOUNT TYPE</th>
          <th class="text-overline">STATUS</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in accounts" :key="item.name">
          <td><VCheckbox hide-details /></td>
          <td>
            <div class="d-flex align-center gap-3 py-2">
              <VAvatar size="38" :image="item.avatar" />
              <div class="d-flex flex-column">
                <span class="text-body-2 font-weight-bold text-high-emphasis">{{ item.name }}</span>
                <span class="text-caption text-disabled">{{ item.connections }}</span>
              </div>
            </div>
          </td>
          <td class="text-center">
            <div class="health-indicator mx-auto">
              <VProgressCircular
                :model-value="item.health"
                color="orange"
                width="3"
                size="40"
              >
                <span class="text-caption font-weight-bold">{{ item.health }}</span>
              </VProgressCircular>
            </div>
          </td>
          <td>
            <VSheet color="rgba(var(--v-theme-on-surface), 0.04)" border rounded class="px-3 py-1 d-inline-block text-caption">
              {{ item.dailyLimits }}
            </VSheet>
          </td>
          <td>
            <div class="d-flex align-center gap-2">
              <VIcon icon="tabler-brand-linkedin" color="primary" size="18" />
              <span class="text-body-2 text-medium-emphasis">{{ item.accountType }}</span>
            </div>
          </td>
          <td>
            <VChip color="success" size="small" class="font-weight-bold text-none px-4">
              {{ item.status }}
            </VChip>
          </td>
        </tr>
      </tbody>
    </VTable>
  </div>
</template>

<style lang="scss" scoped>
.custom-table {
  background: transparent !important;
  
  th {
    background-color: rgba(var(--v-theme-on-surface), 0.04) !important;
    color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity)) !important;
    font-weight: 600 !important;
    letter-spacing: 0.5px !important;
    border-bottom: 1px solid rgba(var(--v-theme-on-surface), 0.12) !important;
  }

  td {
    border-bottom: 1px solid rgba(var(--v-theme-on-surface), 0.12) !important;
  }

  tr:hover {
    background-color: rgba(var(--v-theme-primary), 0.04) !important;
  }
}

.search-input {
  :deep(.v-field__outline) {
    color: rgba(var(--v-theme-on-surface), 0.12) !important;
  }
}

.text-high-emphasis {
  color: rgba(var(--v-theme-on-surface), var(--v-high-emphasis-opacity)) !important;
}

.text-disabled {
  color: rgba(var(--v-theme-on-surface), var(--v-disabled-opacity)) !important;
}

.text-medium-emphasis {
  color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity)) !important;
}

.health-indicator {
  width: 40px;
}
</style>
