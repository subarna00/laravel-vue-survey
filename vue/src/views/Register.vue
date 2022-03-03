<template>
    <div>
        <img
            class="w-auto h-12 mx-auto"
            src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
            alt="Workflow"
        />
        <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
            Register your account
        </h2>
        <p class="mt-2 text-sm text-center text-gray-600">
            Or
            {{ " " }}
            <router-link
                :to="{ name: 'Login' }"
                href="#"
                class="font-medium text-indigo-600 hover:text-indigo-500"
            >
                Login to your account
            </router-link>
        </p>
        <form class="mt-8 space-y-6" @submit.prevent="register">
            <input type="hidden" name="remember" value="true" />
            <div class="-space-y-px rounded-md shadow-sm">
                <div>
                    <label for="email-address" class="sr-only">Full Name</label>
                    <input
                        v-model="user.name"
                        id="email-address"
                        name="email"
                        type="text"
                        required=""
                        class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Full Name"
                    />
                </div>
                <div>
                    <label for="email-address" class="sr-only"
                        >Email address</label
                    >
                    <input
                        v-model="user.email"
                        id="email-address"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required=""
                        class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Email address"
                    />
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input
                        v-model="user.password"
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required=""
                        class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Password"
                    />
                </div>
                <div>
                    <label for="password" class="sr-only"
                        >Confirm Password</label
                    >
                    <input
                        v-model="user.password_confirmation"
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="current-password"
                        required=""
                        class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Confirm Password"
                    />
                </div>
            </div>
            <div>
                <button
                    type="submit"
                    class="relative flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md group hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <span
                        class="absolute inset-y-0 left-0 flex items-center pl-3"
                    >
                        <LockClosedIcon
                            class="w-5 h-5 text-indigo-500 group-hover:text-indigo-400"
                            aria-hidden="true"
                        />
                    </span>
                    Register
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { LockClosedIcon } from "@heroicons/vue/solid";
import { useRouter } from "vue-router";
const router = useRouter();
import store from "../store";
const user = {
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
};

function register(e) {
    e.preventDefault();
    store.dispatch("register", user).then(() => {
        router.push({ name: "Dashboard" });
    });
}
</script>
