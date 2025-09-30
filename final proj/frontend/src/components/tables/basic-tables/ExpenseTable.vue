<template>
  <div
    class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
  >
    <div class="max-w-full overflow-x-auto custom-scrollbar">
      <table class="min-w-full">
        <thead>
          <tr class="border-b border-gray-200 dark:border-gray-700">
            <th class="px-5 py-3 text-left w-3/11 sm:px-6">
              <p class="font-bold text-gray-500 text-theme-xs dark:text-gray-400">Source</p>
            </th>
            <th class="px-5 py-3 text-left w-3/11 sm:px-6">
              <p class="font-bold text-gray-500 text-theme-xs dark:text-gray-400">Amount</p>
            </th>
            <th class="px-5 py-3 text-left w-3/11 sm:px-6">
              <p class="font-bold text-gray-500 text-theme-xs dark:text-gray-400">Date</p>
            </th>
            <th class="px-5 py-3 text-left w-2/11 sm:px-6">
              <p class="font-bold text-gray-500 text-theme-xs dark:text-gray-400">Actions</p>
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
          <tr
            v-for="expense in props.expenses"
            :key="expense.id"
            class="border-t border-gray-100 dark:border-gray-800"
          >
            <td class="px-5 py-4 sm:px-6">
              <p class="text-gray-800 text-theme-sm dark:text-white/90">{{ expense.source }}</p>
            </td>
            <td class="px-5 py-4 sm:px-6">
              <p class="font-bold text-red-600 text-theme-sm">
                -₱{{ expense.amount }}
              </p>
            </td>
            <td class="px-5 py-4 sm:px-6">
              <span class="text-gray-500 text-theme-sm dark:text-gray-400">{{ expense.date }}</span>
            </td>
            <td class="px-5 py-4 sm:px-6">
              <TrashIcon @click="emit('delete', expense.id)" class="w-5 h-5 text-red-600 cursor-pointer hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'
import { TrashIcon } from '@/icons'

const emit = defineEmits(['delete'])

const props = defineProps({
  expenses: {
    type: Array,
    required: true
  }
})
</script>

<style scoped>

</style>
