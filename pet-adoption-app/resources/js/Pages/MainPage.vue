
<template>
    <Head title="Pet Adoption"/>
    <AuthenticatedLayout>
        <div class="w-full">
            <div class="cover-container">
                <img
                    src="/images/img1.jpg"
                    alt="Hero Image"
                    class="w-full h-full object-cover"
                />
            </div>
        </div>

        <div class="container_mainpage mx-auto py-8">
            <div class="flex justify-center mb-6">
                <Link
                    :href="route('pets.index')"
                    class="text-center text-3xl font-bold "
                    style="color:#507E7C"
                >
                    Pets Available For Adoption

                </Link>
            </div>
            <div class="flex justify-center">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    <div v-for="(pet, index) in lastFourPets" :key="pet.id" class="bg-white shadow-md rounded-lg overflow-hidden p-2" style="width: 280px;height: 280px">
                        <img :src="`/storage/${pet.image}`" :alt="pet.species" class="w-full h-56 object-fit:none  rounded-2xl " @click="viewPetDetails(pet.id)">
                        <div class="p-3">
                            <p class="text-xl font-bold " style="text-align: center;color:#5E8E8C"> {{ pet.name }}</p>
                        </div>
                    </div>
                    <Link
                        :href="route('pets.index')"
                        class="text-right" style="margin-right: -850px;color:#5E8E8C; font-size: 18px;"
                    >
                        View All <span style="font-size: 22px; color: #5E8E8C">></span>

                    </Link>
                </div>

            </div>


            <h2 class="flex justify-center mb-10 mt-10 text-4xl font-extrabold tracking-wide" style="color:#5E8E8C">
                Celebrating Every Successful Adoption
            </h2>

            <div class="shadow-lg p-8 text-center w-full rounded-lg border border-gray-200" style="background-color:#88a4a4">
                <p class="text-lg text-white mb-4">Total Pets Adopted:</p>
                <p class="text-4xl font-bold text-teal-300">{{ adopted }}</p>
                <p class="mt-6 text-md text-white">
                    Our application process is designed to be user-friendly and efficient, ensuring that each adoption journey is smooth and fast.
                </p>
            </div>


            <div class="container_mainpage mx-auto py-8 mt-10">
                <div class="text-center mb-6">
                    <h2 class="text-center text-3xl font-bold " style="color:#507E7C">Uncover Ways to Get Involved and Make a Change</h2>
                </div>
                <div class="card-group_mainpage flex justify-center space-x-10">
                    <div class="card-mainpage text-center" style="width: 18rem;">
                        <img src="/images/paw_6168150.png" alt="Hero Image" class="card-img" />
                        <div class="card-body_mainpage">
                            <h5 class="card-title_m">Lost Pet</h5>
                            <p class="card-text_m">Lost Pet? Post your lost pet’s photo and details. Spread the word to find them quickly!</p>
                            <a :href="route('lost-pets.index')" class="btn_m">Go there</a>
                        </div>
                    </div>

                    <div class="card-mainpage text-center" style="width: 18rem;">
                        <img src="/images/gift_3903019.png" alt="Hero Image" class="card-img" style="width: 120px;height: 120px; margin-top: 10px" />
                        <div class="card-body_mainpage" style="margin-top: 20px">
                            <h5 class="card-title_m">Donate And Help</h5>
                            <p class="card-text_m">Every donation helps improve the lives of animals and supports ongoing rescue efforts.</p>
                            <a :href="route('donations.index')" class="btn_m">Go there</a>
                        </div>
                    </div>

                    <div class="card-mainpage text-center" style="width: 18rem;">
                        <img src="/images/laptop_2799324.png" alt="Hero Image" class="card-img" />
                        <div class="card-body_mainpage">
                            <h5 class="card-title_m">Helpful Tips/FAQs</h5>
                            <p class="card-text_m">Find solutions to common pet-related questions to enhance your experience as a pet owner.</p>
                            <a :href="route('faqs.index')" class="btn_m">Go there</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="shadow-lg p-10 bg-white  mt-10 mb-10">
                <h2 class="text-center mb-8 text-4xl font-extrabold tracking-wide" style="color:#5E8E8C">
                    Real-life Love Stories
                </h2>

                <div class="relative flex items-center justify-center">

                    <button @click="prevPost" class="absolute left-32 md:left-36 bg-white rounded-full p-2 shadow-md hover:bg-teal-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>


                    <div class="text-center max-w-xl mx-auto">
                        <blockquote class="italic text-2xl font-light text-teal-800 leading-relaxed">
                            “{{ posts[currentIndex]?.message }}”
                        </blockquote>
                        <p class="text-lg font-medium text-gray-700 mt-4">
                            - {{ posts[currentIndex]?.user?.name }}
                        </p>
                    </div>

                    <button @click="nextPost" class="absolute right-36 md:right-36 bg-white rounded-full p-2 shadow-md hover:bg-teal-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <Footer></Footer>
     </AuthenticatedLayout>

 </template>




 <script setup>
 import {computed, defineProps, onMounted, ref} from 'vue';
 import {Head, Link} from "@inertiajs/vue3";



 import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
 import {Inertia} from "@inertiajs/inertia";
 import Footer from "@/Layouts/Footer.vue";
 import ApplicationLogo from "@/Components/ApplicationLogo.vue";
 function viewPetDetails(petId) {
     Inertia.visit(route('pets.show', { id: petId }));
 }


 const props = defineProps({
     pets: Array,
     posts: Array,
     donationsCount: Number,
     adopted:Number,
 });



 const lastFourPets = computed(() => {
     if (props.pets && props.pets.length > 0) {
         return props.pets.slice(0,4);
     } else {
         return [];
     }
 });

 const currentIndex = ref(0);

 const posts = computed(() => {
     return props.posts || [];
 });

 const nextPost = () => {
     currentIndex.value = (currentIndex.value + 1) % posts.value.length;
 };

 const prevPost = () => {
     currentIndex.value = (currentIndex.value - 1 + posts.value.length) % posts.value.length;
 };
 </script>

 <style>
 .container_mainpage{
     background-color: #F7F0E8;
     margin-bottom: 0;

 }
 .card-group_mainpage {
     margin-top: 30px;
     display: flex;
     justify-content: center;
     gap: 1rem;
     padding: 70px;
     background-color:white;
 }

 .card-body_mainpage {
     width: 18rem;


 }
 .card-text_m{
     padding: 10px;

 }
 .card-title_m{
     padding: 10px;
     font-size: larger;
     font-weight: bolder;
     color:#536762;
 }
 .btn_m{

     font-size: 20px;
     border-radius: 6px;
     background-color: white;
     color: black;
     border: 3px solid #5E8E8C;

 }
 .btn_m:hover {
     background-color: #5E8E8C;
     color: white;
     box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
 }
 .card-img {
     width: 150px;
     height: 150px;
     text-align: center;
     margin-left: 70px;
     object-fit: cover;


 }
 .cover-container{
     display: flex;
     justify-content: center;
     height:500px;

 }
 .cover{
     width: 100%;
     height: 100%;
     object-fit: cover;
 }

 footer {

     padding-top: 0;
 }
 </style>
