<script setup>
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

dayjs.extend(relativeTime);
const props=defineProps(['post']);

const form = useForm({
    message: props.post.message,
});

const editing = ref(false);
</script>
<template>
    <div class="p-6 flex space-x-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-lg font-bold text-teal-700">From Pet Parent - {{ post.user.name }}</span>
                    <small class="ml-2 text-sm text-gray-400">{{ dayjs(post.created_at).fromNow() }}</small>
                    <small v-if="post.created_at !== post.updated_at" class="text-sm text-gray-400"> &middot; edited</small>
                </div>
                <Dropdown v-if="post.user.id === $page.props.auth.user.id">
                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 hover:text-gray-700 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                            Edit
                        </button>
                        <DropdownLink as="button" :href="route('posts.destroy', post.id)" method="delete" class="text-sm leading-5 text-red-600 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out">
                            Delete
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <form v-if="editing" @submit.prevent="form.put(route('posts.update', post.id), { onSuccess: () => editing = false })" class="mt-4">
                <textarea v-model="form.message" class="w-full p-4 text-gray-800 border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-lg shadow-sm resize-none h-28"></textarea>
                <InputError :message="form.errors.message" class="mt-2" />
                <div class="flex space-x-2 mt-4">
                    <PrimaryButton>Save</PrimaryButton>
                    <button class="text-gray-500 hover:text-gray-700 transition-colors" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
            <p v-else class="mt-4 text-lg leading-relaxed text-gray-700 whitespace-pre-line">{{ post.message }}</p>
        </div>
    </div>
</template>



