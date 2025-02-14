<script lang="ts" setup>
import { ref } from 'vue'
import { OnClickOutside } from '@vueuse/components'

const open = ref<Boolean>(false)
const close = () => {
  if (open.value) {
    open.value = false
  }
}
</script>
<template>
  <div class="relative h-full select-none">
    <OnClickOutside @trigger="close" @click="open = !open" class="h-full">
      <slot name="trigger" />
    </OnClickOutside>
    <Transition>
      <div
        v-show="open"
        class="absolute right-0 mt-4 rounded-md shadow-md bg-sidebar dark:bg-sidebar-dark"
      >
        <slot name="content" />
      </div>
    </Transition>
  </div>
</template>
