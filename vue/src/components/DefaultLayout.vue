<template>
    <div class="grid min-h-full grid-cols-12">
        <Sidebar />
        <div class="min-h-full col-span-10">
            <Navbar />
            <router-view></router-view>
            <Notification />
        </div>
    </div>
</template>

<script>
import Notification from "./Notification.vue";
import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
} from "@headlessui/vue";
import { BellIcon, MenuIcon, XIcon } from "@heroicons/vue/outline";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { computed } from "vue";

const navigation = [
    { name: "Dashboard", to: { name: "Dashboard" } },
    { name: "Surveys", to: { name: "Surveys" } },
];

export default {
    name: "DefaultLayout",
    components: {
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        BellIcon,
        MenuIcon,
        XIcon,
        Notification,
        Navbar,
        Sidebar,
    },
    setup() {
        const router = useRouter();
        const store = useStore();
        const userNavigation = [
            { name: "Your Profile", to: "#" },
            { name: "Settings", to: "#" },
            { name: "Sign out", to: { name: "Logout" }, fun: logout },
        ];
        function logout() {
            store.dispatch("logout").then(() => {
                router.push({
                    name: "Login",
                });
            });
        }

        return {
            user: computed(() => store.state.user.data),
            navigation,
            userNavigation,
            logout,
        };
    },
};
</script>
