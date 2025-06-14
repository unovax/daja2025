<script lang="ts" setup>
import type { ErrorObject } from '@vuelidate/core'
import { ref } from 'vue';

const props = defineProps<{
  label?: string
  id?: string
  error?: ErrorObject,
  disabled?: boolean,
  customClass?: string,
  constainerCustomClass?: string,
}>()

const input = ref<HTMLInputElement | null>(null);
const model = defineModel<boolean>()

const emit = defineEmits(['blur', 'focus', 'input']);

const handleFocus = () => {
  emit('focus');
}

const handleBlur = () => {
  emit('blur');
}

const handleInput = () => {
  emit('input');
}
</script>
<template>
  <div class="relative" :class="constainerCustomClass">
    <label class="block text-sm">
        <input :id="id" @input="handleInput" @blur="handleBlur"
        @focus="handleFocus" ref="input"  type="checkbox" v-model="model"
        :class="customClass" :disabled="disabled" />
        {{ label }}
    </label>
    <transition>
      <div v-if="error" class="absolute w-full gap-2 text-xs font-medium text-danger text-end">
        <font-awesome-icon icon="warning" />
        <span>{{ error.$message }}</span>
      </div>
    </transition>
  </div>
</template>
