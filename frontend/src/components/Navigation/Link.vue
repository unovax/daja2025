<script lang="ts" setup>
import { computed } from "vue";

const props = defineProps<{
  text: string;
  to: string;
  query?: Record<string, any>; // Aseguramos que params sea un objeto opcional
}>();

// Computed para manejar params opcionalmente
const routeParams = computed(() => ({
  name: props.to,
  query: props.query ?? {}, // Si no hay params, se envía un objeto vacío
}));
</script>

<template>
  <router-link
    class="text-sm font-medium duration-300 transition-color text-link hover:text-link-hover"
    :to="routeParams"
  >
    {{ text }}
  </router-link>
</template>
