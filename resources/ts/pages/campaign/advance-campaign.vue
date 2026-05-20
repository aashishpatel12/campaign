<script setup lang="ts">
import ImportMethodSelector from '@/components/campaign/ImportMethodSelector.vue'
import CsvUploadArea from '@/components/campaign/CsvUploadArea.vue'
import MapPropertiesTable from '@/components/campaign/MapPropertiesTable.vue'
import LookalikeModal from '@/components/campaign/LookalikeModal.vue'
import SenderProfileTable from '@/components/campaign/SenderProfileTable.vue'

definePage({
  meta: {
    layout: 'default',
    navActiveLink: 'campaign',
  },
})

// Current Workflow Step Status
// 1: LinkedIn URL
// 2: CSV Upload
// 3: Map Properties
// 4: Lookalike Selection
const workflowStep = ref(1)
const currentStep = ref(1) // Header stepper
const importMethod = ref('linkedin')
const linkedinUrl = ref('')
const isCsvUploaded = ref(false)
const uploadedFileName = ref('')
const showLookalikePopup = ref(false)
const profileTab = ref('linkedin')
const isSubmitting = ref(false)

// Toast State
const isSnackbarVisible = ref(false)
const snackbarMessage = ref('')
const snackbarColor = ref('success')
const isValidating = ref(false)

const showToast = (message: string, color: string = 'success') => {
  snackbarMessage.value = message
  snackbarColor.value = color
  isSnackbarVisible.value = true
}

const submitCampaign = () => {
  isSubmitting.value = true
  
  // Simulate submission
  setTimeout(() => {
    isSubmitting.value = false
    showToast('Campaign submitted successfully! Redirecting...')
    
    // Redirect or reset after success
    setTimeout(() => {
      window.location.reload() 
    }, 2000)
  }, 1500)
}

const contactFields = [
  { label: 'Full name', key: 'name' },
  { label: 'Phone number', key: 'phone' },
  { label: 'Email', key: 'email' },
  { label: 'Company', key: 'company' },
  { label: 'Position', key: 'job_title' },
]

const csvColumns = ['Full Name', 'Email Address', 'Mobile Number', 'LinkedIn Profile', 'Current Company']

// Watch importMethod to sync workflowStep when user clicks cards
watch(importMethod, (newMethod) => {
  if (newMethod === 'linkedin') workflowStep.value = 1
  else if (newMethod === 'csv') workflowStep.value = 2
  else if (newMethod === 'lookalike') workflowStep.value = 4
})

const validateLinkedin = () => {
  if (!linkedinUrl.value || !linkedinUrl.value.includes('linkedin.com')) {
    showToast('Please enter a valid LinkedIn URL', 'error')
    return
  }

  isValidating.value = true
  
  // Simulate API call
  setTimeout(() => {
    isValidating.value = false
    showToast('LinkedIn URL validated successfully!')
    goNext()
  }, 1000)
}

const onFileUploaded = (file: File) => {
  isCsvUploaded.value = true
  uploadedFileName.value = file.name
  showToast(`File "${file.name}" uploaded successfully!`)
}

const goNext = () => {
  if (workflowStep.value === 1) {
    if (!linkedinUrl.value) {
      showToast('Please enter a LinkedIn URL first', 'error')
      return
    }
    workflowStep.value = 2 // Go to CSV
    importMethod.value = 'csv'
  } else if (workflowStep.value === 2) {
    if (!isCsvUploaded.value) {
      showToast('Please upload a CSV file first', 'error')
      return
    }
    workflowStep.value = 3 // Go to Map
  } else if (workflowStep.value === 3) {
    workflowStep.value = 4 // Go to Lookalikes
    importMethod.value = 'lookalike'
  } else if (workflowStep.value === 4) {
    showLookalikePopup.value = true
  }
}
</script>

