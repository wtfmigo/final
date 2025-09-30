<template>
  <admin-layout>
    <div class="space-y-6 w-full p-0 m-0">
      <!-- Page Title and Breadcrumb -->
      <div class="col-span-12">
        <nav class="flex mb-4" aria-label="Breadcrumb">
          <button @click="goBack" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white mr-4">
            <ChevronRightIcon class="w-4 h-4 transform -rotate-180" />
            <span class="ml-1">Back to invoice</span>
          </button>
          
        </nav>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Create Invoice</h1>
      </div>

      <!-- Invoice Form Section -->
<div class="col-span-12">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow flex flex-col">
    <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Invoice Details</h3>
    <form @submit.prevent="saveInvoice(true)" class="space-y-4">

      <!-- Invoice Number -->
      <div class="w-full">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Invoice Number</label>
        <input
          v-model="formData.invoiceNumber"
          type="text"
          class="block w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white"
          required
        />
      </div>

      <!-- Client Name -->
      <div class="w-full">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Client Name</label>
        <input
          v-model="formData.clientName"
          type="text"
          class="block w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white"
          required
        />
      </div>

      <!-- Client Email -->
      <div class="w-full">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Client Email</label>
        <input
          v-model="formData.clientEmail"
          type="email"
          class="block w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white"
        />
      </div>

      <!-- Client Address -->
      <div class="w-full">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Client Address</label>
        <input
          v-model="formData.clientAddress"
          type="text"
          class="block w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white"
          required
        />
      </div>

      <!-- Payment Conditions -->
      <div class="w-full">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Conditions</label>
        <select
          v-model="formData.paymentConditions"
          class="block w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white"
          required
        >
          <option value="">Select Payment Condition</option>
          <option v-for="condition in paymentConditions" :key="condition" :value="condition">
            {{ condition }}
          </option>
        </select>
      </div>

      <!-- Issue Date -->
      <div class="w-full">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Issue Date</label>
        <input
          v-model="formData.invoiceDate"
          type="date"
          class="block w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white"
          required
        />
      </div>

      <!-- Due Date -->
      <div class="w-full">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Due Date</label>
        <input
          v-model="formData.dueDate"
          type="date"
          class="block w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white"
          required
        />
      </div>

      <!-- Additional Info -->
      <div class="w-full">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes (optional)</label>
        <textarea
          v-model="formData.additionalInfo"
          rows="5"
          class="block w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white resize-none"
        ></textarea>
      </div>
    </form>
  </div>
</div>


      <!-- Bottom Section: Product Table & Invoice Summary -->
      <div class="col-span-12">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
          <!-- Products Header -->
          <div class="p-8 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Products</h3>
          </div>

          <!-- Product Table -->
          <div class="p-8">
            <div class="overflow-x-auto">
              <table class="min-w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                  <tr>
                    <th class="px-8 py-6 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                    <th class="px-8 py-6 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product Name</th>
                    <th class="px-8 py-6 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                    <th class="px-8 py-6 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                    <th class="px-8 py-6 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Discount</th>
                    <th class="px-8 py-6 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                    <th class="px-8 py-6 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                  <tr v-for="(product, index) in products" :key="index">
                    <td class="px-8 py-6 text-sm font-medium text-gray-900 dark:text-white">{{ index + 1 }}</td>
                    <td class="px-8 py-6 text-sm text-gray-900 dark:text-white">{{ product.productName }}</td>
                    <td class="px-8 py-6 text-sm text-gray-900 dark:text-white">₱{{ formatCurrency(product.unitCost) }}</td>
                    <td class="px-8 py-6 text-sm text-gray-900 dark:text-white">{{ product.quantity }}</td>
                    <td class="px-8 py-6 text-sm text-gray-900 dark:text-white">{{ product.discount }}%</td>
                    <td class="px-8 py-6 text-sm font-medium text-gray-900 dark:text-white">₱{{ formatCurrency(product.total) }}</td>
                    <td class="px-8 py-6">
                      <TrashIcon @click="removeRow(index)" class="w-5 h-5 text-red-600 cursor-pointer hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>


          <!-- Add Product Form -->
          <div class="p-8 border-t border-gray-200 dark:border-gray-700">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Add Product</h4>
            <div class="grid grid-cols-12 gap-4 items-end mb-6">
              
              <!-- Product Name -->
              <div class="col-span-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Name</label>
                <input
                  v-model="newProduct.productName"
                  type="text"
                  placeholder="Product Name"
                  class="w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white"
                />
              </div>

              <!-- Price -->
              <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price</label>
                <input
                  v-model="newProduct.unitCost"
                  type="text"
                  placeholder="0"
                  @input="validatePrice"
                  class="w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white"
                  :class="{ 'border-red-500': !isPriceValid }"
                />
              </div>

              <!-- Quantity -->
              <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quantity</label>
                <input
                  v-model="newProduct.quantity"
                  type="text"
                  placeholder="1"
                  @input="validateQuantity"
                  class="w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white"
                  :class="{ 'border-red-500': !isQuantityValid }"
                />
              </div>

              <!-- Discount -->
              <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Discount (%)</label>
                <input
                  v-model="newProduct.discount"
                  type="text"
                  placeholder="0"
                  @input="validateDiscount"
                  class="w-full px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white"
                  :class="{ 'border-red-500': !isDiscountValid }"
                />
              </div>

              <!-- Add Button -->
              <div class="col-span-2 flex">
                <button @click="addProduct" type="button"
                  class="self-end bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-bold w-full">
                  Add
                </button>
              </div>
            </div>
          </div>


          <!-- Order Summary and Actions -->
          <div class="p-8 border-t border-gray-200 dark:border-gray-700 space-y-6">
            <!-- Summary Panel -->
            <div class="bg-blue-50 dark:bg-blue-900/20 p-8 rounded-lg">
              <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Order Summary</h4>
              <div class="space-y-4">
                <div class="flex justify-between text-base text-gray-700 dark:text-gray-300">
                  <span class="font-medium">Subtotal</span>
                  <span class="font-semibold">₱{{ formatCurrency(subtotal) }}</span>
                </div>
                <div class="flex justify-between text-base text-gray-700 dark:text-gray-300">
                  <span class="font-medium">Tax</span>
                  <span class="font-semibold">₱{{ formatCurrency(tax) }}</span>
                </div>
                <div class="flex justify-between text-2xl font-bold text-gray-900 dark:text-white pt-4 border-t border-gray-200 dark:border-gray-700">
                  <span>Total</span>
                  <span>₱{{ formatCurrency(total) }}</span>
                </div>
              </div>
            </div>
            <!-- Action Buttons -->
            <div class="flex justify-center space-x-4">
              <button @click="saveInvoice(true)" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-md text-base font-semibold">
                Save Invoice
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </admin-layout>
</template>

