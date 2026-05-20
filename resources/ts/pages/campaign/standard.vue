<script setup lang="ts">
definePage({
  meta: {
    layout: "default",
    navActiveLink: "campaign",
  },
});

const currentStep = ref(1);
const campaignName = ref("");
const campaignType = ref("LinkedIn Invitation");
const outreachChannel = ref("LinkedIn Only");
const scheduleTime = ref("Mon - Fri 9:00 AM - 5:00 PM");
const linkedinUrl = ref("");
const uploadedFileNameStandard = ref("");
const message1 = ref("Hi {first_name}, ...");
const message2 = ref("Hi {first_name}, ...");

// Refs
const csvFileInput = ref<HTMLInputElement | null>(null);

// Toast State
const isSnackbarVisible = ref(false);
const snackbarMessage = ref("");
const snackbarColor = ref("success");
const isLaunching = ref(false);

const showToast = (message: string, color: string = "success") => {
  snackbarMessage.value = message;
  snackbarColor.value = color;
  isSnackbarVisible.value = true;
};

const triggerCsvSelect = () => {
  csvFileInput.value?.click();
};

const onCsvUploaded = (e: Event) => {
  const target = e.target as HTMLInputElement;
  if (target.files?.length) {
    uploadedFileNameStandard.value = target.files[0].name;
    showToast(`File "${target.files[0].name}" uploaded!`);
  }
};

const validateStep1 = () => {
  if (!campaignName.value.trim()) {
    showToast("Please enter a campaign name", "error");
    return;
  }
  showToast("Campaign details saved!");
  currentStep.value = 2;
};

const validateStep2 = () => {
  const hasUrl = linkedinUrl.value.trim() && linkedinUrl.value.includes("linkedin.com");
  const hasFile = uploadedFileNameStandard.value !== "";

  if (!hasUrl && !hasFile) {
    showToast("Please provide a LinkedIn URL or upload a CSV file", "error");
    return;
  }
  showToast("Target audience defined!");
  currentStep.value = 3;
};

const launchCampaign = () => {
  isLaunching.value = true;
  // Simulate launch process
  setTimeout(() => {
    isLaunching.value = false;
    showToast("Campaign launched successfully!");
    
    // Refresh after success
    setTimeout(() => {
      window.location.reload();
    }, 2000);
  }, 2000);
};

const scheduleOptions = [
  "Mon - Fri 9:00 AM - 5:00 PM",
  "Mon - Sat 10:00 AM - 6:00 PM",
  "Daily 24 Hours",
  "Weekend Only (Sat-Sun)",
  "Night Shift (10 PM - 6 AM)"
];

const updateSchedule = (val: string) => {
  scheduleTime.value = val;
  showToast(`Schedule updated to ${val}`);
};

const campaignTypes = [
  "LinkedIn Invitation",
  "LinkedIn Message",
  "Email Outreach",
];
const channels = ["Email Only", "LinkedIn Only", "LinkedIn + Email"];
</script>

