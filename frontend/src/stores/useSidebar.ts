import { get, set } from '@/utils/common'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useSidebar = defineStore('sidebar', () => {
  const sidebarOpen = ref<boolean>( get('sidebarOpen') );

  const open = () => {
      set('sidebarOpen', true);
      sidebarOpen.value = true;
  }

  const close = () => {
    set('sidebarOpen', false);
    sidebarOpen.value = false;
  }

  const toogleSidebar = () => {
    sidebarOpen.value ? close() : open()
  }
  return { sidebarOpen, open, close, toogleSidebar }
})
