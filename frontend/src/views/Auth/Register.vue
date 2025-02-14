<script lang="ts" setup>
import AuthCard from '@/components/Auth/AuthCard.vue'
import PrimaryButton from '@/components/Buttons/PrimaryButton.vue'
import Input from '@/components/Forms/Input.vue'
import Link from '@/components/Navigation/Link.vue'
import { registerService, setUserService } from '@/services/authService'
import { emptyRegisterCredentials, type RegisterCredentials } from '@/types/Auth'
import type { Loading } from '@/types/Commons'
import { clone } from '@/utils/common'
import { errorNotification, successNotification } from '@/utils/notifications'
import useVuelidate from '@vuelidate/core'
import { email, required } from '@vuelidate/validators'
import { ref } from 'vue'

interface RegisterResponse {
  error: boolean
  message: string
  data: RegisterCredentials
}

const registerCredentials = ref<RegisterCredentials>(clone(emptyRegisterCredentials))

const rules = {
  name: { required },
  lastname: { required },
  email: { required, email },
  password: { required },
  password_confirmation: { required },
  tenant: {
    name: { required },
    code: { required }
  }
}

const loading = ref<Loading>({
  state: false,
  text: 'Guardando...'
})

const v$ = useVuelidate(rules, registerCredentials)

const handleRegister = async () => {
  try {
    if (!(await v$.value.$validate())) return

    loading.value.state = true

    const { data } = await registerService(registerCredentials.value)
    
    if (data.error) {
      throw new Error(data.message);
    }
    
    const user = data.data.user;
    user.token = data.data.token;

    setUserService(user);

    successNotification('Registro exitoso', 'Registro realizado satisfactoriamente.');

  } catch (error: any) {
    errorNotification('No se pudo completar el registro. Intenta nuevamente más tarde.', error.response.data);

  } finally {
    loading.value.state = false
  }
}
</script>
<template>
  <div class="flex items-center justify-center bg-light w-dvw h-dvh">
    <AuthCard title="Registrarme">
      <template #content>
        <Input
          icon="briefcase"
          v-model="registerCredentials.tenant.code"
          label="Nombre de la empresa"
          placeholder="Ingresa el nombre de tu empresa"
          :error="v$.tenant.name.$errors[0]"
        />
        <Input
          icon="briefcase"
          v-model="registerCredentials.tenant.name"
          label="Nombre de la empresa"
          placeholder="Ingresa el nombre de tu empresa"
          :error="v$.tenant.name.$errors[0]"
        />
        <Input
          icon="user"
          v-model="registerCredentials.name"
          label="Nombre(s)"
          placeholder="Ingresa tu(s) nombre(s)"
          :error="v$.name.$errors[0]"
        />
        <Input
          icon="user"
          v-model="registerCredentials.lastname"
          label="Apellido"
          placeholder="Ingresa tus apellidos"
          :error="v$.lastname.$errors[0]"
        />
        <Input
          icon="envelope"
          v-model="registerCredentials.email"
          label="Correo electronico"
          placeholder="Ingresa tu correo electronico"
          :error="v$.email.$errors[0]"
        />
        <Input
          type="password"
          icon="user-lock"
          label="Contraseña"
          v-model="registerCredentials.password"
          placeholder="Ingresa tu contraseña"
          :error="v$.password.$errors[0]"
        >
        </Input>
        <Input
          type="password"
          icon="user-lock"
          v-model="registerCredentials.password_confirmation"
          label="Confirma tu contraseña"
          placeholder="Ingresa tu contraseña nuevamente"
          :error="v$.password_confirmation.$errors[0]"
        >
        </Input>
      </template>
      <template #footer>
        <Link to="Login" text="Ya tengo cuenta" />
        <PrimaryButton
          :loading="loading"
          @click="handleRegister"
          icon="right-to-bracket"
          text="Iniciar sesión"
        />
      </template>
    </AuthCard>
  </div>
</template>
