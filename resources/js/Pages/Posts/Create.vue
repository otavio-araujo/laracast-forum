<template>
    <AppLayout title="Create a Post">
        <Container>
            <h1 class="text-2xl font-bold">Create a Post</h1>

            <form @submit.prevent="createPost">

                <div class="mt-6">
                    <InputLabel class="sr-only" for="title">Title</InputLabel>
                    <TextInput id="title" v-model="form.title" class="w-full" placeholder="Give it a great title..."/>
                    <InputError :message="form.errors.title" class="mt-1"/>
                </div>
                <div class="mt-3">
                    <InputLabel class="sr-only" for="body">Body</InputLabel>
                    <MarkdownEditor v-model="form.body"/>
                    <TextArea id="body" v-model="form.body" class="mt-3" rows="4"/>
                    <InputError :message="form.errors.body" class="mt-1"/>
                </div>
                <div class="mt-3">
                    <PrimaryButton type="submit">Create Post</PrimaryButton>
                </div>

            </form>
        </Container>
    </AppLayout>
</template>

<script setup>

import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import Container from "@/Components/Container.vue";
import InputError from "@/Components/InputError.vue";
import TextArea from "@/Components/TextArea.vue";
import MarkdownEditor from "@/Components/MarkdownEditor.vue";

const form = useForm({
    title: '',
    body: '',
});

const createPost = () => form.post(route('posts.store'));

</script>
