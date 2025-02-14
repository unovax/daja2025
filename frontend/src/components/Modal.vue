<script setup lang="ts">
import DangerButton from './Buttons/DangerButton.vue';


defineProps<{ 
    isOpen: boolean; 
    title?: string 
    close: any
}>();
</script>

<template>
    <Teleport to="body">
        <Transition>
            <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                <div class="overflow-hidden rounded-lg shadow-lg bg-sidebar dark:bg-sidebar-dark w-96">
                    <div class="flex items-center justify-between px-4 py-2 bg-primary text-light">
                        <h2 class="text-lg font-semibold">{{ title }}</h2>
                        <font-awesome-icon icon="close" class="pointer" @click="close"/>
                    </div>
                    <slot></slot>
                    <div class="flex justify-end gap-2 p-2 border-t bg-sidebar dark:bg-sidebar-dark border-sidebar-hover dark:border-sidebar-dark-hover">
                        <slot name="footer"></slot>
                        <DangerButton @click="close" text="Cerrar" icon="close" />
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
