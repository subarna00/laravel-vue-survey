<template>
    <div>
        <PageComponent title="  Create Client"> </PageComponent>
        <div class="container px-3">
            <form
                @submit.prevent="saveClient"
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
                            >Description</label
                        >
                        <textarea
                            type="text"
                            v-model="model.description"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Description about your client"
                            rows="6"
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
                </div>
                <div class="col-span-4">
                    <div class="mb-6">
                        <label
                            for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Profile Picture</label
                        >
                        <img
                            v-if="model.image_url"
                            :src="model.image_url"
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
    image: null,
    image_url: null,
    description: null,
    status: null,
});

if (route.params.id) {
    store.dispatch("getCurrentClient", route.params.id);
    model.value = computed(() => store.state.currentClient.data);
}
watch(
    () => store.state.currentClient.data,
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
        model.value.image_url = reader.result;
        model.value.image = reader.result;
    };
    reader.readAsDataURL(files);
}
function saveClient() {
    store
        .dispatch("saveClient", model.value)
        .then((res) => {
            router.push({ name: "ClientIndex" });
        })
        .catch((err) => {
            return err;
        });
}
</script>

<style></style>
