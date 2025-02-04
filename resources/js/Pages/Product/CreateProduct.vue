<script setup>
import { ref, onMounted } from "vue";
import { Head } from "@inertiajs/vue3";
import axios from "axios";

// State
const code = ref("");
const name = ref("");
const category_id = ref("");
const price = ref("");
const message = ref("");
const categories = ref([]); 

onMounted(async () => {
    try {
        const response = await axios.get("http://shoe-shop.test/api/categories");
        categories.value = response.data; 
    } catch (error) {
        console.error("Gagal mengambil kategori", error);
    }
});

const createProduct = async () => {
    try {
        const response = await axios.post("http://shoe-shop.test/api/products", {
            code: code.value,
            name: name.value,
            category_id: category_id.value,
            price: price.value,
        });

        message.value = "Successfully create Product";
        code.value = "";
        name.value = "";
        category_id.value = "";
        price.value = "";

        setTimeout(() => {
            window.location.href = "/products";
        }, 1000); 
    } catch (error) {
        console.error(error);
    }
};
</script>

<template>
    <Head title="Create Product" />

    <div class="max-w-md mx-auto mt-10 bg-gray-800 text-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Create Product</h1>
        <form @submit.prevent="createProduct">
            <input
                v-model="code"
                type="text"
                placeholder="Product Code"
                class="border p-2 w-full mb-4 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            />
            <input
                v-model="name"
                type="text"
                placeholder="Product Name"
                class="border p-2 w-full mb-4 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            />
            <select v-model="category_id" id="category" class="border p-2 w-full mb-4 rounded bg-gray-700 text-white">
                <option value="" disabled>Pilih Kategori</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
                </option>
            </select>
            <input
                v-model="price"
                type="number"
                placeholder="Price"
                class="border p-2 w-full mb-4 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            />
            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Create
            </button>
        </form>
        <p v-if="message" class="text-green-400 mt-2">{{ message }}</p>
    </div>
</template>
