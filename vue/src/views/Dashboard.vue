<template>
    <div class="">
        <PageComponent title="Dashboard"> </PageComponent>

        <div v-if="loading" class="flex justify-center">Loading...</div>
        <div
            v-else
            class="grid grid-cols-1 gap-5 text-gray-700 md:grid-cols-2 lg:grid-cols-3"
        >
            <div
                class="flex flex-col p-3 text-center bg-white shadow-md animate-fade-in-down"
            >
                <h3 class="text-2xl font-semibold">Latest Survey</h3>
                <img
                    :src="data.latestSurvey.image_url"
                    alt=""
                    class="w-[240px] mx-auto mt-4"
                />
                <h3 class="mt-3 mb-3 text-xl font-bold">
                    {{ data.latestSurvey.title }}
                </h3>
                <div>Upload Date:</div>
                <div class="">{{ data.latestSurvey.created_at }}</div>
                <div class="flex justify-between mt-3 mb-3 text-sm">
                    <div class="">Answers:</div>
                    <div class="">{{ data.latestSurvey.answers }}</div>
                </div>
                <div class="flex justify-between">
                    <router-link
                        :to="{
                            name: 'SurveyUpdate',
                            params: { id: data.latestSurvey.id },
                        }"
                        class="flex px-4 py-2 text-sm text-indigo-500 transition-colors border border-transparent rounded-md hover:bg-indigo-700 hover:text-white focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Edit Survey
                    </router-link>
                    <button
                        class="flex px-4 py-2 text-sm text-indigo-500 transition-colors border border-transparent rounded-md hover:bg-indigo-700 hover:text-white focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        View Answers
                    </button>
                </div>
            </div>

            <div>
                <div
                    class="flex flex-col p-5 text-center bg-white shadow-md animate-fade-in-down"
                >
                    <h3 class="text-2xl font-semibold">Total Surveys</h3>
                    <div
                        class="flex items-center justify-center flex-1 font-semibold text-8xl"
                    >
                        {{ data.totalSurveys }}
                    </div>
                </div>
                <div
                    class="flex flex-col p-5 mt-3 text-center bg-white shadow-md animate-fade-in-down"
                >
                    <h3 class="text-2xl font-semibold">Total Answers</h3>
                    <div
                        class="flex items-center justify-center flex-1 font-semibold text-8xl"
                    >
                        {{ data.totalAnswers }}
                    </div>
                </div>
            </div>

            <div
                class="flex flex-col p-3 text-center bg-white shadow-md animate-fade-in-down"
            >
                <div class="flex items-center justify-between px-2 mb-3">
                    <h3 class="text-2xl font-semibold">Latest Answers</h3>
                    <a
                        href="#"
                        class="text-sm text-blue-500 hover:decoration-blue-500"
                        >View All</a
                    >
                </div>
                <hr class="mt-2 mb-3" />
                <a
                    href="#"
                    v-for="answer of data.latestAnswers"
                    :key="answer.id"
                    class="block p-2 mt-2 text-left hover:bg-gray-100/90"
                >
                    <div class="font-semibold">
                        {{ answer.survey.title }}
                    </div>
                    <small>
                        Answer Made at:
                        <i class="font-semibold">{{ answer.end_date }}</i>
                    </small>
                </a>
            </div>
        </div>
    </div>
</template>
<script setup>
import PageComponent from "../components/PageComponent.vue";

import { useStore } from "vuex";
import { computed } from "vue";
const store = useStore();
const loading = computed(() => store.state.dashboard.loading);
const data = computed(() => store.state.dashboard.data);

store.dispatch("getDashboardData");
</script>
<style scoped></style>
