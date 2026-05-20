<script setup lang="ts">
const emit = defineEmits<{
  (e: 'file-uploaded', file: File): void
}>()

const isDragging = ref(false)
const fileInput = ref<HTMLInputElement | null>(null)

const onDrop = (e: DragEvent) => {
  isDragging.value = false
  const files = e.dataTransfer?.files
  if (files?.length) {
    emit('file-uploaded', files[0])
  }
}

const onFileSelect = (e: Event) => {
  const target = e.target as HTMLInputElement
  if (target.files?.length) {
    emit('file-uploaded', target.files[0])
  }
}

const triggerSelect = () => {
  fileInput.value?.click()
}
</script>

<template>
  <div
    class="csv-drop-area"
    :class="{ 'opacity-75': isDragging }"
    @dragover.prevent="isDragging = true"
    @dragleave.prevent="isDragging = false"
    @drop.prevent="onDrop"
    @click="triggerSelect"
  >
    <input
      ref="fileInput"
      type="file"
      accept=".csv"
      class="d-none"
      @change="onFileSelect"
    >
    
    <VIcon 
      icon="tabler-cloud-upload" 
      class="upload-icon" 
    />
    
    <div class="upload-text mb-1">
      <span class="text-primary font-weight-bold">Drag a File</span> or click a browse
    </div>
    <div class="upload-hint">Up to 100 rows works best</div>
  </div>
  
  <div class="mt-4">
    <a href="#" class="text-primary text-decoration-none text-caption">
      Download Sample
    </a>
  </div>
</template>

<style lang="scss" scoped>
.csv-drop-area {
  border: 1.5px dashed rgba(var(--v-theme-on-surface), 0.12);
  background-color: rgba(var(--v-theme-on-surface), 0.04);
  border-radius: 12px;
  padding: 40px 20px;
  text-align: center;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;

  &:hover {
    border-color: rgb(var(--v-theme-primary));
    background-color: rgba(var(--v-theme-primary), 0.04);
  }

  .upload-icon {
    font-size: 32px;
    color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity));
    margin-bottom: 12px;
  }

  .upload-text {
    font-size: 15px;
    color: rgba(var(--v-theme-on-surface), var(--v-high-emphasis-opacity));
  }

  .upload-hint {
    font-size: 12px;
    color: rgba(var(--v-theme-on-surface), var(--v-medium-emphasis-opacity));
  }
}
</style>
