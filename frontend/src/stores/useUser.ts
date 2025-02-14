import { defaultUser, type User } from '@/types/Auth'
import { clone, get, remove, set } from '@/utils/common'
import { useStorage } from '@vueuse/core'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useUser = defineStore('user', () => {
  const user = ref<User>( get('user') || clone(defaultUser) );

  const setUser = (userInfo : User) => {
      set('user', userInfo);
      user.value = clone(userInfo);
  }

  const removeUser = () => {
    remove('user');
    user.value = clone(defaultUser);
  }

  return { user, setUser, removeUser }
})