<script>
import AdminLayout from '../components/layout/AdminLayout.vue'
import { TrashIcon, ChevronRightIcon } from '@/icons'
import Swal from 'sweetalert2'
import axios from 'axios'

export default {
  components: {
    AdminLayout,
    TrashIcon,
    ChevronRightIcon,
  },
  name: 'CreateInvoice',
  data() {
    return {
      formData: {
        invoiceNumber: '',
        clientName: '',
        clientEmail: '',   // added email field
        clientAddress: '',
        paymentConditions: '',
        currency: 'PHP',
        issueDate: '',
        dueDate: '',
        additionalInfo: '',
        status: 'Pending',
      },
      products: [],
      newProduct: {
        productName: '',
        unitCost: '',
        quantity: '1',
        discount: '0',
      },
      isPriceValid: true,
      isQuantityValid: true,
      isDiscountValid: true,
      paymentConditions: ['Net 30', 'Net 60', 'Due on Receipt', 'COD'],
      currencies: ['PHP'],
      taxBrackets: [
        { lower: 0, upper: 250000, rate: 0 },
        { lower: 250000, upper: 400000, rate: 0.15 },
        { lower: 400000, upper: 800000, rate: 0.20 },
        { lower: 800000, upper: 2000000, rate: 0.25 },
        { lower: 2000000, upper: 8000000, rate: 0.30 },
        { lower: 8000000, upper: Infinity, rate: 0.35 },
      ],
    }
  },
  computed: {
    subtotal() {
      return this.products.reduce((sum, product) => sum + (product.total || 0), 0);
    },
    tax() {
      let income = this.subtotal;
      if (income <= 0) return 0;
      let tax = 0;
      let previousUpper = 0;
      for (let bracket of this.taxBrackets) {
        if (income <= bracket.lower) break;
        let upper = bracket.upper === Infinity ? income : bracket.upper;
        let sliceStart = Math.max(previousUpper, bracket.lower);
        let slice = Math.min(income, upper) - sliceStart;
        if (slice > 0) {
          tax += slice * bracket.rate;
        }
        previousUpper = upper;
      }
      return tax;
    },
    total() {
      return this.subtotal + this.tax;
    }
  },
  methods: {
    validatePrice() {
      const value = this.newProduct.unitCost.toString().trim();
      if (!value) {
        this.isPriceValid = true;
        this.newProduct.unitCost = '';
        return;
      }
      if (/^\d+$/.test(value) && parseInt(value) > 0) {
        this.isPriceValid = true;
      } else {
        this.isPriceValid = false;
        // Removed SweetAlert here to allow free typing
        // this.newProduct.unitCost = this.newProduct.unitCost.slice(0, -1); // Optionally keep or remove revert
      }
    },
    validateQuantity() {
      let value = this.newProduct.quantity.toString().trim();
      if (!value || value === '0') {
        this.newProduct.quantity = '1'; // Automatically reset to 1 if empty or 0
        this.isQuantityValid = true;
        return;
      }
      if (/^\d+$/.test(value) && parseInt(value) >= 1) {
        this.isQuantityValid = true;
      } else {
        this.isQuantityValid = false;
        // Removed SweetAlert here to allow free typing
        // this.newProduct.quantity = this.newProduct.quantity.slice(0, -1); // Optionally keep or remove revert
      }
    },
    addProduct() {
      if (!this.newProduct.productName) {
        Swal.fire('Error!', 'Please enter the product name.', 'error');
        return;
      }
      if (!this.isPriceValid || !this.isQuantityValid || !this.isDiscountValid) {
        Swal.fire('Error!', 'Please fill in valid product details (positive integers only).', 'error');
        return;
      }
      if (typeof this.newProduct.unitCost !== 'string' || this.newProduct.unitCost.trim() === '') {
        Swal.fire('Error!', 'Price is required and cannot be blank.', 'error');
        return;
      }
      const unitCost = parseInt(this.newProduct.unitCost);
      const quantity = parseInt(this.newProduct.quantity);
      const discount = parseInt(this.newProduct.discount);
      if (isNaN(unitCost) || !Number.isInteger(unitCost) || unitCost <= 0) {
        Swal.fire('Error!', 'Price must be a valid integer greater than zero.', 'error');
        return;
      }
      if (quantity < 1) {
        Swal.fire('Error!', 'Quantity must be at least 1.', 'error');
        return;
      }
      if (discount < 0 || discount > 100) {
        Swal.fire('Error!', 'Discount must be between 0 and 100.', 'error');
        return;
      }
      const total = quantity * unitCost * (1 - discount / 100);
      this.products.push({ 
        productName: this.newProduct.productName,
        unitCost,
        quantity,
        discount,
        total 
      });
      this.newProduct = { productName: '', unitCost: '', quantity: '1', discount: '0' };
      this.isPriceValid = true;
      this.isQuantityValid = true;
      this.isDiscountValid = true;
      Swal.fire('Success!', 'Product added successfully!', 'success');
    },
    removeRow(index) {
      Swal.fire({
        title: 'Confirm Delete?',
        text: 'Are you sure you want to remove this product?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          if (this.products.length > 1) {
            this.products.splice(index, 1);
            Swal.fire('Deleted!', 'Product removed successfully!', 'success');
          } else {
            Swal.fire('Error!', 'At least one product is required.', 'error');
          }
        }
      });
    },
    calculateTotal(index) {
      const product = this.products[index];
      product.total = product.quantity * product.unitCost * (1 - product.discount / 100);
    },
    goBack() {
      this.$router.go(-1);
    },
    async saveInvoice(isSend) {
      // Basic validation
      if (!this.formData.invoiceNumber || !this.formData.clientName) {
        Swal.fire('Error!', 'Please fill in all required fields.', 'error');
        return;
      }
      if (this.products.length === 0 || this.products.some(p => !p.productName)) {
        Swal.fire('Error!', 'Please add at least one valid product.', 'error');
        return;
      }
      // Check if any product has invalid numeric values (though addProduct should prevent this)
      if (this.products.some(p => !Number.isInteger(p.unitCost) || !Number.isInteger(p.quantity) || !Number.isInteger(p.discount) || p.unitCost <= 0 || p.quantity < 1 || p.discount < 0 || p.discount > 100)) {
        Swal.fire('Error!', 'One or more products have invalid values. Please re-add them.', 'error');
        return;
      }

      try {
        await axios.post('http://localhost:8000/api/invoices', {
        invoice_number: this.formData.invoiceNumber,
        client_name: this.formData.clientName,
        client_email: this.formData.clientEmail,
        client_address: this.formData.clientAddress,
        payment_conditions: this.formData.paymentConditions,
        currency: this.formData.currency,
        invoice_date: this.formData.invoiceDate,
        due_date: this.formData.dueDate,
        status: this.formData.status || 'Pending',
        subtotal: this.subtotal,
        tax: this.tax,
        total: this.total,
        products: this.products,
        additional_info: this.formData.additionalInfo,
      })

        Swal.fire('Success!', 'Invoice created successfully!', 'success')
        this.$router.push('/invoices')
      } catch (error) {
        console.error(error)
        Swal.fire('Error!', 'Failed to save invoice.', 'error')
      }
    },
    formatCurrency(value) {
      return value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
  }
}
</script>


<style scoped>

</style>
