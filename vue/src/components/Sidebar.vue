<template>
    <div class="col-span-2 bg-gray-800" style="min-height: 100vh !important">
        <div
            class="w-full h-10 px-2 py-4 font-semibold text-center text-white logo"
        >
            Logo
        </div>
        <hr class="px-2 my-4 bg-gray-500" />
        <ul class="text-white">
            <router-link
                :to="{ name: 'Dashboard' }"
                class="text-white hover:text-white"
            >
                <li
                    class="flex gap-2 px-4 py-2 transition-colors hover:bg-gray-500"
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
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                        />
                    </svg>

                    Dashboard
                </li>
            </router-link>
            <router-link
                :to="{ name: 'Surveys' }"
                class="text-white hover:text-white"
            >
                <li
                    class="flex gap-2 px-4 py-2 transition-colors hover:bg-gray-500"
                >
                    <i>
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
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                            />
                        </svg>
                    </i>

                    Surveys
                </li>
            </router-link>
            <router-link
                :to="{ name: 'Employe' }"
                class="text-white hover:text-white"
            >
                <li
                    class="flex gap-2 px-4 py-2 transition-colors hover:bg-gray-500"
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
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        />
                    </svg>
                    Users/Employes
                </li>
            </router-link>
            <router-link
                :to="{ name: 'ClientIndex' }"
                class="text-white hover:text-white"
            >
                <li
                    class="flex gap-2 px-4 py-2 transition-colors hover:bg-gray-500"
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
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        />
                    </svg>
                    Clients
                </li>
            </router-link>
        </ul>
    </div>
</template>

<script setup></script>

<style></style>
