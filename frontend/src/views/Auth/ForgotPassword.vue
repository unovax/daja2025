<script lang="ts" setup>
import AuthCard from '@/components/Auth/AuthCard.vue'
import PrimaryButton from '@/components/Buttons/PrimaryButton.vue'
import Input from '@/components/Forms/Input.vue'
import Link from '@/components/Navigation/Link.vue'
import { emptyForgotPasswordCredentials, type ForgotPasswordCredentials } from '@/types/Auth'
import { clone } from '@/utils/common'
import { ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { email, required } from '@vuelidate/validators'
import { forgotPasswordService } from '@/services/authService'
import type { Loading } from '@/types/Commons'
import { errorNotification, successNotification } from '@/utils/notifications'
import { useRoute } from 'vue-router';

const route = useRoute();

const forgotPasswordCredentials = ref<ForgotPasswordCredentials>(clone(emptyForgotPasswordCredentials))

forgotPasswordCredentials.value.email = typeof route.query.email == 'string' ? route.query.email : '';

const rules = {
  email: { required, email },
}

const loading = ref<Loading>({
  state: false,
  text: 'Guardando...'
})

const v$ = useVuelidate(rules, forgotPasswordCredentials)

const handleReset = async () => {
  try {
    if (!(await v$.value.$validate())) return

    loading.value.state = true

    const { data } = await forgotPasswordService(forgotPasswordCredentials.value)

    if (data.error) {
      errorNotification(
        'Error al enviar el correo para recuperación de contraseña',
        data.message || 'Ha ocurrido un error inesperado.'
      )
      return
    }

    successNotification(
      'Correo electronico enviado correctamente',
      'Revisa tu bandeja de entrada y sigue las instrucciones para poder recuperar su contraseña.'
    )
    
  } catch (error: any) {
    errorNotification(
      'No se pudo completar el envio del correo de recuperación de contraseña. Intenta nuevamente más tarde.',
      error.response.data
    )
  } finally {
    loading.value.state = false
  } 
}
</script>
<template>
  <div class="flex items-center justify-center bg-light w-dvw h-dvh">
    <AuthCard title="Recuperación de contraseña">
      <template #content>
        <Input icon="envelope" v-model="forgotPasswordCredentials.email" label="Correo electronico"
          placeholder="Ingresa tu correo electronico" :error="v$.email.$errors[0]" />
      </template>
      <template #footer>
        <Link to="Login" text="Regresar al inicio de sesión" />
        <PrimaryButton :loading="loading" icon="right-to-bracket" text="Enviar correo" @click="handleReset" />
      </template>
    </AuthCard>
  </div>
</template>