<template>
  <div class="standard-campaign-content pb-15">
    <!-- Top Stepper Boxes -->
    <VCard
      class="mb-10 py-4 px-6 shadow-none border rounded-lg bg-white header-stepper"
    >
      <div
        class="d-flex align-center !justify-content-between w-100"
        style="justify-content: space-between"
      >
        <!-- Step 1 -->
        <div
          class="d-flex align-center gap-3 cursor-pointer"
          @click="currentStep = 1"
        >
          <VSheet
            :color="currentStep === 1 ? 'primary' : '#DDE7FF'"
            rounded="lg"
            class="d-flex align-center justify-center shadow-sm"
            width="34"
            height="34"
          >
            <VIcon
              icon="tabler-list-details"
              size="18"
              :color="currentStep === 1 ? 'white' : 'primary'"
            />
          </VSheet>
          <span
            class="text-subtitle-1 font-weight-semibold ms-1"
            :class="currentStep === 1 ? 'text-high-emphasis' : 'text-disabled'"
            >Leads List</span
          >
        </div>

        <VIcon
          icon="tabler-chevron-right"
          size="18"
          class="text-disabled"
        />

        <!-- Step 2 -->
        <div
          class="d-flex align-center gap-3 cursor-pointer"
          @click="currentStep = 2"
        >
          <VSheet
            :color="currentStep === 2 ? 'primary' : '#DDE7FF'"
            rounded="lg"
            class="d-flex align-center justify-center shadow-sm"
            width="34"
            height="34"
          >
            <VIcon
              icon="tabler-send"
              size="18"
              :color="currentStep === 2 ? 'white' : 'primary'"
            />
          </VSheet>
          <span
            class="text-subtitle-1 font-weight-semibold ms-1"
            :class="currentStep === 2 ? 'text-high-emphasis' : 'text-disabled'"
            >Target Audience</span
          >
        </div>

        <VIcon
          icon="tabler-chevron-right"
          size="18"
          class="text-disabled"
        />

        <!-- Step 3 -->
        <div
          class="d-flex align-center gap-3 cursor-pointer"
          @click="currentStep = 3"
        >
          <VSheet
            :color="currentStep === 3 ? 'primary' : '#DDE7FF'"
            rounded="lg"
            class="d-flex align-center justify-center shadow-sm"
            width="34"
            height="34"
          >
            <VIcon
              icon="tabler-speakerphone"
              size="18"
              :color="currentStep === 3 ? 'white' : 'primary'"
            />
          </VSheet>
          <span
            class="text-subtitle-1 font-weight-semibold ms-1"
            :class="currentStep === 3 ? 'text-high-emphasis' : 'text-disabled'"
            >Campaign</span
          >
        </div>
      </div>
    </VCard>

    <!-- STEP 1: Leads List -->
    <VCard
      v-if="currentStep === 1"
      class="pa-10 shadow-none border rounded-lg bg-white animate-fade-in"
    >
      <VRow>
        <VCol cols="12" md="6" class="mb-2">
          <div class="text-subtitle-2 font-weight-bold mb-2">Campaign Name</div>
          <VTextField
            v-model="campaignName"
            placeholder="e.g. Founder Outreach - India"
            variant="outlined"
            density="compact"
            hide-details
            class="custom-input"
          />
          <div class="text-caption text-disabled mt-2">
            Give your workflow a clear name so you can find it later.
          </div>
        </VCol>
        <VCol cols="12" md="6" class="mb-2">
          <div class="text-subtitle-2 font-weight-bold mb-2">Campaign Type</div>
          <VSelect
            v-model="campaignType"
            :items="campaignTypes"
            variant="outlined"
            density="compact"
            hide-details
            class="custom-input"
          />
          <div class="text-caption text-disabled mt-2">
            Choose how this workflow will start.
          </div>
        </VCol>
        <VCol cols="12" md="6" class="mt-4">
          <div class="text-subtitle-2 font-weight-bold mb-2">
            Outreach Channel
          </div>
          <div
            class="custom-segmented-group d-flex border rounded-lg overflow-hidden"
          >
            <div
              v-for="ch in channels"
              :key="ch"
              class="segment-item flex-grow-1 text-center py-2 cursor-pointer transition-all"
              :class="{ active: outreachChannel === ch }"
              @click="outreachChannel = ch"
            >
              <span class="text-body-2 font-weight-semibold">{{ ch }}</span>
            </div>
          </div>
          <div class="text-caption text-disabled mt-2">
            Select how you want to reach your leads in this workflow.
          </div>
        </VCol>
        <VCol cols="12" md="6" class="mt-4">
          <div class="text-subtitle-2 font-weight-bold mb-2">
            Sending Schedule
          </div>
          <div class="d-flex gap-3">
            <VMenu offset="10">
              <template #activator="{ props }">
                <div
                  v-bind="props"
                  class="schedule-box flex-grow-1 d-flex align-center justify-space-between px-4 border rounded-lg bg-white cursor-pointer hover-bg-light transition-all"
                >
                  <span class="text-body-2 text-medium-emphasis">{{ scheduleTime }}</span>
                  <VIcon icon="tabler-chevron-down" size="18" class="text-disabled" />
                </div>
              </template>
              <VList class="rounded-lg shadow-lg border">
                <VListItem 
                  v-for="opt in scheduleOptions" 
                  :key="opt" 
                  @click="updateSchedule(opt)"
                  :active="scheduleTime === opt"
                  color="primary"
                >
                  <VListItemTitle class="text-body-2">{{ opt }}</VListItemTitle>
                </VListItem>
              </VList>
            </VMenu>
            <VBtn
              variant="outlined"
              color="secondary"
              class="text-none font-weight-bold px-6 rounded-lg"
              @click="showToast('Custom scheduler coming soon!')"
              >+ Add new time</VBtn
            >
          </div>
          <div class="text-caption text-disabled mt-2">
            Messages are sent only within your selected hours.
          </div>
        </VCol>
      </VRow>
      <div class="d-flex justify-end mt-12 footer-actions-gap">
        <VBtn
          variant="flat"
          class="save-draft-btn text-none hover:bg-transparent"
          @click="showToast('Draft saved successfully!')"
          >Save as Draft</VBtn
        >
        <VBtn
          class="continue-btn text-none"
          @click="validateStep1"
          >Continue</VBtn
        >
      </div>
    </VCard>

    <!-- STEP 2: Target Audience -->
    <VCard
      v-if="currentStep === 2"
      class="pa-6 pa-md-10 shadow-none border rounded-lg bg-white animate-fade-in"
    >
      <VRow class="mb-4">
        <!-- Basic LinkedIn Search -->
        <VCol cols="12" lg="4">
          <div class="h-100 border rounded-lg pa-6">
            <div class="text-subtitle-2 font-weight-bold mb-4">
              Basic LinkedIn Search
            </div>
            <VTextField
              v-model="linkedinUrl"
              placeholder="https://www.linkedin.com/search/results/people/..."
              variant="outlined"
              density="compact"
              hide-details
              class="custom-input mb-2"
            />
            <div class="text-caption">
              Filter profiles in the
              <a href="#" class="text-primary text-decoration-underline"
                >LinkedIn search</a
              >
              and paste the URL above
            </div>
          </div>
        </VCol>
        <!-- Upload CSV File -->
        <VCol cols="12" md="6" lg="4">
          <div
            class="h-100 border rounded-lg pa-6 text-center d-flex flex-column align-center justify-center"
          >
            <div class="text-subtitle-2 font-weight-bold mb-4 w-100 text-start">
              Upload CSV File
            </div>
            
            <input
              ref="csvFileInput"
              type="file"
              accept=".csv"
              class="d-none"
              @change="onCsvUploaded"
            />

            <div
              class="border-dashed pa-6 rounded-lg cursor-pointer w-100 transition-all"
              :class="uploadedFileNameStandard ? 'bg-light-success text-success border-success' : 'bg-light-primary text-primary'"
              @click="triggerCsvSelect"
            >
              <VIcon :icon="uploadedFileNameStandard ? 'tabler-file-check' : 'tabler-upload'" size="24" class="mb-1" />
              <div class="text-caption font-weight-bold">
                {{ uploadedFileNameStandard || 'Drop file here' }}
              </div>
              <div v-if="uploadedFileNameStandard" class="text-[10px] opacity-70 mt-1">Click to change file</div>
            </div>
          </div>
        </VCol>
        <!-- Advanced Options -->
        <VCol cols="12" md="6" lg="4">
          <div class="h-100 border rounded-lg pa-6">
            <div class="text-subtitle-2 font-weight-bold mb-4">
              Advanced options
            </div>
            <VCheckbox
              label="Use Webhook"
              hide-details
              density="compact"
              class="mt-n2"
            />
            <div class="text-caption text-disabled mt-4">
              Use a webhook to send leads automatically
            </div>
          </div>
        </VCol>
      </VRow>
      <div class="d-flex align-center justify-space-between mt-12">
        <VBtn
          variant="text"
          color="primary"
          @click="currentStep = 1"
          class="text-none font-weight-bold"
          >Back</VBtn
        >
        <div class="d-flex footer-actions-gap">
          <VBtn
            variant="flat"
            class="save-draft-btn text-none"
            @click="showToast('Draft saved successfully!')"
            >Save as Draft</VBtn
          >
          <VBtn
            class="continue-btn text-none"
            @click="validateStep2"
            >Continue</VBtn
          >
        </div>
      </div>
    </VCard>

    <!-- STEP 3: Campaign Sequence -->
    <div v-if="currentStep === 3" class="sequence-view animate-fade-in">
      <div class="sequence-timeline px-8">
        <div class="seq-node mb-6">
          <VCard class="shadow-none border rounded-lg bg-white overflow-hidden">
            <div class="pa-4 d-flex align-center gap-3">
              <VIcon icon="tabler-send" size="18" color="primary" />
              <span class="text-subtitle-2 font-weight-bold"
                >Campaign Start</span
              >
            </div>
            <div class="bg-light-primary pa-2 px-4">
              <span class="text-caption text-disabled"
                >When a lead enters your target audience</span
              >
            </div>
          </VCard>
        </div>

        <div class="seq-node mb-6">
          <VCard class="shadow-none border rounded-lg bg-white overflow-hidden">
            <div class="pa-4 d-flex align-center justify-space-between">
              <div class="d-flex align-center gap-3">
                <VIcon icon="tabler-brand-linkedin" size="18" color="primary" />
                <span class="text-subtitle-2 font-weight-bold"
                  >Send LinkedIn Connection Request</span
                >
              </div>
              <div class="d-flex gap-2">
                <VIcon
                  icon="tabler-external-link"
                  size="18"
                  class="text-disabled"
                /><VIcon icon="tabler-trash" size="18" class="text-error" />
              </div>
            </div>
            <VDivider />
            <div class="pa-6">
              <VTextarea
                v-model="message1"
                variant="outlined"
                hide-details
                rows="3"
                class="custom-input mb-4"
              />
              <div class="d-flex gap-3">
                <VBtn
                  variant="flat"
                  color="primary"
                  class="text-none font-weight-bold px-6"
                  >Edit Message</VBtn
                >
                <VBtn
                  variant="outlined"
                  color="primary"
                  prepend-icon="tabler-wand"
                  class="text-none font-weight-bold px-6"
                  >Make with AI</VBtn
                >
              </div>
            </div>
          </VCard>
        </div>

        <div class="seq-node mb-6">
          <VCard class="shadow-none border rounded-lg bg-white overflow-hidden">
            <div
              class="pa-4 d-flex align-center justify-space-between border-bottom"
            >
              <div class="d-flex align-center gap-3">
                <VIcon
                  icon="tabler-arrow-forward-up"
                  size="18"
                  color="primary"
                />
                <span class="text-subtitle-2 font-weight-bold"
                  >Set Follow-up message</span
                >
              </div>
              <div class="d-flex gap-2">
                <VIcon
                  icon="tabler-external-link"
                  size="18"
                  class="text-disabled"
                /><VIcon icon="tabler-trash" size="18" class="text-error" />
              </div>
            </div>
            <div class="pa-6">
              <VTextarea
                v-model="message2"
                variant="outlined"
                hide-details
                rows="3"
                class="custom-input mb-4"
              />
              <div class="d-flex gap-3 mb-6">
                <VBtn
                  variant="flat"
                  color="primary"
                  class="text-none font-weight-bold px-6"
                  >Edit Message</VBtn
                >
                <VBtn
                  variant="outlined"
                  color="primary"
                  prepend-icon="tabler-wand"
                  class="text-none font-weight-bold px-6"
                  >Make with AI</VBtn
                >
              </div>
              <div
                class="pa-4 bg-light-primary rounded-lg d-flex align-center justify-center gap-4 border-dashed border-primary"
              >
                <span class="text-caption">Once accepted wait</span>
                <div class="d-flex align-center gap-1 border-bottom px-2">
                  <span>3</span><span class="text-disabled">Minutes</span>
                </div>
                <div class="d-flex align-center gap-1 border-bottom px-2">
                  <span>3</span><span class="text-disabled">Hour</span>
                </div>
                <div class="d-flex align-center gap-1 border-bottom px-2">
                  <span>3</span><span class="text-disabled">days</span>
                </div>
              </div>
            </div>
          </VCard>
        </div>

        <div
          class="seq-node-dashed mb-6 py-4 text-center border-dashed border-disabled rounded-lg cursor-pointer"
        >
          <VIcon
            icon="tabler-circle-plus"
            size="20"
            class="me-2 text-disabled"
          />
          <span class="text-subtitle-2 font-weight-bold text-disabled"
            >Add new follow-up</span
          >
        </div>

        <div class="seq-node mb-10">
          <VCard
            class="shadow-none border rounded-lg bg-light-primary overflow-hidden"
          >
            <div class="pa-4 d-flex align-center gap-3">
              <VIcon icon="tabler-checkbox" size="18" class="text-primary" />
              <span class="text-subtitle-2 font-weight-bold text-primary"
                >End of Campaign</span
              >
            </div>
          </VCard>
        </div>
      </div>

      <div class="d-flex align-center justify-space-between mt-12">
        <VBtn
          variant="text"
          color="primary"
          @click="currentStep = 2"
          class="text-none font-weight-bold"
          >Back</VBtn
        >
        <div class="d-flex footer-actions-gap">
          <VBtn
            variant="flat"
            class="save-draft-btn text-none"
            @click="showToast('Draft saved successfully!')"
            >Save as Draft</VBtn
          >
          <VBtn
            :loading="isLaunching"
            class="continue-btn-launch text-none"
            @click="launchCampaign"
            >Launch Campaign</VBtn
          >
        </div>
      </div>
    </div>

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
.standard-campaign-content {
  max-width: 1250px;
  margin: 0 auto;
}
.custom-input {
  :deep(.v-field__outline) {
    border-color: #ededf2 !important;
  }
}
.custom-segmented-group {
  border-color: rgba(var(--v-theme-on-surface), 0.12) !important;
  .segment-item {
    color: rgba(var(--v-theme-on-surface), var(--v-disabled-opacity));
    border-right: 1px solid rgba(var(--v-theme-on-surface), 0.12);
    &.active {
      background-color: rgba(var(--v-theme-primary), 0.08);
      color: rgb(var(--v-theme-primary));
    }
  }
}
.schedule-box {
  border-color: rgba(var(--v-theme-on-surface), 0.12) !important;
  background-color: rgb(var(--v-theme-surface)) !important;
  height: 40px;
  &.hover-bg-light:hover {
    background-color: rgba(var(--v-theme-on-surface), 0.04) !important;
    border-color: rgba(var(--v-theme-on-surface), 0.2) !important;
  }
}

