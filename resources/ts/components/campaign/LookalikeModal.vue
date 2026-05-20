<script setup lang="ts">
const props = defineProps<{
  modelValue: boolean
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', val: boolean): void
  (e: 'select'): void
}>()

const onSelect = () => {
  emit('select')
  emit('update:modelValue', false)
}

const isSelectionMode = ref(false)
const selectedList = ref('founder')

const lists = [
  { id: 'founder', title: 'Founder', subtitle: '(1000+ Users in the List)' },
  { id: 'tech', title: 'Tech Profiles', subtitle: '(1000+ Users in the List)' },
]
</script>

<template>
  <VDialog
    :model-value="modelValue"
    max-width="702"
    persistent
    class="lookalike-dialog"
    @update:model-value="emit('update:modelValue', $event)"
  >
    <VCard 
      class="modal-card overflow-hidden" 
      :style="{ height: isSelectionMode ? '433px' : '557px', minHeight: 'unset' }"
    >
      <!-- Header Area -->
      <header class="modal-header d-flex align-center justify-space-between">
        <div>
          <h5 class="modal-title mb-1">Lookalikes</h5>
          <p class="modal-subtitle mb-0">Select a lookalike list for this campaign</p>
        </div>
        <div class="close-btn-wrapper" @click="emit('update:modelValue', false)">
          <VIcon icon="tabler-x" size="20" color="rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity))" />
        </div>
      </header>

      <!-- Content Area -->
      <div v-if="!isSelectionMode" class="modal-content d-flex flex-column align-center justify-center text-center pa-10 h-100">
        <h2 class="empty-title mb-2">You don’t have any leads</h2>
        <p class="empty-subtitle mb-10">Create a lead list to start running campaigns</p>
        
        <VBtn
          class="btn-gradient px-10"
          height="42"
          rounded="lg"
          @click="isSelectionMode = true"
        >
          Create a List
        </VBtn>
      </div>

      <!-- Selection Mode -->
      <div v-else class="modal-content selection-content pa-6 d-flex flex-column">
        <div class="lists-wrapper flex-grow-1 px-2 scrollable-area">
          <div 
            v-for="list in lists" 
            :key="list.id" 
            class="list-card-item d-flex align-center px-4 mb-3 transition-all"
            :class="{ 'is-selected': selectedList === list.id }"
            @click="selectedList = list.id"
          >
            <div class="icon-section me-3">
              <VIcon icon="tabler-list" size="20" color="rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity))" />
            </div>
            <div class="text-section flex-grow-1">
              <span class="text-title me-2">{{ list.title }}</span>
              <span class="text-subtitle">{{ list.subtitle }}</span>
            </div>
            <div class="action-section">
              <VCheckbox
                v-model="selectedList"
                :multiple="false"
                :value="list.id"
                hide-details
                color="primary"
                density="compact"
                class="shrink-check"
              />
            </div>
          </div>
        </div>

        <div class="px-2 text-end mt-2">
          <a href="#" class="add-new-link">Add New</a>
        </div>

        <div class="footer-actions d-flex justify-end gap-3 mt-auto pt-4 px-2">
          <VBtn 
            variant="tonal" 
            class="cancel-btn px-8"
            height="38"
            @click="isSelectionMode = false"
          >
            Cancel
          </VBtn>
          <VBtn 
            class="btn-gradient px-8"
            height="38"
            @click="onSelect"
          >
            Select List
          </VBtn>
        </div>
      </div>
    </VCard>
</VDialog>
</template>

<style lang="scss" scoped>
.modal-card {
  width: 702px;
  border-radius: 12px !important;
  background: rgb(var(--v-theme-surface));
  box-shadow: 0px 4px 18px rgba(0, 0, 0, 0.1);
  transition: height 0.3s ease;
}

.modal-header {
  height: 88px;
  background: rgba(var(--v-theme-on-surface), 0.04);
  padding: 14px 25px;
  border-bottom: 1px solid rgba(var(--v-theme-on-surface), 0.12);
}

.modal-title {
  font-size: 20px;
  font-weight: 600;
  color: rgba(var(--v-theme-on-surface), var(--v-high-emphasis-opacity));
}

.modal-subtitle {
  font-size: 14px;
  color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity));
}

.close-btn-wrapper {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background 0.2s;
  border: 1px solid rgba(var(--v-theme-on-surface), 0.12);

  &:hover {
    background: rgba(var(--v-theme-on-surface), 0.08);
  }
}

/* Empty State */
.empty-title {
  font-size: 32px;
  font-weight: 700;
  color: rgba(var(--v-theme-on-surface), var(--v-high-emphasis-opacity));
}

.empty-subtitle {
  font-size: 15px;
  color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity));
}

/* Selection Mode Styling */
.selection-content {
  height: calc(100% - 88px);
}

.list-card-item {
  width: 650px;
  height: 64px;
  margin: 0 auto;
  background: rgba(var(--v-theme-on-surface), 0.02);
  border: 1px solid rgba(var(--v-theme-on-surface), 0.12);
  border-radius: 5px;
  cursor: pointer;

  &.is-selected {
    border-color: rgb(var(--v-theme-primary));
    background: rgba(var(--v-theme-primary), 0.08);
  }
}

.text-title {
  font-size: 15px;
  font-weight: 700;
  color: rgba(var(--v-theme-on-surface), var(--v-high-emphasis-opacity));
}

.text-subtitle {
  font-size: 12px;
  color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity));
  font-weight: 400;
}

.add-new-link {
  font-size: 13px;
  font-weight: 600;
  color: rgb(var(--v-theme-primary));
  text-decoration: none;
  
  &:hover { text-decoration: underline; }
}

.cancel-btn {
  background-color: rgba(var(--v-theme-on-surface), 0.08) !important;
  color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity)) !important;
  text-transform: none;
  font-weight: 600;
}

.btn-gradient {
  background: linear-gradient(135deg, #8ba6ff 0%, #3666ee 100%) !important;
  color: white !important;
  text-transform: none;
  font-weight: 600;
}

.shrink-check :deep(.v-selection-control) {
  min-height: unset;
}

.transition-all { transition: all 0.2s ease; }

:deep(.v-overlay__content) {
  border-radius: 12px !important;
}
</style>
