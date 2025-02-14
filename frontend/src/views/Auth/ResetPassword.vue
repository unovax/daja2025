<script lang="ts" setup>
import AuthCard from '@/components/Auth/AuthCard.vue'
import PrimaryButton from '@/components/Buttons/PrimaryButton.vue'
import Input from '@/components/Forms/Input.vue'
import Link from '@/components/Navigation/Link.vue'
import { emptyResetPasswordCredentials, type ResetPasswordCredentials } from '@/types/Auth'
import { clone } from '@/utils/common'
import { ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { email, required } from '@vuelidate/validators'
import { resetPasswordService } from '@/services/authService'
import type { Loading } from '@/types/Commons'
import { errorNotification, successNotification } from '@/utils/notifications'
import { useRoute } from 'vue-router';
import router from '@/router'

const route = useRoute();

const resetPasswordCredentials = ref<ResetPasswordCredentials>(clone(emptyResetPasswordCredentials))

resetPasswordCredentials.value.email = typeof route.query.email == 'string' ? route.query.email : '';
resetPasswordCredentials.value.token = typeof route.query.token == 'string' ? route.query.token : '';

const rules = {
    email: { required, email },
    token: { required },
    password: { required },
    password_confirmation: { required },
}

const loading = ref<Loading>({
    state: false,
    text: 'Guardando...'
})

const v$ = useVuelidate(rules, resetPasswordCredentials)

const handleReset = async () => {
    try {
        if (!(await v$.value.$validate())) return

        loading.value.state = true

        const { data } = await resetPasswordService(resetPasswordCredentials.value)

        if (data.error) {
            errorNotification(
                'Error al actualizar su contraseña.',
                data.message || 'Ha ocurrido un error inesperado.'
            )
            return
        }

        successNotification(
            'Contraseña actualizada correctamente',
            'Su contraseña ha sido actualizada correctamente. Sera reedirigido a la pestaña de inicio de sesión en unos momentos. Espere por favor...'
        )
        setTimeout(() => {
            router.push({ 'name': 'Login' });
        }, 1000 );
    } catch (error: any) {
        errorNotification(
            'No se pudo completar el reestablecimiento de su contraseña. Re intente el proceso nuevamente.',
            error.response.data,
        )
    } finally {
        loading.value.state = false
    }
}
</script>
<template>
    <div class="flex items-center justify-center bg-light w-dvw h-dvh">
        <AuthCard title="Actualización de contraseña">
            <template #content>
                <Input icon="envelope" v-model="resetPasswordCredentials.email" label="Correo electronico"
                    placeholder="Ingresa tu correo electronico" :error="v$.email.$errors[0]" readonly />
                <Input type="password" icon="user-lock" label="Contraseña" v-model="resetPasswordCredentials.password"
                    placeholder="Ingresa tu contraseña" :error="v$.password.$errors[0]">
                </Input>
                <Input type="password" icon="user-lock" v-model="resetPasswordCredentials.password_confirmation"
                    label="Confirma tu contraseña" placeholder="Ingresa tu contraseña nuevamente"
                    :error="v$.password_confirmation.$errors[0]">
                </Input>
            </template>
            <template #footer>
                <Link to="Login" text="Regresar al inicio de sesión" />
                <PrimaryButton :loading="loading" icon="right-to-bracket" text="Actualizar contraseña" @click="handleReset" />
            </template>
        </AuthCard>
    </div>
</template>
