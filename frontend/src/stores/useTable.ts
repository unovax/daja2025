import { get, set } from '@/utils/common'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useTable = defineStore('table', () => {
  const activeTr = ref<string | null>(null);

  const setActiveTr = (id: string) => {
    activeTr.value = id;
  }

  return { activeTr, setActiveTr }
})
