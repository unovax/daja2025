<script lang='ts' setup>
interface Action {
    icon: string,
    onClick: Function
}
defineProps<{
    actions: Array<Action>
}>();
</script>
<template>
    <td>
        <div class="flex items-center justify-center gap-2">
            <font-awesome-icon class="pointer" v-for="action in actions" :icon="action.icon" @click="action.onClick" :key="action.icon" />
        </div>
    </td>
</template>