<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const apiURL = 'http://shoe-shop.test/api/orders'; 
const orders = ref([]);
const isLoading = ref(false);

const loadOrders = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get(apiURL);
        orders.value = response.data;
    } catch (error) {
        console.error('Error loading orders:', error);
    } finally {
        isLoading.value = false;
    }
};

// Fungsi placeholder untuk edit dan hapus produk
const editProduct = (id) => {
    alert(`Edit produk dengan ID: ${id}`);
};

const deleteProduct = (id) => {
    alert(`Hapus produk dengan ID: ${id}`);
};

// Panggil fungsi saat komponen dimount
onMounted(loadOrders);
</script>

<template>
    <Head title="Order" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="container mx-auto p-4">
                        <div class="mb-4 flex justify-between items-center">
                            <h1 class="text-xl font-bold text-white">Manajemen Order</h1>
                            <button
                                class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800"
                                >
                                Tambah Order
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-gray-800 border border-gray-700 rounded-md">
                                <thead>
                                    <tr class="bg-gray-700 border-b">
                                        <th class="text-left px-4 py-2 font-medium text-gray-300">#</th>
                                        <th class="text-left px-4 py-2 font-medium text-gray-300">Produk</th>
                                        <th class="text-left px-4 py-2 font-medium text-gray-300">Total</th>
                                        <th class="text-left px-4 py-2 font-medium text-gray-300">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="isLoading">
                                        <td class="px-4 py-2 text-center text-gray-300" colspan="6">
                                            Loading data...
                                        </td>
                                    </tr>
                                    <tr
                                        v-for="(order, index) in orders"
                                        :key="order.id"
                                        class="border-b hover:bg-gray-700"
                                    >
                                        <td class="px-4 py-2 text-gray-300">{{ index + 1 }}</td>
                                        <td class="px-4 py-2 text-gray-300">{{ order.product_id }}</td>
                                        <td class="px-4 py-2 text-gray-300">Rp {{ order.amount.toLocaleString() }}</td>
                                        <td class="px-4 py-2 text-gray-300">
                                            <button
                                                class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800"
                                                @click="editOrder(order.id)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 ml-2"
                                                @click="deleteOrder(order.id)"
                                            >
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
    </AuthenticatedLayout>
</template>
