<template>
    <fieldset class="mb-4">
        <div>
            <legend class="text-base font-medium text-gray-900">
                {{ index + 1 }}. {{ question.question }}
            </legend>
            <p>{{ question.description }}</p>
        </div>
        <div class="mt-3">
            <div v-if="question.type === 'select'">
                <select
                    :value="modelValue"
                    @change="emits('update:modelValue', $event.target.value)"
                    class="block w-full px-3 py-2 mt-1 bg-white border border-transparent border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                    <option value="">Please Select</option>
                    <option
                        v-for="option in question.data.options"
                        :key="option.uuid"
                        :value="option.text"
                    >
                        {{ option.text }}
                    </option>
                </select>
            </div>

            <div v-else-if="question.type === 'radio'">
                <div
                    v-for="(option, ind) of question.data.options"
                    :key="option.uuid"
                    class="flex items-center"
                >
                    <input
                        :id="option.uuid"
                        type="radio"
                        :name="'question' + question.id"
                        :value="option.text"
                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                        @change="
                            emits('update:modelValue', $event.target.value)
                        "
                    />
                    <label
                        :for="option.uuid"
                        class="block ml-3 text-sm font-medium text-gray-700"
                        >{{ option.text }}</label
                    >
                </div>
            </div>
            <div v-else-if="question.type === 'checkbox'">
                <div
                    v-for="(option, ind) of question.data.options"
                    :key="option.uuid"
                    class="flex items-center"
                >
                    <input
                        type="checkbox"
                        :name="'question' + question.id"
                        v-model="model[option.text]"
                        @change="onCheckBoxChange"
                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                    />
                    <label
                        :for="option.uuid"
                        class="block ml-3 text-sm font-medium text-gray-700"
                        >{{ option.text }}</label
                    >
                </div>
            </div>
            <div v-else-if="question.type === 'text'">
                <input
                    type="text"
                    :value="modelValue"
                    @input="emits('update:modelValue', $event.target.value)"
                    class="block w-full py-2 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
            </div>
            <div v-else-if="question.type === 'textarea'">
                <textarea
                    type="text"
                    :value="modelValue"
                    row="10"
                    @input="emits('update:modelValue', $event.target.value)"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
            </div>
        </div>
        <hr class="my-2" />
    </fieldset>
</template>

<script setup>
import { ref } from "vue";
const { question, index, modelValue } = defineProps({
    question: Object,
    index: Number,
    modelValue: [String, Array],
});
const emits = defineEmits(["update:modelValue"]);
let model;
if (question.type === "checkbox") {
    model = ref({});
}

function onCheckBoxChange($event) {
    const selectedOptions = [];
    for (let text in model.value) {
        if (model.value[text]) {
            selectedOptions.push(text);
        }
        emits("update:modelValue", selectedOptions);
    }
}
</script>

<style></style>