<template>
  <div class="advance-campaign-content pb-15">
    <!-- Top Stepper Boxes -->
    <VCard class="mb-10 py-4 px-6 shadow-none border rounded-lg header-stepper">
      <div class="d-flex align-center">
        <!-- Step 1 -->
        <div 
          class="d-flex align-center gap-3 cursor-pointer transition-all" 
          :class="{ 'opacity-60': currentStep !== 1 }"
          @click="currentStep = 1"
        >
          <VSheet 
            :color="currentStep === 1 ? 'primary' : 'rgba(var(--v-theme-on-surface), 0.08)'" 
            rounded="lg" 
            class="d-flex align-center justify-center shadow-sm" 
            width="34" 
            height="34"
          >
            <VIcon 
              icon="tabler-list-details" 
              size="18" 
              :color="currentStep === 1 ? 'white' : 'rgba(var(--v-theme-on-surface), 0.6)'" 
            />
          </VSheet>
          <span 
            class="text-subtitle-1 font-weight-semibold ms-1"
            :class="currentStep === 1 ? 'text-high-emphasis' : 'text-disabled'"
          >
            Define Target Audience
          </span>
        </div>

        <VIcon icon="tabler-chevron-right" size="18" class="text-disabled mx-6" />

        <!-- Step 2 -->
        <div 
          class="d-flex align-center gap-3 cursor-pointer transition-all" 
          :class="{ 'opacity-60': currentStep !== 2 }"
          @click="currentStep = 2"
        >
          <VSheet 
            :color="currentStep === 2 ? 'primary' : 'rgba(var(--v-theme-on-surface), 0.08)'" 
            rounded="lg" 
            class="d-flex align-center justify-center" 
            width="34" 
            height="34"
          >
            <VIcon 
              icon="tabler-user" 
              size="18" 
              :color="currentStep === 2 ? 'white' : 'rgba(var(--v-theme-on-surface), 0.6)'" 
            />
          </VSheet>
          <span 
            class="text-subtitle-1 font-weight-medium ms-1"
            :class="currentStep === 2 ? 'text-high-emphasis' : 'text-disabled'"
          >
            Sender Profiles
          </span>
        </div>
      </div>
    </VCard>

    <!-- Step 1: Define Target Audience UI -->
    <div v-if="currentStep === 1" class="workflow-outer d-flex flex-column flex-md-row">
       <div class="timeline-sidebar me-0 me-md-8 mb-6 mb-md-0 d-none d-md-flex">
        <div class="timeline-line"></div>
        <div class="timeline-node" style="top: 15px;"><VIcon icon="tabler-circle-check-filled" size="18" color="success" /></div>
        <template v-if="workflowStep === 1">
           <div class="timeline-node node-active-ring" style="top: 360px;"><div class="ring-circle"></div></div>
        </template>
        <template v-if="workflowStep >= 2">
           <div class="timeline-node" :style="{ top: workflowStep === 2 ? '120px' : '45px' }"><VIcon icon="tabler-circle-check-filled" size="18" color="success" /></div>
        </template>
        <template v-if="workflowStep === 2">
           <div class="timeline-node node-active-ring" style="top: 270px;"><div class="ring-circle"></div></div>
        </template>
        <template v-if="workflowStep === 3">
           <div class="timeline-node" style="top: 105px;"><VIcon icon="tabler-circle-check-filled" size="18" color="success" /></div>
           <div class="timeline-node node-active-ring" style="top: 175px;"><div class="ring-circle"></div></div>
        </template>
        <template v-if="workflowStep === 4">
          <div class="timeline-node node-active-ring" style="top: 80px;"><div class="ring-circle"></div></div>
        </template>
      </div>

      <div class="flex-grow-1">
        <div v-if="workflowStep === 3" class="mb-4">
          <VCard class="shadow-none border rounded-lg mb-4 min-height-card">
            <div class="pa-4 d-flex align-center justify-space-between">
              <div class="d-flex align-center gap-3">
                <span class="text-subtitle-1 font-weight-bold">Upload CSV file Selected</span>
                <div class="pill-badge">Step 1 of 2</div>
              </div>
              <VIcon icon="tabler-chevron-up" size="20" class="text-disabled" />
            </div>
          </VCard>
          <VCard class="shadow-none border rounded-lg mb-4 min-height-card">
            <div class="pa-4 d-flex align-center justify-space-between">
              <div class="d-flex align-center gap-3">
                <span class="text-subtitle-1 font-weight-bold">Upload CSV File</span>
                <div class="pill-badge">Step 1 of 2</div>
              </div>
              <VIcon icon="tabler-chevron-up" size="20" class="text-disabled" />
            </div>
          </VCard>
        </div>

        <div v-if="workflowStep === 1" class="section-wrapper mb-8 animate-fade-in">
          <VCard class="shadow-none border rounded-lg overflow-hidden mb-6">
            <div class="pa-5 d-flex align-center justify-space-between"><span class="text-subtitle-1 font-weight-bold">Choose Import Method</span><VIcon icon="tabler-chevron-up" size="20" class="text-disabled" /></div>
            <VDivider /><VCardText class="pa-6 pb-8"><ImportMethodSelector v-model="importMethod" /></VCardText>
          </VCard>
          <VCard class="shadow-none border rounded-lg overflow-hidden pa-6">
            
            <!-- <div class="pa-4 mb-4"><span class="text-subtitle-1 font-weight-bold">Paste LinkedIn Search URL</span></div> -->
            <div class="linkedin-search-box pa-4 mb-4">
  <span class="linkedin-search-text">
    Paste LinkedIn Search URL
  </span>
