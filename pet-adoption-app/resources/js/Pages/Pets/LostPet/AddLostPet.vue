<template>
    <Head title="Add All The Details For The Lost Pet" />
    <AuthenticatedLayout>
        <div>
            <div v-if="errors.length">
                <ul>
                    <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
            </div>

            <h1 class="text-2xl text-center font-bold mt-10 mb-6" style="color:#5E8E8C">Add All The Details For The Lost Pet </h1>
            <form @submit.prevent="handleSubmit" class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 space-y-4">

                <div>
                    <label for="species" class="block text-sm font-medium text-gray-700 mb-1">Species:</label>
                    <select id="species" v-model="formData.species" class="input-field">
                        <option value="dog">Dog</option>
                        <option value="cat">Cat</option>
                        <option value="bird">Bird</option>
                        <option value="rabbit">Rabbit</option>
                        <option value="guinea pig">Guinea pig</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label for="breed" class="block text-sm font-medium text-gray-700 mb-1">Breed:</label>
                    <input type="text" id="breed" v-model="formData.breed" class="input-field">
                </div>

                <div class="flex space-x-2">
                    <div>
                        <label for="years" class="block text-sm font-medium text-gray-700 mb-1">Years:</label>
                        <input type="number" id="years" v-model="formData.years" class="input-field w-full">
                    </div>
                    <div>
                        <label for="months" class="block text-sm font-medium text-gray-700 mb-1">Months:</label>
                        <input type="number" id="months" v-model="formData.months" class="input-field w-full">
                    </div>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location:</label>
                    <input type="text" id="location" v-model="formData.location" class="input-field">
                </div>


                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender:</label>
                    <select id="gender" v-model="formData.gender" class="input-field">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description:</label>
                    <textarea id="description" v-model="formData.description" rows="3" class="input-field"></textarea>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image:</label>
                    <input type="file" id="image" @change="handleImageChange" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone:</label>
                    <textarea id="phone_number" v-model="formData.phone_number"  class="input-field"></textarea>
                </div>
                <button type="submit" class="w-full py-2 px-4 bg-[#5E8E8C] hover:bg-[#284268] text-white font-semibold rounded-lg shadow-md  focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">Add Pet</button>
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
                species: '',
                breed: '',
                years: null,
                months: null,
                location: '',
                gender: '',
                description: '',
                image: null,
                phone_number:''

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

            axios.post('/lost-pets', formData)
                .then(() => {
                    window.location.href = '/lost-pets';
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


            if (!this.formData.species || !this.formData.breed || !this.formData.location || !this.formData.gender || !this.formData.description || !this.formData.image) {
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
<script setup>
</script>
