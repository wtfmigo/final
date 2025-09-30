<template>
  <div class="max-w-full overflow-x-auto custom-scrollbar">
    <div id="expenseChart" class="-ml-5 min-w-[650px] xl:min-w-full pl-2">
      <VueApexCharts type="bar" height="180" :options="chartOptions" :series="series" />
    </div>
  </div>
</template>

<script setup>
import { ref, watch, defineProps } from 'vue'
import VueApexCharts from 'vue3-apexcharts'

// ✅ Accept expenses from parent (Expense.vue or Dashboard.vue)
const props = defineProps({
  expenses: { type: Array, default: () => [] }
})

// Helper: group expenses by month
function groupByMonth(records) {
  const monthly = Array(12).fill(0)
  records.forEach(r => {
    const month = new Date(r.date).getMonth() // 0 = Jan
    monthly[month] += Number(r.amount)
  })
  return monthly
}

const series = ref([
  { name: 'Expenses', data: [] }
])

const chartOptions = ref({
  colors: ['#dc2626'], // red for expenses
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

// ✅ Watch for changes in expenses and update chart
watch(() => props.expenses, (newVal) => {
  series.value[0].data = groupByMonth(newVal)
}, { deep: true, immediate: true })
</script>
