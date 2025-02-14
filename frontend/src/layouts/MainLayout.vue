<script lang="ts" setup>
import Sidebar from '@/components/Navigation/Sidebar.vue'
import Topbar from '@/components/Navigation/Topbar.vue'
</script>
<template>
  <Sidebar />
  <main
    class="relative flex flex-col flex-1 w-full h-full gap-2 p-2 overflow-x-hidden overflow-y-auto bg-main dark:bg-main-dark text-dark-50 dark:text-light-50"
  >
    <Topbar />
    <router-view />
  </main>
</template>
