<template>
    <AppLayout title="Posts Show">
        <Container>
            <PageHeading>{{ post.title }}</PageHeading>

            <span class="mt-1 block text-sm text-gray-600">{{ formattedDate }} ago by {{ post.user.name }}</span>

            <article class="mt-6 max-w-none prose prose-sm" v-html="post.html"></article>

            <div>
                <h2 class="mt-12 text-xl font-semibold">Comments</h2>

                <form v-if="$page.props.auth.user" class="mt-4"
                      @submit.prevent="() => commentIdBeingEdited ? updateComment() : addComment()">
                    <div>
                        <InputLabel class="sr-only" for="body">Comment</InputLabel>
                        <MarkdownEditor id="body" ref="commentTextAreaRef" v-model="commentForm.body"
                                        editorClass="min-h-[160px]" placeholder="Speak your mind spock..."/>
                        <InputError :message="commentForm.errors.body" class="mt-1"/>
                    </div>

                    <PrimaryButton :disabled="commentForm.processing" class="mt-3" type="submit"
                                   v-text="commentIdBeingEdited ? 'Update Comment' : 'Add Comment'"></PrimaryButton>
                    <SecondaryButton v-if="commentIdBeingEdited" class="ml-3" @click="cancelEditComment">Cancel
                    </SecondaryButton>
                </form>

                <ul class="divide-y">
                    <li v-for="comment in comments.data" :key="comment.id" class="mt-4 px-2 py-4">
                        <Comment :comment="comment" @delete="deleteComment" @edit="editComment"/>
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
import {computed, ref} from "vue";
import Pagination from "@/Components/Pagination.vue";
import {relativeDate} from "@/Utilities/date.js";
import Comment from "@/Components/Comment.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {router, useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useConfirm} from "@/Utilities/Composables/useConfirm.js";
import MarkdownEditor from "@/Components/MarkdownEditor.vue";
import PageHeading from "@/Components/PageHeading.vue";

const props = defineProps(['post', 'comments']);

const formattedDate = computed(() => relativeDate(props.post.created_at));

const commentForm = useForm({
    body: '',
});

const commentTextAreaRef = ref(null);
const commentIdBeingEdited = ref(null);

const commentBeingEdit = computed(() => props.comments.data.find(comment => comment.id === commentIdBeingEdited.value));

const editComment = (commentId) => {
    commentIdBeingEdited.value = commentId;
    commentForm.body = commentBeingEdit.value?.body;
    commentTextAreaRef.value?.focus();
}

const cancelEditComment = () => {
    commentIdBeingEdited.value = null;
    commentForm.reset();
}

const addComment = () => commentForm.post(route('posts.comments.store', props.post.id), {
    preserveScroll: true,
    onSuccess: () => commentForm.reset(),
});

const {confirmation} = useConfirm();

const updateComment = async () => {

    if (!await confirmation('Are you sure you want to update this comment?')) {
        commentTextAreaRef.value?.focus();
        return;
    }

    commentForm.put(route('comments.update', {

        comment: commentIdBeingEdited.value,
        page: props.comments.meta.current_page,
    }), {
        preserveScroll: true,
        onSuccess: cancelEditComment,
    })
};

const deleteComment = async (commentId) => {

    if (!await confirmation('Are you sure you want to delete this comment?')) {
        return;
    }

    router.delete(route('comments.destroy', {
        comment: commentId,
        page: props.comments.meta.current_page
    }), {
        preserveScroll: true,
    })
};

</script>
