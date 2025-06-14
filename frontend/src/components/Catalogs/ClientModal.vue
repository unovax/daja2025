<script lang='ts' setup>
import { onMounted, ref, watch } from 'vue';
import PrimaryButton from '../Buttons/PrimaryButton.vue';
import Modal from '../Modal.vue';
import Input from '../Forms/Input.vue';
import { defaultClient, type Client } from '@/types/Catalogs';
import { createClientService, updateClientService } from '@/services/Catalogs/clientService';
import { errorNotification } from '@/utils/notifications';
import type { Loading } from '@/types/Commons';
import { clone } from '@/utils/common';
import useVuelidate from '@vuelidate/core';
import { email, required } from '@vuelidate/validators';

const props = defineProps<{
    client: Client,
    isOpen: boolean,
    close: Function,
    onSuccess: (client: Client, isUpdate: boolean) => void
}>();

const loading = ref<Loading>({
    state: false,
    text: 'Guardando...'
});

const isUpdate = ref<boolean>(false);
const client = ref<Client>(clone(props.client));

const rules = {
    name: { required },
    lastname: { required },
    phone: { required },
    email: { email },
}

const v$ = useVuelidate(rules, client)

const saveClient = async () => {
    try {
        if (!(await v$.value.$validate())) return
        loading.value.state = true;
        const { data } = client.value.id ? await updateClientService(client.value) : await createClientService(client.value);
        if (data.error) {
            errorNotification(data.message, data.errors);
        }
        props.onSuccess(data.data.client, isUpdate.value);
        client.value = clone(defaultClient);
    } catch (error: any) {
        errorNotification('No se pudo completar el inicio de sesión. Intenta nuevamente más tarde.', error.response.data);
    } finally {
        loading.value.state = false
    }
}

const closeModal = () => {
    client.value = clone(defaultClient);
    v$.value.$reset();
    props.close();
}

watch(() => props.isOpen, (newVal) => {
    if (newVal) {
        client.value = clone(props.client);
        v$.value.$reset();
        isUpdate.value = Boolean(client.value.id)
    }
});


</script>
<template>
    <Modal :isOpen="isOpen" :close="closeModal" title="Nuevo cliente">
        <form class="p-2 space-y-2">
            <Input :error="v$.name.$errors[0]" v-model="client.name" icon="user" label="Nombre" placeholder="Ingresa el nombre del cliente" />
            <Input :error="v$.lastname.$errors[0]" v-model="client.lastname" icon="id-badge" label="Apellido" placeholder="Ingresa el apellido del cliente" />
            <Input :error="v$.email.$errors[0]" v-model="client.email" icon="envelope" label="Correo electronico" placeholder="Ingresa el correo electronico del cliente" />
            <Input :error="v$.phone.$errors[0]" v-model="client.phone" icon="phone" label="Telefono" placeholder="Ingresa el telefono del cliente" />
        </form>
        <template #footer>
            <PrimaryButton :loading="loading" @click="saveClient" text="Guardar" icon="save" />
        </template>
    </Modal>
</template>