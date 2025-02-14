<script lang="ts" setup>
import { ref } from 'vue'
import VueApexCharts from 'vue3-apexcharts'

interface Serie {
    name: string,
    data: Array<string|number>
};

const props = defineProps<{
    categories: Array<string>
    series: Array<Serie>
}>();

const chartOptions = ref({
  chart: { type: 'line' },
  xaxis: { categories: props.categories }
})
</script>

<template>
  <VueApexCharts :type="chartOptions.chart.type" :options="chartOptions" :series="series" />
</template>
