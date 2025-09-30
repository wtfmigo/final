<template>
  <admin-layout>
    <div class="grid grid-cols-12 gap-4 md:gap-6">
      <div class="col-span-12">
        <div class="flex items-center justify-between">
          <h1 class="text-2xl font-bold mb-4 dark:text-white">Staff Control Center</h1>
          <router-link to="/create-staff" class="flex items-center bg-blue-600 text-white font-bold px-3 py-2 rounded-lg hover:bg-blue-700">
            <PlusIcon class="w-3 h-3 mr-2" />
            Add Staff
          </router-link>
        </div>
      </div>

      <!-- Metrics -->
      <div class="col-span-12 md:col-span-4">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold text-gray-500 mb-2">Total Staff</h3>
          <p class="text-2xl font-bold dark:text-white">{{ totalStaff }}</p>
        </div>
      </div>
      <div class="col-span-12 md:col-span-4">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold text-gray-500 mb-2">Admins</h3>
          <p class="text-2xl font-bold dark:text-white">{{ adminCount }}</p>
        </div>
      </div>
      <div class="col-span-12 md:col-span-4">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold text-gray-500 mb-2">Accountancy</h3>
          <p class="text-2xl font-bold dark:text-white">{{ accountancyCount }}</p>
        </div>
      </div>

      <!-- Staff Table -->
      <div class="col-span-12">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
          <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
              <h3 class="text-lg font-semibold dark:text-white">Staff Management</h3>
              
              <div class="flex items-center gap-2 md:gap-4">
                <!-- Status Filter Buttons -->
                <div class="flex space-x-2">
                  <button 
                    v-for="role in ['all', 'admin', 'accountancy']" 
                    :key="role"
                    @click="setRoleFilter(role)"
                    :class="[
                      'px-4 py-2 rounded-md text-sm font-semibold',
                      roleFilter === role 
                        ? 'bg-blue-600 text-white' 
                        : 'bg-gray-200 text-gray-500 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600'
                    ]"
                  >
                    {{ role.charAt(0).toUpperCase() + role.slice(1).replace('_', ' ') }}
                  </button>
                </div>

                <!-- Search Input -->
                <input 
                  v-model="searchQuery" 
                  type="text"
                  placeholder="Search staff..." 
                  class="flex-1 max-w-md px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <!-- Filter Button with Dropdown -->
                <div class="relative">
                  <button 
                    @click="toggleRoleFilter"
                    class="flex items-center px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 hover:bg-gray-50 dark:hover:bg-gray-600"
                  >
                    <span class="text-sm text-gray-500 font-bold">Filter</span>
                    <ChevronDownIcon :class="showRoleFilter ? 'rotate-180' : ''" class="w-4 h-4 ml-1 transition-transform duration-200" />
                  </button>
                  <div 
                    v-if="showRoleFilter" 
                    class="absolute right-0 mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg p-3 z-10 min-w-[220px]"
                  >
                    <div class="space-y-2">
                      <button 
                        @click="roleFilter = 'admin'; showRoleFilter = false"
                        class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-sm"
                      >
                        Admin
                      </button>
                      <button 
                        @click="roleFilter = 'accountancy'; showRoleFilter = false"
                        class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-sm"
                      >
                        Accountancy
                      </button>
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
                  <th class="px-6 py-3 text-left text-xs font-bold text-gray-500">Name</th>
                  <th class="px-6 py-3 text-left text-xs font-bold text-gray-500">Employee ID</th>
                  <th class="px-6 py-3 text-left text-xs font-bold text-gray-500">Email</th>
                  <th class="px-6 py-3 text-left text-xs font-bold text-gray-500">Phone Number</th>
                  <th class="px-6 py-3 text-left text-xs font-bold text-gray-500">Hire Date</th>
                  <th class="px-6 py-3 text-left text-xs font-bold text-gray-500">Role</th>
                  <th class="px-6 py-3 text-left text-xs font-bold text-gray-500">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr v-for="user in filteredUsers" :key="user.id">
                  <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                    {{ user.name }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                    {{ user.employeeId }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                    {{ user.email }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                    {{ user.phoneNumber }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                    {{ user.hireDate }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                    {{ user.role }}
                  </td>
                  <td class="px-6 py-4">
                    <TrashIcon @click="deleteUser(user.id)" 
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
import { TrashIcon, PlusIcon, ChevronDownIcon, SendIcon } from '@/icons'
import Swal from 'sweetalert2'

export default {
  components: { AdminLayout, TrashIcon, PlusIcon, ChevronDownIcon, SendIcon },
  name: 'StaffControlCenter',
  data() {
    return {
      users: [],
      searchQuery: '',
      roleFilter: 'all',
      showRoleFilter: false
    }
  },
  computed: {
    filteredUsers() {
      let filtered = this.users;

      // Role filter
      if (this.roleFilter !== 'all') {
        filtered = filtered.filter(u => u.role === this.roleFilter);
      }

      // Search filter
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        filtered = filtered.filter(u => 
          u.name.toLowerCase().includes(query) || 
          u.email.toLowerCase().includes(query)
        );
      }

      return filtered;
    },
    totalStaff() {
      return this.users.length
    },
    adminCount() {
      return this.users.filter(u => u.role === 'admin').length
    },
    accountancyCount() {
      return this.users.filter(u => u.role === 'accountancy').length
    },
  },
  methods: {
    setRoleFilter(role) {
      this.roleFilter = role;
      this.searchQuery = '';
      this.showRoleFilter = false;
    },
    toggleRoleFilter() {
      this.showRoleFilter = !this.showRoleFilter;
    },
    exportToCSV() {
      const headers = ['Name', 'Employee ID', 'Email', 'Phone Number', 'Hire Date', 'Role'];
      const csvContent = [
        headers.join(','),
        ...this.filteredUsers.map(user => [
          user.name,
          user.employeeId,
          user.email,
          user.phoneNumber,
          user.hireDate,
          user.role
        ].map(field => `"${field}"`).join(','))
      ].join('\n');

      const blob = new Blob([csvContent], { type: 'text/csv' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'staff.csv';
      a.click();
      URL.revokeObjectURL(url);
    },
    async deleteUser(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently remove the user from the staff list.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          this.users = this.users.filter(u => u.id !== id)
          Swal.fire('Deleted!', 'User has been deleted.', 'success')
        }
      })
    }
  },
  mounted() {
    this.users = [
      { id: 1, name: 'miggy', email: 'ncst@example.com', employeeId: '#', phoneNumber: '234-567-8900', address: '123 Test St, Cavite, State 12345', hireDate: '2025-01-01', role: 'admin' },
      { id: 2, name: 'miggy', email: 'ncst@example.com', employeeId: '#', phoneNumber: '234-567-8901', address: '456 Test St, Cavite, State 12345', hireDate: '2025-02-01', role: 'accountancy' },
    ]
  }
}
</script>
