<script setup lang="ts">
import { ref, defineProps, defineEmits, watch } from "vue";

const props = defineProps<{ modelValue: File | string | null }>();
const emit = defineEmits(["update:modelValue"]);

const preview = ref<string | null>(null);

// Función para actualizar la vista previa
const updatePreview = (value: File | string | null) => {
  if (!value) {
    preview.value = null;
  } else if (typeof value === "string") {
    preview.value = value; // Es una URL
  } else {
    preview.value = URL.createObjectURL(value); // Es un archivo
  }
};

// Manejar cambio de archivo
const onFileChange = (event: Event) => {
  const file = (event.target as HTMLInputElement).files?.[0] || null;
  if (file && file.type.startsWith("image/")) {
    emit("update:modelValue", file);
  }
};

// Eliminar imagen
const removeImage = () => {
  emit("update:modelValue", null);
};

// Watch para actualizar la vista previa si cambia el modelValue
watch(() => props.modelValue, updatePreview, { immediate: true });
</script>

<template>
  <div class="flex flex-col items-center">
    <label class="relative flex items-center justify-center w-full overflow-hidden transition border-2 border-gray-400 border-dashed rounded-lg cursor-pointer md:max-w-40 md:min-w-40 aspect-square hover:border-gray-600">
      <input type="file" accept="image/*" @change="onFileChange" class="hidden" />
      <div v-if="preview" class="relative w-full h-full">
        <img :src="preview" alt="Vista previa" class="object-cover w-full h-full rounded-lg" />
        <button @click.prevent="removeImage" class="absolute p-1 text-white transition bg-black bg-opacity-50 rounded-full top-2 right-2 hover:bg-opacity-75">
          ✖
        </button>
      </div>
      <div v-else class="text-sm text-gray-500">📷 Cargar imagen</div>
    </label>
  </div>
</template>
