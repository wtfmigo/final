<template>
  <div 
    :class="[
      'fixed inset-0 overflow-y-auto z-99999',
      placement === 'right' ? 'flex items-stretch justify-end' : 'flex items-center justify-center'
    ]"
    :style="placement === 'right' ? { transition: 'transform 0.3s ease-in-out' } : {}"
  >
    <div
      v-if="fullScreenBackdrop"
      class="fixed inset-0 h-full w-full bg-gray-900/50"
      aria-hidden="true"
      @click="$emit('close')"
    ></div>
    <div 
      v-if="placement === 'right'" 
      class="relative w-full max-w-md bg-white dark:bg-gray-800 shadow-xl h-full transform transition-transform"
      :class="{ 'translate-x-full': !visible, 'translate-x-0': visible }"
    >
      <slot name="body"></slot>
    </div>
    <div v-else class="relative max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-xl">
      <slot name="body"></slot>
    </div>
  </div>
</template>

<script setup lang="ts">
interface ModalProps {
  fullScreenBackdrop?: boolean
  placement?: 'center' | 'right'
  visible?: boolean
}

const props = defineProps<ModalProps>()
defineEmits(['close'])
</script>
