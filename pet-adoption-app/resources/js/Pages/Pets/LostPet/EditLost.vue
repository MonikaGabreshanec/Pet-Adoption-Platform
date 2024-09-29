<template xmlns="http://www.w3.org/1999/html" >
    <Head title="Update Your  Pet's Details" />
    <AuthenticatedLayout>
        <div class="container mx-auto py-8">
            <h1 class="text-2xl text-center font-bold mb-6" style="color:#5E8E8C">Update Your  Pet's Details</h1>
            <h3 class="text-xl text-center  mb-6" style="color:#5E8E8C">Every information is important. Please update the details!</h3>
            <form @submit.prevent="updatePetData" class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 space-y-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Species</label>
                    <select v-model="form.species" class="input-field">
                        <option value="dog">Dog</option>
                        <option value="cat">Cat</option>
                        <option value="bird">Bird</option>
                        <option value="rabbit">Rabbit</option>
                        <option value="guinea pig">Guinea pig</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Breed</label>
                    <input v-model="form.breed" type="text" class="input-field" />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select v-model="form.gender" class="input-field">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="flex space-x-2">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Years</label>
                        <input v-model="form.years" type="number" class="input-field w-full" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Months</label>
                        <input v-model="form.months" type="number" class="input-field w-full" />
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <input v-model="form.location" type="text" class="input-field" />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea v-model="form.description" class="input-field h-24"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                    <div v-if="form.imageUrl" class="mb-2">
                        <img :src="form.imageUrl" alt="Current Image" class="max-h-32 rounded shadow" />
                    </div>
                    <input @change="handleImageChange" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Phone number</label>
                    <textarea v-model="form.phone_number" class="p-2 border rounded w-3/4"></textarea>
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

const props = defineProps(['pet']);
const router = useRouter();

const form = ref({
    species: props.pet.species,
    breed: props.pet.breed,
    years: props.pet.years,
    months: props.pet.months,
    location: props.pet.location,
    gender: props.pet.gender,
    description: props.pet.description,
    phone_number:props.pet.phone_number,
    image: null,
    imageUrl: props.pet.image ? `/storage/${props.pet.image}` : null,
});

function handleImageChange(event) {
    const file = event.target.files[0];
    if (file) {
        form.value.image = file;
        form.value.imageUrl = URL.createObjectURL(file); // Preview the selected image
    }
}

function updatePetData() {
    const formData = new FormData();
    formData.append('species', form.value.species);
    formData.append('breed', form.value.breed);
    formData.append('years', form.value.years);
    formData.append('months', form.value.months);
    formData.append('location', form.value.location);
    formData.append('gender', form.value.gender);
    formData.append('description', form.value.description);
    formData.append('phone_number', form.value.phone_number);

    if (form.value.image) {
        formData.append('image', form.value.image);
    }

    formData.append('_method', 'PUT');
    Inertia.post(route('lost-pets.update', props.pet.id), formData, {
        onSuccess: () => {
            router.push({ name: 'lost-pets.index' });
        },
        onError: (errors) => {
            console.error('Update failed:', errors);
        },
    });
}
</script>
<style>
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
