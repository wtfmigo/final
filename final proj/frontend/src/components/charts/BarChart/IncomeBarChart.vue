<template>
  <div class="max-w-full overflow-x-auto custom-scrollbar">
    <div id="incomeChart" class="-ml-5 min-w-[650px] xl:min-w-full pl-2">
      <VueApexCharts type="bar" height="180" :options="chartOptions" :series="series" />
    </div>
  </div>
</template>

<script setup>
import { ref, watch, defineProps } from 'vue'
import VueApexCharts from 'vue3-apexcharts'

// ✅ Accept incomes from parent
const props = defineProps({
  incomes: { type: Array, default: () => [] }
})

// Helper: group income by month
function groupByMonth(records) {
  const monthly = Array(12).fill(0)
  records.forEach(r => {
    const month = new Date(r.date).getMonth() // 0 = Jan
    monthly[month] += Number(r.amount)
  })
  return monthly
}

const series = ref([
  { name: 'Income', data: [] }
])

const chartOptions = ref({
  colors: ['#10b981'],
  chart: {
    fontFamily: 'Outfit, sans-serif',
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
  stroke: { show: true, width: 4, colors: ['transparent'] },
  xaxis: {
    categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    axisBorder: { show: false },
    axisTicks: { show: false },
  },
  legend: {
    show: true,
    position: 'top',
    horizontalAlign: 'left',
    fontFamily: 'Outfit',
    markers: { radius: 99 },
  },
  yaxis: { title: false },
  grid: { yaxis: { lines: { show: true } } },
  fill: { opacity: 1 },
  tooltip: {
    y: {
      formatter: val => `₱${val.toLocaleString()}`
    }
  },
})

// ✅ Watch for changes in incomes and update chart
watch(() => props.incomes, (newVal) => {
  series.value[0].data = groupByMonth(newVal)
}, { deep: true, immediate: true })
</script>
