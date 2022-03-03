<template>
    <div>
        <header class="mb-4 bg-white shadow">
            <div class="px-4 py-3 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h1 class="font-bold text-gray-900 text-2x">
                    {{ title }}
                </h1>
                <slot name="header"></slot>
            </div>
        </header>
    </div>
</template>
<script setup>
const props = defineProps({
    title: String,
});
</script>
<style></style>
