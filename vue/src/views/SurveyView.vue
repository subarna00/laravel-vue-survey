<template>
    <div>
        <PageComponent>
            <template v-slot:header>
                <div class="flex items-center justify-between">
                    <h1 class="font-bold text-1xl text-grey-900">
                        {{ route.params.id ? model.title : "Create a Survey" }}
                    </h1>
                    <button
                        v-if="route.params.id"
                        type="button"
                        @click="deleteSurvey()"
                        class="px-3 py-2 text-white bg-red-500 rounded-md hover:bg-red-600"
                    >
                        Delete Survey
                    </button>
                </div>
            </template>
        </PageComponent>
        <form v-if="!loading" @submit="saveSurvey" class="animate-fade-in-down">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 space-y-6 bg-white sm:p-6">
                    <div class="grid grid-cols-12 gap-3">
                        <div class="col-span-4">
                            <label
                                for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                >Client</label
                            >
                            <select
                                name="status"
                                id=""
                                v-model="model.client_id"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option value="">Select Client</option>
                                <option
                                    v-for="cl in client"
                                    :key="cl.id"
                                    :value="cl.id"
                                >
                                    {{ cl.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-span-4">
                            <label
                                for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                >Employe/Users</label
                            >
                            <select
                                name="status"
                                id=""
                                v-model="model.employe_id"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option value="">Select Employe</option>
                                <option
                                    v-for="cl in employe"
                                    :key="cl.id"
                                    :value="cl.id"
                                >
                                    {{ cl.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-span-4">
                            <label
                                class="block text-sm font-medium text-grey-700"
                                >Image</label
                            >
                            <div class="flex items-center mt-1">
                                <img
                                    v-if="model.image_url"
                                    :src="model.image_url"
                                    :alt="model.title"
                                    class="object-cover w-64 h-48"
                                />
                                <span
                                    v-else
                                    class="flex items-center justify-center w-12 h-12 overflow-hidden rounded-full bg-grey-100"
                                >
                                    <svg
                                        class="w-full h-full text-gray-300"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"
                                        />
                                    </svg>
                                </span>
                                <button
                                    type="button"
                                    class="relative inline-flex justify-center px-4 py-2 mx-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    <input
                                        type="file"
                                        @change="onImageChoose"
                                        class="absolute top-0 bottom-0 left-0 right-0 opacity-0 cursor-pointer"
                                    />
                                    Change
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <label
                            for="title"
                            class="block text-sm font-medium text-gray-700"
                            >Title</label
                        >
                        <input
                            type="text"
                            name="title"
                            id="title"
                            v-model="model.title"
                            autocomplete="survey_title"
                            placeholder="Survey title"
                            class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        />
                    </div>

                    <div class="">
                        <label
                            for="title"
                            class="block text-sm font-medium text-gray-700"
                            >Description</label
                        >
                        <div class="mt-1">
                            <textarea
                                name="description"
                                id="description"
                                cols="30"
                                rows="5"
                                v-model="model.description"
                                autocomplete="survey_descripiton"
                                placeholder="Describe your survey"
                                class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            ></textarea>
                        </div>
                    </div>

                    <div class="">
                        <label
                            for="expire_date"
                            class="block text-sm font-medium text-gray-700"
                            >Expiry Date</label
                        >
                        <input
                            type="date"
                            name="expiry_date"
                            id="expire_date"
                            v-model="model.expire_date"
                            autocomplete="survey_expire_date"
                            placeholder="Survey expire_date"
                            class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        />
                    </div>

                    <div class="flex item-start">
                        <div class="flex items-center h-5">
                            <input
                                type="checkbox"
                                name="status"
                                v-model="model.status"
                                id="status"
                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                            />
                        </div>
                        <div class="ml-3 text-sm">
                            <label
                                for="status"
                                class="font-medium text-grey-700"
                                >Active</label
                            >
                        </div>
                    </div>
                    <!-- quws -->

                    <div class="px-2 py-3 space-y-6 border rounded-md sm:p-6">
                        <h3
                            class="flex justify-between text-2xl font-semibold itens-center"
                        >
                            Questions
                            <button
                                type="button"
                                @click="addQuestion()"
                                class="flex items-center px-4 py-2 text-sm text-white bg-gray-600 rounded-sm hover:bg-gray-700"
                            >
                                +Add Question
                            </button>
                        </h3>
                        <div
                            v-if="model.questions.length === 0"
                            class="font-bold text-center text-gray-600"
                        >
                            You don't have any questions created.
                        </div>
                        <div
                            v-else
                            v-for="(question, index) in model.questions"
                            :key="question.id"
                        >
                            <QuestionEditior
                                :question="question"
                                :index="index"
                                @change="questionChange"
                                @addQuestion="addQuestion"
                                @deleteQuestion="deleteQuestion"
                            />
                        </div>
                    </div>

                    <!-- save button -->

                    <div class="px-4 py-3 text-right bg-grey-50 sm:px-6">
                        <button
                            type="submit"
                            class="px-4 py-2 text-white bg-indigo-800 rounded rounded-md hover:bg-indigo-900"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div
            v-else
            class="flex items-center justify-center mt-10 font-semibold"
        >
            Loading....
        </div>
    </div>
</template>
<script setup>
import { ref, watch, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import PageComponent from "../components/PageComponent.vue";
import QuestionEditior from "../components/editor/QuestionEditor.vue";
import { v4 as uuidv4 } from "uuid";

import store from "../store";
const route = useRoute();
const router = useRouter();
const loading = computed(() => store.state.currentSurvey.loading);
let model = ref({
    title: "",
    status: false,
    description: null,
    image_url: null,
    image: null,
    client_id: null,
    employe_id: null,
    expire_date: null,
    questions: [],
});

watch(
    () => store.state.currentSurvey.data,
    (newVal, oldVal) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newVal)),
            status: newVal.status !== "draft",
        };
    }
);

if (route.params.id) {
    store.dispatch("getSurvey", route.params.id);
}
store.dispatch("getClients");
store.dispatch("getEmployes");
const client = computed(() => store.state.clients.data);
const employe = computed(() => store.state.employes.data);
function onImageChoose(e) {
    const file = e.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {
        model.value.image_url = reader.result;
        model.value.image = reader.result;
    };
    reader.readAsDataURL(file);
}

function addQuestion(index) {
    const newQuestion = {
        id: uuidv4(),
        type: "text",
        question: "",
        description: "",
        data: {},
    };
    model.value.questions.splice(index, 0, newQuestion);
}
function deleteQuestion(question) {
    model.value.questions = model.value.questions.filter((q) => q !== question);
}
function questionChange(params) {
    model.value.questions = model.value.questions.map((q) => {
        if (q.id === params.id) {
            return JSON.parse(JSON.stringify(params));
        }
        return q;
    });
}
function saveSurvey(e) {
    e.preventDefault();
    store.dispatch("saveSurvey", model.value).then((res) => {
        store.commit("notify", {
            type: "success",
            message: "Survey was added successfully updated",
        });

        router.push({
            name: "Surveys",
        });
    });
}
function deleteSurvey(params) {
    if (
        confirm(
            `Are you sure you want to delete this survey ? Operation can't be undone.`
        )
    ) {
        store.dispatch("deleteSurvey", model.value.id).then(() => {
            router.push({
                name: "Surveys",
            });
        });
    }
}
</script>
