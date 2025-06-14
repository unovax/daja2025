<script lang="ts" setup>
import type { Loading } from '@/types/Commons'

defineProps<{
  text?: string
  icon?: string
  loading?: Loading
}>()
</script>
<template>
  <button
    :disabled="loading && loading.state"
    class="px-4 py-2 text-sm text-white truncate rounded bg-primary hover:bg-primary-hover"
  >
    <span v-if="!loading || !loading.state" class="flex items-center gap-2">
      <font-awesome-icon v-if="icon" :icon="icon" />
      <span>{{ text }}</span>
    </span>
    <span v-else class="flex items-center gap-2">
      <font-awesome-icon icon="spinner" class="animate-spin"/>
      <span>{{ loading.text }}</span>
    </span>
    <slot></slot>
  </button>
</template>

