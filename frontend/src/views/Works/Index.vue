<script lang="ts" setup>
import LinkButton from '@/components/Buttons/LinkButton.vue'
import Search from '@/components/Search.vue'
import Actions from '@/components/Tables/Actions.vue'
import BodyTr from '@/components/Tables/BodyTr.vue'
import Container from '@/components/Tables/Container.vue'
import Pagination from '@/components/Tables/Pagination.vue'
import { getWorksService } from '@/services/workService'
import { defaultParamsData, type Loading, type ParamsData } from '@/types/Commons'
import { type Work } from '@/types/Work'
import { clone, getParamsData } from '@/utils/common'
import { onMounted, ref } from 'vue'

const works = ref<Work[]>([]);
const filteredWorks = ref<Work[]>(works.value);
const paramsData = ref<ParamsData>(defaultParamsData);

const loading = ref<Loading>({
  state: false,
  text: 'Obteniendo trabajos...'
});

const getWorks = async (params?: ParamsData) => {
  paramsData.value = params ?? paramsData.value;
  loading.value.state = true;
  const { data } = await getWorksService(paramsData.value);
  works.value = data.data;
  paramsData.value = getParamsData(data, paramsData.value);
  loading.value.state = false;
  filteredWorks.value = clone(works.value);
}

onMounted(() => {
  getWorks();
});
</script>
<template>
  <div class="flex items-center justify-between gap-2 p-2 rounded-md bg-sidebar dark:bg-sidebar-dark">
    <Search :search="getWorks" :paramsData="paramsData" />
    <LinkButton to="NuevoTrabajo" text="Nuevo trabajo" icon="plus" />
  </div>
  <Container :loading="loading" :entries="filteredWorks" withoutEntriesMessage="Sin trabajos registrados...">
    <table class="w-full text-left">
      <thead>
        <tr>
          <th width="100px">Acciones</th>
          <th width="100px">Código</th>
          <th>Notas</th>
          <th>Fecha inicio</th>
          <th>Fecha final</th>
          <th>Cantidad de detalles</th>
        </tr>
      </thead>
      <tbody>
        <BodyTr v-for="work in filteredWorks" :key="work.code" :id="`work-${work.id}`">
          <!-- <Actions :actions="[
            { icon: 'edit', onClick: () => { editWork(work) } },
            { icon: 'trash', onClick: () => { deleteWork(work) } }
          ]" /> -->
          <td></td>
          <td>{{ work.code }}</td>
          <td>{{ work.notes }}</td>
          <td>{{ work.start_date }}</td>
          <td>{{ work.end_date }}</td>
          <td>{{ work.work_details.length }}</td>
        </BodyTr>
      </tbody>
    </table>
    <template #pagination>
      <Pagination :paramsData="paramsData" :setPage="getWorks" />
    </template>
  </Container>
</template>
