<template>
  <div
    class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
  >
    <div class="max-w-full overflow-x-auto custom-scrollbar">
      <table class="min-w-full">
        <thead>
          <tr class="border-b border-gray-200 dark:border-gray-700">
            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
              <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Date</p>
            </th>
            <th class="px-5 py-3 text-left w-3/11 sm:px-6">
              <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Description</p>
            </th>
            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
              <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Category</p>
            </th>
            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
              <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Amount</p>
            </th>
            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
              <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Type</p>
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
          <tr
            v-for="(transaction, index) in recentTransactions"
            :key="index"
            class="border-t border-gray-100 dark:border-gray-800"
          >
            <td class="px-5 py-4 sm:px-6">
              <p class="text-gray-800 text-theme-sm dark:text-white/90">{{ transaction.date }}</p>
            </td>
            <td class="px-5 py-4 sm:px-6">
              <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                {{ transaction.description || transaction.source }}
              </p>
            </td>
            <td class="px-5 py-4 sm:px-6">
              <span class="text-gray-500 text-theme-sm dark:text-gray-400">
                {{ transaction.category || (transaction.type === 'Income' ? 'Income' : 'Expense') }}
              </span>
            </td>
            <td class="px-5 py-4 sm:px-6">
              <p :class="['font-medium text-theme-sm', transaction.type === 'Income' ? 'text-green-600' : 'text-red-600']">
                {{ transaction.type === 'Income' ? '+' : '-' }}₱{{ Number(transaction.amount).toLocaleString() }}
              </p>
            </td>
            <td class="px-5 py-4 sm:px-6">
              <span
                :class="[
                  'rounded-full px-2 py-0.5 text-theme-xs font-bold',
                  {
                    'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500':
                      transaction.type === 'Income',
                    'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-500':
                      transaction.type === 'Expense',
                  },
                ]"
              >
                {{ transaction.type }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

// ✅ Accept incomes and expenses from Dashboard.vue
const props = defineProps({
  incomes: { type: Array, default: () => [] },
  expenses: { type: Array, default: () => [] }
})

// ✅ Merge and sort by date (latest first)
const recentTransactions = computed(() => {
  const incomeTx = props.incomes.map(i => ({
    ...i,
    type: 'Income',
    description: i.source, // map "source" to description
    category: 'Income'
  }))
  const expenseTx = props.expenses.map(e => ({
    ...e,
    type: 'Expense',
    description: e.source, // map "source" to description
    category: 'Expense'
  }))
  return [...incomeTx, ...expenseTx].sort((a, b) => new Date(b.date) - new Date(a.date))
})
</script>
