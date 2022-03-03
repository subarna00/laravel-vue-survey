<template>
    <div class="flex justify-between p-2 bg-gray-900">
        <div class="my-auto">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6 text-white"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
        </div>
        <div class="">
            <div class="relative inline-block group">
                <div
                    class="inline-flex items-center px-4 py-2 font-semibold text-white bg-gray-900"
                >
                    <span class="mr-1">User</span>
                </div>
                <ul
                    class="absolute hidden w-20 pt-1 text-gray-700 right-7 group-hover:block"
                >
                    <li class="">
                        <a
                            class="block px-2 py-1 whitespace-no-wrap bg-gray-200 rounded-t hover:bg-gray-400"
                            href="#"
                            >Profile</a
                        >
                    </li>
                    <hr class="bg-fray-900" />
                    <li class="">
                        <a
                            class="block px-2 py-1 whitespace-no-wrap bg-gray-200 hover:bg-gray-400"
                            href="#"
                            >Logout</a
                        >
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup></script>

<style></style>
