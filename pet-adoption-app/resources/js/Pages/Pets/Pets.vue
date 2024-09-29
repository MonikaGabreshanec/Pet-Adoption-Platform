<script setup>
import { defineProps, ref, computed } from 'vue';
import {Head, Link} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import EditPets from "@/Components/EditPets.vue";
import {Inertia} from "@inertiajs/inertia";
import {useRouter} from "vue-router";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Footer from "@/Layouts/Footer.vue";

const props = defineProps(['pets']);
const filterCriteria = ref('');
const selectedSpecies = ref('');
const selectedBreed = ref('');
const selectedGender = ref('');
const selectedSize = ref('');
const selectedLocation = ref('');
const selectedAgeRange = ref('');
const router = useRouter();

function getPage(url) {
    Inertia.get(url, {}, { preserveState: true });
}

function viewPetDetails(petId) {
    Inertia.visit(route('pets.show', { id: petId }));
}

const deletePet = (id) => {
    if (confirm('Are you sure you want to delete this pet?')) {
        Inertia.delete(route('pets.destroy', { id }));
    }
};

const formattedAge = (pet) => {
    let ageString = '';

    if (pet.years > 0) {
        ageString += pet.years + ' years';
    }

    if (pet.months > 0) {
        if (pet.years <= 0 || pet.years == null) {
            ageString += pet.months + ' months';
        }
    }

    return ageString;
};

const ageRangeFilter = (pet) => {
    const totalMonths = pet.years * 12 + pet.months;
    switch (selectedAgeRange.value) {
        case '0-1':
            return totalMonths <= 12;
        case '1-3':
            return totalMonths > 12 && totalMonths <= 36;
        case '3-7':
            return totalMonths > 36 && totalMonths <= 84;
        case '7+':
            return totalMonths > 84;
        default:
            return true;
    }
};

const uniqueBreeds = computed(() => {
    const petsData = props.pets.data || [];
    const breeds = petsData.map(pet => pet.breed);
    return [...new Set(breeds)];
});

const filteredPets = computed(() => {
    const petsData = props.pets.data || [];
    return petsData.filter(pet => {
        const matchesCriteria = pet.species.toLowerCase().includes(filterCriteria.value.toLowerCase()) || pet.breed.toLowerCase().includes(filterCriteria.value.toLowerCase());
        const matchesSpecies = selectedSpecies.value === '' || pet.species === selectedSpecies.value;
        const matchesBreed = selectedBreed.value === '' || pet.breed === selectedBreed.value;
        const matchesGender = selectedGender.value === '' || pet.gender === selectedGender.value;
        const matchesSize = selectedSize.value === '' || pet.size === selectedSize.value;
        const matchesLocation = selectedLocation.value === '' || pet.location.toLowerCase().includes(selectedLocation.value.toLowerCase());
        const matchesAge = ageRangeFilter(pet);
        return matchesCriteria && matchesSpecies && matchesBreed && matchesGender && matchesSize && matchesLocation && matchesAge;
    });
});

</script>

