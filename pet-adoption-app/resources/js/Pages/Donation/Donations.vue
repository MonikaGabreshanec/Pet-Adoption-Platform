<script setup>


import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { defineProps, ref, computed } from 'vue';
import { Link } from "@inertiajs/vue3";
import {Inertia} from "@inertiajs/inertia";
import {useRouter} from "vue-router";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Footer from "@/Layouts/Footer.vue";

const props = defineProps(['donations']);

const selectedLocation = ref('');
const router = useRouter();

function getPage(url) {
    Inertia.get(url, {}, { preserveState: true });
}


const deletePost = (id) => {
    Inertia.delete(route('donations.destroy', { id }));
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="container_donations mx-auto py-8 bg-[#F7F0E8]">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-[#284268]"><span style="color:#5E8E8C"> Support Pets</span> in Need Across the Country</h1>
                <p class="text-xl font-bold text-gray-600 mt-3">
                    Help animals in your area and beyond. Your contribution can make a significant difference in their lives.
                </p>
                <Link :href="route('donations.create')" class="text-xl text-gray-600 mt-12">
                    Need Help or Looking for Donations?<span class="text-xl font-bold" style="color:#5E8E8C"> Post Your Request Here!</span>
                </Link>
            </div>

            <div class="container mx-auto py-8">
                <div class=" donation-card max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div
                        v-for="donation in donations"
                        :key="donation.id"
                        class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 flex items-center"
                    >
                        <div class="  w-full lg:w-2/3">
                            <p class="text-xl font-semibold text-teal-700">
                                {{ donation.title }}
                            </p>
                            <p class="text-lg text-gray-600">
                                <strong>Location:</strong> {{ donation.location }}
                            </p>
                            <p class="mt-2 text-gray-700">
                                <strong>Contact:</strong> {{ donation.email }} | {{ donation.phone_number }}
                            </p>
                            <p class="mt-4 text-gray-700">
                                {{ donation.description }}
                            </p>
                            <p class="text-md text-gray-500 mt-2">
                                Transaction Acc: {{ donation.transaction }}
                            </p>
                            <p class="flex items-center text-gray-600" style="margin-top: 10px " @click="deletePost(donation.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>


                            </p>
                        </div>
                        <div class="w-full lg:w-1/3">
                            <img
                                :src="`/storage/${donation.image}`"
                                :alt="donation.title"
                                class=" donation-image  object-cover rounded-lg"
                            />
                        </div>

                    </div>

                </div>

</div>

            <div class="flex justify-center mt-4">
                <button v-if="donations.prev_page_url" @click="getPage(donations.prev_page_url)" class="bg-gray-200 px-4 py-2 rounded-l">Previous</button>
                <button v-if="donations.next_page_url" @click="getPage(donations.next_page_url)" class="bg-gray-200 px-4 py-2 rounded-r">Next</button>
            </div>
        </div>


        <Footer></Footer>
    </AuthenticatedLayout>
</template>


<style scoped>
.donations-container{
    align-items: center;
    margin-right: 100px;

}
.donation-image {

}

.donation-card{



}
</style>
