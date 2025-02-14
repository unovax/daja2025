<script lang="ts" setup>
import type { ParamsData } from '@/types/Commons';
import { ref, watch } from 'vue';

const debounce : number = 500;

const props = defineProps<{
  search: (params: ParamsData) => void,
  paramsData: ParamsData
}>();

const text = ref<string>('')
let timeout : ReturnType<typeof setTimeout> | null = null;

watch(text, () => {
  if (timeout) clearTimeout(timeout);
  
  timeout = setTimeout(() => {
    props.search({
      ...props.paramsData,
      search: text.value
    });
  }, debounce);
});
</script>
<template>
  <input v-model="text" placeholder="Busqueda" type="text"
    class="px-2 py-1 rounded-md bg-input dark:bg-input-dark max-w-[500px] flex-1" />
</template>
