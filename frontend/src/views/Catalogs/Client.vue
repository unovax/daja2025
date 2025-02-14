<script lang="ts" setup>
import PrimaryButton from '@/components/Buttons/PrimaryButton.vue'
import ClientModal from '@/components/Catalogs/ClientModal.vue'
import Search from '@/components/Search.vue'
import Actions from '@/components/Tables/Actions.vue'
import BodyTr from '@/components/Tables/BodyTr.vue'
import Container from '@/components/Tables/Container.vue'
import Pagination from '@/components/Tables/Pagination.vue'
import { deleteClientService, getClientsService } from '@/services/Catalogs/clientService'
import { defaultClient, type Client } from '@/types/Catalogs'
import { defaultParamsData, type Loading, type ParamsData } from '@/types/Commons'
import { clone, getParamsData } from '@/utils/common'
import { confirmNotification, errorNotification, successNotification } from '@/utils/notifications'
import { onMounted, ref } from 'vue'

const clients = ref<Client[]>([]);
const filteredClients = ref<Client[]>(clients.value);
const paramsData = ref<ParamsData>(defaultParamsData);

const loading = ref<Loading>({
  state: false,
  text: 'Obteniendo clientes...'
});

const client = ref<Client>(clone(defaultClient));

const isOpen = ref<boolean>(false);

const newClient = () => {
  client.value = clone(defaultClient);
  isOpen.value = true;
}

const saveClient = (client: Client) => {
  client.id ? updateClient(client) : addClient(client);
}

const addClient = (client: Client) => {
  clients.value.unshift(clone(client));
  filteredClients.value = clients.value;
  close();
  successNotification('Accion realizada correctamente', 'El cliente fue creado satisfactoriamente.');
}

const editClient = (clientToEdit: Client) => {
  client.value = clone(clientToEdit);
  isOpen.value = true;
}
 
const updateClient = (client: Client) => {
  clients.value = clients.value.map(c => c.id === client.id ? client : c);
  filteredClients.value = clients.value;
  close();
  successNotification('Accion realizada correctamente', 'El cliente fue actualizado satisfactoriamente.');
}

const deleteClient = async (clientToDelete: Client) => {
  if (!await confirmNotification("Estas seguro de realizar esta acción?", "", "Si, eliminar.")) {
    return;
  }
  const { data } = await deleteClientService(clientToDelete.id);
  if (data.error) {
    errorNotification("Error al eliminar el cliente", data.message);
    return;
  }
  filteredClients.value = filteredClients.value.filter(c => { return c.id != clientToDelete.id });
  successNotification("Operación realizada correctamente.", data.message);
}

const close = () => {
  isOpen.value = false;
}

const getClients = async (params?: ParamsData) => {
  paramsData.value = params ?? paramsData.value;
  loading.value.state = true;
  const { data } = await getClientsService(paramsData.value);
  clients.value = data.data;
  paramsData.value = getParamsData(data, paramsData.value);
  loading.value.state = false;
  filteredClients.value = clone(clients.value);
}

onMounted(() => {
  getClients();
});
</script>
<template>
  <div class="flex items-center justify-between gap-2 p-2 rounded-md bg-sidebar dark:bg-sidebar-dark">
    <Search :search="getClients" :paramsData="paramsData" />
    <PrimaryButton @click="newClient" text="Nuevo cliente" icon="plus" />
  </div>
  <Container :loading="loading" :entries="filteredClients" withoutEntriesMessage="Sin clientes registrados...">
    <table class="w-full text-left">
      <thead>
        <tr>
          <th width="100px">Acciones</th>
          <th width="100px">Código</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Correo electronico</th>
          <th>Telefono</th>
        </tr>
      </thead>
      <tbody>
        <BodyTr v-for="client in filteredClients" :key="client.code" :id="`client-${client.id}`" @dblclick="editClient(client)">
          <Actions :actions="[
            { icon: 'edit', onClick: () => { editClient(client) } },
            { icon: 'trash', onClick: () => { deleteClient(client) } }
          ]" />
          <td>{{ client.code }}</td>
          <td>{{ client.name }}</td>
          <td>{{ client.lastname }}</td>
          <td>{{ client.email }}</td>
          <td>{{ client.phone }}</td>
        </BodyTr>
      </tbody>
    </table>
    <template #pagination>
      <Pagination :paramsData="paramsData" :setPage="getClients" />
    </template>
  </Container>

  <ClientModal :isOpen="isOpen" :client="client" :close="close" :onSuccess="saveClient" />
</template>
