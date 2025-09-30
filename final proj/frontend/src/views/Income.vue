<template>
  <div>
    <AdminLayout>
      <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12">
          <h1 class="text-2xl font-bold mb-4 dark:text-white">Income Management</h1>
        </div>

        <!-- Income Bar Chart -->
        <div class="col-span-12">
          <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4 dark:text-white">Income Overview</h3>
            <p class="text-sm text-gray-500">Track your earnings over time and analyze income trends</p>
            <IncomeBarChart :incomes="incomes" />
          </div>
        </div>

        <!-- Income Sources Table -->
        <div class="col-span-12">
          <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-semibold dark:text-white">Income Sources</h3>
              <button @click="isModalOpen = true"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-bold flex items-center gap-2">
                <PlusIcon />
                Add Income
              </button>
            </div>
            <IncomeTable :incomes="incomes" @delete="deleteIncome" />
          </div>
        </div>
      </div>
    </AdminLayout>

    <!-- Add Income Modal -->
    <Modal v-if="isModalOpen" @close="isModalOpen = false" fullScreenBackdrop="true" placement="center"
      :visible="isModalOpen">
      <template #body>
        <div class="h-full flex flex-col p-6 overflow-y-auto">
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
              <BoxIcon class="w-6 h-6 text-green-600 mr-3" />
              <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Add Income</h2>
            </div>
            <button @click="isModalOpen = false"
              class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
          <p class="text-gray-600 dark:text-gray-400 mb-6">
            Enter the details of your income source to track your earnings.
          </p>
          <form @submit.prevent="addIncome" class="space-y-6 flex-1">
            <div>
              <label class="block text-sm font-semibold mb-2 dark:text-white">Income Source</label>
              <div class="relative">
                <BoxIcon class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
              <input v-model="incomeSource" type="text" placeholder="Work, Freelance, Salary, etc" required
                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400" />
              </div>
            </div>
            <div>
              <label class="block text-sm font-semibold mb-2 dark:text-white">Amount</label>
              <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">₱</span>
                <input v-model="amount" type="number" step="0.01" placeholder="0.00" required
                 class="block w-full pl-8 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400" />
            </div>
            </div>
            <div>
            <label class="block text-sm font-semibold mb-2 dark:text-white">Date</label>
              <div class="relative">
                <Calendar2Line class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                <input v-model="selectedDate" type="date" required
                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
              </div>
            </div>
            <div class="flex w-full justify-center space-x-3 pt-4 mt-auto">
              <button type="button" @click="isModalOpen = false"
                class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-bold">
                Cancel
              </button>
              <button type="submit" :disabled="!incomeSource || !amount || !selectedDate"
                 class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200 flex items-center gap-2">
                <PlusIcon class="w-4 h-4" />
                Add Income
              </button>
            </div>
          </form>
        </div>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import AdminLayout from '@/components/layout/AdminLayout.vue'
import IncomeBarChart from '@/components/charts/BarChart/IncomeBarChart.vue'
import IncomeTable from '@/components/tables/basic-tables/IncomeTable.vue'
import PlusIcon from '@/icons/PlusIcon.vue'
import Calendar2Line from '@/icons/Calendar2Line.vue'
import Modal from '@/components/ui/Modal.vue'
import BoxIcon from '@/icons/BoxIcon.vue'
import Swal from 'sweetalert2'

const incomes = ref([])

const isModalOpen = ref(false)
const incomeSource = ref('')
const amount = ref('')
const selectedDate = ref('')

// Fetch incomes from backend
const fetchIncomes = async () => {
  try {
    const { data } = await axios.get('http://localhost:8000/api/incomes')
    incomes.value = data
  } catch (error) {
    console.error(error)
    Swal.fire('Error', 'Failed to load incomes', 'error')
  }
}

// Add income to backend
const addIncome = async () => {
  try {
    const { data } = await axios.post('http://localhost:8000/api/incomes', {
      source: incomeSource.value,
      amount: amount.value,
      date: selectedDate.value,
    })
    incomes.value.push(data)
    Swal.fire('Success!', 'Income added successfully!', 'success')
    // reset form
    incomeSource.value = ''
    amount.value = ''
    selectedDate.value = ''
    isModalOpen.value = false
  } catch (error) {
    console.error(error)
    Swal.fire('Error', 'Failed to add income', 'error')
  }
}

// Delete income from backend
const deleteIncome = async (id) => {
  Swal.fire({
    title: 'Are you sure?',
    text: "This will permanently remove the entry.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        await axios.delete(`http://localhost:8000/api/incomes/${id}`)
        incomes.value = incomes.value.filter(inc => inc.id !== id)
        Swal.fire('Deleted!', 'Income has been deleted.', 'success')
      } catch (error) {
        console.error(error)
        Swal.fire('Error', 'Failed to delete income', 'error')
      }
    }
  })
}

onMounted(fetchIncomes)
</script>
