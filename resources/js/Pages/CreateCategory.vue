<script setup>
import { ref } from "vue";
import axios from "axios";
import { Head } from "@inertiajs/vue3";

// State
const name = ref("");
const code = ref("");
const message = ref("");

// Function untuk membuat kategori
const createCategory = async () => {
    try {
        const response = await axios.post("http://shoe-shop.test/api/categories", {
            name: name.value,
            code: code.value,
        });

        message.value = response.data.message;
        name.value = "";
        code.value = "";
        window.location.href = "/categories";

    } catch (error) {
        console.error(error);
    }
};
</script>

<template>
    <Head title="Create Category" />

        <div class="max-w-md mx-auto mt-10">
            <h1 class="text-2xl font-bold mb-4">Create Category</h1>
            <form @submit.prevent="createCategory">
                <input
                    v-model="code"
                    type="text"
                    placeholder="Category Code"
                    class="border p-2 w-full mb-2"
                    required
                />
                <input
                    v-model="name"
                    type="text"
                    placeholder="Category Name"
                    class="border p-2 w-full mb-2"
                    required
                />
                <button type="submit" class="bg-blue-500 text-white px-4 py-2">
                    Create
                </button>
            </form>
            <p v-if="message" class="text-green-600 mt-2">{{ message }}</p>
        </div>
</template>


