<template>
    <AuthenticatedLayout>

        <section class="py-60 bg-[#F7F0E8]">
            <div class="container_donations mx-auto py-8">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-[#284268]">Tips/FAQs</h1>
                </div>

                <div class="faqs-section ">
                    <div
                        v-for="(faq, index) in faqs"
                        :key="faq.id"
                        class="faq accordion"
                    >
                        <div class="question-wrapper" @click="toggle(index)">
                            <div class="d-flex align-items-center">
                                <p class="question">{{ faq.title }}</p>
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-chevron-down"
                                viewBox="0 0 16 16"
                                :class="{ 'icon-expand': expandedIndex === index }"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"
                                />
                            </svg>
                        </div>
                        <div class="answer-wrapper" :style="{ maxHeight: expandedIndex === index ? '1000px' : '0' }">
                            <p class="answer">{{ faq.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>



    </AuthenticatedLayout>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import $ from "../../../../public/build/assets/UpdatePasswordForm-bf0be81a";
import {defineProps} from "vue";

const props = defineProps(['faqs']);

</script>
<script>

export default {
    props: {
        faqs: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            expandedIndex: null,
        };
    },
    methods: {
        toggle(index) {
            this.expandedIndex = this.expandedIndex === index ? null : index;
        },
    },
};
</script>
<style>
.py-60 {
    padding: 60px 0;

}
section {
    background: #f3f3f3;
    border-radius: 8px;
}

.answer-wrapper {
    overflow: hidden;
    transition: max-height 0.5s ease-out;
    max-height: 0; /* Initially collapsed */
    border-radius: 8px;
}
.accordion {
    background-color: #fff;
    color: #444;
    cursor: pointer;
    width: 60%;
    margin-bottom: 20px;
    text-align: left;
    border: none;
    outline: none;
    transition: 0.2s;
    box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.2);
    border-radius: 8px;
    margin-left: 300px;

}
.icon-expand {
    transform: rotate(180deg);
}

.accordion:hover .question {
    color: #fff;
    border-radius: 8px;
}
.question {
    font-size: 20px;
    color: #284268;
    line-height: 1.5;
    font-weight: bold;
    margin-bottom: 0;
    padding: 16px 16px 32px 15px;

}

.answer {
    font-size: 18px;
    color: #284268;
    padding: 16px 16px 32px 15px;
    background-color: #fff;
    overflow: hidden;
}
.question-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background-color 0.25s ease-in-out;
}
.active,
.accordion:hover .question-wrapper {
    background-color: #5E8E8C;
    color: white;
    border-radius: 8px;
}
.icon-expend {
    transform: rotateX(180deg);
    transition: transform 0.75s ease-in-out;
}

</style>
