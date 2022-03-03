<template>
    <div class="">
        <PageComponent title="Survey Questions/Answers"></PageComponent>
        <div class="container rounded-md">
            <div class="px-8 py-5 bg-gray-100 rounded-md">
                <div v-if="loading" class="flex justify-center">Loading...</div>
                <form
                    v-else
                    class="container mx-auto"
                    @submit.prevent="submitSurvey"
                >
                    <div class="grid items-center grid-cols-12">
                        <div v-if="survey.image_url" class="col-span-4 mr-4">
                            <img :src="survey.image_url" :alt="survey.title" />
                        </div>
                        <div class="col-span-8">
                            <h1 class="mb-3 text-3xl">
                                {{ survey.title }}
                            </h1>
                            <p class="text-sm text-gray-500">
                                {{ survey.description }}
                            </p>
                        </div>
                    </div>
                    <div v-if="surveyFinished">
                        <div class="mb-3 text-xl font-semibold">
                            Thank you for participating in this survey.
                        </div>
                        <button
                            type="button"
                            @click="submitAnotherResponse"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm"
                        >
                            Submit another response
                        </button>
                    </div>
                    <div v-else>
                        <hr class="my-3" />
                        <div
                            v-for="(question, index) of survey.questions"
                            :key="question.id"
                        >
                            <QuestionViewer
                                v-model="answers[question.id]"
                                :question="question"
                                :index="index"
                            />
                        </div>
                        <button
                            class="px-4 py-2 bg-indigo-600 border shadow-sm"
                            type="submit"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";
import { useRoute } from "vue-router";
import QuestionViewer from "../components/viewer/QuestionViewer.vue";
import PageComponent from "../components/PageComponent.vue";
import { useStore } from "vuex";
const route = useRoute();
const store = useStore();
const loading = computed(() => store.state.currentSurvey.loading);
const survey = computed(() => store.state.currentSurvey.data);
const surveyFinished = ref(false);
const answers = ref({});
store.dispatch("getSurveyBySlug", route.params.slug);

function submitSurvey() {
    store
        .dispatch("saveSurveyAnswer", {
            surveyId: survey.value.id,
            answers: answers.value,
        })
        .then((res) => {
            if (res.status === 201) {
                surveyFinished.value = true;
            }
        });
}
function submitAnotherResponse() {
    answers.value = {};
    surveyFinished.value = false;
}
</script>

<style></style>
