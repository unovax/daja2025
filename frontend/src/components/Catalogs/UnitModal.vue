<script lang='ts' setup>
import { onMounted, ref, watch } from 'vue';
import PrimaryButton from '../Buttons/PrimaryButton.vue';
import Modal from '../Modal.vue';
import Input from '../Forms/Input.vue';
import { defaultUnit, type Unit } from '@/types/Catalogs';
import { createUnitService, updateUnitService } from '@/services/Catalogs/unitService';
import { errorNotification } from '@/utils/notifications';
import type { Loading } from '@/types/Commons';
import { clone } from '@/utils/common';
import useVuelidate from '@vuelidate/core';
import { email, required } from '@vuelidate/validators';

const props = defineProps<{
    unit: Unit,
    isOpen: boolean,
    close: Function,
    onSuccess: (unit: Unit, isUpdate: boolean) => void
}>();

const loading = ref<Loading>({
    state: false,
    text: 'Guardando...'
});

const unit = ref<Unit>(clone(props.unit));

const rules = {
    name: { required },
}

const v$ = useVuelidate(rules, unit)

const saveUnit = async () => {
    try {
        if (!(await v$.value.$validate())) return
        loading.value.state = true;
        const { data } = unit.value.id ? await updateUnitService(unit.value) : await createUnitService(unit.value);
        if (data.error) {
            errorNotification(data.message, data.errors);
        }
        props.onSuccess(data.data.unit, Boolean(unit.value.id));
        unit.value = clone(defaultUnit);
    } catch (error: any) {
        errorNotification('No se pudo realizar esta acción. Intenta nuevamente más tarde.', error.response.data);
    } finally {
        loading.value.state = false
    }
}

const closeModal = () => {
    unit.value = clone(defaultUnit);
    v$.value.$reset();
    props.close();
}

watch(() => props.isOpen, (newVal) => {
    if (newVal) {
        unit.value = clone(props.unit);
        v$.value.$reset();
    }
});


</script>
<template>
    <Modal :isOpen="isOpen" :close="closeModal" title="Nueva unidad de medida">
        <form class="p-2 space-y-2">
            <Input :error="v$.name.$errors[0]" v-model="unit.name" icon="user" placeholder="Nombre" />
        </form>
        <template #footer>
            <PrimaryButton :loading="loading" @click="saveUnit" text="Guardar" icon="save" />
        </template>
    </Modal>
</template>