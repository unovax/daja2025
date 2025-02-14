<script lang="ts" setup>
import { computed, ref } from 'vue'
import { useSidebar } from '@/stores/useSidebar';
import { storeToRefs } from 'pinia';
const { title } = defineProps<{
  title: string
  count: number
}>()

const open = ref<Boolean>(localStorage.getItem(`${title}-dropdown`) === 'true');

const toggleDropdown = () => {
  open.value = !open.value;
  localStorage.setItem(`${title}-dropdown`, JSON.stringify(open.value));
}
const { sidebarOpen } = storeToRefs(useSidebar());
</script>
<template>
  <li :class="[sidebarOpen ? 'justify-between' : 'justify-center']" @click="toggleDropdown"
    class="flex items-center w-full h-[40px] gap-2 px-4 py-2 cursor-pointer select-none text-dark dark:text-light sidebar-dropdown hover:bg-sidebar-hover dark:hover:bg-sidebar-dark-hover">
    <span v-if="sidebarOpen">{{ title }}</span>
    <font-awesome-icon v-if="!open" :icon="['fas', 'circle-chevron-down']" />
    <font-awesome-icon v-else :icon="['fas', 'circle-chevron-up']" />
  </li>
  <ul :style="{ height: open ? `${count * 40}px` : '0px' }" class="overflow-hidden transition-all">
    <slot />
  </ul>
</template>
