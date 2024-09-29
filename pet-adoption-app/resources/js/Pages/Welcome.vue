<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Pet Adoption"/>

    <div
        class="absolute inset-0 bg-white opacity-75 bg-custom bg-center bg-cover selection:bg-red-500 selection:text-white"
    >
        <div v-if="canLogin" class="sm:fixed sm:top-1 sm:right-0 p-6 text-right">
          <Link
                v-if="$page.props.auth.user"
                :href="route('home')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Home</Link
            >


            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold  text-xl text-gray-900 hover:text-white dark:text-gray-400 dark:hover:text-white "
                    >Log in |</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="font-semibold   text-xl text-gray-900 hover:text-white dark:text-gray-400 dark:hover:text-white "
                >
                    Register</Link
                >
            </template>

        </div>

            <div class="sm:fixed sm:top-60 sm:right-0 p-6 text-right">


                <h1 class="text-5xl font-bold text-gray-800">Change a Life, Adopt a Pet!</h1>

                <div class="sm:fixed sm:top-90 sm:right-40 p-6 text-right" >
                    <Link
                        :href="route('register')"
                        class="px-6 py-3 text-xl font-semibold text-gray-800 border border-gray-800 rounded-full bg-transparent hover:bg-gray-800 hover:text-white transition duration-300 "
                    >Find Your Furry Friend Today!</Link
                    >
                </div>
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
