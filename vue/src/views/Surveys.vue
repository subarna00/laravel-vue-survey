<template>
    <div>
        <PageComponent>
            <template v-slot:header>
                <div class="flex items-center justify-between">
                    <h1 class="font-bold text-1xl text-grey-900">Surveys</h1>
                    <router-link
                        :to="{ name: 'SurveyCreate' }"
                        class="px-3 py-1 text-sm text-white rounded-md bg-emerald-500 hover:bg-emerald-600"
                    >
                        Add Survey
                    </router-link>
                    <a
                        @click="downloadInExcell"
                        class="px-3 py-1 text-sm text-white rounded-md bg-emerald-500 hover:bg-emerald-600"
                    >
                        Download Survey
                    </a>
                </div>
            </template>
        </PageComponent>
        <div
            v-if="surveys.loading"
            class="flex items-center justify-center mt-10 font-semibold"
        >
            Loading....
        </div>
        <div v-else class="container px-4">
            <div class="px-3 py-2 bg-gray-100 rounded-md">
                <SurveyListItem
                    v-for="(survey, index) in surveys.data"
                    :key="survey.id"
                    :survey="survey"
                    :index="index"
                    class="animate-fade-in-down"
                    :style="{ animationDelay: `${index * 0.1}s` }"
                    @delete="deleteSurvey(survey)"
                />
                <div class="flex justify-center mt-5">
                    <nav
                        class="relative z-0 inline-flex justify-center rounded-md shadow-sm"
                        aria-label="Pagination"
                    >
                        <a
                            v-for="(link, i) of surveys.links"
                            :key="i"
                            :disabled="!link.url"
                            v-html="link.label"
                            href="#"
                            @click="getForPage(link)"
                            aria-current="page"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium border whitespace-nowrap"
                            :class="[
                                link.active
                                    ? 'z-10 bg-indigo-100 border-indigo-500 text-indigo-600'
                                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                i === 0 ? 'rounded-l-md' : '',
                                i === surveys.links.length - 1
                                    ? 'rounded-r-md'
                                    : '',
                            ]"
                        ></a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { computed } from "vue";
import store from "../store";
import PageComponent from "../components/PageComponent.vue";
import SurveyListItem from "../components/editor/SurveyListItem.vue";
const surveys = computed(() => store.state.surveys);
store.dispatch("getSurveys");
function deleteSurvey(survey) {
    if (
        confirm(
            `Are you sure you want to delete this survey? Operation can't be undone.`
        )
    ) {
        store.dispatch("deleteSurvey", survey.id).then(() => {
            store.dispatch("getSurveys");
        });
    }
}
function downloadInExcell() {
    store.dispatch("surveyExcellDownload");
}
function getForPage(link) {
    if (!link.url || link.active) {
        return;
    }
    store.dispatch("getSurveys", { url: link.url });
}
</script>