<template>
    <Head title="Pets" />
    <AuthenticatedLayout>
        <div class="container_pets mx-auto py-8">
            <div class="">
                <p style="font-size: 70px; margin-left: 500px; color:#284268">Help Them Find a <span style="color:#5E8E8C">Family</span> </p>
                <Link :href="route('pets.create')" class="add bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Post a Pet For Adoption
                </Link>
                <p class="find">Find Your <span style="color:#5E8E8C">Forever</span> Friend</p>
            </div>

            <div class="flex" style="padding: 50px">
                <div class="w-full md:w-1/4 mb-4 flex flex-col space-y-4" >
                    <input
                        type="text"
                        v-model="filterCriteria"
                        placeholder="Search pets..."
                        class="p-2 border rounded"
                    />
                    <label>Species</label>
                    <select v-model="selectedSpecies" class="p-2 border rounded">
                        <option value="">All Species</option>
                        <option value="dog">Dog</option>
                        <option value="cat">Cat</option>
                        <option value="bird">Bird</option>
                        <option value="rabbit">Rabbit</option>
                        <option value="guinea pig">Guinea pig</option>
                        <option value="other">Other</option>
                    </select>
                    <label>Breed</label>
                    <select v-model="selectedBreed" class="p-2 border rounded">
                        <option value="">All Breeds</option>
                        <option v-for="breed in uniqueBreeds" :key="breed" :value="breed">{{ breed }}</option>
                    </select>
                    <label>Gender</label>
                    <div class="p-1 mb-4 border rounded" >
                        <label>
                            <input type="radio" value="" v-model="selectedGender" />
                            All
                        </label>
                        <label>
                            <input type="radio" value="male" v-model="selectedGender" />
                            Male
                        </label>
                        <label>
                            <input type="radio" value="female" v-model="selectedGender" />
                            Female
                        </label>
                    </div>
                    <label>Size</label>
                    <select v-model="selectedSize" class="p-2 border rounded">
                        <option value="">All Sizes</option>
                        <option value="small">Small</option>
                        <option value="medium">Medium</option>
                        <option value="large">Large</option>
                    </select>
                    <label>Age</label>
                    <select v-model="selectedAgeRange" class="p-2 border rounded">
                        <option value="">All Ages</option>
                        <option value="0-1">0-1 years</option>
                        <option value="1-3">1-3 years</option>
                        <option value="3-7">3-7 years</option>
                        <option value="7+">7+ years</option>
                    </select>

                    <label>Location</label>
                    <input
                        type="text"
                        v-model="selectedLocation"
                        placeholder="Search by location..."
                        class="p-2 border rounded"
                    />
                </div>


                <div class="w-full   md:w-3/4 pets-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mx-auto" style="margin-left: 100px;">
                    <div v-for="pet in filteredPets" :key="pet.id" class="pet-card bg-white shadow-lg rounded-lg overflow-hidden cursor-pointer transition-transform transform hover:scale-105">
                        <img :src="`/storage/${pet.image}`" :alt="pet.species" class="pet-image w-full h-48 object-cover" @click="viewPetDetails(pet.id)">
                        <div class="p-4">
                            <div class="mb-2 flex justify-between items-center">
                                <h1 class="card-title_pet text-xl  ">{{ pet.name }}</h1>
                                <Dropdown v-if="pet.user.id === $page.props.auth.user.id" class="ml-auto">
                                    <template #trigger>
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </template>
                                    <template #content>
                                        <DropdownLink :href="route('pets.edit', { id: pet.id })" class="hover:bg-gray-100">
                                            Edit
                                        </DropdownLink>
                                        <DropdownLink as="button" :href="route('pets.destroy', pet.id)" method="delete" class="hover:bg-gray-100">
                                            Delete
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                            <p class="text-gray-600">{{ pet.gender }} {{ pet.species }} | {{ formattedAge(pet) }}</p>
                            <p class="flex items-center text-gray-600" style="margin-top: 10px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="grey" class="bi bi-geo-alt-fill mr-1" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                                </svg>
                                {{ pet.location }}
                            </p>
                            <p class="text-gray-600"></p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="flex justify-center mt-6 space-x-2">

                <button v-if="pets.prev_page_url" @click="getPage(pets.prev_page_url)" class="bg-[#5E8E8C] hover:bg-[#284268] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-[#5E8E8C]">
        <span class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Previous
        </span>
                </button>

                <button v-if="pets.next_page_url" @click="getPage(pets.next_page_url)" class="bg-[#5E8E8C] hover:bg-[#284268] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-[#5E8E8C]">
        <span class="flex items-center">
            Next
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </span>
                </button>
            </div>
        </div>

        <Footer></Footer>
    </AuthenticatedLayout>
</template>



<style>
.container_pets{
    background-color:#F7F0E8;
}
.add{
    color: white;
    border-radius: 0.25rem;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s ease;
    margin-left: 700px;
    font-size: 30px;
    background-color:#5E8E8C;

}
.add:hover{
    background-color:#284268;
}
.find{
    font-size: 40px;
    margin-left: 20px;
    color:#284268;
}
.pets-container {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;

}
.pet-card {
    border: 1px solid #ccc;
    border-radius: 8px;
    overflow: hidden;
    width: 300px;
    height: 350px;
}
.card-title_pet{
    font-size: larger;
    font-weight: bolder;
    color:#5E8E8C;
}
.pet-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-bottom: 1px solid #ccc;
}
.card-title{
    font-size: 20px;
}
label{
    color:#284268;
    font-weight: bolder;
}
</style>


