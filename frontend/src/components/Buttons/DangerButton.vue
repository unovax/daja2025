<script lang="ts" setup>
import type { Loading } from '@/types/Commons'
import { faSpinner } from '@fortawesome/free-solid-svg-icons';

defineProps<{
  text: string
  icon?: string
  loading?: Loading
}>()
</script>
<template>
  <button
    :disabled="loading && loading.state"
    class="px-4 py-2 text-sm text-white truncate rounded bg-danger hover:bg-danger-hover"
  >
    <span v-if="!loading || !loading.state" class="flex items-center gap-2">
      <font-awesome-icon v-if="icon" :icon="icon" />
      <span>{{ text }}</span>
    </span>
    <span v-else class="flex items-center gap-2">
      <font-awesome-icon :icon="faSpinner" class="animate-spin"/>
      <span>{{ loading.text }}</span>
    </span>
  </button>
</template>
