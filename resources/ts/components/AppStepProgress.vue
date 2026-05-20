<script setup lang="ts">
interface Step {
  label: string
  icon: string
}

const props = defineProps<{
  steps: Step[]
  current: number // 1-based
}>()
</script>

<template>
  <div class="d-flex align-center justify-space-between w-100 mb-8 px-4">
    <template v-for="(step, index) in steps" :key="index">
      <!-- Step Item -->
      <div class="d-flex align-center gap-2">
        <div 
          class="step-timeline-dot" 
          :class="{ 
            'active': current === index + 1, 
            'done': current > index + 1,
            'pending': current < index + 1 
          }"
        >
          <VIcon 
            v-if="current > index + 1" 
            icon="tabler-check" 
            size="18" 
          />
          <VIcon 
            v-else 
            :icon="step.icon" 
            size="18" 
          />
        </div>
        <div 
          class="text-subtitle-2 font-weight-medium"
          :class="current >= index + 1 ? 'text-primary' : 'text-disabled'"
        >
          {{ step.label }}
        </div>
      </div>

      <!-- Connector Line -->
      <div 
        v-if="index < steps.length - 1" 
        class="flex-grow-1 mx-4"
        style="height: 2px; background: #CFDAFE;"
      />
    </template>
  </div>
</template>

<style lang="scss" scoped>
@use "@core-scss/template/pages/campaign";
</style>
