<template>
    <AuthenticatedLayout>
        <div>
            <div v-if="errors.length">
                <ul>
                    <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
            </div>

            <form @submit.prevent="handleSubmit">

                <label>Title:</label>
                <input type="text" v-model="formData.title">

                <label>Description:</label>
                <textarea v-model="formData.description"></textarea>

                <button type="submit">Add Pet</button>
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

            axios.post('/faqs', formData)
                .then(() => {
                    window.location.href = '/faqs';
                })
                .catch(error => {

                    console.error(error);
                });
        },
        validateForm() {
            this.errors = [];
            if (!this.formData.title || !this.formData.description) {
                this.errors.push('All fields are required.');
            }

            return this.errors.length === 0;
        },
    },
};
</script>

<style scoped>
</style>
