<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const apiURL = 'http://shoe-shop.test/api/categories'; 
const categories = ref([]);
const isLoading = ref(false);
const isModalOpen = ref(false);
const editCategory = ref({ id: "", code: "", name: "" });

const loadCategories = async () => {
    isLoading.value = true;
    try {
        const { data } = await axios.get(apiURL);
        categories.value = data;
    } catch (error) {
        console.error('Error loading categories:', error);
    } finally {
        isLoading.value = false;
    }
};

const deleteCategory = async (id) => {
    if (!confirm("Are you sure delete category?")) return;
    try {
        await axios.delete(`${apiURL}/${id}`);
        categories.value = categories.value.filter(cat => cat.id !== id);
    } catch (error) {
        console.error(error);
    }
};

const openModal = (category) => {
    editCategory.value = { ...category }; // Pastikan Vue reaktif
    isModalOpen.value = true;
};

const updateCategory = async () => {
    try {
        await axios.put(`${apiURL}/${editCategory.value.id}`, {
            code: editCategory.value.code,
            name: editCategory.value.name
        });
        await loadCategories();
        isModalOpen.value = false;
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
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
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
                                            @click="openModal(category)"
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

                        <!-- Modal -->
                        <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center">
                            <div class="bg-gray-900 p-6 rounded-lg w-96 shadow-lg">
                                <h2 class="text-xl font-bold mb-4 text-white">Edit Category</h2>
                                
                                <input v-model="editCategory.code" type="text" placeholder="Code" class="w-full border border-gray-700 bg-gray-800 text-white p-2 mb-2 rounded" />
                                
                                <input v-model="editCategory.name" type="text" placeholder="Name" class="w-full border border-gray-700 bg-gray-800 text-white p-2 mb-2 rounded" />
                                
                                <div class="flex justify-end space-x-2 mt-4">
                                    <button @click="isModalOpen = false" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                                        Cancel
                                    </button>
                                    <button @click="updateCategory" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
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
