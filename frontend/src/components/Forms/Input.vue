<script lang="ts" setup>
import type { ErrorObject } from '@vuelidate/core'

defineProps<{
  label?: string
  placeholder?: string
  icon?: string
  error?: ErrorObject,
  type?: string,
  readonly?: boolean
}>()
const model = defineModel()
</script>
<template>
  <div class="py-2">
    <label v-if="label" class="block text-sm">{{ label }}</label>
    <slot name="label" />
    <div class="relative flex items-center">
      <input
        :type="type ?? 'text'"
        v-model="model"
        class="w-full px-2 py-1 rounded-md bg-main dark:bg-main-dark text-dark dark:text-light pl-[42px]"
        :placeholder="placeholder"
        :readonly="readonly"
      />
      <div
        class="absolute left-0 p-2 flex justify-center text-dark dark:text-light items-center w-[36px] h-[20px] border-r border-primary"
      >
        <font-awesome-icon v-if="icon" :icon="icon" />
      </div>
    </div>
    <transition>
      <span v-if="error" class="absolute text-xs font-medium text-danger">
        {{ error.$message }}
      </span>
    </transition>
  </div>
</template>
