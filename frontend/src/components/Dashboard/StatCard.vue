<script lang='ts' setup>
    defineProps<{
        value: string,
        description: string,
        icon?: string,
    }>();
</script>
<template>
    <div class="flex justify-between w-full overflow-hidden rounded-md bg-sidebar dark:bg-dark-50">
        <div class="flex flex-col flex-1 p-2">
            <span>{{ value }}</span>
            <span class="text-xs text-gray-600">{{ description }}</span>
        </div>
        <div class="flex items-center justify-center p-4 bg-primary">
            <font-awesome-icon class="text-light" v-if="icon" :icon="icon" />
        </div>
    </div>
</template>