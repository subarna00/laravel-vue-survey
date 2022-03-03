<template>
    <!-- <div
        class="flex flex-col py-4 px-6 shadow-md bg-white hover:bg-gray-50 h-[470px]"
    >
        <img :src="survey.image_url" class="object-cover w-full h-48" />
        <h4 class="mt-4 text-lg font-bold">{{ survey.title }}</h4>
        <div v-html="survey.description" class="flex-1 overflow-hidden"></div>
        <div class="flex items-center justify-between mt-3">
            <router-link
                :to="{
                    name: 'SurveyUpdate',
                    params: { id: survey.id },
                }"
                class="flex px-4 py-2 text-sm text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                Edit
            </router-link>
            <div class="flex items-center">
                <a
                    :href="`/view/survey/${survey.slug}`"
                    target="_blank"
                    class="items-center justify-center px-2 py-1 mx-1 text-sm text-indigo-500 align-middle border border-transparent rounded-md"
                    >View</a
                >
                <button
                    v-if="survey.id"
                    type="button"
                    @click="emit('delete', survey)"
                    class="flex items-center justify-center w-8 h-8 text-sm text-red-500 border border-transparent rounded-full focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div> -->
    <router-link :to="{ name: 'SurveyDetails', params: { id: survey.id } }">
        <div
            class="grid grid-cols-12 px-3 py-2 my-2 bg-white rounded-md shadow-md trans"
        >
            <div class="col-span-1 my-auto">{{ index + 1 }}.</div>
            <div class="col-span-1 mr-auto">
                <img
                    :src="survey.image_url"
                    alt=" "
                    class="object-cover w-10 h-10"
                />
            </div>
            <div class="col-span-6 my-auto">
                <span class="gap-2 font-bold text-1xl">
                    {{ survey.title }}
                </span>
            </div>
            <div class="flex col-span-4 gap-3 m-auto">
                <router-link
                    :to="`/view/survey/${survey.slug}`"
                    class="items-center justify-center px-2 py-1 mx-1 text-sm text-indigo-500 align-middle border border-transparent rounded-md"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-indigo-600 hover:text-indigo-700 hover:ring-2 hover:rounded-full hover:p-1 hover:border-indigo-800"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                        /></svg
                ></router-link>

                <router-link
                    :to="{
                        name: 'SurveyUpdate',
                        params: { id: survey.id },
                    }"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-blue-600 hover:text-blue-700 hover:ring-2 hover:rounded-full hover:p-1 hover:border-blue-800"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        />
                    </svg>
                </router-link>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 text-red-600 hover:text-red-700 hover:ring-2 hover:rounded-full hover:p-1 hover:border-red-800"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    @click="emit('delete', survey)"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                    />
                </svg>
            </div>
        </div>
    </router-link>
</template>

<script setup>
const props = defineProps({
    survey: Object,
    index: Number,
});
const emit = defineEmits(["delete"]);
</script>

<style></style>
