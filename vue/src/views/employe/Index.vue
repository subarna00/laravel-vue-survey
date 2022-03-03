<template>
    <div>
        <PageComponent>
            <template v-slot:header>
                <div class="flex items-center justify-between">
                    <h1 class="font-bold text-1xl text-grey-900">
                        Users/Employes
                    </h1>
                    <router-link
                        :to="{ name: 'EmployeCreate' }"
                        class="px-3 py-1 text-sm text-white rounded-md bg-emerald-500 hover:bg-emerald-600"
                    >
                        Add User/Employe
                    </router-link>
                </div>
            </template>
        </PageComponent>
        <div v-if="employes.data.length === 0">
            <div class="container flex items-center justify-center my-5">
                No users/employes created yet.
            </div>
        </div>
        <div v-else class="container px-4">
            <div class="px-3 py-2 bg-gray-100 rounded-md">
                <div
                    class="grid grid-cols-12 px-3 py-2 my-2 bg-white rounded-md shadow-md trans"
                    v-for="(employe, index) in employes.data"
                    :key="employe.id"
                >
                    <div class="col-span-1 my-auto">{{ index + 1 }}.</div>
                    <div class="col-span-1 mr-auto">
                        <img
                            :src="employe.profile_picture_url"
                            alt=" "
                            class="object-cover w-10 h-10"
                        />
                    </div>
                    <div class="col-span-6 my-auto">
                        <span class="gap-2 font-bold text-1xl">
                            {{ employe.name }} ,</span
                        >
                        <span class="text-sm font-bold text-yellow-400"
                            >{{ employe.email }} ,</span
                        >
                        <span class="text-sm text-violet-800">{{
                            employe.phone_number
                        }}</span>
                    </div>
                    <div class="flex col-span-4 gap-3 m-auto">
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
                            />
                        </svg>
                        <router-link
                            :to="{
                                name: 'EmployeUpdate',
                                params: { id: employe.id },
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
                            @click="deleteEmploye(employe.id)"
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
            </div>
        </div>
    </div>
</template>

<script setup>
import PageComponent from "../../components/PageComponent.vue";
import { useStore } from "vuex";
import { computed } from "vue";
import { useRouter } from "vue-router";
const store = useStore();
const router = useRouter();
store.dispatch("getEmployes");
let employes = computed(() => store.state.employes);

function deleteEmploye(id) {
    store.dispatch("deleteEmploye", id).then(() => {
        store.dispatch("getEmployes");
    });
}
</script>

<style>
.trans:hover {
    transform: translateY(-3px);
    transition-delay: 0.1s;
}
</style>
