_at
<template>
    <div>
        <PageComponent title="Survey Details"></PageComponent>
        <div class="container px-3">
            <div class="bg-gray-100 rounded-md">
                <div class="grid grid-cols-12 p-3 gap-3">
                    <div class="col-span-4">
                        <img :src="surveyData.survey.image" alt="" />
                    </div>
                    <div class="col-span-8">
                        <h1 class="text-2xl font-bold">
                            {{ surveyData.survey.title }}
                        </h1>
                        <p class="my-2 text-sm text-gray-900">
                            {{ surveyData.survey.description }}
                        </p>
                        <div class="pt-3 font-semibold text-sm">
                            <p>Client: {{ surveyData.survey.client_id }}</p>
                            <p>
                                Employe/User: {{ surveyData.survey.employe_id }}
                            </p>
                            <p>
                                Status:
                                {{
                                    surveyData.survey.status === 1
                                        ? "Active"
                                        : "Inactive"
                                }}
                            </p>
                            <p>
                                Created At: {{ surveyData.survey.created_at }}
                            </p>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="px-3 py-2 bg-gray-100 rounded-md">
                    <div v-if="model.ss.specificDetail">
                        <SurveyAnswerQuestion
                            :ans="model"
                            :answer="goToAnswerQuestionPage"
                        />
                    </div>
                    <div
                        v-else
                        class="grid grid-cols-12 px-3 py-2 my-2 bg-white rounded-md shadow-md trans cursor-pointer"
                        v-for="(ans, i) of surveyData.answers"
                        :key="i"
                        @click="goToAnswerQuestionPage([true, ans])"
                    >
                        <div class="col-span-1 my-auto">{{ i + 1 }}.</div>

                        <div class="col-span-6 my-auto">
                            {{ ans.start_date }}
                        </div>
                        <div class="flex col-span-4 gap-3 m-auto">
                            Questions/Answers({{ ans.detail.length }})
                        </div>
                    </div>
                </div>
                <div class="mt-3"></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import PageComponent from "../components/PageComponent.vue";
import SurveyAnswerQuestion from "../views/SurveyAnswerQuestion.vue";
import { useStore } from "vuex";
const route = useRoute();
const store = useStore();
const router = useRouter();
const model = ref({
    ss: {
        specificDetail: false,
        data: [],
    },
});
store.dispatch("getSurveyDetail", route.params.id);
const surveyData = computed(() => store.state.surveyDetails.surveyData);
function goToAnswerQuestionPage([condition, ans]) {
    model.value.ss.specificDetail = condition;
    model.value.ss.data = ans;
}
</script>

<style></style>
