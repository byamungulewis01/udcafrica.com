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
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import { Label } from "@/Components/ui/label";
import { Switch } from "@/Components/ui/switch";
import { Alert, AlertDescription } from "@/Components/ui/alert";
import ImageUpload from '@/Components/ImageUpload.vue';
import GalleryUpload from '@/Components/GalleryUpload.vue';
import QuillEditor from '@/Components/QuillEditor.vue';

const props = defineProps({
    project: Object,
    categories: Array,
});

const form = useForm({
    title: props.project.title || '',
    slug: props.project.slug || '',
    description: props.project.description || '',
    content: props.project.content || '',
    featured_image: null, // Will hold new uploaded image
    client: props.project.client || '',
    duration: props.project.duration || '',
    location: props.project.location || '',
    contractor: props.project.contractor || '',
    gallery: [], // Will hold new uploaded gallery images
    is_featured: props.project.is_featured || false,
    is_published: props.project.is_published || false,
    order: props.project.order || '',
    category_id: props.project.category_id || '',
    meta_title: props.project.meta_title || '',
    meta_description: props.project.meta_description || '',
    meta_keywords: props.project.meta_keywords || '',
    _method: 'PUT',
});

const handleSubmit = () => {
    form.post(route('projects.update', props.project.id), {
        preserveScroll: true,
        onSuccess: () => {
            // Don't reset form on edit page
        },
        onError: () => {
            console.log(form.errors);
        },
    });
};

const handleImageUpload = (file) => {
    form.featured_image = file;
};

