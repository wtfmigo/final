<template>
  <div class="max-w-full overflow-x-auto custom-scrollbar">
    <div id="chartOne" class="-ml-5 min-w-[650px] xl:min-w-full pl-2">
      <VueApexCharts type="bar" height="300" :options="chartOptions" :series="series" />
    </div>
  </div>
</template>

<script setup>
import { ref, watch, defineProps } from 'vue'
import VueApexCharts from 'vue3-apexcharts'

// Props from Dashboard.vue
const props = defineProps({
  incomes: { type: Array, default: () => [] },
  expenses: { type: Array, default: () => [] }
})

// Helper: group records by month
function groupByMonth(records) {
  const monthly = Array(12).fill(0)
  records.forEach(r => {
    const month = new Date(r.date).getMonth()
    monthly[month] += Number(r.amount)
  })
  return monthly
}

const series = ref([
  { name: 'Income', data: [] },
  { name: 'Expenses', data: [] }
])

const chartOptions = ref({
  colors: ['#10b981', '#dc2626'], // green for income, red for expenses
  chart: {
    fontFamily: 'Poppins, sans-serif',
    type: 'bar',
    toolbar: { show: false },
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '39%',
      borderRadius: 5,
      borderRadiusApplication: 'end',
    },
  },
  dataLabels: { enabled: false },
  stroke: { show: true, width: 2, colors: ['transparent'] },
  xaxis: {
    categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    axisBorder: { show: false },
    axisTicks: { show: false },
  },
  legend: {
    show: true,
    position: 'top',
    horizontalAlign: 'left',
    fontFamily: 'Poppins',
    markers: {
      width: 12,
      height: 12,
      radius: 6,
    },
  },
  yaxis: { title: false },
  grid: { yaxis: { lines: { show: true } } },
  fill: { opacity: 1 },
  tooltip: {
    y: { formatter: val => `₱${val.toLocaleString()}` }
  },
})

// Watch for changes in props and update chart
watch(() => [props.incomes, props.expenses], () => {
  series.value[0].data = groupByMonth(props.incomes)
  series.value[1].data = groupByMonth(props.expenses)
}, { deep: true, immediate: true })
</script>

<style>
.apexcharts-legend-text {
  font-weight: 600 !important;
}
.apexcharts-legend-marker {
  border-radius: 50% !important;
}
</style>