.transition-all {
  transition: all 0.2s ease;
}
.continue-btn, .action-btn-standard.continue-btn {
  width: 115px !important;
  height: 37px !important;
  background: linear-gradient(135deg, #8ba6ff 0%, #3666ee 100%) !important;
  color: white !important;
  border-radius: 5px !important;
  font-weight: 600 !important;
  font-size: 14px !important;
  letter-spacing: 0.3px !important;
}

.continue-btn-launch {
  width: 183px !important;
  height: 37px !important;
  background: linear-gradient(135deg, #8ba6ff 0%, #3666ee 100%) !important;
  color: white !important;
  border-radius: 5px !important;
  font-weight: 600 !important;
  font-size: 14px !important;
  letter-spacing: 0.3px !important;
}

.save-draft-btn {
  width: 141px !important;
  height: 37px !important;
  border: 1px solid rgba(var(--v-theme-on-surface), 0.12) !important;
  background-color: rgba(var(--v-theme-on-surface), 0.04) !important;
  color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity)) !important;
  border-radius: 5px !important;
  font-weight: 600 !important;
  font-size: 14px !important;
  
  &:hover, &:focus, &:active {
    background-color: rgba(var(--v-theme-on-surface), 0.08) !important;
    opacity: 1 !important;
    .v-btn__overlay {
      display: none !important;
    }
  }

  :deep(.v-btn__overlay) {
    display: none !important;
  }
}

