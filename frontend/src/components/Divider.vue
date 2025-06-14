<script lang='ts' setup>
    defineProps<{
        text: string
    }>()
</script>
<template>
    <div class="relative flex items-center py-2 my-2">
        <div class="w-full border"></div>
        <span class="absolute px-2 bg-sidebar left-2">{{ text }}</span>
    </div>
</template>