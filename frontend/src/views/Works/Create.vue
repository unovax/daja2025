<script lang='ts' setup>
import DangerButton from '@/components/Buttons/DangerButton.vue';
import LinkButton from '@/components/Buttons/LinkButton.vue';
import PrimaryButton from '@/components/Buttons/PrimaryButton.vue';
import ContainerFlex from '@/components/ContainerFlex.vue';
import Divider from '@/components/Divider.vue';
import CatalogSelect from '@/components/Forms/CatalogSelect.vue';
import Checkbox from '@/components/Forms/Checkbox.vue';
import ImageInput from '@/components/Forms/ImageInput.vue';
import Input from '@/components/Forms/Input.vue';
import { createWorkService } from '@/services/workService';
import { defaultWork, defaultWorkDetail, type Work } from '@/types/Work';
import { clone } from '@/utils/common';
import { endDateAfterStartDate } from '@/utils/customValidations';
import useVuelidate from '@vuelidate/core';
import { required } from '@vuelidate/validators';
import { onMounted, ref } from 'vue';

const work = ref<Work>(clone(defaultWork))
const code = ref<number>(1);

const rules = {
        start_date: { required },
        end_date: { required, endDateAfterStartDate: endDateAfterStartDate(work.value.start_date) },
        client_id: { required }
}

const v$ = useVuelidate(rules, work)

const saveWork = async () => {
        if (!(await v$.value.$validate())) return;
        const { data } = await createWorkService(work.value); 
        console.log( data );
}

const addWorkDetail = () => {
        code.value++
        work.value.work_details.push({ ...clone(defaultWorkDetail), code: code.value });
}
const removeWorkDetail = (code: string | number) => {
        work.value.work_details = work.value.work_details.filter(work_detail => { return work_detail.code != code });
}

onMounted(() => {
        work.value.start_date = new Date().toISOString().slice(0, 16);
})
</script>
<template>
        <div class="p-2 bg-sidebar dark:bg-sidebar-dark">
                <div class="flex items-center gap-2 rounded-md">
                        <CatalogSelect :error="v$.client_id.$errors[0]" v-model="work.client_id" icon="user"
                                catalog="clients" label="Selecciona un cliente" placeholder="Ingresa un nombre" />
                        <div v-if="!work.individual_dates" class="flex items-center justify-end flex-1 gap-2">
                                <Input :disabled="true" type="datetime-local" :error="v$.start_date.$errors[0]"
                                        v-model="work.start_date" icon="calendar-alt" label="Fecha de inicio" />
                                <Input type="datetime-local" :error="v$.end_date.$errors[0]" v-model="work.end_date"
                                        icon="calendar-alt" label="Fecha de entrega" />
                        </div>
                </div>
                <Divider text="Opciones del trabajo" />
                <Input type="textarea" v-model="work.notes" icon="" label="Notas"
                                        placeholder="Ingresa notas del trabajo" />
                <Checkbox v-model="work.individual_dates" label=" Utilizar fechas de entrega individual" />
        </div>
        <div class="flex flex-wrap gap-2">
                <div v-for="(work_detail, index) in work.work_details" :key="work_detail.code"
                        class="flex flex-col flex-1 gap-2 p-2 rounded-md basis-1/3 bg-sidebar dark:bg-sidebar-dark md:flex-row">
                        <div class="space-y-2">
                                <ImageInput v-model="work_detail.photo" />
                                <Checkbox v-model="work_detail.is_new" label="Es nuevo" />
                        </div>
                        <div class="flex flex-col flex-1 h-full">
                                <div class="flex flex-wrap gap-2">
                                        <Input :constainerCustomClass="work.individual_dates ? 'w-full' : ' w-full md:w-3/4'"
                                                type="text" icon="scissors" label="Nombre del detalle"
                                                placeholder="Ingresa el nombre del detalle" />

                                        <Input :constainerCustomClass="'w-full md:flex-1'" type="number"
                                                icon="circle-dollar-to-slot" label="Precio" placeholder="0.00"
                                                :min="0" />

                                        <template v-if="work.individual_dates">
                                                <Input class="w-full md:flex-1" type="datetime-local"
                                                        v-model="work_detail.start_date" icon="calendar-alt"
                                                        label="Fecha de inicio" />
                                                <Input class="w-full md:flex-1" type="datetime-local"
                                                        v-model="work_detail.end_date" icon="calendar-alt"
                                                        label="Fecha de entrega" />
                                        </template>
                                </div>
                                <Input type="textarea" v-model="work_detail.description" icon="" label="Descripción"
                                        placeholder="Ingresa la descripción del detalle" />
                                <div class="flex items-end justify-end flex-1 gap-2">
                                        <DangerButton v-if="index > 0" @click="removeWorkDetail(work_detail.code)"
                                                icon="trash" text="Remover detalle" />
                                        <PrimaryButton v-if="index + 1 === work.work_details.length"
                                                @click="addWorkDetail" icon="plus" text="Agregar detalle" />
                                </div>
                        </div>
                </div>
        </div>
        <div class="flex items-center justify-end gap-2">
                <LinkButton to="Trabajos" text="Regresar" icon="chevron-left" type="danger" />
                <PrimaryButton @click="saveWork" icon="save" text="Guardar" />
        </div>
</template>