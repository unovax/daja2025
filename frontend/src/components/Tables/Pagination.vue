<script setup lang="ts">
import { computed, ref, watch } from "vue";
import PrimaryButton from "../Buttons/PrimaryButton.vue";
import type { ParamsData } from "@/types/Commons";
import { set } from "@/utils/common";

const props = defineProps<{
  paramsData: ParamsData
  setPage: (params: ParamsData) => void
}>();

const emit = defineEmits(["pageChange"]);
const perPage = ref<number>(props.paramsData.per_page);

const changePage = (page: number) => {
  console.log(props.paramsData);
  if (page >= 1 && page <= props.paramsData.last_page) {
    props.setPage({
      ...props.paramsData,
      page: page
    })
  }
};

const changePerPage = () => {
  set('perPage', perPage.value);
  props.setPage({
    ...props.paramsData,
    per_page: perPage.value,
    page: 1
  })
}

const pages = computed(() => {
  const range = [];
  for (let i = 1; i <= props.paramsData.last_page; i++) {
    range.push(i);
  }
  return range;
});

</script>

<template>
  <div class="flex flex-col items-center justify-between gap-2 md:flex-row">
    <div class="flex items-center gap-2">
      <select class="px-4 py-2 rounded-md bg-sidebar dark:bg-sidebar-dark" v-model="perPage" @change="changePerPage()">
        <option value="10">10</option>
        <option value="50">50</option>
        <option value="100">100</option>
        <option value="200">200</option>
      </select>
      <span class="text-xs">Mostrando {{ paramsData.from ?? 0 }} al {{ paramsData.to ?? 0 }} de {{ paramsData.total ?? 0 }}</span>
    </div>
    <div class="flex flex-wrap space-x-2">
      <button
        class="flex items-center justify-center px-4 py-2 border rounded-md bg-sidebar text-primary dark:bg-sidebar-dark dark:text-sidebar disabled:bg-sidebar-hover dark:disabled:bg-sidebar-dark-hover border-sidebar dark:border-sidebar-dark"
        @click="changePage(1)" :disabled="paramsData.page === 1">
        <font-awesome-icon icon="angles-left" />
      </button>
      <button
        class="flex items-center justify-center px-4 py-2 border rounded-md bg-sidebar text-primary dark:bg-sidebar-dark dark:text-sidebar disabled:bg-sidebar-hover dark:disabled:bg-sidebar-dark-hover border-sidebar dark:border-sidebar-dark"
        @click="changePage(paramsData.page - 1)" :disabled="paramsData.page === 1">
        <font-awesome-icon icon="chevron-left" />
      </button>
      <button
        v-for="page in pages.filter(page => Math.abs(page - paramsData.page) <= 1)" :key="page"
        :text="page.toString()" @click="changePage(page)" :class="[
          'px-3 py-2 rounded-md border dark:border-sidebar-dark',
          page === paramsData.page
            ? 'bg-primary text-sidebar'
            : 'bg-sidebar text-primary dark:bg-sidebar-dark dark:text-sidebar',
        ]"
        class="flex items-center justify-center px-4 py-2 rounded-md">
        {{ page }}
      </button>
      <button
        class="flex items-center justify-center px-4 py-2 rounded-md bg-sidebar text-primary dark:bg-sidebar-dark dark:text-sidebar disabled:bg-sidebar-hover dark:disabled:bg-sidebar-dark-hover border-sidebar dark:border-sidebar-dark"
        @click="changePage(paramsData.page + 1)" :disabled="paramsData.page === paramsData.last_page">
        <font-awesome-icon icon="chevron-right" />
      </button>
      <button
        class="flex items-center justify-center px-4 py-2 border rounded-md bg-sidebar text-primary dark:bg-sidebar-dark dark:text-sidebar disabled:bg-sidebar-hover dark:disabled:bg-sidebar-dark-hover border-sidebar dark:border-sidebar-dark"
        @click="changePage(paramsData.last_page)" :disabled="paramsData.page === paramsData.last_page">
        <font-awesome-icon icon="angles-right" />
      </button>
    </div>
  </div>
</template>
