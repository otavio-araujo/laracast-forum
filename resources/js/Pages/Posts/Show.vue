<template>
    <AppLayout title="">
        <Container>
            <h1 class="text-2xl font-bold">{{ post.title }}</h1>

            <span class="block mt-1 text-sm text-gray-600">{{ formattedDate }} ago by {{ post.user.name }}</span>

            <article class="mt-6">
                <pre class="whitespace-pre-wrap font-sans">{{ post.body }}</pre>
            </article>

            <div>
                <h2 class="mt-12 text-xl font-semibold">Comments</h2>

                <form v-if="$page.props.auth.user" class="mt-4" @submit.prevent="addComment">
                    <div>
                        <InputLabel class="sr-only" for="body">Comment</InputLabel>
                        <TextArea id="body" v-model="commentForm.body" placeholder="Speak your mind spock..." rows="4"/>
                        <InputError :message="commentForm.errors.body" class="mt-1"/>
                    </div>

                    <PrimaryButton :disabled="commentForm.processing" class="mt-3" type="submit">Add Comment
                    </PrimaryButton>
                </form>

                <ul class="divide-y">
                    <li v-for="comment in comments.data" :key="comment.id" class="px-2 py-4 mt-4">
                        <Comment :comment="comment"/>
                    </li>
                </ul>
                <Pagination :meta="comments.meta" :only="['comments']"/>
            </div>
        </Container>
    </AppLayout>
</template>

<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import {computed} from "vue";
import Pagination from "@/Components/Pagination.vue";
import {relativeDate} from "@/Utilities/date.js";
import Comment from "@/Components/Comment.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps(['post', 'comments']);

const formattedDate = computed(() => relativeDate(props.post.created_at));

const commentForm = useForm({
    body: '',
});

const addComment = () => commentForm.post(route('posts.comments.store', props.post.id), {
    preserveScroll: true,
    onSuccess: () => commentForm.reset(),
});

</script>