</div>
            <div class="paste-url-box border rounded-lg pa-6">
              <div class="d-flex align-center justify-space-between mb-4">
                <div class="d-flex align-center gap-2"><VIcon icon="tabler-brand-linkedin" size="20" color="primary" />
                  <span class="text-body-2 text-medium-emphasis">Find your target audience with <a href="#" class="text-primary text-decoration-underline font-weight-medium">LinkedIn Search</a> or <a href="#" class="text-primary text-decoration-underline font-weight-medium">Sales Navigator</a></span>
                </div>
                <a href="#" class="text-primary text-body-2 text-decoration-none font-weight-bold d-flex align-center"><VIcon icon="tabler-help-circle" size="16" class="me-1" />Search Guide</a>
              </div>
              <div class="d-flex gap-2">
                <VTextField v-model="linkedinUrl" placeholder="https://www.linkedin.com/search..." variant="outlined" density="compact" hide-details class="flex-grow-1" />
                <VBtn :loading="isValidating" class="btn-gradient px-10" height="40" @click="validateLinkedin">Validate</VBtn>
              </div>
            </div>
          </VCard>
        </div>

        <div v-if="workflowStep === 2" class="section-wrapper mb-8 animate-fade-in">
          <VCard class="shadow-none border rounded-lg overflow-hidden mb-6">
            <div class="pa-5 d-flex align-center justify-space-between"><span class="text-subtitle-1 font-weight-bold">Choose Import Method</span><VIcon icon="tabler-chevron-up" size="20" class="text-disabled" /></div>
            <VDivider /><VCardText class="pa-6"><ImportMethodSelector v-model="importMethod" /></VCardText>
          </VCard>
          <VCard class="shadow-none border rounded-lg overflow-hidden pa-6">
             <div class="pa-4 mb-4 d-flex align-center justify-space-between">
               <span class="text-subtitle-1 font-weight-bold">Upload CSV file</span>
               <div v-if="isCsvUploaded" class="d-flex align-center gap-2">
                 <VIcon icon="tabler-paperclip" size="18" color="success" />
                 <span class="text-caption text-success font-weight-bold">{{ uploadedFileName }}</span>
               </div>
             </div>
             <CsvUploadArea @file-uploaded="onFileUploaded" />
          </VCard>
        </div>

        <div v-if="workflowStep === 3" class="section-wrapper mb-8 animate-fade-in">
          <VCard class="shadow-none border rounded-lg overflow-hidden pa-6">
            <MapPropertiesTable :csv-columns="csvColumns" :contact-fields="contactFields" />
          </VCard>
        </div>

        <div v-if="workflowStep === 4" class="section-wrapper mb-8 animate-fade-in">
           <VCard class="shadow-none border rounded-lg overflow-hidden pa-6">
            <div class="pa-5 d-flex align-center justify-space-between mb-4"><span class="text-subtitle-1 font-weight-bold">Choose Import Method</span><VIcon icon="tabler-chevron-up" size="20" class="text-disabled" /></div>
            <VDivider /><VCardText class="pa-6"><ImportMethodSelector v-model="importMethod" /></VCardText>
          </VCard>
          <VCard class="shadow-none border rounded-lg overflow-hidden pa-12 text-center border-dashed">
             <p class="text-body-1 text-disabled">Please select a lead list as your Lookalike base</p>
          </VCard>
        </div>

        <div class="d-flex justify-end mt-4">
          <VBtn class="next-btn px-12 text-none" size="large" @click="goNext">Next</VBtn>
        </div>
      </div>
    </div>

    <!-- Step 2: Sender Profiles UI -->
    <div v-else class="sender-profiles-view animate-fade-in">
      <div class="custom-tab-group d-inline-flex mb-6">
        <div 
          class="tab-item" 
          :class="{ active: profileTab === 'linkedin' }"
          @click="profileTab = 'linkedin'"
        >
          LinkedIn Profile
        </div>
        <div 
          class="tab-item"
          :class="{ active: profileTab === 'email' }"
          @click="profileTab = 'email'"
        >
          Email Accounts
        </div>
      </div>

      <VCard class="shadow-none border rounded-lg overflow-hidden mb-8">
        <VCardText class="pa-6">
          <div class="d-flex align-center justify-space-between mb-4">
            <div class="d-flex align-center gap-2">
              <VIcon 
                :icon="profileTab === 'linkedin' ? 'tabler-brand-linkedin' : 'tabler-mail'" 
                color="primary" 
                size="22" 
              />
              <div class="d-flex flex-column">
                <span class="text-subtitle-1 font-weight-bold text-high-emphasis">
                  {{ profileTab === 'linkedin' ? 'LinkedIn Profile' : 'Email Accounts' }}
                </span>
                <span class="text-caption text-disabled">
                  Pick which {{ profileTab === 'linkedin' ? 'LinkedIn profiles' : 'email accounts' }} you want to use for this campaign.
                </span>
              </div>
            </div>
            <VBtn color="primary" prepend-icon="tabler-plus" class="text-none px-6 rounded-lg font-weight-bold">
              Add Account
            </VBtn>
          </div>

          <VDivider class="mb-6" />
          
          <div v-if="profileTab === 'linkedin'">
            <SenderProfileTable />
          </div>
          <div v-else class="pa-12 text-center text-disabled">
            <VIcon icon="tabler-mail-off" size="48" class="mb-2 opacity-20" />
            <p>No email accounts connected yet</p>
          </div>
        </VCardText>
      </VCard>

      <!-- Footer Actions -->
      <div class="d-flex justify-end align-center gap-4 mt-8">
        <VBtn 
          variant="text" 
          color="primary" 
          prepend-icon="tabler-arrow-back-up" 
          class="text-none font-weight-bold" 
          @click="currentStep = 1"
        >
          Previous
        </VBtn>
        <VBtn 
          :loading="isSubmitting"
          class="next-btn px-12 text-none" 
          size="large"
          @click="submitCampaign"
        >
          Submit
        </VBtn>
      </div>
    </div>

    <!-- Final Popup -->
    <LookalikeModal 
      v-model="showLookalikePopup" 
      @select="currentStep = 2"
    />

    <!-- Toast Component -->
    <VSnackbar
      v-model="isSnackbarVisible"
      :color="snackbarColor"
      location="top end"
      :timeout="3000"
    >
      <div class="d-flex align-center gap-3">
        <VIcon :icon="snackbarColor === 'success' ? 'tabler-circle-check' : 'tabler-alert-circle'" color="white" />
        <span class="font-weight-medium">{{ snackbarMessage }}</span>
      </div>
      
      <template #actions>
        <VBtn
          icon="tabler-x"
          variant="text"
          color="white"
          size="x-small"
          @click="isSnackbarVisible = false"
        />
      </template>
    </VSnackbar>
  </div>
