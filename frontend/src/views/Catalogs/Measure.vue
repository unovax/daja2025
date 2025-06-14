<script lang="ts" setup>
import PrimaryButton from '@/components/Buttons/PrimaryButton.vue'
import MeasureModal from '@/components/Catalogs/MeasureModal.vue'
import Back from '@/components/Buttons/LinkButton.vue'
import Search from '@/components/Search.vue'
import Actions from '@/components/Tables/Actions.vue'
import BodyTr from '@/components/Tables/BodyTr.vue'
import Container from '@/components/Tables/Container.vue'
import Pagination from '@/components/Tables/Pagination.vue'
import { getClientService } from '@/services/Catalogs/clientService'
import { deleteMeasureService, getMeasuresService } from '@/services/Catalogs/measureService'
import { useSidebar } from '@/stores/useSidebar'
import { defaultClient, defaultMeasure, type Client, type Measure } from '@/types/Catalogs'
import { defaultParamsData, type Loading, type ParamsData } from '@/types/Commons'
import { clone, getParamsData } from '@/utils/common'
import { confirmNotification, errorNotification, successNotification } from '@/utils/notifications'
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import LinkButton from '@/components/Buttons/LinkButton.vue'

interface ClientParamsData extends ParamsData {
  client_id?: string | null
}

const measures = ref<Measure[]>([]);
const filteredMeasures = ref<Measure[]>(measures.value);
const paramsData = ref<ClientParamsData>(defaultParamsData);

const loading = ref<Loading>({
  state: true,
  text: 'Obteniendo medidas...'
});

const route = useRoute();
const client = ref<Client>(defaultClient);

const measure = ref<Measure>(clone(defaultMeasure));

const isOpen = ref<boolean>(false);

const newMeasure = () => {
  measure.value = clone(defaultMeasure);
  isOpen.value = true;
}

const saveMeasure = (measure: Measure, isUpdate = false) => {
  isUpdate ? updateMeasure(measure) : addMeasure(measure);
}

const addMeasure = (measure: Measure) => {
  measures.value.unshift(clone(measure));
  filteredMeasures.value = measures.value;
  console.log(filteredMeasures.value);
  close();
  successNotification('Accion realizada correctamente', 'El medidas fue creado satisfactoriamente.');
}

const editMeasure = (measureToEdit: Measure) => {
  measure.value = clone(measureToEdit);
  isOpen.value = true;
}

const updateMeasure = (measure: Measure) => {
  measures.value = measures.value.map(c => c.id === measure.id ? measure : c);
  filteredMeasures.value = measures.value;
  close();
  successNotification('Accion realizada correctamente', 'El medidas fue actualizado satisfactoriamente.');
}

const deleteMeasure = async (measureToDelete: Measure) => {
  if (!await confirmNotification("Estas seguro de realizar esta acción?", "", "Si, eliminar.")) {
    return;
  }
  const { data } = await deleteMeasureService(measureToDelete.id);
  if (data.error) {
    errorNotification("Error al eliminar el medidas", data.message);
    return;
  }
  filteredMeasures.value = filteredMeasures.value.filter(c => { return c.id != measureToDelete.id });
  successNotification("Operación realizada correctamente.", data.message);
}

const close = () => {
  isOpen.value = false;
}

const getMeasures = async (params?: ClientParamsData) => {
  paramsData.value = params ?? paramsData.value;
  paramsData.value.client_id = client.value.id;
  loading.value.state = true;
  const { data } = await getMeasuresService(paramsData.value);
  measures.value = data.data;
  paramsData.value = getParamsData(data, paramsData.value);
  loading.value.state = false;
  filteredMeasures.value = clone(measures.value);
}

const getClient = async () => {
  const { data } = await getClientService(route.params.client_id as string);
  client.value = data.data.client;
}
onMounted(async () => {
  await getClient();
  useSidebar().setTabName(`Medidas del cliente : ${client.value.name} ${client.value.lastname}`);
  getMeasures();
});
</script>
<template>
  
  <div class="flex items-center justify-between gap-2 p-2 rounded-md bg-sidebar dark:bg-sidebar-dark">
    <Search :search="getMeasures" :paramsData="paramsData" />
    <div class="flex items-center gap-2">
      <PrimaryButton @click="newMeasure" text="Nueva medida" icon="plus" />
      <LinkButton to="Clientes" icon="chevron-left" text="Regresar" />
    </div>
  </div>
  <Container :loading="loading" :entries="filteredMeasures" withoutEntriesMessage="Sin medidas registrados...">
    <table class="w-full text-left">
      <thead>
        <tr>
          <th width="100px">Acciones</th>
          <th width="100px">Código</th>
          <th>Nombre</th>
          <th>Valor</th>
          <th>Unidad</th>
        </tr>
      </thead>
      <tbody>
        <BodyTr v-for="measure in filteredMeasures" :key="measure.code" :id="`measure-${measure.id}`"
          @dblclick="editMeasure(measure)">
          <Actions :actions="[
            { icon: 'edit', onClick: () => { editMeasure(measure) } },
            { icon: 'trash', onClick: () => { deleteMeasure(measure) } }
          ]" />
          <td>{{ measure.code }}</td>
          <td>{{ measure.name }}</td>
          <td>{{ Number(measure.value).toFixed(2) }}</td>
          <td>{{ measure.unit?.name }}</td>
        </BodyTr>
      </tbody>
    </table>
    <template #pagination>
      <Pagination :paramsData="paramsData" :setPage="getMeasures" />
    </template>
  </Container>

  <MeasureModal :client="client" :isOpen="isOpen" :measure="measure" :close="close" :onSuccess="saveMeasure" />
</template>
