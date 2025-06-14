import { get, set } from '@/utils/common'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useSidebar = defineStore('sidebar', () => {
  const sidebarOpen = ref<boolean>( get('sidebarOpen') );
  const tabName = ref<string | null>(null);
  
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

  const setTabName = (name: string | null) => {
    tabName.value = name;
  }
  return { sidebarOpen, tabName, open, close, toogleSidebar, setTabName }
})
