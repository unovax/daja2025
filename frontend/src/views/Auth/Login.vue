<script lang="ts" setup>
import AuthCard from '@/components/Auth/AuthCard.vue'
import PrimaryButton from '@/components/Buttons/PrimaryButton.vue'
import Input from '@/components/Forms/Input.vue'
import Link from '@/components/Navigation/Link.vue'
import { emptyLoginCredentials, type LoginCredentials } from '@/types/Auth'
import { clone } from '@/utils/common'
import { ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { email, required } from '@vuelidate/validators'
import { loginService, setUserService } from '@/services/authService'
import type { Loading } from '@/types/Commons'
import { errorNotification, successNotification } from '@/utils/notifications'

const loginCredentials = ref<LoginCredentials>(clone(emptyLoginCredentials))

const rules = {
  email: { required, email },
  password: { required }
}

const loading = ref<Loading>({
  state: false,
  text: 'Guardando...'
})

const v$ = useVuelidate(rules, loginCredentials)

const handleLogin = async () => {
  try {
    if (!(await v$.value.$validate())) return

    loading.value.state = true

    const { data } = await loginService(loginCredentials.value)
    
    if (data.error) {
      throw new Error("Error en el inicio de sesión");
    }
    
    const user = data.data.user;
    user.token = data.data.token;

    setUserService(user);
    successNotification('Inicio se sesión exitoso', 'Inicio de sesión realizado satisfactoriamente.');

  } catch (error: any) {
    errorNotification('No se pudo completar el inicio de sesión. Intenta nuevamente más tarde.', error.response.data);
  } finally {
    loading.value.state = false
  }
}
</script>
<template>
  <div class="flex items-center justify-center bg-light w-dvw h-dvh">
    <AuthCard title="Iniciar sesión">
      <template #content>
        <Input
          icon="envelope"
          v-model="loginCredentials.email"
          label="Correo electronico"
          placeholder="Ingresa tu correo electronico"
          :error="v$.email.$errors[0]"
        />
        <Input
          icon="user-lock"
          v-model="loginCredentials.password"
          placeholder="Ingresa tu contraseña"
          type="password"
          :error="v$.password.$errors[0]"
        >
          <template #label>
            <div class="flex justify-between gap-2">
              <label class="block">Contraseña</label>
              <Link to="ForgotPassword"  :query="{ email: loginCredentials.email }" text="¿Olvidaste tu contraseña?" />
            </div>
          </template>
        </Input>
      </template>
      <template #footer>
        <Link to="Register" text="No tengo cuenta" />
        <PrimaryButton :loading="loading" icon="right-to-bracket" text="Iniciar sesión" @click="handleLogin" />
      </template>
    </AuthCard>
  </div>
</template>
