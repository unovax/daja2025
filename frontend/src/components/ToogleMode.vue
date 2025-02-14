<script lang="ts" setup>
import { ref } from 'vue'
const darkMode = ref<Boolean>(localStorage.getItem('darkMode') == 'true')

const setDarkMode = () => {
  const html = document.querySelector('html')
  html?.classList.toggle('dark')
  localStorage.setItem('darkMode', JSON.stringify(darkMode.value))
}

const toggleDarkMode = () => {
  console.log('toogle')
  darkMode.value = !darkMode.value
  setDarkMode()
}

if (darkMode.value) {
  setDarkMode()
}
</script>
<template>
  <button @click="toggleDarkMode" class="">Toogle</button>
</template>
