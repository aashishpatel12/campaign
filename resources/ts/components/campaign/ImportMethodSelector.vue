<script setup lang="ts">
const props = defineProps<{
  modelValue: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', val: string): void
}>()

const methods = [
  {
    id: 'linkedin',
    title: 'LinkedIn Search',
    subtitle: '(Basic, Sales Nav, Post, Group or Event URL)',
    icon: 'tabler-brand-linkedin',
  },
  {
    id: 'csv',
    title: 'Upload CSV File',
    subtitle: 'Upload LinkedIn profiles via CSV. Download Sample',
    icon: 'tabler-file-upload',
  },
  {
    id: 'lookalike',
    title: 'Lookalike Audience',
    subtitle: 'Use Lead Finder to find audience.',
    icon: 'tabler-users',
  },
  {
    id: 'webhook',
    title: 'Inbound Webhook',
    subtitle: 'Sync leads from zapier, n8n make in real time',
    icon: 'tabler-webhook',
  }
]
</script>

<template>
  <div class="import-selector-flex">
    <div
      v-for="method in methods"
      :key="method.id"
      class="import-method-card shadow-none"
      :class="{ 'is-active': modelValue === method.id }"
      @click="emit('update:modelValue', method.id)"
    >
      <!-- Selection Indicator -->
      <div v-if="modelValue === method.id" class="selection-badge">
        <VIcon icon="tabler-check" size="14" color="white" />
      </div>

      <div class="mb-4">
        <VIcon 
          :icon="method.icon" 
          size="24" 
          class="method-icon-styled"
        />
      </div>
      
      <div class="method-title mb-1">{{ method.title }}</div>
      <div class="method-subtitle">{{ method.subtitle }}</div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.import-selector-flex {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.import-method-card {
  position: relative;
  width: 175px;
  height: 148px;
  padding: 24px 16px;
  border-radius: 8px;
  border: 1px solid rgba(var(--v-theme-on-surface), 0.12);
  background-color: rgba(var(--v-theme-on-surface), 0.02);
  display: flex;
  flex-direction: column;
  cursor: pointer;
  transition: all 0.2s ease;

  &.is-active {
    border-color: rgb(var(--v-theme-primary)) !important;
    background-color: rgba(var(--v-theme-primary), 0.08);
    border-width: 1.5px !important;
  }
  
  &:hover:not(.is-active) {
    border-color: rgba(var(--v-theme-on-surface), 0.24);
  }
}

.method-icon-styled {
  border: 1.5px solid #3666EE;
  border-radius: 6px;
  padding: 4px;
  background: #334155;
}

.selection-badge {
  position: absolute;
  top: 12px;
  right: 12px;
  width: 22px;
  height: 22px;
  background-color: rgb(var(--v-theme-primary));
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2;
}

.method-title {
  font-size: 14px;
  font-weight: 600;
  color: rgba(var(--v-theme-on-surface), var(--v-high-emphasis-opacity));
  line-height: 1.4;
}

.method-subtitle {
  font-size: 11px;
  color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity));
  line-height: 1.4;
  font-weight: 400;
}

@media (max-width: 600px) {
  .import-method-card {
    width: 100%;
    height: auto;
    min-height: 140px;
  }
}
</style>