const handleGalleryUpload = (files) => {
    form.gallery = files;
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
    <Head title="Edit Project" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader>
                <CardTitle class="text-2xl">Edit Project</CardTitle>
                <CardDescription>Update the project details</CardDescription>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <Label for="title">Title</Label>
                            <Input id="title" v-model="form.title" required
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('title') }" />
                            <p v-if="getFieldError('title')" class="text-sm text-red-600">
                                {{ getFieldError('title') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="slug">Slug</Label>
                            <Input id="slug" v-model="form.slug"
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('slug') }" />
                            <p v-if="getFieldError('slug')" class="text-sm text-red-600">
                                {{ getFieldError('slug') }}
                            </p>
                            <p v-else class="text-sm text-gray-500">Leave empty to generate from title</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <Label for="description">Description</Label>
                        <Textarea id="description" v-model="form.description" rows="3" required
                            :class="{ 'border-red-500 focus:border-red-500': hasFieldError('description') }" />
                        <p v-if="getFieldError('description')" class="text-sm text-red-600">
                            {{ getFieldError('description') }}
                        </p>
                    </div>

                    <!-- Content -->
                    <div class="space-y-2">
                        <Label for="content">Content</Label>
                        <QuillEditor v-model="form.content" placeholder="Write your project content here..."
                            :class="{ 'border-red-500': hasFieldError('content') }" />
                        <p v-if="getFieldError('content')" class="text-sm text-red-600">
                            {{ getFieldError('content') }}
                        </p>
                    </div>

                    <!-- Current Featured Image Display -->
                    <div v-if="project.featured_image" class="space-y-2">
                        <Label>Current Featured Image</Label>
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <img :src="project.featured_image" :alt="project.title"
                                 class="max-w-xs max-h-48 object-cover rounded-lg" />
                            <p class="text-sm text-gray-600 mt-2">Upload a new image below to replace this one</p>
                        </div>
                    </div>

                    <!-- Featured Image Upload -->
                    <div class="space-y-2">
                        <Label>{{ project.featured_image ? 'Replace Featured Image' : 'Featured Image' }}</Label>
                        <ImageUpload @upload="handleImageUpload" />
                        <p v-if="getFieldError('featured_image')" class="text-sm text-red-600">
                            {{ getFieldError('featured_image') }}
                        </p>
                    </div>

                    <!-- Project Details -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <Label for="category_id">Category</Label>
                            <Select v-model="form.category_id" required>
                                <SelectTrigger
                                    :class="{ 'border-red-500 focus:border-red-500': hasFieldError('category_id') }">
                                    <SelectValue placeholder="Select a category" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="category in categories" :key="category.id" :value="category.id.toString()">
                                        {{ category.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <p v-if="getFieldError('category_id')" class="text-sm text-red-600">
                                {{ getFieldError('category_id') }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <Label for="client">Client</Label>
                            <Input id="client" v-model="form.client" required
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('client') }" />
                            <p v-if="getFieldError('client')" class="text-sm text-red-600">
                                {{ getFieldError('client') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="duration">Duration</Label>
                            <Input id="duration" v-model="form.duration" required
                                placeholder="e.g., 6 months, 2022-2023"
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('duration') }" />
                            <p v-if="getFieldError('duration')" class="text-sm text-red-600">
                                {{ getFieldError('duration') }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <Label for="location">Location</Label>
                            <Input id="location" v-model="form.location"
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('location') }" />
                            <p v-if="getFieldError('location')" class="text-sm text-red-600">
                                {{ getFieldError('location') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="contractor">Contractor</Label>
                            <Input id="contractor" v-model="form.contractor"
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('contractor') }" />
                            <p v-if="getFieldError('contractor')" class="text-sm text-red-600">
                                {{ getFieldError('contractor') }}
                            </p>
                        </div>
                    </div>



                    <!-- Current Gallery Display -->
                    <div v-if="project.gallery && project.gallery.length > 0" class="space-y-2">
                        <Label>Current Gallery Images</Label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 border rounded-lg bg-gray-50">
                            <div v-for="(image, index) in project.gallery" :key="index" class="relative">
                                <img :src="image" :alt="`Gallery image ${index + 1}`"
                                     class="w-full h-24 object-cover rounded-lg" />
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">Upload new images below to replace the current gallery</p>
                    </div>

                    <!-- Gallery Upload -->
                    <div class="space-y-2">
                        <Label>{{ project.gallery && project.gallery.length > 0 ? 'Replace Project Gallery' : 'Project Gallery' }}</Label>
                        <GalleryUpload @upload="handleGalleryUpload" />
                        <p v-if="getFieldError('gallery')" class="text-sm text-red-600">
                            {{ getFieldError('gallery') }}
                        </p>
                        <p v-else class="text-sm text-gray-500">Upload multiple images for the project gallery</p>
                    </div>

                    <!-- Status Toggles -->
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-2">
                            <Switch id="is_featured" v-model="form.is_featured" />
                            <Label for="is_featured">Featured Project</Label>
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

                    <!-- Meta Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium">Meta Information</h3>
                        <div class="space-y-2">
                            <Label for="meta_title">Meta Title</Label>
                            <Input id="meta_title" v-model="form.meta_title"
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('meta_title') }" />
                            <p v-if="getFieldError('meta_title')" class="text-sm text-red-600">
                                {{ getFieldError('meta_title') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="meta_description">Meta Description</Label>
                            <Textarea id="meta_description" v-model="form.meta_description" rows="2"
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('meta_description') }" />
                            <p v-if="getFieldError('meta_description')" class="text-sm text-red-600">
                                {{ getFieldError('meta_description') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="meta_keywords">Meta Keywords</Label>
                            <Input id="meta_keywords" v-model="form.meta_keywords"
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('meta_keywords') }" />
                            <p v-if="getFieldError('meta_keywords')" class="text-sm text-red-600">
                                {{ getFieldError('meta_keywords') }}
                            </p>
                            <p v-else class="text-sm text-gray-500">Separate keywords with commas</p>
                        </div>
                    </div>
                </CardContent>
                <CardFooter class="flex justify-end space-x-4">
                    <Button type="button" variant="outline" @click="$inertia.visit(route('projects.index'))">
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        <span v-if="form.processing">Updating...</span>
                        <span v-else>Update Project</span>
                    </Button>
                </CardFooter>
            </form>
        </Card>
    </AuthenticatedLayout>
</template>