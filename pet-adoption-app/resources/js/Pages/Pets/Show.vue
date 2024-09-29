<template>
    <Head title="Pet" />
    <AuthenticatedLayout>

        <div class="container mx-auto py-8">
            <div class="card-con flex flex-col lg:flex-row bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="img-con w-full lg:w-1/2">
                    <img :src="`/storage/${pet.image}`" :alt="pet.species" class="pet-image object-cover">
                </div>
                <div class="card-show w-full lg:w-1/2 p-8">
                    <div class="info">
                        <h1 class="text-4xl font-extrabold text-teal-700 mb-4">{{ pet.name }}</h1>
                        <p class="text-l text-gray-500 mb-6">{{ formatDate(pet.created_at)}} by <span class="text-xl text-teal-500 mb-6 underline  hover:text-teal-700 transition cursor-pointer" @click="viewUserDetails(pet.user.id)">{{ pet.user.name }} </span></p>
                        <h2 class="text-2xl font-semibold text-teal-600 mb-4">About Me</h2>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <p class="text-gray-600"><span class="font-semibold">Breed:</span> {{ pet.breed }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Age:</span> {{ formattedAge(pet) }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Size:</span> {{ pet.size }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Health:</span> {{ pet.health }}</p>
                            <p class="flex items-center text-gray-600" style="margin-top: 10px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="grey" class="bi bi-geo-alt-fill mr-1" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                                </svg>
                                {{ pet.location }}
                            </p>
                        </div>
                        <p class="text-gray-700 mb-4"> {{ pet.description }}</p>
                    </div>
                    <p v-if="pet && pet.adopted !== null" class=" text-lg font-semibold text-[#5E8E8C] ml-40 px-4  mt-4" >
                        {{ pet.name }}  is adopted by <span style="text-decoration-line: underline" @click="viewUserDetails(pet.adopter.id)">{{ pet.adopter.name }} </span>  !
                    </p>
                    <label  v-if="pet && pet.user && pet.user.id === $page.props.auth.user.id  && pet.adopted === null" class="text-lg font-semibold text-[#5E8E8C]">Has this pet been adopted?</label>
                    <button v-if="pet && pet.user && pet.user.id === $page.props.auth.user.id  && pet.adopted === null " class="bg-[#5E8E8C] hover:bg-[#284268] text-white px-4 py-2 rounded mt-4" @click="goToInbox">
                       Go to your inbox and marked it !
                    </button>

                    <button v-if="pet && pet.user && pet.user.id !== $page.props.auth.user.id && pet.adopted === null" class="bg-[#5E8E8C] hover:bg-[#284268] text-white px-4 py-2 rounded mt-4" @click="goToApplicationForm">
                        Adopt
                    </button>

                </div>
                </div>
            </div>


    </AuthenticatedLayout>
</template>

<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from "@inertiajs/vue3";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    pet: Object
});

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
const goToApplicationForm = () => {
    Inertia.visit(route('application.form', { petId: props.pet.id }));
};
const goToInbox= () => {
    Inertia.visit(route('pets.inbox', { petId: props.pet.id }));
};
const markAsAdopted = (petId, appId) => {
    Inertia.visit(route('pets.adopt', { id: petId, appId: appId }));
};

function viewUserDetails(userId) {
    Inertia.visit(route('profile.showUser', { id: userId }));
}
const formatDate = (dateString) => {
    const date = new Date(dateString);
    const months = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"];
    const day = date.getDate();
    const month = months[date.getMonth()];
    const year = date.getFullYear();
    return `Added ${day} ${month} ${year}`;
};
</script>

<style scoped>
.container {
    background-color: #f7fafc;
    padding: 20px;
}

.card-con {
    margin: 0 auto;
    max-width: 1200px;
    height: 600px;
}

.img-con {
    max-height: 600px;
}

.pet-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-show {
    background-color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.info {
    padding: 16px;
}

h1, h2 {
    color: #2c7a7b;
}
</style>
