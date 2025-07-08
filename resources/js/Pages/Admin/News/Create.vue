<script setup>
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
import { Alert, AlertDescription } from "@/Components/ui/alert";
import ImageUpload from '@/Components/ImageUpload.vue';


const form = useForm({
    title: '',
    description: '',
    featured_image: null,
    source_url: '',
    source_logo: null,
    source_name: '',
    is_featured: false,
    is_published: false,
});

const handleSubmit = () => {
    form.post(route('news.store'), {
        preserveScroll: true,
        onSuccess: () => {
            resetForm();
        },
        onError: () => {
            console.log(form.errors);
        },
    });
};
const resetForm = () => {
    form.reset();
    form.clearErrors();
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

    <Head title="Create News" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader>
                <CardTitle class="text-2xl">Create New News</CardTitle>
                <CardDescription>Fill in the details to create a new news</CardDescription>
            </CardHeader>

            <!-- General Error Alert -->
            <div v-if="form.errors.error" class="mx-6 mb-4">
                <Alert variant="destructive">
                    <AlertDescription>
                        {{ form.errors.error }}
                    </AlertDescription>
                </Alert>
            </div>

            <form @submit.prevent="handleSubmit">
                <CardContent class="space-y-6">
                    <!-- Title and Slug -->
                    <div class="space-y-2">
                        <Label for="title">Title</Label>
                        <Input id="title" v-model="form.title" required
                            :class="{ 'border-red-500 focus:border-red-500': hasFieldError('title') }" />
                        <p v-if="getFieldError('title')" class="text-sm text-red-600">
                            {{ getFieldError('title') }}
                        </p>
                    </div>

                    <!-- Excerpt and Content -->
                    <div class="space-y-2">
                        <Label for="description">Description</Label>
                        <Textarea id="description" v-model="form.description" rows="3"
                            :class="{ 'border-red-500 focus:border-red-500': hasFieldError('excerpt') }" />
                        <p v-if="getFieldError('description')" class="text-sm text-red-600">
                            {{ getFieldError('description') }}
                        </p>
                    </div>


                    <!-- Featured Image -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <Label>Featured Image</Label>
                            <ImageUpload @upload="handleImageUpload" />
                            <p v-if="getFieldError('featured_image')" class="text-sm text-red-600">
                                {{ getFieldError('featured_image') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label>Source Logo</Label>
                            <ImageUpload @upload="handleSourceLogoUpload" />
                            <p v-if="getFieldError('source_logo')" class="text-sm text-red-600">
                                {{ getFieldError('source_logo') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="source_name">Source Name</Label>
                            <Input id="source_name" v-model="form.source_name" required
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('source_name') }" />
                            <p v-if="getFieldError('source_name')" class="text-sm text-red-600">
                                {{ getFieldError('source_name') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="source_url">Source URL</Label>
                            <Input id="source_url" type="url" v-model="form.source_url" required
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('source_url') }" />
                            <p v-if="getFieldError('source_url')" class="text-sm text-red-600">
                                {{ getFieldError('source_url') }}
                            </p>
                        </div>
                    </div>

                    <!-- Status Toggles -->
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-2">
                            <Switch id="is_featured" v-model="form.is_featured" />
                            <Label for="is_featured">Featured News</Label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <Switch id="is_published" v-model="form.is_published" />
                            <Label for="is_published">Published</Label>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <p v-if="getFieldError('is_featured')" class="text-sm text-red-600">
                            {{ getFieldError('is_featured') }}
                        </p>
                        <p v-if="getFieldError('is_published')" class="text-sm text-red-600">
                            {{ getFieldError('is_published') }}
                        </p>
                    </div>


                </CardContent>
                <CardFooter class="flex justify-end space-x-4">
                    <Button type="button" variant="outline" @click="$inertia.visit(route('news.index'))">
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        <span v-if="form.processing">Creating...</span>
                        <span v-else>Create News</span>
                    </Button>
                </CardFooter>
            </form>
        </Card>
    </AuthenticatedLayout>
</template>