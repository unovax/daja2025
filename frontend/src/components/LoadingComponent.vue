<script lang='ts' setup>
    defineProps<{
        text?: string | null,
        icon?: string
    }>();
</script>
<template>
    <div class="flex items-center justify-center w-full gap-2 p-4">
        <font-awesome-icon  :icon="icon ?? 'spinner'" class="animate-spin"/>
        <span>{{ text }}</span>
    </div>
</template>