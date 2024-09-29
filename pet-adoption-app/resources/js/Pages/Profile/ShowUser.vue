<template>
    <Head title="Pet" />
    <AuthenticatedLayout>

        <div class="container mx-auto py-12">
            <div class="bg-white rounded-xl shadow-2xl p-10">
                <div class="text-center mb-12">
                    <h1 class="text-5xl font-bold text-teal-700 mb-4">{{ user.name }}</h1>
                    <p class="text-gray-500 text-lg">{{ user.email }}</p>
                    <p class="text-gray-500 text-lg">Joined on {{ formatDate(user.created_at) }}</p>
                </div>


                <div class="border-t border-gray-200 pt-8">
                    <h2 class="text-3xl font-semibold text-teal-600 mb-6">Pets Posted by {{ user.name }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div v-for="pet in pets" :key="pet.id" class="p-6 bg-teal-50 rounded-lg shadow hover:bg-teal-100 transition cursor-pointer" @click="viewPetDetails(pet.id)">
                            <p class="text-gray-700 text-lg"><span class="font-semibold">{{ pet.name }}</span> - {{ pet.gender }} {{ pet.species }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-8 mt-12">
                    <h2 class="text-3xl font-semibold text-teal-600 mb-6">Pets Adopted by {{ user.name }}</h2>
                    <div v-if="adopted_pets.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div v-for="pet in adopted_pets" :key="pet.id" class="p-6 bg-teal-50 rounded-lg shadow hover:bg-teal-100 transition cursor-pointer" @click="viewPetDetails(pet.id)">
                            <p class="text-gray-700 text-lg"><span class="font-semibold">{{ pet.name }}</span> - {{ pet.gender }} {{ pet.species }}</p>
                        </div>
                    </div>
                    <p v-else class="text-gray-500 text-lg text-center">No pets adopted yet.</p>
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
    user: Object,
    pets:Object,
    adopted_pets:Object,

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
    return ` ${day} ${month} ${year}`;
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
