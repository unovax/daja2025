<script lang="ts" setup>
import router from '@/router'
import UserDropdown from '../User/UserDropdown.vue'
import SidebarButton from './SidebarButton.vue';
const route = router.currentRoute
</script>
<template>
  <nav
    class="sticky top-0 flex items-center justify-between w-full gap-2 px-4 py-2 rounded-md shadow-md text-dark-50 dark:text-light-50 bg-sidebar dark:bg-sidebar-dark"
  >
    <h1 class="flex items-center gap-2 text-lg font-medium">
      <SidebarButton class="block md:hidden" />
      <font-awesome-icon v-if="route.meta.icon" :icon="route.meta.icon" />
      <span>{{ route.meta.title }}</span>
    </h1>
    <UserDropdown />
  </nav>
</template>
