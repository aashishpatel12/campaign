<script setup lang="ts">
interface SequenceStep {
  id: string
  type: 'start' | 'connection' | 'message' | 'end' | 'add'
  title: string
  subtitle?: string
  message?: string
  wait?: {
    minutes: number
    hours: number
    days: number
  }
}

const steps = ref<SequenceStep[]>([
  {
    id: '1',
    type: 'start',
    title: 'Campaign Start',
    subtitle: 'When a lead enters your target audience'
  },
  {
    id: '2',
    type: 'connection',
    title: 'Send LinkedIn Connection Request',
    message: 'Hi {{first_name}}...'
  },
  {
    id: '3',
    type: 'message',
    title: 'Set Follow-up message',
    message: 'Hi {{first_name}}...',
    wait: { minutes: 3, hours: 3, days: 3 }
  },
  {
    id: '4',
    type: 'add',
    title: 'Add new follow-up'
  },
  {
    id: '5',
    type: 'end',
    title: 'End of Campaign'
  }
])

const removeStep = (id: string) => {
  steps.value = steps.value.filter(s => s.id !== id)
}
</script>

<template>
  <div class="sequence-builder mx-auto" style="max-width: 800px;">
    <div v-for="(step, index) in steps" :key="step.id" class="position-relative pb-4">
      <!-- Connection Line -->
      <div 
        v-if="index < steps.length - 1 && step.type !== 'add'" 
        class="position-absolute"
        style="left: 14px; top: 28px; bottom: 0; width: 2px; background: #CFDAFE; z-index: 0;"
      />

      <!-- Start Step -->
      <div v-if="step.type === 'start'" class="d-flex align-center gap-4 position-relative" style="z-index: 1;">
        <div class="step-timeline-dot pending bg-white">
           <div class="rounded-circle border-primary" style="width: 10px; height: 10px; border: 2px solid;" />
        </div>
        <div>
          <div class="step-title">{{ step.title }}</div>
          <div class="step-subtitle">{{ step.subtitle }}</div>
        </div>
      </div>

      <!-- Action Steps (Connection / Message) -->
      <div v-else-if="step.type === 'connection' || step.type === 'message'" class="d-flex gap-4 position-relative" style="z-index: 1;">
        <div class="step-timeline-dot pending bg-white">
           <VIcon :icon="step.type === 'connection' ? 'tabler-link' : 'tabler-message-share'" size="16" class="text-primary" />
        </div>
        <div class="sequence-step-row flex-grow-1 shadow-sm">
          <div class="d-flex align-center justify-space-between mb-2">
            <div class="step-title">{{ step.title }}</div>
            <div class="d-flex gap-2">
              <VBtn icon="tabler-edit" variant="text" size="x-small" color="secondary" />
              <VBtn icon="tabler-trash" variant="text" size="x-small" color="secondary" @click="removeStep(step.id)" />
            </div>
          </div>
          
          <div v-if="step.message" class="message-preview text-muted">
            {{ step.message }}
          </div>
          
          <div class="d-flex gap-2 mt-3">
            <VBtn variant="outlined" color="primary" density="compact" size="small" class="text-none">
              Edit Message
            </VBtn>
            <VBtn variant="tonal" color="primary" density="compact" size="small" class="text-none">
              <VIcon icon="tabler-sparkles" size="14" class="me-1" />
              Make with AI
            </VBtn>
          </div>

          <!-- Wait condition for messages -->
          <div v-if="step.wait" class="mt-4 pt-4 border-top">
            <div class="text-caption text-muted mb-2">Once accepted wait</div>
            <div class="d-flex align-center gap-2">
               <VTextField v-model="step.wait.minutes" type="number" density="compact" hide-details variant="outlined" style="max-width: 60px;" />
               <span class="text-caption">Minutes</span>
               <VTextField v-model="step.wait.hours" type="number" density="compact" hide-details variant="outlined" style="max-width: 60px;" />
               <span class="text-caption">Hour</span>
               <VTextField v-model="step.wait.days" type="number" density="compact" hide-details variant="outlined" style="max-width: 60px;" />
               <span class="text-caption">days</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Add Step -->
      <div v-else-if="step.type === 'add'" class="d-flex gap-4 position-relative" style="z-index: 1;">
         <div class="step-timeline-dot pending bg-white">
           <VIcon icon="tabler-plus" size="16" class="text-primary" />
        </div>
        <div class="add-step-row flex-grow-1">
          <VIcon icon="tabler-plus" size="18" class="me-2" />
          {{ step.title }}
        </div>
      </div>

      <!-- End Step -->
      <div v-else-if="step.type === 'end'" class="d-flex gap-4 position-relative" style="z-index: 1;">
         <div class="step-timeline-dot pending bg-white">
           <div class="rounded-circle border-primary" style="width: 10px; height: 10px; border: 2px solid;" />
        </div>
        <div class="end-of-campaign">
          <VIcon icon="tabler-square-rounded-x" size="18" />
          {{ step.title }}
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "@core-scss/template/pages/campaign";

.shadow-sm {
  box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important;
}

.border-top {
  border-top: 1px solid #F0F0F0 !important;
}
</style>
