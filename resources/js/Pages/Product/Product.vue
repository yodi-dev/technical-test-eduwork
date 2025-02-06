<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, reactive } from 'vue';
import axios from 'axios';
import { Link, router } from "@inertiajs/vue3";

const productsUrl = 'http://shoe-shop.test/api/products';
const categoriesUrl = 'http://shoe-shop.test/api/categories';
const products = ref([]);
const isLoading = ref(false);
const categories = ref([]);
const isModalOpen = ref(false);
const editProduct = reactive({id: "", code: "", name: "", category_id: "", price: ""});


const loadProducts = async () => {
    isLoading.value = true;
    try {
        const resProducts = await axios.get(productsUrl);
        const resCategories = await axios.get(categoriesUrl);
        products.value = resProducts.data;
        categories.value = resCategories.data;
    } catch (error) {
        console.error('Error loading products:', error);
    } finally {
        isLoading.value = false;
    }
};

const deleteProduct = async (id) => {
    if (!confirm("Are you sure delete product?")) return;

    try {
        await axios.delete(`http://shoe-shop.test/api/products/${id}`);

        // Hapus dari UI
        products.value = products.value.filter(cat => cat.id !== id);
    } catch (error) {
        console.error(error);
    }
};

const openModal = (product) => {
    editProduct.id = product.id;
    editProduct.code = product.code;
    editProduct.name = product.name;
    editProduct.category_id = product.category_id;
    editProduct.price = product.price;
    isModalOpen.value = true;
};


const updateProduct = async () => {
    try {
        await axios.put(`http://shoe-shop.test/api/products/${editProduct.id}`, {
            code: editProduct.code,
            name: editProduct.name,
            category_id: editProduct.category_id,
            price: editProduct.price,
        });

        await loadProducts(); 

        isModalOpen.value = false;
    } catch (error) {
        console.error(error);
    }
};

onMounted(loadProducts);
</script>

<template>
    <Head title="Product" />

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="container mx-auto p-4">
                        <div class="mb-4 flex justify-between items-center">
                            <h1 class="text-xl font-bold text-white">Manajemen Produk</h1>
                            <Link
                                href="/create-product"
                                class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800"
                            >
                                Add Product
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-gray-800 border border-gray-700 rounded-md">
                                <thead>
                                    <tr class="bg-gray-700 border-b">
                                        <th class="text-left px-4 py-2 font-medium text-gray-300">#</th>
                                        <th class="text-left px-4 py-2 font-medium text-gray-300">Code</th>
                                        <th class="text-left px-4 py-2 font-medium text-gray-300">Product Name</th>
                                        <th class="text-left px-4 py-2 font-medium text-gray-300">Category</th>
                                        <th class="text-left px-4 py-2 font-medium text-gray-300">Price</th>
                                        <th class="text-left px-4 py-2 font-medium text-gray-300">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="isLoading">
                                        <td class="px-4 py-2 text-center text-gray-300" colspan="6">
                                            Loading data...
                                        </td>
                                    </tr>
                                    <tr
                                        v-for="(product, index) in products"
                                        :key="product.id"
                                        class="border-b hover:bg-gray-700"
                                    >
                                        <td class="px-4 py-2 text-gray-300">{{ index + 1 }}</td>
                                        <td class="px-4 py-2 text-gray-300">{{ product.code }}</td>
                                        <td class="px-4 py-2 text-gray-300">{{ product.name }}</td>
                                        <td class="px-4 py-2 text-gray-300">{{ product.category_name ? product.category_name : 'No Category' }}</td>
                                        <td class="px-4 py-2 text-gray-300">Rp {{ product.price.toLocaleString() }}</td>
                                        <td class="px-4 py-2 text-gray-300">
                                            <button
                                                class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800"
                                                @click="openModal(product)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 ml-2"
                                                @click="deleteProduct(product.id)"
                                            >
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                             <!-- Modal -->
                            <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center">
                                <div class="bg-gray-900 p-6 rounded-lg w-96 shadow-lg">
                                    <h2 class="text-xl font-bold mb-4 text-white">Edit Product</h2>
                                    
                                    <input v-model="editProduct.code" type="text" placeholder="Code" class="w-full border border-gray-700 bg-gray-800 text-white p-2 mb-2 rounded" />
                                    
                                    <input v-model="editProduct.name" type="text" placeholder="Name" class="w-full border border-gray-700 bg-gray-800 text-white p-2 mb-2 rounded" />
                                    
                                    <select v-model="editProduct.category_id" class="w-full border border-gray-700 bg-gray-800 text-white p-2 mb-2 rounded">
                                        <option v-for="category in categories" :key="category.id" :value="category.id">
                                            {{ category.name }}
                                        </option>
                                    </select>
                                    
                                    <input v-model="editProduct.price" type="number" placeholder="Price" class="w-full border border-gray-700 bg-gray-800 text-white p-2 mb-2 rounded" />
                                    
                                    <div class="flex justify-end space-x-2 mt-4">
                                        <button @click="isModalOpen = false" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                                            Cancel
                                        </button>
                                        <button @click="updateProduct" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
