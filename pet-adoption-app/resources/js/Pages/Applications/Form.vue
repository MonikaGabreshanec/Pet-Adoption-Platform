<template>
    <AuthenticatedLayout>
        <div>
            <div v-if="successMessage" class="mb-4 text-green-600">
                {{ successMessage }}
            </div>

            <div v-if="errors.length" class="mb-4 text-red-600">
                <ul>
                    <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
            </div>

            <h1 class="text-2xl text-center font-bold mt-10 mb-6" style="color:#5E8E8C">Fill The Application</h1>
            <form @submit.prevent="handleSubmit" class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 space-y-4">

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name:</label>
                    <input type="text" id="name" v-model="formData.name" class="input-field" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
                    <input type="email" id="email" v-model="formData.email" class="input-field" required>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone:</label>
                    <input type="tel" id="phone" v-model="formData.phone" class="input-field" required>
                </div>

                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason:</label>
                    <textarea id="reason" v-model="formData.reason" rows="3" class="input-field" required></textarea>
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-[#5E8E8C] hover:bg-[#284268] text-white font-semibold rounded-lg shadow-md  focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">Submit Application</button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {defineProps, ref} from 'vue';
import {usePage, useForm} from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps(['pet']);

const formData = useForm({
    name: '',
    email: '',
    phone: '',
    reason: '',
});


const successMessage = ref('');
const errors = ref([]);

const handleSubmit = () => {
    formData.post(route('application.store', {petId: props.pet.id}), {
        onSuccess: () => {
            successMessage.value = 'Your application has been successfully submitted!';
        },
        onError: (err) => {
            errors.value = err;
        },
    });
};
</script>

<style scoped>
.input-field {
    display: block;
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    background-color: #f9fafb;
    outline: none;
    transition: border-color 0.3s;
}

.input-field:focus {
    border-color: #2563eb;
    background-color: #fff;
}
</style>