.footer-actions-gap {
  gap: 9px !important;
}

// Media Queries for Responsiveness
@media (max-width: 600px) {
  .header-stepper {
    padding: 12px !important;
    .text-subtitle-1 {
      display: none !important; // Hide text in stepper on very small screens
    }
  }

  .continue-btn, .save-draft-btn, .continue-btn-launch {
    width: 100% !important;
    margin-right: 0 !important;
  }

  .footer-actions-gap {
    flex-direction: column-reverse !important; // Stack buttons, with primary on top
    width: 100% !important;
    gap: 12px !important;
  }

  .d-flex.align-center.justify-space-between.mt-12 {
    flex-direction: column !important;
    gap: 20px !important;
    align-items: stretch !important;
    
    .v-btn.variant-text {
      align-self: flex-start !important;
    }
  }

  .custom-segmented-group {
    flex-wrap: wrap !important;
    .segment-item {
      flex: 1 1 100% !important;
      border-right: none !important;
      border-bottom: 1px solid #ededf2 !important;
      &:last-child {
        border-bottom: none !important;
      }
    }
  }

  .schedule-box {
    width: 100% !important;
  }

  .pa-10 {
    padding: 20px !important;
  }

  // Step 3 Sequence Fixes
  .sequence-timeline {
    padding-left: 20px !important; // Reduce padding on mobile
    padding-right: 20px !important;
    &::before {
      left: 2px !important; // Move the line further left
    }
  }

  .seq-node {
    &::before {
      left: -21px !important; // Adjust the dot to match the line
    }

    .pa-6 {
      padding: 16px !important; // Reduce node internal padding
    }

    .d-flex.gap-3 {
      flex-direction: column !important; // Stack "Edit Message" and "Make with AI"
      gap: 12px !important;
      .v-btn {
        width: 100% !important;
      }
    }
  }

  .pa-4.bg-light-primary.rounded-lg.d-flex.align-center.justify-center.gap-4 {
    flex-wrap: wrap !important;
    justify-content: flex-start !important;
    padding: 16px !important;
    gap: 16px !important;
    
    .text-caption {
      width: 100% !important;
      margin-bottom: -10px !important;
    }
  }
}

.bg-light-primary {
  background-color: rgba(var(--v-theme-primary), 0.08) !important;
}
.bg-light-success {
  background-color: rgba(var(--v-theme-success), 0.08) !important;
}
.border-success {
  border-color: rgb(var(--v-theme-success)) !important;
}
.border-dashed {
  border-style: dashed !important;
  border-width: 1px !important;
  border-color: rgba(var(--v-theme-on-surface), 0.12) !important;
}
.sequence-timeline {
  position: relative;
  &::before {
    content: "";
    position: absolute;
    left: 10px;
    top: 20px;
    bottom: 20px;
    width: 2px;
    background: rgba(var(--v-theme-on-surface), 0.12);
  }
}
.seq-node {
  position: relative;
  &::before {
    content: "";
    position: absolute;
    left: -26px;
    top: 22px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgb(var(--v-theme-surface));
    border: 2px solid #3666ee;
    z-index: 2;
  }
}
.animate-fade-in {
  animation: fadeIn 0.4s ease-out;
}
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
