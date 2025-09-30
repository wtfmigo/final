<template>
  <admin-layout>
    <div class="space-y-6 w-full p-0 m-0">
      <!-- Page Title and Breadcrumb -->
      <div class="col-span-12">
        <nav class="flex mb-4" aria-label="Breadcrumb">
          <router-link to="/staff-control-center" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white mr-4">
            <ChevronRightIcon class="w-4 h-4 transform -rotate-180" />
            Back to Staff
          </router-link>
        </nav>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Create Staff</h1>
      </div>

      <!-- Staff Form Section -->
      <div class="col-span-12">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
          <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Staff Details</h3>
          <form @submit.prevent="saveStaff" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Name -->
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
                <input
                  v-model="formData.name"
                  type="text"
                  placeholder="Enter full name"
                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                />
                <span v-if="!isNameValid && formData.name" class="text-red-500 text-sm">Name must contain only letters and spaces.</span>
              </div>

              <!-- Employee ID -->
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Employee ID *</label>
                <input
                  v-model="formData.employeeId"
                  type="text"
                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                />
              </div>

              <!-- Email -->
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                <input
                  v-model="formData.email"
                  type="email"
                  placeholder="Enter email address"
                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                />
              </div>

              <!-- Phone Number -->
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number *</label>
                <input
                  v-model="formData.phoneNumber"
                  type="tel"
                  placeholder="Enter 11-digit phone number (e.g., 09123456789)"
                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                />
                <span v-if="!isPhoneValid && formData.phoneNumber" class="text-red-500 text-sm">Phone number must be exactly 11 digits.</span>
              </div>

              <!-- Role -->
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role *</label>
                <select
                  v-model="formData.role"
                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >
                  <option value="">Select Role</option>
                  <option value="admin">Accountancy</option>
                  
                </select>
              </div>

              <!-- Hire Date -->
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Hire Date *</label>
                <input
                  v-model="formData.hireDate"
                  type="date"
                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                />
              </div>
            </div>

            <!-- Address -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address *</label>
              <textarea
                v-model="formData.address"
                rows="3"
                placeholder="Enter full address"
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 resize-none"
              ></textarea>
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password *</label>
                <input
                  v-model="formData.password"
                  type="password"
                  placeholder="Enter password"
                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                />
                <small class="text-gray-500 dark:text-gray-400">Password must be at least 8 characters long and contain at least one uppercase letter.</small>
              </div>

              <!-- Confirm Password -->
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password *</label>
                <input
                  v-model="formData.confirmPassword"
                  type="password"
                  placeholder="Confirm password"
                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                />
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 pt-4">
              <router-link to="/staff-control-center" class="px-6 py-3 bg-gray-200 font-bold text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200">
                Cancel
              </router-link>
              <button type="submit" :disabled="isSubmitting"
                      class="px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200 flex items-center gap-2">
                <PlusIcon class="w-4 h-4" />
                Create Staff
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </admin-layout>
</template>

<script>
import AdminLayout from '../components/layout/AdminLayout.vue'
import { ChevronRightIcon, PlusIcon } from '@/icons'
import Swal from 'sweetalert2'

export default {
  components: {
    AdminLayout,
    ChevronRightIcon,
    PlusIcon
  },
  name: 'CreateStaff',
  data() {
    return {
      formData: {
        name: '',
        employeeId: '',
        email: '',
        phoneNumber: '',
        address: '',
        hireDate: new Date().toISOString().split('T')[0],
        password: '',
        confirmPassword: '',
        role: ''
      },
      isSubmitting: false
    }
  },
  computed: {
    isNameValid() {
      return this.formData.name.trim() && /^[a-zA-Z\s]+$/.test(this.formData.name.trim())
    },
    isPhoneValid() {
      const phone = this.formData.phoneNumber.trim()
      return phone && /^\d{11}$/.test(phone)
    },
    isPasswordValid() {
      return this.formData.password.length >= 8 && /[A-Z]/.test(this.formData.password)
    },
    isFormValid() {
      return this.isNameValid &&
             this.formData.employeeId &&
             this.formData.email &&
             this.isPhoneValid &&
             this.formData.address &&
             this.formData.hireDate &&
             this.isPasswordValid &&
             this.formData.confirmPassword &&
             this.formData.role &&
             this.formData.password === this.formData.confirmPassword
    }
  },
  methods: {
    async saveStaff() {
      // Check for missing required fields first
      const missingFields = []
      if (!this.formData.name.trim()) missingFields.push('Name')
      if (!this.formData.employeeId.trim()) missingFields.push('Employee ID')
      if (!this.formData.email.trim()) missingFields.push('Email')
      if (!this.formData.phoneNumber.trim()) missingFields.push('Phone Number')
      if (!this.isPhoneValid) missingFields.push('Valid Phone Number')
      if (!this.formData.address.trim()) missingFields.push('Address')
      if (!this.formData.role) missingFields.push('Role')
      if (!this.formData.password.trim()) missingFields.push('Password')
      if (!this.formData.confirmPassword.trim()) missingFields.push('Confirm Password')
      if (!this.isNameValid) missingFields.push('Valid Name')

      if (missingFields.length > 0) {
        Swal.fire('Error', `Please fill in the following required fields: ${missingFields.join(', ')}`, 'error')
        return
      }

      if (this.formData.password !== this.formData.confirmPassword) {
        Swal.fire('Error', 'Passwords do not match.', 'error')
        return
      }

      if (!this.isPasswordValid) {
        Swal.fire('Error', 'Password must be at least 8 characters and contain at least one uppercase letter.', 'error')
        return
      }

      this.isSubmitting = true
      // Simulate staff creation
      Swal.fire('Success', 'Staff member created successfully!', 'success')
      this.$router.push('/staff-control-center')
      this.isSubmitting = false
    }
  },
  mounted() {
    // Pre-fill hire date if needed
    if (!this.formData.hireDate) {
      this.formData.hireDate = new Date().toISOString().split('T')[0]
    }
  }
}
</script>

<style scoped>
/* Add any custom styles if needed */
</style>
