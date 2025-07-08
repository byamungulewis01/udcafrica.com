<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Input } from "@/Components/ui/input";
import { Button } from '@/Components/ui/button';
import { Textarea } from "@/Components/ui/textarea";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";

import { Label } from "@/Components/ui/label";
import { Switch } from "@/Components/ui/switch";
import ImageUpload from '@/Components/ImageUpload.vue';

const props = defineProps({
    news: Object,
});

const form = useForm({
    title: props.news.title,
    description: props.news.description,
    featured_image: null,
    source_url: props.news.source_url,
    source_logo: null,
    source_name: props.news.source_name,
    is_featured: props.news.is_featured,
    is_published: props.news.is_published,
    _method: 'PUT',
});

const handleSubmit = () => {
    form.post(route('news.update', props.news.id), {
        preserveScroll: true,
    });
};

const handleImageUpload = (file) => {
    form.featured_image = file;
};
const handleSourceLogoUpload = (file) => {
    form.source_logo = file;
};
// Helper function to get field error
const getFieldError = (fieldName) => {
    return form.errors[fieldName];
};

// Helper function to check if field has error
const hasFieldError = (fieldName) => {
    return !!form.errors[fieldName];
};

</script>

<template>

    <Head title="Edit News" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader>
                <CardTitle class="text-2xl">Edit News</CardTitle>
                <CardDescription>Update the news details</CardDescription>
            </CardHeader>
            <form @submit.prevent="handleSubmit">
                <CardContent class="space-y-6">
                    <!-- Title and Description -->
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <div class="space-y-2">
                            <Label for="title">Title</Label>
                            <Input id="title" v-model="form.title" required />
                            <p v-if="hasFieldError('title')" class="text-sm text-red-500">
                                {{ getFieldError('title') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="description">Description</Label>
                            <Textarea id="description" v-model="form.description" rows="3" />
                            <p v-if="hasFieldError('description')" class="text-sm text-red-500">
                                {{ getFieldError('description') }}
                            </p>
                        </div>
                    </div>
                    <!-- Featured Image -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <Label>Featured Image</Label>
                            <div v-if="news.featured_image" class="mb-4">
                                <img :src="news.featured_image" :alt="news.title"
                                    class="w-20 h-20 object-cover rounded-md" />
                            </div>
                            <ImageUpload @upload="handleImageUpload" />
                            <p class="text-sm text-gray-500">Upload a new image to replace the current one</p>
                        </div>
                        <!-- Source Logo -->
                        <div class="space-y-2">
                            <Label for="source_logo">Source Logo</Label>
                            <div v-if="news.source_logo" class="mb-4">
                                <img :src="news.source_logo" :alt="news.source_name"
                                    class="w-20 h-20 object-cover rounded-md" />
                            </div>
                            <ImageUpload @upload="handleSourceLogoUpload" />
                            <p class="text-sm text-gray-500">Upload a new logo to replace the current one</p>
                            <p v-if="hasFieldError('source_logo')" class="text-sm text-red-500">
                                {{ getFieldError('source_logo') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="source_name">Source Name</Label>
                            <Input id="source_name" v-model="form.source_name" required />
                            <p v-if="hasFieldError('source_name')" class="text-sm text-red-500">
                                {{ getFieldError('source_name') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="source_url">Source URL</Label>
                            <Input id="source_url" type="url" v-model="form.source_url" required />
                            <p v-if="hasFieldError('source_url')" class="text-sm text-red-500">
                                {{ getFieldError('source_url') }}
                            </p>
                        </div>
                    </div>


                    <!-- Status Toggles -->
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <Switch id="is_featured" v-model="form.is_featured" />
                            <Label for="is_featured">Featured News</Label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <Switch id="is_published" v-model="form.is_published" />
                            <Label for="is_published">Published</Label>
                        </div>
                    </div>
                </CardContent>

                <CardFooter class="flex justify-end space-x-4">
                    <Button type="button" variant="outline" @click="$inertia.visit(route('news.index'))">
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        Update News
                    </Button>
                </CardFooter>
            </form>
        </Card>
    </AuthenticatedLayout>
</template>
