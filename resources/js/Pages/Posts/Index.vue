<template>
    <AppLayout>
        <Container>
            <div>
                <Link v-if="selectedTopic" :href="route('posts.index')" class="text-indigo-500 hover:text-indigo-700 block mb-2">Back to all posts</Link>
                <PageHeading v-text="selectedTopic ? selectedTopic.name : 'All Posts'"/>
                <p v-if="selectedTopic" class="mt-1 text-gray-600 text-sm">{{ selectedTopic.description }}</p>
            </div>
            <ul class="divide-y mt-4">
                <li v-for="post in posts.data" :key="post.id"
                    class="flex flex-col md:flex-row items-baseline justify-between">
                    <Link :href="post.routes.show" class="block group px-2 py-4">
                        <span class="font-bold text-lg group-hover:text-indigo-500">{{ post.title }}</span>
                        <span class="first-letter:uppercase block pt-1 text-sm text-gray-600">
                            {{ formattedDate(post) }} ago by {{ post.user.name }}
                        </span>
                    </Link>
                    <Link
                        :href="route('posts.index', { topic: post.topic.slug })"
                        class="rounded-md border border-pink-400 px-2 py-1 text-xs text-pink-400 uppercase mb-2 hover:bg-indigo-600 hover:text-indigo-300">
                        {{ post.topic.name }}
                    </Link>
                </li>
            </ul>

            <Pagination :meta="posts.meta" :only="['posts']" class="mt-2"/>
        </Container>
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import {Link} from "@inertiajs/vue3";
import {relativeDate} from "@/Utilities/date.js";
import PageHeading from "@/Components/PageHeading.vue";

defineProps(['posts', 'selectedTopic']);

const formattedDate = (post) => relativeDate(post.created_at);
</script>
