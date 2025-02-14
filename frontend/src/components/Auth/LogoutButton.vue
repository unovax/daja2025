<script lang="ts" setup>
import type { Loading } from '@/types/Commons'
import DangerButton from '../Buttons/DangerButton.vue'
import { ref } from 'vue'
import { logoutService, removeUserService } from '@/services/authService'
import { errorNotification, successNotification } from '@/utils/notifications'

const loading = ref<Loading>({
  state: false,
  text: 'Cerrando sesión...'
})

const handleLogout = async () => {
  try {
    loading.value.state = true
    const { data } = await logoutService()

    if (data.error) {
      errorNotification('Error en el cierre de sesión', data.message || 'Ha ocurrido un error inesperado.');
      return
    }

    removeUserService();
    successNotification('Cierre de sesión exitoso', 'Cierre de sesión realizado satisfactoriamente.');
  } catch (error: any) {
        errorNotification('Error de conexión', 'No se pudo completar el cierre de sesión. Intenta nuevamente más tarde.');
  } finally {
    loading.value.state = false
  }
}
</script>
<template>
  <DangerButton
    @click="handleLogout"
    :loading="loading"
    text="Cerrar sesión"
    icon="right-from-bracket"
  />
</template>
