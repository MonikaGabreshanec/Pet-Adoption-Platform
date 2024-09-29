<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue'; // import your Dropdown component
import DropdownLink from '@/Components/DropdownLink.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue"; // import your DropdownLink component

const props = defineProps(['pet']);

const editing = ref(false);


const form = useForm({
    species: props.pet.species,
    breed: props.pet.breed,
    years: props.pet.years,
    months: props.pet.months,
    location: props.pet.location,
    gender: props.pet.gender,
    description: props.pet.description,
    image: null,
});

function handleImageChange(event) {
    form.image = event.target.files[0];
}

function updatePetData() {
    props.pet.species = form.species;
    props.pet.breed = form.breed;
    props.pet.years = form.years;
    props.pet.months = form.months;
    props.pet.location = form.location;
    props.pet.gender = form.gender;
    props.pet.description = form.description;
    // You may also need to handle the image if it's displayed
    // props.pet.image = form.image;
}
</script>

<template>
    <div>
        <Dropdown v-if="pet.user.id === $page.props.auth.user.id">
            <template #trigger>
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                </button>
            </template>
            <template #content>
                <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                    Edit
                </button>
                <DropdownLink as="button" :href="route('pets.destroy', pet.id)" method="delete">
                    Delete
                </DropdownLink>
            </template>
        </Dropdown>

        <div v-if="editing" >
            <form @submit.prevent="form.put(route('pets.update', props.pet.id), { onSuccess: () => editing = false})">
                <label>Species:</label>
                <input type="text" v-model="form.species">

                <label>Breed:</label>
                <input type="text" v-model="form.breed">

                <label>Years:</label>
                <input type="number" v-model="form.years">

                <label>Months:</label>
                <input type="number" v-model="form.months">

                <label>Location:</label>
                <input type="text" v-model="form.location">

                <label>Gender:</label>
                <select v-model="form.gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>

                <label>Description:</label>
                <textarea v-model="form.description"></textarea>

                <label>Image:</label>
                <input type="file" @change="handleImageChange">

                <div>
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
        </div>
        <div v-else>
            <div>
                <h2>{{ pet.species }} ({{ pet.breed }})</h2>
                <p>{{ pet.gender }}</p>
                <p>{{ pet.description }}</p>
            </div>
        </div>
    </div>
</template>

-->


