<template>
    <div>
        <div class="flex justify-between">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-10 w-10"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                @click="answer([false, []])"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"
                />
            </svg>

            <p class="font-bold">{{ ans.ss.data.start_date }}</p>
        </div>
        <div class="my-3 py-2 px-3">
            <div v-for="(details, index) of ans.ss.data.detail" :key="index">
                <div class="bg-white p-3 my-2">
                    <p>
                        <span>{{ index + 1 }}.</span>
                        {{ details.question.question }}
                    </p>
                    <p>{{ details.question.description }}</p>
                    <p>{{ details.question.data }}</p>
                    <p>{{ details.answer }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useStore } from "vuex";
import { computed } from "vue";
const store = useStore();
const props = defineProps({
    ans: Object,
    answer: Function,
});
</script>

<style></style>
