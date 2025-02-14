<script lang="ts" setup>
import type { Loading } from '@/types/Commons';
import LoadingComponent from '../LoadingComponent.vue';

defineProps<{
  entries: Array<any>
  withoutEntriesMessage?: string,
  loading: Loading
}>()
</script>
<template>
  <LoadingComponent :text="loading.text" v-if="loading.state" />
  <div v-else class="flex-1">
    <div v-if="entries.length" class="w-full overflow-x-auto rounded-md shadow bg-sidebar dark:bg-sidebar-dark">
      <slot />
    </div>
    <div v-else class="flex justify-center flex-1 p-2 text-sm">
      <span>{{ withoutEntriesMessage ?? 'Sin registros...' }}</span>
    </div>
  </div>
  <slot v-if="!loading.state" name="pagination"></slot>
</template>
