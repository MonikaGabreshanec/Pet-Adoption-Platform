<template>
    <AuthenticatedLayout>
        <div>
            <div v-if="errors.length">
                <ul>
                    <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
            </div>

            <form @submit.prevent="handleSubmit" class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 space-y-4">

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title:</label>
                    <input type="text" id="title" v-model="formData.title" class="input-field">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description:</label>
                    <textarea id="description" v-model="formData.description" rows="3" class="input-field"></textarea>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location:</label>
                    <input type="text" id="location" v-model="formData.location" class="input-field">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
                    <input type="text" id="email" v-model="formData.email" class="input-field">
                </div>

                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone number:</label>
                    <input type="text" id="phone_number" v-model="formData.phone_number" class="input-field">
                </div>

                <div>
                    <label for="transaction" class="block text-sm font-medium text-gray-700 mb-1">Transaction:</label>
                    <input type="text" id="transaction" v-model="formData.transaction" class="input-field">
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image:</label>
                    <input type="file" id="image" @change="handleImageChange" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-[#5E8E8C] hover:bg-[#284268] text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">Add Post</button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    components: {AuthenticatedLayout},
    data() {
        return {
            formData: {
                title:null,
                description: '',
                location: '',
                email: '',
                phone_number: '',
                transaction:'/',
                image: null,

            },
            errors: [],
        };
    },
    methods: {
        handleSubmit() {

            if (!this.validateForm()) {
                return;
            }

            const formData = new FormData();
            for (const key in this.formData) {
                formData.append(key, this.formData[key]);
            }

            axios.post('/donations', formData)
                .then(() => {
                    window.location.href = '/donations';
                })
                .catch(error => {

                    console.error(error);
                });
        },
        handleImageChange(event) {
            this.formData.image = event.target.files[0];
        },
        validateForm() {
            this.errors = [];


            if (!this.formData.location || !this.formData.description ) {
                this.errors.push('All fields are required.');
            }

            return this.errors.length === 0;
        },
    },
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
