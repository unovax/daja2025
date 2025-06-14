<script lang="ts" setup>
import PrimaryButton from '@/components/Buttons/PrimaryButton.vue'
import UnitModal from '@/components/Catalogs/UnitModal.vue'
import Search from '@/components/Search.vue'
import Actions from '@/components/Tables/Actions.vue'
import BodyTr from '@/components/Tables/BodyTr.vue'
import Container from '@/components/Tables/Container.vue'
import Pagination from '@/components/Tables/Pagination.vue'
import { deleteUnitService, getUnitsService } from '@/services/Catalogs/unitService'
import { defaultUnit, type Unit } from '@/types/Catalogs'
import { defaultParamsData, type Loading, type ParamsData } from '@/types/Commons'
import { clone, getParamsData } from '@/utils/common'
import { confirmNotification, errorNotification, successNotification } from '@/utils/notifications'
import { onMounted, ref } from 'vue'

const units = ref<Unit[]>([]);
const filteredUnits = ref<Unit[]>(units.value);
const paramsData = ref<ParamsData>(defaultParamsData);

const loading = ref<Loading>({
  state: false,
  text: 'Obteniendo unidades...'
});

const unit = ref<Unit>(clone(defaultUnit));

const isOpen = ref<boolean>(false);

const newUnit = () => {
  unit.value = clone(defaultUnit);
  isOpen.value = true;
}

const saveUnit = (unit: Unit, isUpdate = false) => {
    isUpdate ? updateUnit(unit) : addUnit(unit);
}

const addUnit = (unit: Unit) => {
  units.value.unshift(clone(unit));
  filteredUnits.value = units.value;
  console.log(filteredUnits.value);
  close();
  successNotification('Accion realizada correctamente', 'El unidades fue creado satisfactoriamente.');
}

const editUnit = (unitToEdit: Unit) => {
  unit.value = clone(unitToEdit);
  isOpen.value = true;
}
 
const updateUnit = (unit: Unit) => {
  units.value = units.value.map(c => c.id === unit.id ? unit : c);
  filteredUnits.value = units.value;
  close();
  successNotification('Accion realizada correctamente', 'El unidades fue actualizado satisfactoriamente.');
}

const deleteUnit = async (unitToDelete: Unit) => {
  if (!await confirmNotification("Estas seguro de realizar esta acción?", "", "Si, eliminar.")) {
    return;
  }
  const { data } = await deleteUnitService(unitToDelete.id);
  if (data.error) {
    errorNotification("Error al eliminar el unidades", data.message);
    return;
  }
  filteredUnits.value = filteredUnits.value.filter(c => { return c.id != unitToDelete.id });
  successNotification("Operación realizada correctamente.", data.message);
}

const close = () => {
  isOpen.value = false;
}

const getUnits = async (params?: ParamsData) => {
  paramsData.value = params ?? paramsData.value;
  loading.value.state = true;
  const { data } = await getUnitsService(paramsData.value);
  units.value = data.data;
  paramsData.value = getParamsData(data, paramsData.value);
  loading.value.state = false;
  filteredUnits.value = clone(units.value);
}

onMounted(() => {
  getUnits();
});
</script>
<template>
  <div class="flex items-center justify-between gap-2 p-2 rounded-md bg-sidebar dark:bg-sidebar-dark">
    <Search :search="getUnits" :paramsData="paramsData" />
    <PrimaryButton @click="newUnit" text="Nueva unidad de medida" icon="plus" />
  </div>
  <Container :loading="loading" :entries="filteredUnits" withoutEntriesMessage="Sin unidades registrados...">
    <table class="w-full text-left">
      <thead>
        <tr>
          <th width="100px">Acciones</th>
          <th width="100px">Código</th>
          <th>Nombre</th>
        </tr>
      </thead>
      <tbody>
        <BodyTr v-for="unit in filteredUnits" :key="unit.code" :id="`unit-${unit.id}`" @dblclick="editUnit(unit)">
          <Actions :actions="[
            { icon: 'edit', onClick: () => { editUnit(unit) } },
            { icon: 'trash', onClick: () => { deleteUnit(unit) } }
          ]" />
          <td>{{ unit.code }}</td>
          <td>{{ unit.name }}</td>
        </BodyTr>
      </tbody>
    </table>
    <template #pagination>
      <Pagination :paramsData="paramsData" :setPage="getUnits" />
    </template>
  </Container>

  <UnitModal :isOpen="isOpen" :unit="unit" :close="close" :onSuccess="saveUnit" />
</template>
