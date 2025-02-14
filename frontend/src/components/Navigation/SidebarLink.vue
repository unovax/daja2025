<script lang="ts" setup>
import { useSidebar } from '@/stores/useSidebar';
import { storeToRefs } from 'pinia';

  defineProps<{
    title: string,
    to: string,
    icon: string,
  }>();
  const { sidebarOpen } = storeToRefs(useSidebar());

  const checkIfIsMobile = () => {
    if(window.matchMedia("(max-width: 768px)").matches){
      useSidebar().close();
    }
  }
</script>
<template>
  <router-link
    @click="checkIfIsMobile"
    :class="[
      sidebarOpen ? '' : 'justify-center'
    ]"
    class="flex items-center h-[40px] w-full gap-2 px-4 py-2 text-dark dark:text-light hover:bg-sidebar-hover dark:hover:bg-sidebar-dark-hover"
    :to="to"
  >
    <font-awesome-icon v-if="icon" :icon="icon" />
    <span v-if="sidebarOpen">{{ title }}</span>
  </router-link>
</template>
