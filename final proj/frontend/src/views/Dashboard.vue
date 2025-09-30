<template>
  <admin-layout>
    <div class="grid grid-cols-12 gap-4 md:gap-6">
      <div class="col-span-12">
        <h1 class="text-2xl font-bold mb-4 dark:text-white">Financial Management Dashboard</h1>
      </div>

      <!-- Key Financial Metrics -->
      <div class="col-span-12 md:col-span-4">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold text-gray-500 mb-2">Total Income</h3>
          <p class="text-2xl font-bold dark:text-white">₱{{ totalIncome.toLocaleString() }}</p>
        </div>
      </div>
      <div class="col-span-12 md:col-span-4">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold text-gray-500 mb-2">Total Expenses</h3>
          <p class="text-2xl font-bold dark:text-white">₱{{ totalExpenses.toLocaleString() }}</p>
        </div>
      </div>
      <div class="col-span-12 md:col-span-4">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold text-gray-500 mb-2">Balance</h3>
          <p class="text-2xl font-bold dark:text-white">₱{{ balance.toLocaleString() }}</p>
        </div>
      </div>

      <!-- Charts -->
      <div class="col-span-12">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold mb-4 dark:text-white">Income & Expenses</h3>
          <bar-chart-one :incomes="incomes" :expenses="expenses" />
        </div>
      </div>

      <!-- Transactions Table -->
      <div class="col-span-12">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold mb-4 dark:text-white">Recent Transactions</h3>
          <basic-table-one :incomes="incomes" :expenses="expenses" />
        </div>
      </div>
    </div>
  </admin-layout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import AdminLayout from '../components/layout/AdminLayout.vue'
import BarChartOne from '../components/charts/BarChart/BarChartOne.vue'
import BasicTableOne from '../components/tables/basic-tables/BasicTableOne.vue'

const incomes = ref([])
const expenses = ref([])

// Totals
const totalIncome = computed(() =>
  incomes.value.reduce((sum, i) => sum + Number(i.amount), 0)
)
const totalExpenses = computed(() =>
  expenses.value.reduce((sum, e) => sum + Number(e.amount), 0)
)
const balance = computed(() => totalIncome.value - totalExpenses.value)

// Fetch data from backend
const fetchData = async () => {
  try {
    const [incomeRes, expenseRes] = await Promise.all([
      axios.get('http://localhost:8000/api/incomes'),
      axios.get('http://localhost:8000/api/expenses'),
    ])
    incomes.value = incomeRes.data
    expenses.value = expenseRes.data
  } catch (error) {
    console.error('Failed to load dashboard data', error)
  }
}

onMounted(fetchData)
</script>
