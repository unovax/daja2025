<script lang='ts' setup>
import { useSidebar } from '@/stores/useSidebar';

const toogleSidebar = () => {
    useSidebar().toogleSidebar();
}
</script>
<template>
    <font-awesome-icon @click="toogleSidebar" icon="fa-bars" class="pointer size-[20px]" />
</template>