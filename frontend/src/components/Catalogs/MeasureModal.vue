<script lang='ts' setup>
import { onMounted, ref, watch } from 'vue';
import PrimaryButton from '../Buttons/PrimaryButton.vue';
import Modal from '../Modal.vue';
import Input from '../Forms/Input.vue';
import CatalogSelect from '../Forms/CatalogSelect.vue';
import { defaultMeasure, type Client, type Measure } from '@/types/Catalogs';
import { createMeasureService, updateMeasureService } from '@/services/Catalogs/measureService';
import { errorNotification } from '@/utils/notifications';
import type { Loading } from '@/types/Commons';
import { clone } from '@/utils/common';
import useVuelidate from '@vuelidate/core';
import { email, required } from '@vuelidate/validators';

const props = defineProps<{
    client: Client,
    measure: Measure,
    isOpen: boolean,
    close: Function,
    onSuccess: (measure: Measure, isUpdate: boolean) => void
}>();

const loading = ref<Loading>({
    state: false,
    text: 'Guardando...'
});

const measure = ref<Measure>(clone(props.measure));

const rules = {
    name: { required },
    value: { required },
    client_id: { required },
    unit_id: { required },
}

const v$ = useVuelidate(rules, measure)

const saveMeasure = async () => {
    measure.value.client_id = props.client.id;
    try {
        if (!(await v$.value.$validate())) return;
        loading.value.state = true;
        const { data } = measure.value.id ? await updateMeasureService(measure.value) : await createMeasureService(measure.value);
        if (data.error) {
            errorNotification(data.message, data.errors);
        }
        props.onSuccess(data.data.measure, Boolean(measure.value.id));
        measure.value = clone(defaultMeasure);
    } catch (error: any) {
        errorNotification('No se pudo realizar esta acción. Intenta nuevamente más tarde.', error.response.data);
    } finally {
        loading.value.state = false
    }
}

const closeModal = () => {
    measure.value = clone(defaultMeasure);
    v$.value.$reset();
    props.close();
}

watch(() => props.isOpen, (newVal) => {
    if (newVal) {
        measure.value = clone(props.measure);
        v$.value.$reset();
    }
});

</script>
<template>
    <Modal :isOpen="isOpen" :close="closeModal" title="Nueva unidad de medida">
        <div class="p-2">
            <p class="font-bold">{{ client.name + ' ' + client.lastname }}</p>
            <p class="text-sm font-medium">{{ client.phone }}</p>
        </div>
        <hr>
        <form class="px-2 pt-2 pb-6 space-y-2">
            <Input :error="v$.name.$errors[0]" v-model="measure.name" icon="user" placeholder="Ingresa del nombre de la medida" label="Nombre"/>
            <Input :error="v$.value.$errors[0]" v-model="measure.value" icon="ruler-combined" placeholder="Ingresa el valor de la medida" label="Valor"/>
            <CatalogSelect :error="v$.unit_id.$errors[0]" icon="ruler-horizontal" v-model="measure.unit_id" catalog="units" label="Selecciona una unidad" placeholder="Ingresa el nombre de la unidad"/>
        </form>
        <template #footer>
            <PrimaryButton :loading="loading" @click="saveMeasure" text="Guardar" icon="save" />
        </template>
    </Modal>
</template>