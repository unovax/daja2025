<script lang='ts' setup>
import PrimaryButton from '../Buttons/PrimaryButton.vue';

defineProps<{
    to: string,
    icon: string,
    text: string,
    type?: string
}>();

const types : Record<string, string> = {
    'primary' : 'bg-primary hover:bg-primary-hover',
    'danger' : 'bg-danger hover:bg-danger-hover',
    'success' : 'bg-success hover:bg-danger-hover',
    'info' : 'bg-info hover:bg-danger-hover',
}
</script>
<template>
    <router-link :to="{
        name: to
    }" class="flex items-center gap-2 px-4 py-2 text-sm text-white truncate rounded" :class="[
        types[type ?? 'primary'] 
    ]">
        <font-awesome-icon :icon="icon" />
        <span>{{ text }}</span>
    </router-link>
</template>