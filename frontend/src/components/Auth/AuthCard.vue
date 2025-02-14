<script lang="ts" setup>
defineProps<{ title: string }>()
</script>
<template>
  <div class="w-full bg-sidebar dark:bg-sidebar-dark max-w-[500px] rounded-md">
    <h1 class="w-full px-4 py-2 text-2xl font-bold text-center border-b">

        <span>{{ title }}</span>
    </h1>
    <div class="flex flex-col gap-2 px-4 py-2">
      <slot name="content" />
    </div>
    <div class="flex items-center justify-between px-4 py-2">
        <slot name="footer" />
    </div>
  </div>
</template>
