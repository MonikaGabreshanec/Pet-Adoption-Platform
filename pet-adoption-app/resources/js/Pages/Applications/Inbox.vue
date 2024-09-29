<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-teal-900 leading-tight">Inbox</h2>
        </template>

        <div class="container mx-auto py-8">
            <div class="max-w-4xl mx-auto mb-6">

                <label class="block text-lg font-semibold text-teal-600 mb-2">Sort The Applications:</label>
                <div class="flex flex-col sm:flex-row justify-between space-y-4 sm:space-y-0 sm:space-x-4">
                    <div class="flex-1">
                        <select id="filter" v-model="filter" class="border border-gray-300 rounded-lg p-2 text-gray-800 w-full">
                            <option value="all">All Applications</option>
                            <option value="adopted">Adopted</option>
                            <option value="not_adopted">Not Adopted</option>
                        </select>
                    </div>

                    <div class="flex-1">
                        <select id="sort" v-model="sortOrder" @change="sortApplications" class="border border-gray-300 rounded-lg p-2 text-gray-800 w-full">
                            <option value="latest">Latest</option>
                            <option value="oldest">Oldest</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto space-y-2">
                <div v-if="filteredApplications.length > 0">
                    <div v-for="application in filteredApplications" :key="application.id" class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 flex items-center space-x-4 mb-6">
                        <div class="w-full lg:w-2/3 space-y-4">
                            <p class="text-sm text-gray-500 mb-6">{{ formatDate(application.created_at) }}</p>
                            <p class="text-2xl font-bold text-teal-700"><strong>Application for:</strong> {{ application.pet.name }}</p>
                            <p class="text-lg text-gray-700"><strong>Applicant:</strong> {{ application.name }}</p>
                            <p class="text-lg text-gray-700"><strong>Email:</strong> {{ application.email }}</p>
                            <p class="text-lg text-gray-700"><strong>Phone:</strong> {{ application.phone }}</p>
                            <p class="text-lg text-gray-700"><strong>From Applicant:</strong> {{ application.reason }}</p>

                            <div v-if="application.pet.adopted === null" class="mt-6">
                                <label class="block text-lg font-semibold text-teal-600 mb-2">
                                    Has this pet been adopted?
                                </label>
                                <button class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium px-6 py-3 rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none" @click="markAsAdopted(application.pet.id, application.user.id)">
                                    Mark as Adopted
                                </button>
                            </div>
                            <div v-if="application.pet.adopted !== null" class="mt-6">
                                <label class="block text-lg font-semibold text-teal-600 mb-2">
                                    You found home for {{ application.pet.name }} !
                                </label>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/3">
                            <img
                                :src="`/storage/${application.pet.image}`"
                                :alt="application.pet.name"
                                class="pet-image object-cover rounded-lg cursor-pointer transform transition duration-300 hover:scale-105"
                                @click="viewPetDetails(application.pet.id, application.user.id)"
                            >
                        </div>
                    </div>
                </div>
                <p v-else class="text-gray-500 text-lg text-center">No applications matching the filter criteria.</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<script setup>
import {ref, computed} from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Inertia} from '@inertiajs/inertia';

const props = defineProps({
    applications: Array,
    applicant: Object,
});

const filter = ref('all');
const sortOrder = ref('latest');

const filteredApplications = computed(() => {
    let filtered = props.applications;

    if (filter.value === 'adopted') {
        filtered = filtered.filter(application => application.pet.adopted !== null);
    } else if (filter.value === 'not_adopted') {
        filtered = filtered.filter(application => application.pet.adopted === null);
    }

    if (sortOrder.value === 'latest') {
        filtered = filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
    } else if (sortOrder.value === 'oldest') {
        filtered = filtered.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
    }

    return filtered;
});

const sortApplications = () => {
};

const markAsAdopted = (petId, appId) => {
    Inertia.visit(route('pets.adopt', {id: petId, appId: appId}));
};

const viewPetDetails = (petId, appId) => {
    Inertia.visit(route('pets.show', {id: petId, appId: appId}));
};

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
