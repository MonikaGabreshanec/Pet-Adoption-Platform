<script setup>

import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="absolute inset-0 bg-white opacity-75 bg-custom  flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>

<style>
.bg-custom {
background-image: url('/images/mainpage.jpg');
background-size: cover;
background-position: center;


}
</style>
