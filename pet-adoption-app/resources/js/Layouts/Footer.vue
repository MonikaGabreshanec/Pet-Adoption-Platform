<script setup>

import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import {Link} from "@inertiajs/vue3";
</script>

<template>

    <footer class="bg-[#5E8E8C] text-white py-8 mt-9">
        <div class="container mx-auto px-4">
            <section class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 text-center md:text-left items-center">
                    <div class="flex flex-col items-center ">
                        <Link :href="route('home')" class="flex items-center mb-4">
                            <ApplicationLogo class="block h-16 w-auto fill-current text-white" />
                        </Link>
                        <p class="italic text-lg">Where Every Pet Finds a Loving Home</p>
                    </div>

                    <div class="ml-16">
                        <ul class="list-none space-y-2">
                            <li><a class="hover:text-gray-200 transition" :href="route('pets.index')">Adopt A Pet</a></li>
                            <li><a class="hover:text-gray-200 transition" :href="route('pets.create')">Post A Pet For Adoption</a></li>
                            <li><a class="hover:text-gray-200 transition" :href="route('lost-pets.index')">Post A Lost Pet</a></li>
                        </ul>
                    </div>

                    <div>
                        <ul class="list-none space-y-2">
                            <li><a class="hover:text-gray-200 transition" :href="route('donations.index')">Donate And Help</a></li>
                            <li><a class="hover:text-gray-200 transition" :href="route('posts.index')">Blog</a></li>
                            <li><a class="hover:text-gray-200 transition" :href="route('faqs.index')">FAQs</a></li>
                        </ul>
                    </div>

                    <div class="flex flex-col items-center ">
                        <h3 class="font-semibold mb-3"><span style="margin-left: 70px">Contact Us </span><br>info@petadoptionplatform.com</h3>
                        <div class="flex space-x-4">
                            <a href="#!" class="text-gray-300 hover:text-white transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.675 0H1.325C.593 0 0 .593 0 1.326v21.348C0 23.407.593 24 1.325 24h11.495V14.708h-3.13v-3.62h3.13V8.587c0-3.1 1.893-4.788 4.656-4.788 1.324 0 2.463.098 2.794.143v3.24h-1.917c-1.505 0-1.798.715-1.798 1.765v2.314h3.594l-.468 3.62h-3.126V24h6.127C23.407 24 24 23.407 24 22.674V1.326C24 .593 23.407 0 22.675 0z"/>
                                </svg>
                            </a>

                            <a href="#!" class="text-gray-300 hover:text-white transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.954 4.569c-.885.392-1.83.656-2.825.775 1.014-.608 1.794-1.574 2.163-2.724-.951.563-2.005.974-3.127 1.194-.896-.957-2.173-1.555-3.591-1.555-2.717 0-4.92 2.205-4.92 4.921 0 .385.043.76.126 1.122-4.087-.205-7.719-2.165-10.148-5.144-.423.726-.664 1.562-.664 2.457 0 1.694.861 3.188 2.168 4.068-.799-.025-1.553-.245-2.211-.613v.062c0 2.366 1.683 4.341 3.918 4.79-.41.111-.843.171-1.287.171-.314 0-.615-.031-.916-.088.631 1.953 2.445 3.376 4.6 3.414-1.68 1.316-3.808 2.101-6.104 2.101-.397 0-.788-.024-1.177-.069 2.179 1.394 4.768 2.207 7.548 2.207 9.055 0 14.001-7.496 14.001-13.987 0-.213-.004-.426-.015-.637.961-.694 1.8-1.562 2.46-2.549z"/>
                                </svg>
                            </a>

                            <a href="#!" class="text-gray-300 hover:text-white transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.849.07 1.206.055 1.926.24 2.379.402.513.182.88.4 1.268.768.388.368.586.734.768 1.268.162.453.347 1.173.402 2.379.058 1.265.07 1.645.07 4.849s-.012 3.584-.07 4.849c-.055 1.206-.24 1.926-.402 2.379-.182.513-.4.88-.768 1.268-.368.388-.734.586-1.268.768-.453.162-1.173.347-2.379.402-1.265.058-1.645.07-4.849.07s-3.584-.012-4.849-.07c-1.206-.055-1.926-.24-2.379-.402-.513-.182-.88-.4-1.268-.768-.388-.368-.586-.734-.768-1.268-.162-.453-.347-1.173-.402-2.379-.058-1.265-.07-1.645-.07-4.849s.012-3.584.07-4.849c.055-1.206.24-1.926.402-2.379.182-.513.4-.88.768-1.268.368-.388.734-.586 1.268-.768.453-.162 1.173-.347 2.379-.402 1.265-.058 1.645-.07 4.849-.07M12 0C8.741 0 8.332.012 7.052.07c-1.277.059-2.15.268-2.908.57-.784.313-1.452.732-2.119 1.399-.667.667-1.086 1.335-1.399 2.119-.303.758-.511 1.631-.57 2.908C.012 8.332 0 8.741 0 12c0 3.259.012 3.668.07 4.948.059 1.277.268 2.15.57 2.908.313.784.732 1.452 1.399 2.119.667.667 1.335 1.086 2.119 1.399.758.303 1.631.511 2.908.57C8.332 23.988 8.741 24 12 24c3.259 0 3.668-.012 4.948-.07 1.277-.059 2.15-.268 2.908-.57.784-.313 1.452-.732 2.119-1.399.667-.667 1.086-1.335 1.399-2.119.303-.758.511-1.631.57-2.908.058-1.28.07-1.689.07-4.948s-.012-3.668-.07-4.948c-.059-1.277-.268-2.15-.57-2.908-.313-.784-.732-1.452-1.399-2.119-.667-.667-1.335-1.086-2.119-1.399-.758-.303-1.631-.511-2.908-.57C15.668.012 15.259 0 12 0zM12 5.838a6.163 6.163 0 100 12.325 6.163 6.163 0 000-12.325zm0 10.125a3.962 3.962 0 110-7.925 3.962 3.962 0 010 7.925zm6.406-11.7a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                </svg>
                            </a>

                            <a href="#!" class="text-gray-300 hover:text-white transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.72v-5.569c0-1.327-.025-3.034-1.849-3.034-1.851 0-2.135 1.444-2.135 2.937v5.666h-3.719V9.499h3.571v1.494h.051c.498-.942 1.711-1.936 3.523-1.936 3.761 0 4.457 2.475 4.457 5.694v6.701zM5.337 8.007c-1.2 0-2.172-.975-2.172-2.173 0-1.2.975-2.172 2.172-2.172s2.172.975 2.172 2.172c0 1.199-.974 2.173-2.172 2.173zM3.666 20.452h3.339V9.499H3.666v10.953zM22.225 0H1.771C.791 0 0 .791 0 1.771v20.457C0 23.209.791 24 1.771 24h20.457C23.209 24 24 23.209 24 22.229V1.771C24 .791 23.209 0 22.225 0z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>


                <hr class="my-4 border-gray-200" />

                <div class="text-center ">
                    <p class="text-sm text-gray-300">© 2024 Pet Adoption Platform. All rights reserved.</p>
                </div>
            </section>
        </div>
    </footer>
</template>



<style scoped>

</style>
