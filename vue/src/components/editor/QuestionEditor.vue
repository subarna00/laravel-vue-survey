<template>
    <div class="px-3 py-3 bg-gray-300 rounded-md">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold">
                {{ index + 1 }}. {{ model.question }}
            </h3>
            <div class="flex items-center">
                <button
                    class="flex items-center px-3 py-1 mr-2 text-xs text-white bg-gray-600 rounded-sm hover:bg-gray-700"
                    type="button"
                    @click="addQuestion()"
                >
                    Add +
                </button>
                <button
                    class="flex items-center px-3 py-1 text-xs text-red-500 border border-transparent rounded-sm hover:text-red-600"
                    type="button"
                    @click="deleteQuestion()"
                >
                    Delete
                </button>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-3">
            <div class="col-span-9 mt-3">
                <label class="block text-sm font-medium text-gray-700">
                    Question Text
                </label>
                <input
                    type="text"
                    :name="'question_text_' + model.data"
                    @change="dataChange"
                    :id="'question_text_' + model.data"
                    v-model="model.question"
                    class="block w-full py-2 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
            </div>
            <div class="col-span-3 mt-3">
                <label
                    for="question_type"
                    class="block text-sm font-medium text-gray-700"
                    >Select Question Type</label
                >
                <select
                    name="question_type"
                    id="question_type"
                    v-model="model.type"
                    @change="typeChange"
                    class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                    <option
                        v-for="type in questionTypes"
                        :key="type"
                        :value="type"
                    >
                        {{ upperCaseFirst(type) }}
                    </option>
                </select>
            </div>
        </div>

        <div class="col-span-9 mt-3">
            <label
                :for="'question_description_' + model.id"
                class="block text-sm font-medium text-gray-700"
                >Description</label
            >
            <textarea
                :name="'question_description_' + model.id"
                :id="'question_description_' + model.id"
                cols="30"
                rows="5"
                @change="dataChange"
                v-model="model.description"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            ></textarea>
        </div>

        <div v-if="shouldHaveOptions()" class="mt-3">
            <h4
                class="flex items-center justify-between mb-1 text-sm font-semibold"
            >
                Options

                <button
                    type="button"
                    @click="addOption()"
                    class="flex items-center px-2 py-1 text-xs text-white bg-gray-600 rounded-sm hover:bg-gray-700"
                >
                    Add Option
                </button>
            </h4>
            <div
                v-if="!model.data.options.length"
                class="py-3 text-xs text-center text-gray-600"
            >
                You don't have any options defined
            </div>
            <div
                v-for="(option, index) in model.data.options"
                :key="option.uuid"
                class="flex items-center mt-3 mb-1"
            >
                <span class="w-6 text-sm">{{ index + 1 }}.</span>
                <input
                    type="text"
                    v-model="option.text"
                    @change="dataChange"
                    class="w-full px-2 py-2 mr-1 text-xs border border-gray-300 rounded-md focus:border-indigo-500"
                />
                <button
                    type="button"
                    @click="removeOption(option)"
                    class="flex items-center justify-center w-6 h-6 transition-colors border border-transparent rounded-full hover:bg-red-9500"
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

        <hr class="my-4" />
    </div>
</template>
<script setup>
import { ref, computed } from "vue";
import store from "../../store";
import { v4 as uuidv4 } from "uuid";
const props = defineProps({
    question: Object,
    index: Number,
});

const emit = defineEmits(["change", "addQuestion", "deleteQuestion"]);
const model = ref(JSON.parse(JSON.stringify(props.question)));

const questionTypes = computed(() => store.state.questionTypes);

function upperCaseFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}
function shouldHaveOptions() {
    return ["select", "radio", "checkbox"].includes(model.value.type);
}
function getOptions() {
    return model.value.data.options;
}
function setOptions(options) {
    return (model.value.data.options = options);
}
function addOption() {
    setOptions([...getOptions(), { uuid: uuidv4(), text: "" }]);
    dataChange();
}

function removeOption(op) {
    setOptions(getOptions().filter((opt) => opt !== op));
    dataChange();
}
function typeChange(params) {
    if (shouldHaveOptions()) {
        setOptions(getOptions() || []);
    }
    dataChange();
}
function dataChange() {
    const data = JSON.parse(JSON.stringify(model.value));
    if (!shouldHaveOptions()) {
        delete data.data.options;
    }
    emit("change", data);
}
function addQuestion() {
    emit("addQuestion", props.index + 1);
}
function deleteQuestion() {
    emit("deleteQuestion", props.question);
}
</script>

<style></style>
