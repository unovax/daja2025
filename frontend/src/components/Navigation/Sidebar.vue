<script lang="ts" setup>
import { ref } from 'vue'
import SidebarDropdown from './SidebarDropdown.vue'
import SidebarLink from './SidebarLink.vue'
import { useSidebar } from '@/stores/useSidebar'
import { storeToRefs } from 'pinia'
import SidebarButton from './SidebarButton.vue'

const appName = import.meta.env.VITE_APP_NAME

const links = [
  {
    title: 'Tablero',
    icon: 'chart-simple',
    to: '/dashboard'
  },
  {
    title: 'Catalogos',
    sublinks: [
      {
        title: 'Clientes',
        icon: 'user-group',
        to: '/catalogos/clientes'
      },
      {
        title: 'Unidades',
        icon: 'ruler-horizontal',
        to: '/catalogos/unidades'
      },
    ]
  },
  {
    title: 'Trabajos',
    icon: 'list',
    to: '/trabajos'
  },
  {
    title: 'Reportes',
    sublinks: [
      {
        title: 'Inventario por categorias',
        icon: 'file-lines',
        to: '/catalogos/clientes'
      },
      {
        title: 'Inventario por productos',
        icon: 'file-lines',
        to: '/catalogos/clientes'
      }
    ]
  }
]

const { sidebarOpen } = storeToRefs(useSidebar());

</script>
<template>
  <nav
    :class="[sidebarOpen ? 'w-full md:max-w-[250px]' : 'w-0 md:w-[60px] md:max-w-[60px] overflow-x-hidden']"
    class="absolute z-[1000] transition-all border-r shadow-xl bg-sidebar dark:bg-sidebar-dark border-sidebar-border dark:border-sidebar-border-dark md:relative h-full"
  >
    <h1
        :class="[sidebarOpen ? 'justify-between' : 'justify-center']"
      class="flex items-center w-full gap-2 px-4 py-2 font-sans text-lg font-bold text-center text-black border-b border-light-50 dark:border-dark-50 dark:text-white"
    >
      <span v-if="sidebarOpen">{{ appName }}</span>
      <SidebarButton/>
    </h1>
    <ul>
      <template v-for="link in links" :key="link.title">
        <SidebarDropdown
          v-if="link.sublinks"
          :title="link.title"
          :count="link.sublinks.length"
        >
          <SidebarLink
            :icon="sublink.icon"
            :title="sublink.title"
            :to="sublink.to"
            v-for="sublink in link.sublinks"
          />
        </SidebarDropdown>
        <SidebarLink
          v-else
          :icon="link.icon"
          :title="link.title"
          :to="link.to"
        />
        <hr class="border-light-50 dark:border-dark-50">
      </template>
    </ul>
  </nav>
</template>
