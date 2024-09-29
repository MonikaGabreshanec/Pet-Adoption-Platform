<template xmlns="http://www.w3.org/1999/html" >
    <AuthenticatedLayout>
        <div class="container mx-auto py-8">
            <h1 class="text-2xl font-bold mb-6">Edit Pet</h1>
            <form @submit.prevent="updatePetData">
                <div class="mb-4">
                    <label class="block text-gray-700">Title</label>
                    <input v-model="form.title" type="text" class="p-2 border rounded w-40" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Description</label>
                    <textarea v-model="form.description" class="p-2 border rounded w-3/4"></textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>



<script setup>
import {ref} from 'vue';
import {useRouter} from 'vue-router';
import {Inertia} from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps(['faq']);
const router = useRouter();

const form = ref({
    title:props.faq.title,
    description: props.faq.description,
});

function updatePetData() {
    const formData = new FormData();
    formData.append('title', form.value.title);
    formData.append('description', form.value.description);


    formData.append('_method', 'PUT');
    Inertia.post(route('faqs.update', props.faq.id), formData, {
        onSuccess: () => {
            router.push({ name: 'faqs.index' });
        },
        onError: (errors) => {
            console.error('Update failed:', errors);
        },
    });
}
</script>
<style>

</style>
