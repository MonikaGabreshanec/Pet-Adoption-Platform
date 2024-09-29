<script setup>
import { defineProps, ref, computed } from 'vue';
import { Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import EditPets from "@/Components/EditPets.vue";
import {Inertia} from "@inertiajs/inertia";
import {useRouter} from "vue-router";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Footer from "@/Layouts/Footer.vue";

const props = defineProps(['lost_pets']);
const filterCriteria = ref('');
const selectedSpecies = ref('');
const selectedLocation = ref('');
const router = useRouter();

function getPage(url) {
    Inertia.get(url, {}, { preserveState: true });
}
function viewPetDetails(petId) {
    Inertia.visit(route('lost-pets.show', { id: petId }));
}
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

const filteredPets = computed(() => {
    const petsData = props.lost_pets.data || [];
    return petsData.filter(pet => {
        const matchesCriteria = pet.species.toLowerCase().includes(filterCriteria.value.toLowerCase()) || pet.breed.toLowerCase().includes(filterCriteria.value.toLowerCase());
        const matchesSpecies = selectedSpecies.value === '' || pet.species === selectedSpecies.value;
        const matchesLocation = selectedLocation.value === '' || pet.location.toLowerCase().includes(selectedLocation.value.toLowerCase());
        return matchesCriteria && matchesSpecies  && matchesLocation;
    });
});

</script>

<template>
    <Head title="Lost Pets" />
    <AuthenticatedLayout>
        <div class="container_pets mx-auto py-8">
            <div class="">
                <p style="font-size: 70px; margin-left: 500px;color:#284268">Help Bring Them Home</p>
                <Link :href="route('lost-pets.create')" class="add bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Report a Lost Pet
                </Link>
                <p class="find">Search For Your Lost Pet</p>
            </div>

            <div class="flex" style="padding: 50px">
                <div class="w-full md:w-1/4 mb-4 flex flex-col space-y-4" >
                    <input
                        type="text"
                        v-model="filterCriteria"
                        placeholder="Search pets..."
                        class="p-2 border rounded"
                    />
                    <label>I'm searching for</label>
                    <select v-model="selectedSpecies" class="p-2 border rounded">
                        <option value="">All Species</option>
                        <option value="dog">Dog</option>
                        <option value="cat">Cat</option>
                        <option value="bird">Bird</option>
                        <option value="rabbit">Rabbit</option>
                        <option value="guinea pig">Guinea pig</option>
                        <option value="other">Other</option>
                    </select>
                    <label>Location</label>
                    <input
                        type="text"
                        v-model="selectedLocation"
                        placeholder="Search by location..."
                        class="p-2 border rounded"
                    />
                </div>

                <!-- Cards Section -->
                <div class="w-full   md:w-3/4 pets-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mx-auto" style="margin-left: 100px;">
                    <div v-for="pet in filteredPets" :key="pet.id" class="pet-card bg-white shadow-lg rounded-lg overflow-hidden cursor-pointer transition-transform transform hover:scale-105">
                        <img :src="`/storage/${pet.image}`" :alt="pet.species" class="pet-image w-full h-48 object-cover" @click="viewPetDetails(pet.id)">
                        <div class="p-4">
                            <div class="mb-2 flex justify-between items-center">
                                <h2 class="text-xl font-bold text-teal-700">{{ pet.gender }} {{ pet.species }} </h2>
                                <Dropdown v-if="pet.user.id === $page.props.auth.user.id" class="ml-auto">
                                    <template #trigger>
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </template>
                                    <template #content>
                                        <DropdownLink :href="route('lost-pets.edit', { id: pet.id })" class="hover:bg-gray-100">
                                            Edit
                                        </DropdownLink>
                                        <DropdownLink as="button" :href="route('lost-pets.destroy', pet.id)" method="delete" class="hover:bg-gray-100">
                                            Delete
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                            <p class="text-sm text-gray-500 mb-2">{{ formattedAge(pet) }} | {{ pet.location }}</p>
                            <p class="flex items-center text-gray-600" style="margin-top: 10px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="grey" class="bi bi-geo-alt-fill mr-1" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                                </svg>
                                {{ pet.location }}
                            </p>
                            <p class="flex items-center text-gray-600" style="margin-top: 10px">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone mr-1" viewBox="0 0 16 16">
                                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                            </svg>
                                 {{ pet.phone_number }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-6 space-x-2">

                <button v-if="lost_pets.prev_page_url" @click="getPage(lost_pets.prev_page_url)" class="bg-[#5E8E8C] hover:bg-[#284268] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-[#5E8E8C]">
        <span class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Previous
        </span>
                </button>

                <button v-if="lost_pets.next_page_url" @click="getPage(lost_pets.next_page_url)" class="bg-[#5E8E8C] hover:bg-[#284268] text-white font-semibold px-4 py-2 rounded-lg shadow-md transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-[#5E8E8C]">
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
    background-color:cadetblue;

}
.add:hover{
    background-color: #5f96a0;
}
.find{
    font-size: 40px;
    margin-left: 20px;
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
.find{
    font-size: 40px;
    margin-left: 20px;
    color:#284268;
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
</style>



