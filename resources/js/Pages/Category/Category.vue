<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Link } from "@inertiajs/vue3";

const apiURL = 'http://shoe-shop.test/api/categories'; 
const categories = ref([]);
const isLoading = ref(false);

const loadCategories = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get(apiURL);
        categories.value = response.data;
    } catch (error) {
        console.error('Error loading categories:', error);
    } finally {
        isLoading.value = false;
    }
};

const deleteCategory = async (id) => {
    if (!confirm("Are you sure delete category?")) return;

    try {
        await axios.delete(`http://shoe-shop.test/api/categories/${id}`);

        // Hapus dari UI
        categories.value = categories.value.filter(cat => cat.id !== id);
    } catch (error) {
        console.error(error);
    }
};

const updateCategory = async (category) => {
    const input = prompt(`Edit category (pisahkan dengan koma):\nKode, Nama`, `${category.code}, ${category.name}`);
    
    if (!input) return; // Jika user cancel
    const [newCode, newName] = input.split(",").map(item => item.trim());

    if (!newCode || !newName) {
        alert("Input tidak valid! Pastikan formatnya: Kode, Nama");
        return;
    }

    try {
        await axios.put(`http://shoe-shop.test/api/categories/${category.id}`, {
            code: newCode,
            name: newName
        });

        category.code = newCode;
        category.name = newName;
    } catch (error) {
        console.error(error);
    }
};



onMounted(loadCategories);
</script>

<template>
    <Head title="Category" />

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div
                class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
            >
                <div class="container mx-auto p-4">
                    <div class="mb-4 flex justify-between items-center">
                        <h1 class="text-xl font-bold text-white">Manajemen Category</h1>
                        <Link
                            href="/create-category"
                            class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800"
                        >
                            Add Category
                        </Link>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-gray-800 border border-gray-700 rounded-md">
                            <thead>
                                <tr class="bg-gray-700 border-b">
                                    <th class="text-left px-4 py-2 font-medium text-gray-300">#</th>
                                    <th class="text-left px-4 py-2 font-medium text-gray-300">Code</th>
                                    <th class="text-left px-4 py-2 font-medium text-gray-300">Name</th>
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
                                    v-for="(category, index) in categories"
                                    :key="category.id"
                                    class="border-b hover:bg-gray-700"
                                >
                                    <td class="px-4 py-2 text-gray-300">{{ index + 1 }}</td>
                                    <td class="px-4 py-2 text-gray-300">{{ category.code }}</td>
                                    <td class="px-4 py-2 text-gray-300">{{ category.name }}</td>
                                    <td class="px-4 py-2 text-gray-300">
                                        <button
                                            class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800"
                                            @click="updateCategory(category)"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 ml-2"
                                            @click="deleteCategory(category.id)"
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
</template>
