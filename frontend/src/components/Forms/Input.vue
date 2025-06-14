<script lang="ts" setup>
import type { ErrorObject } from '@vuelidate/core'
import { ref } from 'vue';

const props = defineProps<{
  label?: string
  placeholder?: string
  icon?: string
  id?: string
  error?: ErrorObject,
  type?: string,
  readonly?: boolean,
  disabled?: boolean,
  clear?: Function,
  canClear?: boolean,
  cantAutocomplete?: boolean,
  rows?: number,
  customClass?: string,
  constainerCustomClass?: string,
  min?: number
}>()

const input = ref<HTMLInputElement | null>(null);
const handleClick = () => {
  if (props.type === 'datetime-local' && input.value != null && !props.disabled) {
    input.value.showPicker();
  }
}
const model = defineModel<string | number>()

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
    <label v-if="label" class="block text-sm">{{ label }}</label>
    <slot name="label" />
    <textarea v-if="type === 'textarea'" :autocomplete="cantAutocomplete ? 'off' : 'on'" :id="id" @input="handleInput"
      @blur="handleBlur" @focus="handleFocus" ref="input" @click="handleClick"
      :class="['w-full px-2 py-1 rounded-md bg-main dark:bg-main-dark text-dark dark:text-light', customClass]" v-model="model"
      :placeholder="placeholder" :readonly="readonly" :disabled="disabled" :rows="rows ?? 3"></textarea>
    <div v-else class="relative flex items-center">
      <input :min="min" :autocomplete="cantAutocomplete ? 'off' : 'on'" :id="id" @input="handleInput" @blur="handleBlur"
        @focus="handleFocus" ref="input" @click="handleClick" :type="type ?? 'text'" v-model="model"
        :class="['w-full px-2 py-1 rounded-md bg-main dark:bg-main-dark text-dark dark:text-light pl-[42px]', customClass, canClear ? 'pr-[42px]' : '']":placeholder="placeholder" :readonly="readonly" :disabled="disabled" />
      <div
        class="absolute left-0 p-2 flex justify-center text-dark dark:text-light items-center w-[36px] h-[20px] border-r border-primary">
        <font-awesome-icon v-if="icon" :icon="icon" />
      </div>
      <div v-if="canClear"
        class="absolute right-0 p-2 flex justify-center text-dark dark:text-light items-center w-[36px] h-[20px] border-l border-primary">
        <font-awesome-icon class="pointer" icon="close" @click="clear" />
      </div>
    </div>
    <transition>
      <div v-if="error" class="absolute w-full gap-2 text-xs font-medium text-danger text-end">
        <font-awesome-icon icon="warning" />
        <span>{{ error.$message }}</span>
      </div>
    </transition>
  </div>
</template>
