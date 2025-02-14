<script lang='ts' setup>
import { useTable } from '@/stores/useTable';
import { storeToRefs } from 'pinia';
const props = defineProps<{
   id: string
}>();
const { activeTr } = storeToRefs(useTable());
</script>
<template>
     <tr :class="[
         'cursor-pointer',
         activeTr === id ? 'bg-sidebar-hover' : ''
     ]" @click="useTable().setActiveTr(id)">
        <slot></slot>
     </tr>
</template>