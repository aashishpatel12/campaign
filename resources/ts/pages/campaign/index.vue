<script setup lang="ts">
import SelectWorkflowModal from '@/components/campaign/SelectWorkflowModal.vue'
import avatar1 from '@images/figma/OBJECT.png'

definePage({
  meta: {
    layout: 'default',
  },
})

const router = useRouter()

const isSelectWorkflowModalVisible = ref(false)
const searchQuery = ref('')
const selectedFilter = ref('All')

const onWorkflowSelected = (type: 'advanced' | 'standard') => {
  if (type === 'advanced') {
    router.push({ name: 'campaign-advance-campaign' })
  } else {
    router.push({ name: 'campaign-standard' })
  }
}
</script>

<template>
  <div class="campaign-page">
    <!-- Filters & Search -->
    <div class="d-flex align-center gap-4 mb-6">
      <VSelect
        v-model="selectedFilter"
        :items="['All', 'Active', 'Paused', 'Draft']"
        density="compact"
        hide-details
        variant="outlined"
        style="max-width: 150px;"
        class="bg-white"
      />
      <VTextField
        v-model="searchQuery"
        placeholder="Search"
        density="compact"
        hide-details
        variant="outlined"
        prepend-inner-icon="tabler-search"
        class="bg-white"
        style="max-width: 300px;"
      />
    </div>

    <!-- Empty State -->
    <VCard class="d-flex align-center justify-center py-12" style="min-height: 500px;">
      <div class="text-center">
        <div class="mb-6">
          <VImg
             :src="avatar1"
            width="22.1rem"
            height="18.45rem"
            class="mx-auto"
          />
        </div>
        <VBtn
          class="btn-gradient px-8"
          @click="isSelectWorkflowModalVisible = true"
        >
          New Campaign
        </VBtn>
      </div>
    </VCard>

    <!-- Modal -->
    <SelectWorkflowModal
      v-model:is-dialog-visible="isSelectWorkflowModalVisible"
      @selected="onWorkflowSelected"
    />
  </div>
</template>

<style lang="scss" scoped>
@use "@core-scss/template/pages/campaign";
.v-card--variant-elevated {
  box-shadow: none !important;
}

.bg-transparent {
  background-color: transparent !important;
}

.shadow-none {
  box-shadow: none !important;
}
.campaign-page{
  background: white;
  padding: 2rem;
   .v-theme--dark & {
    background: rgb(var(--v-theme-surface));
  }
}
</style>
