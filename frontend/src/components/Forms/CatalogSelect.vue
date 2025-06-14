<script lang="ts" setup>
import { getCatalogService } from '@/services/Catalogs/catalogService';
import type { ErrorObject } from '@vuelidate/core'
import { onMounted, ref } from 'vue';
import Input from './Input.vue';
import { OnClickOutside } from '@vueuse/components'
import { clone } from '@/utils/common';

const props = defineProps<{
  label?: string
  error?: ErrorObject,
  value?: string,
  catalog: string,
  placeholder?: string,
  icon?: string
}>()

interface Entry {
  id: string,
  code: string,
  name: string,
}

const model = defineModel()
const entries = ref<Entry[]>();
const filteredEntries = ref<Entry[]>();

const isOpen = ref<boolean>(false);
const hasSelectedEntry = ref<boolean>(false);
const selectedEntry = ref<string | null>(null);

const setEntry = (id: string, name: string) => {
  isOpen.value = false;
  selectedEntry.value = name;
  model.value = id;
  hasSelectedEntry.value = true;
}

const unsetEntry = () => {
  isOpen.value = true;
  selectedEntry.value = null;
  model.value = null;
  hasSelectedEntry.value = false;
  filteredEntries.value = clone(entries.value);
  setTimeout(() => {
    document.getElementById('client-selector')?.focus();
  }, 100);
}

const open = () => {
  if (selectedEntry.value != null) return;
  isOpen.value = true;
}
const close = () => {
  isOpen.value = false;
}

onMounted(async () => {
  const { data } = await getCatalogService(props.catalog);
  entries.value = data.data;
  filteredEntries.value = clone(entries.value);
})

const search = () => {
  filteredEntries.value = clone(entries.value) ?? [];

  if (!selectedEntry?.value) return;

  const searchTerm = selectedEntry.value?.toLowerCase() ?? "";

  if (!filteredEntries.value) return;

  filteredEntries.value = filteredEntries.value.filter(entry => {
    const searchString = (entry?.code?.toLowerCase() + ' - ' + entry?.name?.toLowerCase());
    return (
      searchString.includes(searchTerm.toLowerCase()) || 
      entry?.code?.toLowerCase().includes(searchTerm.toLowerCase()) || 
      entry?.name?.toLowerCase().includes(searchTerm.toLowerCase())
    );
  });


  isOpen.value = true;
};



</script>
<template>

  <div class="relative">
    <Input cantAutocomplete id="client-selector" :disabled="hasSelectedEntry" @click="open" @input="search" v-model="selectedEntry"
      :icon="icon" :placeholder="placeholder" :label="label" :canClear="selectedEntry != null" :clear="unsetEntry" :error="error"/>
    <OnClickOutside v-if="isOpen" @trigger="close"
      class="absolute max-h-[500px] overflow-auto overflow-x-hidden bg-sidebar dark:bg-sidebar-dark w-full rounded-md shadow z-10">
      <div @click="setEntry(entry.id, entry.code + ' - ' + entry.name)"
        class="px-2 py-1 cursor-pointer hover:bg-sidebar-hover" v-for="entry in filteredEntries" :key="entry.id"
        :value="entry.id">{{ entry.code + ' - ' + entry.name }}
      </div>

    </OnClickOutside>
  </div>
</template>
