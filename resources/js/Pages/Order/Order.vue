<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const apiURL = 'http://shoe-shop.test/api/orders';
const productsUrl = 'http://shoe-shop.test/api/products';
const orders = ref([]);
const products = ref([]);
const isLoading = ref(false);
const isModalOpen = ref(false);
const form = ref({ id: null, product_id: '', amount: '' });

const loadOrders = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get(apiURL);
        orders.value = response.data;
        const resProducts = await axios.get(productsUrl);
        products.value = resProducts.data;
    } catch (error) {
        console.error('Error loading orders:', error);
    } finally {
        isLoading.value = false;
    }
};

const openModal = (order = null) => {
    if (order) {
        form.value = { ...order };
    } else {
        form.value = { id: null, product_id: '', amount: '' };
    }
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const saveOrder = async () => {
    try {
        if (form.value.id) {
            await axios.put(`${apiURL}/${form.value.id}`, form.value);
        } else {
            await axios.post(apiURL, form.value);
        }
        closeModal();
        loadOrders();
    } catch (error) {
        console.error('Error saving order:', error);
    }
};

const deleteOrder = async (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus order ini?')) {
        try {
            await axios.delete(`${apiURL}/${id}`);
            loadOrders();
        } catch (error) {
            console.error('Error deleting order:', error);
        }
    }
};

onMounted(loadOrders);
</script>

<template>
    <Head title="Order" />

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="container mx-auto p-4">
                    <div class="mb-4 flex justify-between items-center">
                        <h1 class="text-xl font-bold text-white">Manajemen Order</h1>
                        <button class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800" @click="openModal()">
                            Add Order
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-gray-800 border border-gray-700 rounded-md">
                            <thead>
                                <tr class="bg-gray-700 border-b">
                                    <th class="text-left px-4 py-2 font-medium text-gray-300">#</th>
                                    <th class="text-left px-4 py-2 font-medium text-gray-300">Product</th>
                                    <th class="text-left px-4 py-2 font-medium text-gray-300">Amount</th>
                                    <th class="text-left px-4 py-2 font-medium text-gray-300">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="isLoading">
                                    <td class="px-4 py-2 text-center text-gray-300" colspan="4">Loading data...</td>
                                </tr>
                                <tr v-for="(order, index) in orders" :key="order.id" class="border-b hover:bg-gray-700">
                                    <td class="px-4 py-2 text-gray-300">{{ index + 1 }}</td>
                                    <td class="px-4 py-2 text-gray-300">{{ order.product_id }}</td>
                                    <td class="px-4 py-2 text-gray-300">Rp {{ order.amount.toLocaleString() }}</td>
                                    <td class="px-4 py-2 text-gray-300">
                                        <button class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800" @click="openModal(order)">
                                            Edit
                                        </button>
                                        <button class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 ml-2" @click="deleteOrder(order.id)">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-gray-900 p-6 rounded-lg w-96 shadow-lg">
            <h2 class="text-xl font-bold mb-4 text-white">{{ form.id ? 'Edit Order' : 'Tambah Order' }}</h2>

            <select v-model="form.product_id" class="w-full border border-gray-700 bg-gray-800 text-white p-2 mb-2 rounded">
                <option v-for="product in products" :key="product.id" :value="product.id">
                    {{ product.name }}
                </option>
            </select>

            <input v-model="form.amount" type="number" class="w-full border border-gray-700 bg-gray-800 text-white p-2 mb-2 rounded"
            placeholder="Amount">

            <div class="flex justify-end">
                <button class="bg-gray-500 text-white px-4 py-2 rounded mr-2" @click="closeModal">Batal</button>
                <button class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800" @click="saveOrder">Simpan</button>
            </div>
        </div>
    </div>
</template>
