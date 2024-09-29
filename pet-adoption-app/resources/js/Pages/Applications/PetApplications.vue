<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-teal-900 leading-tight">My Applications</h2>
        </template>
        <div class="container mx-auto py-8 ">
            <div class="max-w-4xl mx-auto">

                    <div v-for="application in applications" :key="application.id" class="mb-6">
                        <div v-if="application.user.id === $page.props.auth.user.id" class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 flex items-center">
                                <div class="w-full lg:w-2/3">
                                    <p class="text-sm text-gray-500 mb-6">{{ formatDate(application.created_at) }}</p>
                                    <p class="text-xl font-semibold text-teal-700"><strong>Application for</strong> {{ application.pet.name }}</p>
                                    <p class="flex items-center text-gray-600" style="margin-top: 10px">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="grey" class="bi bi-geo-alt-fill mr-1" viewBox="0 0 16 16">
                                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                                        </svg>
                                        {{ application.pet.location }}
                                    </p>
                                    <p class="mt-2 text-lg font-medium" :class="application.pet.adopted === null ? 'text-yellow-600' : 'text-red-600'">
                                        <strong>Status:</strong> {{ application.pet.adopted === null ? 'Pending' : 'ADOPTED' }}
                                    </p>
                                </div>
                                <div class="w-full lg:w-1/3">
                                    <img
                                        :src="`/storage/${application.pet.image}`"
                                        :alt="application.pet.name"
                                        class="pet-image object-cover rounded-lg cursor-pointer transform transition duration-300 hover:scale-105"
                                        @click="viewPetDetails(application.pet.id)"
                                    >
                                </div>
                         </div>

                    </div>


            </div>
        </div>
    </AuthenticatedLayout>
</template>


<script setup>
import {ref, onMounted, defineProps} from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    applications: Array,

});
function viewPetDetails(petId) {
    Inertia.visit(route('pets.show', { id: petId }));
}

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const months = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"];
    const day = date.getDate();
    const month = months[date.getMonth()];
    const year = date.getFullYear();
    return `Created ${day} ${month} ${year}`;
};
</script>
