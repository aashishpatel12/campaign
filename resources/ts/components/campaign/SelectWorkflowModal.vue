<script setup lang="ts">
import fram1 from "@images/figma/Group (2).png"
import fram2 from "@images/figma/Frame 11.png"

const props = defineProps<{
  isDialogVisible: boolean
}>()

const emit = defineEmits<{
  (e: 'update:isDialogVisible', val: boolean): void
  (e: 'selected', type: 'advanced' | 'standard'): void
}>()

const selectedMode = ref<'advanced' | 'standard'>('advanced')

const onSubmit = () => {
  emit('selected', selectedMode.value)
  emit('update:isDialogVisible', false)
}
</script>

<template>
  <VDialog
    :model-value="props.isDialogVisible"
    persistent
    width="643"
    @update:model-value="val => emit('update:isDialogVisible', val)"
  >
    <VCard class="workflow-modal-card rounded-lg overflow-hidden border">
      <!-- Header Area -->
      <div class="modal-header d-flex justify-space-between align-center px-8 border-bottom bg-[#F8F8F8]">
        <div>
          <h2 class="text-h6 font-weight-bold color-title leading-tight mb-0">Select Workflow Mode</h2>
          <p class="text-caption color-subtitle mb-0">Choose how you want your campaign to behave</p>
        </div>
        <VBtn
          icon="tabler-x"
          variant="outlined"
          density="compact"
          color="secondary"
          class="rounded-circle btn-close"
          @click="emit('update:isDialogVisible', false)"
        />
      </div>

      <VCardText class="pa-8">
        <VRadioGroup v-model="selectedMode" hide-details class="workflow-group">
          <!-- Advanced Workflow Card -->
          <div 
            class="workflow-option-card pa-4 rounded-lg mb-4 cursor-pointer transition-all"
            :class="{ 'active-option': selectedMode === 'advanced' }"
            @click="selectedMode = 'advanced'"
          >
            <div class="d-flex align-top gap-3 justify-between">
              <div class="d-flex w-[80%]" style="width: 80%; gap: 10px;">
                <VRadio value="advanced" color="primary" class="mt-1" density="compact" hide-details />
                <div class="flex-grow-1">
                  <div class="d-flex align-center gap-2 mb-1">
                    <span class="text-button font-weight-bold color-title text-capitalize">Advanced Workflow</span>
                    <div class="recommended-badge">Recommended</div>
                  </div>
                  <p class="text-caption color-subtitle mb-3">Best for high-volume outreach</p>
                  
                  <div class="features-list d-flex align-center gap-4">
                    <div class="feature-dot-item">Conditional logic</div>
                    <div class="feature-dot-item">Multiple paths</div>
                    <div class="feature-dot-item">More control</div>
                  </div>
                </div>
              </div>
              <!-- Image Illustration -->
              <VImg :src="fram1" width="80" height="60" contain class="flex-shrink-0 w-full" />
            </div>
          </div>

          <!-- Standard Workflow Card -->
          <div 
            class="workflow-option-card pa-4 rounded-lg cursor-pointer transition-all"
            :class="{ 'active-option': selectedMode === 'standard' }"
            @click="selectedMode = 'standard'"
          >
            <div class="d-flex align-top gap-3 justify-between">
              <div class="d-flex w-[80%]" style="width: 80%; gap: 10px;">
                <VRadio value="standard" color="primary" class="mt-1" density="compact" hide-details />
                <div class="flex-grow-1">
                  <div class="d-flex align-center gap-2 mb-1">
                    <span class="text-button font-weight-bold color-title text-capitalize">Standard Workflow</span>
                  </div>
                  <p class="text-caption color-subtitle mb-3">Best for beginners</p>
                  
                  <div class="features-list d-flex align-center gap-4">
                    <div class="feature-dot-item">Linear steps</div>
                    <div class="feature-dot-item">No conditions</div>
                    <div class="feature-dot-item">Easy Setup</div>
                  </div>
                </div>
              </div>
              <!-- Image Illustration -->
              <VImg :src="fram2" width="full" height="60" contain class="d-flex justify-content-end align-end" />
            </div>
          </div>
        </VRadioGroup>
      </VCardText>

      <!-- Footer -->
      <div class="d-flex justify-end gap-3 px-8 pb-8">
        <VBtn
          color="#F1F1F4"
          variant="flat"
          class="px-8 text-none font-weight-bold rounded-lg color-btn-text"
          height="40"
          @click="emit('update:isDialogVisible', false)"
        >
          Close
        </VBtn>
        <VBtn 
          class="btn-gradient px-8 text-none font-weight-bold rounded-lg"
          height="40"
          @click="onSubmit"
        >
          Next
        </VBtn>
      </div>
    </VCard>
  </VDialog>
</template>

<style lang="scss" scoped>
.workflow-modal-card {
  height: 471px;
  background: rgb(var(--v-theme-surface));
  box-shadow: 0 10px 40px rgba(0,0,0,0.1) !important;
}

.modal-header {
  height: 70px;
  background: rgba(var(--v-theme-on-surface), 0.04);
}

.workflow-option-card {
  width: 582px;
  height: 137px;
  background: rgb(var(--v-theme-surface));
  border: 1px solid rgba(var(--v-theme-on-surface), 0.12) !important;
  display: flex;
  flex-direction: column;
  justify-content: center;
  
  &.active-option {
    border-color: rgba(var(--v-theme-primary), 0.2) !important;
    background: rgba(var(--v-theme-primary), 0.08);
    border-width: 1px !important;
  }

  &:hover:not(.active-option) {
    border-color: rgba(var(--v-theme-on-surface), 0.24) !important;
  }
}

.recommended-badge {
  background-color: rgba(var(--v-theme-success), 0.12);
  color: rgb(var(--v-theme-success));
  font-size: 10px;
  font-weight: 700;
  padding: 1px 8px;
  border-radius: 4px;
}

.feature-dot-item {
  display: flex;
  align-items: center;
  font-size: 12px;
  color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity));
  font-weight: 500;

  &::before {
    content: "";
    width: 6px;
    height: 6px;
    background-color: rgba(var(--v-theme-on-surface), 0.12);
    border-radius: 50%;
    margin-right: 8px;
  }
}

.btn-close {
  width: 24px;
  height: 24px;
  border-color: rgba(var(--v-theme-on-surface), 0.12) !important;
  color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity)) !important;
  .v-icon { font-size: 14px; }
}

.btn-gradient {
  background: linear-gradient(135deg, #8ba6ff 0%, #3666ee 100%) !important;
  color: white !important;
  box-shadow: 0 4px 10px rgba(54, 102, 238, 0.2) !important;
}

.color-title { color: rgba(var(--v-theme-on-surface), var(--v-high-emphasis-opacity)) !important; }
.color-subtitle { color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity)) !important; }
.color-btn-text { color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity)) !important;  .v-theme--dark & {
    background: rgba(var(--v-theme-on-surface), 0.08) !important;
  } }
.leading-tight { line-height: 1.25; }

.transition-all {
  transition: all 0.2s ease;
}

.border-bottom {
  border-bottom: 1px solid rgba(var(--v-theme-on-surface), 0.12) !important;
}

.workflow-group :deep(.v-selection-control) {
  width: 24px !important;
  min-height: auto !important;
  margin-inline-end: 0px !important;
  flex: none !important;
}

.workflow-group :deep(.v-selection-control__wrapper) {
  width: 24px !important;
  height: 24px !important;
  margin: 0 !important;
}

.workflow-group :deep(.v-radio) {
  margin-inline-end: 0px !important;
  align-items: start;
}
</style>
