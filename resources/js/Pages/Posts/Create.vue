<template>
    <AppLayout title="Create a Post">
        <Container>
            <PageHeading>Create a Post</PageHeading>

            <form @submit.prevent="createPost">

                <div class="mt-6">
                    <InputLabel class="sr-only" for="title">Title</InputLabel>
                    <TextInput id="title" v-model="form.title" class="w-full" placeholder="Give it a great title..."/>
                    <InputError :message="form.errors.title" class="mt-1"/>
                </div>
                <div class="mt-3">
                    <InputLabel for="topic_id">Select a Topic</InputLabel>
                    <select id="topic_id"
                            v-model="form.topic_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1">
                        <option v-for="topic in topics" :key="topic.id" :value="topic.id"> {{ topic.name }}</option>
                    </select>
                    <InputError :message="form.errors.topic_id" class="mt-1"/>
                </div>
                <div class="mt-3">
                    <InputLabel class="sr-only" for="body">Body</InputLabel>
                    <MarkdownEditor v-model="form.body" editorClass="min-h-[512px]">
                        <template #toolbar="{editor}">
                            <li v-if="! isInProduction()">
                                <button
                                    class="px-3 py-2"
                                    title="Autofill"
                                    type="button"
                                    @click="autofill">
                                    <i class="ri-article-line"></i>
                                </button>
                            </li>
                        </template>
                    </MarkdownEditor>
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
import MarkdownEditor from "@/Components/MarkdownEditor.vue";
import {isInProduction} from "@/Utilities/enviroment.js";
import PageHeading from "@/Components/PageHeading.vue";

const props = defineProps(['topics'])

const form = useForm({
    title: '',
    body: '',
    topic_id: props.topics[0].id,
});

const createPost = () => form.post(route('posts.store'));

const autofill = async () => {

    if (isInProduction()) {
        return;
    }

    const response = await axios.get('/local/post-content');

    form.title = response.data.title;
    form.body = response.data.body;
};

</script>
