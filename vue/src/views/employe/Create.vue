<template>
    <div>
        <PageComponent title="  Create Users/Employes"> </PageComponent>
        <div class="container px-3">
            <form
                @submit.prevent="saveEmploye"
                class="grid grid-cols-12 gap-4 p-3 bg-gray-100 border border-transparent rounded-md shadow-md"
            >
                <div class="col-span-8">
                    <div class="mb-6">
                        <label
                            for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Full Name</label
                        >
                        <input
                            type="text"
                            v-model="model.name"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Full Name"
                            required=""
                        />
                    </div>
                    <div class="mb-6">
                        <label
                            for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Phone Number</label
                        >
                        <input
                            type="number"
                            v-model="model.phone_number"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="enter phone number"
                            required=""
                        />
                    </div>
                    <div class="mb-6">
                        <label
                            for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Address</label
                        >
                        <input
                            type="text"
                            v-model="model.address"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="address"
                            required=""
                        />
                    </div>
                    <div class="mb-6">
                        <label
                            for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Status</label
                        >
                        <select
                            name="status"
                            id=""
                            v-model="model.status"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label
                            for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Start Date</label
                        >
                        <input
                            type="date"
                            v-model="model.start_date"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="name@flowbite.com"
                            required=""
                        />
                    </div>
                </div>
                <div class="col-span-4">
                    <div class="mb-6">
                        <label
                            for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Profile Picture</label
                        >
                        <img
                            v-if="model.profile_picture_url"
                            :src="model.profile_picture_url"
                            alt=""
                            class="object-cover mb-1 w-35 h-35"
                        />
                        <input
                            type="file"
                            id="email"
                            @change="profilePicture"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                    </div>
                    <div class="mb-6">
                        <label
                            for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Your email</label
                        >
                        <input
                            type="email"
                            id="email"
                            v-model="model.email"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="name@flowbite.com"
                            required=""
                        />
                    </div>
                    <div class="mb-6">
                        <label
                            for="password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Your password</label
                        >
                        <input
                            type="password"
                            id="password"
                            v-model="model.password"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                    </div>
                    <button
                        type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import PageComponent from "../../components/PageComponent.vue";
import { useStore } from "vuex";
import { ref, computed, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
const router = useRouter();
const route = useRoute();
const store = useStore();
let model = ref({
    name: null,
    address: null,
    email: null,
    password: null,
    profile_picture: null,
    profile_picture_url: null,
    start_date: null,
    end_date: null,
    status: null,
});

if (route.params.id) {
    store.dispatch("getCurrentEmploye", route.params.id);
    model.value = computed(() => store.state.currentEmploye.data);
}
watch(
    () => store.state.currentEmploye.data,
    (newVal, oldVal) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newVal)),
        };
    }
);
function profilePicture(e) {
    const files = e.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {
        model.value.profile_picture_url = reader.result;
        model.value.profile_picture = reader.result;
    };
    reader.readAsDataURL(files);
    console.log(files);
}
function saveEmploye() {
    store
        .dispatch("saveEmploye", model.value)
        .then((res) => {
            router.push({ name: "Employe" });
        })
        .catch((err) => {
            return err;
        });
}
</script>

<style></style>
