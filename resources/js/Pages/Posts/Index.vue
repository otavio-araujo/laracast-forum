<template>
    <app-layout>
        <Container>
            <ul class="divide-y">
                <li v-for="post in posts" :key="post.id" class="px-2 py-4">
                    <span class="font-bold text-lg">{{ post.title }}</span>
                </li>
            </ul>
        </Container>
    </app-layout>
</template>

<script lang="ts" setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";

defineProps(['posts']);
</script>
