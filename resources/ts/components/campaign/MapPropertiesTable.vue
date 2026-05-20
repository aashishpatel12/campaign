<script setup lang="ts">
const props = defineProps<{
  csvColumns: string[]
  contactFields: { label: string; key: string; icon?: string }[]
}>()

const searchUnmapped = ref('')
const unmappedItems = ref([
  { label: 'Location', count: 9, matched: 3, icon: 'tabler-list' },
  { label: 'Industry', count: 3, matched: 3, icon: 'tabler-list' },
  { label: 'Notes', count: 9, matched: 9, icon: 'tabler-list' },
])

const matchedFields = ref([
  { label: 'Full name', key: 'name', count: 35, icon: 'tabler-user' },
  { label: 'First name', key: 'first_name', count: 3, icon: 'tabler-user' },
  { label: 'Last name', key: 'last_name', count: 12, icon: 'tabler-user' },
  { label: 'Company Name', key: 'company', count: 36, icon: 'tabler-building' },
  { label: 'Position', key: 'job_title', count: 25, icon: 'tabler-briefcase' },
  { label: 'Headline', key: 'headline', count: 25, icon: 'tabler-calendar' },
])

// Mapping state
const selectedMappings = ref<Record<string, string>>({
  'name': 'Full Name',
  'email': 'Email Address',
  'phone': 'Mobile Number',
  'company': 'Current Company',
})

const filteredUnmappedItems = computed(() => {
  if (!searchUnmapped.value) return unmappedItems.value
  return unmappedItems.value.filter(item => 
    item.label.toLowerCase().includes(searchUnmapped.value.toLowerCase())
  )
})

const clearAll = () => {
  selectedMappings.value = {}
}
</script>

<template>
  <div class="map-properties-container">
    <div class="d-flex align-center justify-space-between mb-2">
      <h5 class="text-h5 font-weight-bold text-high-emphasis">Map Properties</h5>
      <VBtn icon variant="text" color="error" size="small" @click="clearAll">
        <VIcon icon="tabler-trash" size="22" />
      </VBtn>
    </div>
    <div class="text-primary text-body-2 d-flex align-center mb-10">
      <VIcon icon="tabler-check" size="18" class="me-2" />
      Make sure file includes contact name and phone number
    </div>

    <VRow>
      <!-- Main Mapping area -->
      <VCol cols="12" md="8">
        <VRow class="mb-4">
          <VCol cols="6"><span class="text-subtitle-2 font-weight-bold text-high-emphasis">Contact Field</span></VCol>
          <VCol cols="6"><span class="text-subtitle-2 font-weight-bold text-high-emphasis">CSV Column</span></VCol>
        </VRow>

        <VRow v-for="(field, index) in matchedFields" :key="index" class="mb-3" no-gutters>
          <VCol cols="6" class="pe-3">
            <div class="mapping-box d-flex align-center pa-3 rounded-lg border">
              <VSheet color="rgba(var(--v-theme-primary), 0.08)" rounded class="d-flex align-center justify-center me-3" width="32" height="32">
                <VIcon :icon="field.icon || 'tabler-list'" size="18" color="success" />
              </VSheet>
              <span class="text-body-2 font-weight-medium">{{ field.label }}</span>
            </div>
          </VCol>
          <VCol cols="6" class="ps-3">
            <div class="mapping-box d-flex align-center pa-3 rounded-lg border">
              <VSheet color="rgba(var(--v-theme-on-surface), 0.08)" rounded class="d-flex align-center justify-center me-3" width="32" height="32">
                <VIcon :icon="field.icon || 'tabler-user'" size="18" color="secondary" />
              </VSheet>
              <VSelect
                v-model="selectedMappings[field.key]"
                :items="csvColumns"
                density="compact"
                variant="plain"
                hide-details
                class="flex-grow-1 select-mapping"
                placeholder="Select Column"
              />
              <span class="text-caption text-disabled ms-2" v-if="selectedMappings[field.key]">({{ field.count }})</span>
            </div>
          </VCol>
        </VRow>
      </VCol>

      <!-- Sidebar -->
      <VCol cols="12" md="4" class="ps-md-6">
        <div class="unmapped-sidebar border rounded-lg pa-5 h-100">
          <div class="d-flex align-center gap-2 mb-4">
            <span class="text-subtitle-2 font-weight-bold text-high-emphasis">Unmapped Works</span>
            <VDivider vertical class="mx-2" />
          </div>

          <VTextField
            v-model="searchUnmapped"
            placeholder="Search"
            density="compact"
            variant="outlined"
            prepend-inner-icon="tabler-search"
            class="mb-4 search-unmapped"
            hide-details
          />

          <div v-for="item in filteredUnmappedItems" :key="item.label" class="unmapped-item pa-3 border rounded-lg mb-2 d-flex align-center">
            <VIcon :icon="item.icon" size="20" color="primary" class="me-3" />
            <span class="text-body-2 flex-grow-1">{{ item.label }} ({{ item.count }})</span>
            <span class="text-caption text-disabled">({{ item.matched }})</span>
          </div>

          <div class="text-end mt-4">
            <a href="javascript:void(0)" class="text-primary text-caption text-decoration-none font-weight-bold" @click="clearAll">Clear All Matched</a>
          </div>
        </div>
      </VCol>
    </VRow>
  </div>
</template>

<style lang="scss" scoped>
.mapping-box {
  border-color: rgba(var(--v-theme-on-surface), 0.12) !important;
  background-color: rgb(var(--v-theme-surface)) !important;
  height: 52px;
}

.select-mapping {
  :deep(.v-field__input) {
    font-size: 14px !important;
    font-weight: 500 !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    min-height: auto !important;
    color: rgba(var(--v-theme-on-surface), var(--v-high-emphasis-opacity)) !important;
  }
}

.unmapped-sidebar {
  border-color: rgba(var(--v-theme-on-surface), 0.12) !important;
  background-color: rgba(var(--v-theme-on-surface), 0.02);
}

.unmapped-item {
  border-color: rgba(var(--v-theme-on-surface), 0.08) !important;
  background-color: rgb(var(--v-theme-surface)) !important;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
}

.search-unmapped {
  :deep(.v-field__outline) {
    color: rgba(var(--v-theme-on-surface), 0.12) !important;
  }
}

.text-high-emphasis {
  color: rgba(var(--v-theme-on-surface), var(--v-high-emphasis-opacity)) !important;
}
</style>
