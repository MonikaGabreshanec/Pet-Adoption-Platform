<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import Blog from "@/Pages/Blog/Blog.vue";
import Footer from "@/Layouts/Footer.vue";

defineProps(['posts']);



const form = useForm({
    message: '',
});
</script>

<template>
    <Head title="Blog" />
    <AuthenticatedLayout>
        <div class="container_blog bg-gray-100 min-h-screen">
            <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-[#284268]">Share Your Pet Adoption <span style="color:#5E8E8C">Love Story</span></h1>
                    <p class="text-2xl text-gray-600 mt-4">Inspire others with your journey!</p>
                </div>

                <form @submit.prevent="form.post(route('posts.store'), { onSuccess: () => form.reset() })" class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <textarea
                        v-model="form.message"
                        placeholder="Write your story..."
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm resize-none h-32 overflow-hidden"
                    ></textarea>
                    <InputError :message="form.errors.message" class="mt-2" />
                    <button class="w-25 mt-4 py-2 px-4 bg-[#5E8E8C] hover:bg-[#284268] text-white font-semibold rounded-lg shadow-md  focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">Post Your Story</button>
                </form>


                <div class="grid grid-cols-2 sm:grid-cols-2 gap-4 ">
                    <Blog
                        v-for="post in posts"
                        :key="post.id"
                        :post="post"
                    />
                </div>
            </div>
        </div>
        <Footer></Footer>
    </AuthenticatedLayout>
</template>

<style>
.container_blog{
    background-color:#F7F0E8;
    overflow: hidden
}
</style>
