<template>
  <admin-layout>
    <div class="grid grid-cols-12 gap-4 md:gap-6">
      <div class="col-span-12">
        <div class="flex items-center justify-between">
          <h1 class="text-2xl font-bold mb-4 dark:text-white">Invoices Section</h1>
          <button @click="$router.push('/invoices/create')" 
                  class="flex items-center bg-blue-600 text-white font-bold px-3 py-2 rounded-lg hover:bg-blue-700">
            <PlusIcon class="w-3 h-3 mr-2" />
            Create Invoice
          </button>
        </div>
      </div>

      <!-- Overview Metrics -->
      <div class="col-span-12 md:col-span-3">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold mb-2 text-gray-500 ">Due</h3>
          <p class="text-2xl font-bold dark:text-white ">₱{{ dueAmount.toLocaleString() }}</p>
          <p class="text-sm text-gray-500">{{ dueCount }} invoices</p>
        </div>
      </div>

      <div class="col-span-12 md:col-span-3">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold mb-2 text-gray-500 ">Paid</h3>
          <p class="text-2xl font-bold dark:text-white">₱{{ paidAmount.toLocaleString() }}</p>
          <p class="text-sm text-gray-500 ">{{ paidCount }} invoices</p>
        </div>
      </div>

      <div class="col-span-12 md:col-span-3">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold mb-2 text-gray-500 ">Overdue</h3>
          <p class="text-2xl font-bold dark:text-white">₱{{ overdueAmount.toLocaleString() }}</p>
          <p class="text-sm text-gray-500 ">{{ overdueCount }} invoices</p>
        </div>
      </div>

      <div class="col-span-12 md:col-span-3">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold mb-2 text-gray-500 ">Total</h3>
          <p class="text-2xl font-bold dark:text-white">₱{{ totalAmount.toLocaleString() }}</p>
          <p class="text-sm text-gray-500">{{ filteredInvoices.length }} invoices</p>
        </div>
      </div>

      <!-- Invoices Table -->
      <div class="col-span-12">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
          <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
              <h3 class="text-lg font-semibold dark:text-white">Invoices</h3>
              
              <div class="flex items-center gap-2 md:gap-4">
                <!-- Status Filter Buttons -->
                <div class="flex space-x-2">
                  <button 
                    v-for="status in ['all', 'unpaid', 'draft']" 
                    :key="status"
                    @click="setFilterStatus(status)"
                    :class="[
                      'px-4 py-2 rounded-md text-sm font-semibold',
                      filterStatus === status 
                        ? 'bg-blue-600 text-white' 
                        : 'bg-gray-200 text-gray-500 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600'
                    ]"
                  >
                    {{ status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ') }}
                  </button>
                </div>

                <!-- Search Input -->
                <input 
                  v-model="searchTerm" 
                  type="text"
                  placeholder="Search invoices..." 
                  class="flex-1 max-w-md px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <!-- Filter Button with Dropdown -->
                <div class="relative">
                  <button 
                    @click="toggleDateFilter"
                    class="flex items-center px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 hover:bg-gray-50 dark:hover:bg-gray-600"
                  >
                    <span class="text-sm text-gray-500 font-bold">Filter</span>
                    <ChevronDownIcon :class="showDateFilter ? 'rotate-180' : ''" class="w-4 h-4 ml-1 transition-transform duration-200" />
                  </button>
                  <div 
                    v-if="showDateFilter" 
                    class="absolute right-0 mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg p-3 z-10 min-w-[220px]"
                  >
                    <div class="flex items-center gap-2">
                      <input 
                        type="date" 
                        v-model="dateFrom" 
                        class="flex-1 px-2 py-1 border border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                      />
                      <span class="text-gray-500 font-semibold dark:text-gray-400 text-sm min-w-[20px] text-center">to</span>
                      <input 
                        type="date" 
                        v-model="dateTo" 
                        class="flex-1 px-2 py-1 border border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                      />
                    </div>
                  </div>
                </div>

                <!-- Export Button -->
                <button 
                  @click="exportToCSV"
                  class="flex items-center px-3 py-2 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold"
                >
                  <SendIcon class="w-4 h-4 mr-2" />
                  Export
                </button>
              </div>
            </div>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full">
              <thead class="bg-white dark:bg-gray-800 border-0 border-b-1 dark:border-gray-700">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-bold text-gray-500">Invoice #</th>
                  <th class="px-6 py-3 text-left text-xs font-bold text-gray-500">Client</th>
                  <th class="px-6 py-3 text-left text-xs font-bold text-gray-500">Issue Date</th>
                  <th class="px-6 py-3 text-left text-xs font-bold text-gray-500">Due Date</th>
                  <th class="px-6 py-3 text-left text-xs font-bold text-gray-500">Amount</th>
                  <th class="px-6 py-3 text-left text-xs font-bold text-gray-500">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-bold text-gray-500">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr v-for="invoice in filteredInvoices" :key="invoice.id">
                  <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                    {{ invoice.invoice_number }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                    {{ invoice.client_name }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                    {{ invoice.invoice_date }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                    {{ invoice.due_date }}
                  </td>
                  <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                    ₱{{ Number(invoice.total).toLocaleString() }}
                  </td>
                  <td class="px-6 py-4">
                    <span :class="[
                      'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                      invoice.status === 'Paid' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' :
                      invoice.status === 'Pending' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' :
                      invoice.status === 'Draft' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' :
                      'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                    ]">
                      {{ invoice.status }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <TrashIcon @click="deleteInvoice(invoice.id)" 
                               class="w-5 h-5 text-red-600 cursor-pointer hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </admin-layout>
</template>

<script>
import AdminLayout from '../components/layout/AdminLayout.vue'
import { TrashIcon, ChevronDownIcon, SendIcon, PlusIcon } from '@/icons'
import Swal from 'sweetalert2'
import axios from 'axios'

export default {
  components: { AdminLayout, TrashIcon, ChevronDownIcon, SendIcon, PlusIcon },
  name: 'Invoices',
  data() {
    return {
      invoices: [],  // start empty, fill from backend
      filterStatus: 'all',
      searchTerm: '',
      dateFrom: '',
      dateTo: '',
      showDateFilter: false
    }
  },
  computed: {
    paidAmount() {
      return this.filteredInvoices
        .filter(i => i.status === 'Paid')
        .reduce((sum, i) => sum + Number(i.total), 0)
    },
    paidCount() {
      return this.filteredInvoices.filter(i => i.status === 'Paid').length
    },
    dueAmount() {
      return this.filteredInvoices
        .filter(i => i.status === 'Pending')
        .reduce((sum, i) => sum + Number(i.total), 0)
    },
    dueCount() {
      return this.filteredInvoices.filter(i => i.status === 'Pending').length
    },
    overdueAmount() {
      return this.filteredInvoices
        .filter(i => i.status === 'Overdue')
        .reduce((sum, i) => sum + Number(i.total), 0)
    },
    overdueCount() {
      return this.filteredInvoices.filter(i => i.status === 'Overdue').length
    },
    totalAmount() {
      return this.filteredInvoices.reduce((sum, i) => sum + Number(i.total), 0)
    },
    filteredInvoices() {
      let filtered = [...this.invoices]; // Copy to avoid mutating original

      // Status filter
      if (this.filterStatus === 'unpaid') {
        filtered = filtered.filter(i => i.status !== 'Paid');
      } else if (this.filterStatus === 'draft') {
        filtered = filtered.filter(i => i.status === 'Draft');
      }
      // 'all' does nothing

      // Search filter
      if (this.searchTerm) {
        const term = this.searchTerm.toLowerCase();
        filtered = filtered.filter(i =>
          i.invoice_number.toLowerCase().includes(term) ||
          i.client_name.toLowerCase().includes(term)
        );
      }

      // Date filter on due_date
      if (this.dateFrom) {
        filtered = filtered.filter(i => new Date(i.due_date) >= new Date(this.dateFrom));
      }
      if (this.dateTo) {
        filtered = filtered.filter(i => new Date(i.due_date) <= new Date(this.dateTo));
      }

      // Sort by invoice_date desc
      return filtered.sort((a, b) => new Date(b.invoice_date) - new Date(a.invoice_date));
    }
  },
  methods: {
    async fetchInvoices() {
      try {
        const { data } = await axios.get('http://localhost:8000/api/invoices')
        this.invoices = data
      } catch (error) {
        console.error(error)
        Swal.fire('Error', 'Failed to load invoices', 'error')
      }
    },
    setFilterStatus(status) {
      this.filterStatus = status;
      this.searchTerm = '';
      this.dateFrom = '';
      this.dateTo = '';
    },
    clearDateFilters() {
      this.dateFrom = '';
      this.dateTo = '';
    },
    toggleDateFilter() {
      this.showDateFilter = !this.showDateFilter;
    },
    exportToCSV() {
      const headers = ['Invoice #', 'Client', 'Issue Date', 'Due Date', 'Amount', 'Status'];
      const csvContent = [
        headers.join(','),
        ...this.filteredInvoices.map(invoice => [
          invoice.invoice_number,
          invoice.client_name,
          invoice.invoice_date,
          invoice.due_date,
          invoice.total,
          invoice.status
        ].join(','))
      ].join('\n');

      const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
      const link = document.createElement('a');
      const url = URL.createObjectURL(blob);
      link.setAttribute('href', url);
      link.setAttribute('download', 'invoices.csv');
      link.style.visibility = 'hidden';
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
      URL.revokeObjectURL(url);
    },
    async deleteInvoice(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently remove the invoice.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then(async (result) => {
        if (result.isConfirmed) {
          try {
            await axios.delete(`http://localhost:8000/api/invoices/${id}`)
            this.invoices = this.invoices.filter(inv => inv.id !== id)
            Swal.fire('Deleted!', 'Invoice has been deleted.', 'success')
          } catch (error) {
            console.error(error)
            Swal.fire('Error', 'Failed to delete invoice', 'error')
          }
        }
      })
    }
  },
  mounted() {
    this.fetchInvoices()
  }
}
</script>
