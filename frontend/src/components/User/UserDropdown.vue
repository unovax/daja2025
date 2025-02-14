<script lang="ts" setup>
import Dropdown from '../Dropdown.vue'
import defaultProfilePicture from '@/assets/images/profile-pictures/default.png'
import ToogleMode from '../ToogleMode.vue'
import { storeToRefs } from 'pinia'
import { useUser } from '@/stores/useUser'
import type { User } from '@/types/Auth'
import LogoutButton from '../Auth/LogoutButton.vue'
import { computed } from 'vue'
import SidebarLink from '../Navigation/SidebarLink.vue'

const { user } = storeToRefs(useUser())

const getFullName = computed(() => {
  return `${user.value.name} ${user.value.lastname}`;
})
</script>
<template>
  <Dropdown>
    <template #trigger>
      <img
        :src="user.profilePicture ?? defaultProfilePicture"
        class="w-[40px] rounded-full aspect-square pointer"
      />
    </template>
    <template #content>
      <div class="px-6 py-2">
        <h2 class="text-sm text-center">{{ getFullName }}</h2>
        <h2 class="text-xs text-center text-gray-500">{{ user.email }}</h2>
      </div>
      <span class="flex items-center gap-2 px-6 py-2 text-sm transition-all cursor-pointer border-y border-sidebar-hover dark:border-sidebar-dark-hover hover:bg-sidebar-hover dark:hover:bg-sidebar-dark-hover">
        <font-awesome-icon icon="fa-user" />
        <span>Mi perfil</span>
      </span>
      <ToogleMode/>
      <LogoutButton/>
    </template>
  </Dropdown>
</template>