</template>

<style lang="scss" scoped>
@use "@core-scss/template/pages/campaign";

.advance-campaign-content {
  // max-width: 1392px;
  max-width: 1124px;
  margin: 0 auto;
  min-height: 800px;
}
.linkedin-search-box {
  height: 3.25rem; // 52px
  border-radius: 0.3125rem; // 5px
  opacity: 1;
  background: rgb(var(--v-theme-surface));
  border: 1px solid rgba(var(--v-theme-on-surface), 0.12);
  display: flex;
  align-items: center;
}

.linkedin-search-text {
  font-weight: 500;
  font-size: 0.9375rem; // 15px
  line-height: 140%;
  letter-spacing: 0;
  color: rgba(var(--v-theme-on-surface), var(--v-high-emphasis-opacity));
}

.timeline-sidebar {
  position: relative;
  width: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.timeline-line {
  position: absolute;
  top: 15px;
  bottom: 0;
  width: 2px;
  background: rgba(var(--v-theme-on-surface), 0.12);
}

.timeline-node {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  background: rgb(var(--v-theme-surface));
  z-index: 2;
}

.node-active-ring {
  width: 16px;
  height: 16px;
  border: 2px solid #3E79F7;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgb(var(--v-theme-surface));

  .ring-circle {
    width: 6px;
    height: 6px;
    background: rgb(var(--v-theme-surface));
  }
}

.paste-url-box {
  background-color: rgba(var(--v-theme-on-surface), 0.02);
  border: 1px solid rgba(var(--v-theme-on-surface), 0.12) !important;
}

.btn-gradient, .next-btn {
  background: linear-gradient(135deg, #7C9BFF 0%, #3E79F7 100%) !important;
  color: white !important;
  border-radius: 8px !important;
  font-weight: 600;
  box-shadow: 0 4px 12px rgba(62, 121, 247, 0.2) !important;
}

.text-decoration-underline {
  text-decoration: underline !important;
}

.header-stepper {
  border-color: #EDEDF2 !important;
}

.custom-tab-group {
  border: 1px solid rgb(var(--v-theme-primary));
  border-radius: 8px;
  overflow: hidden;
  background-color: rgb(var(--v-theme-surface));

  .tab-item {
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 600;
    color: rgb(var(--v-theme-primary));
    cursor: pointer;
    transition: all 0.2s ease;

    &.active {
      background-color: rgba(var(--v-theme-primary), 0.08);
    }

    &:first-child {
      border-right: 1px solid rgb(var(--v-theme-primary));
    }
  }
}

.pill-badge {
  background-color: rgba(var(--v-theme-on-surface), 0.12);
  color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity));
  font-size: 11px;
  font-weight: 600;
  padding: 2px 10px;
  border-radius: 4px;
}

.min-height-card {
  min-height: 56px;
  display: flex;
  align-items: center;
}
</style>
