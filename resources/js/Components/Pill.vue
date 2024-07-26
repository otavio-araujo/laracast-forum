<template>
    <Link
        :class="{ 'bg-indigo-600 text-indigo-300' : filled }"
        :href="href"
        class="mb-2 whitespace-nowrap rounded-md border border-pink-400 px-2 py-1 text-xs uppercase text-pink-400 hover:bg-indigo-600 hover:text-indigo-300">
        <slot></slot>
    </Link>
</template>
<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    href: {
        required: true,
    },
    filled: {
        default: false
    },
});
</script>
