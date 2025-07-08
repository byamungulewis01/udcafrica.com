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
import QuillEditor from '@/Components/QuillEditor.vue';

const props = defineProps({
    categories: Array,
});

const form = useForm({
    title: '',
    slug: '',
    excerpt: '',
    content: '',
    featured_image: null,
    meta_title: '',
    meta_description: '',
    meta_keywords: '',
    author: '',
    published_at: '',
    is_featured: false,
    is_published: false,
    category_id: '',
});

const handleSubmit = () => {
    form.post(route('blogs.store'), {
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
    <Head title="Create Blog Post" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader>
                <CardTitle class="text-2xl">Create New Blog Post</CardTitle>
                <CardDescription>Fill in the details to create a new blog post</CardDescription>
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
                            <Input
                                id="title"
                                v-model="form.title"
                                required
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('title') }"
                            />
                            <p v-if="getFieldError('title')" class="text-sm text-red-600">
                                {{ getFieldError('title') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="slug">Slug</Label>
                            <Input
                                id="slug"
                                v-model="form.slug"
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('slug') }"
                            />
                            <p v-if="getFieldError('slug')" class="text-sm text-red-600">
                                {{ getFieldError('slug') }}
                            </p>
                            <p v-else class="text-sm text-gray-500">Leave empty to generate automatically</p>
                        </div>
                    </div>

                    <!-- Excerpt and Content -->
                    <div class="space-y-2">
                        <Label for="excerpt">Excerpt</Label>
                        <Textarea
                            id="excerpt"
                            v-model="form.excerpt"
                            rows="3"
                            :class="{ 'border-red-500 focus:border-red-500': hasFieldError('excerpt') }"
                        />
                        <p v-if="getFieldError('excerpt')" class="text-sm text-red-600">
                            {{ getFieldError('excerpt') }}
                        </p>
                    </div>
                    <div class="space-y-2">
                        <Label for="content">Content</Label>
                        <QuillEditor
                            v-model="form.content"
                            placeholder="Write your blog post content here..."
                            :class="{ 'border-red-500': hasFieldError('content') }"
                        />
                        <p v-if="getFieldError('content')" class="text-sm text-red-600">
                            {{ getFieldError('content') }}
                        </p>
                    </div>

                    <!-- Featured Image -->
                    <div class="space-y-2">
                        <Label>Featured Image</Label>
                        <ImageUpload @upload="handleImageUpload" />
                        <p v-if="getFieldError('featured_image')" class="text-sm text-red-600">
                            {{ getFieldError('featured_image') }}
                        </p>
                    </div>

                    <!-- Author and Publishing -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <Label for="author">Author</Label>
                            <Input
                                id="author"
                                v-model="form.author"
                                required
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('author') }"
                            />
                            <p v-if="getFieldError('author')" class="text-sm text-red-600">
                                {{ getFieldError('author') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="published_at">Publish Date</Label>
                            <Input
                                id="published_at"
                                type="datetime-local"
                                v-model="form.published_at"
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('published_at') }"
                            />
                            <p v-if="getFieldError('published_at')" class="text-sm text-red-600">
                                {{ getFieldError('published_at') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="category_id">Category</Label>
                            <Select
                                id="category_id"
                                v-model="form.category_id"
                                required
                            >
                                <SelectTrigger :class="{ 'border-red-500 focus:border-red-500': hasFieldError('category_id') }">
                                    <SelectValue placeholder="Select a category" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <p v-if="getFieldError('category_id')" class="text-sm text-red-600">
                                {{ getFieldError('category_id') }}
                            </p>
                        </div>
                    </div>

                    <!-- Status Toggles -->
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-2">
                            <Switch id="is_featured" v-model="form.is_featured" />
                            <Label for="is_featured">Featured Post</Label>
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
                            <Input
                                id="meta_title"
                                v-model="form.meta_title"
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('meta_title') }"
                            />
                            <p v-if="getFieldError('meta_title')" class="text-sm text-red-600">
                                {{ getFieldError('meta_title') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="meta_description">Meta Description</Label>
                            <Textarea
                                id="meta_description"
                                v-model="form.meta_description"
                                rows="2"
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('meta_description') }"
                            />
                            <p v-if="getFieldError('meta_description')" class="text-sm text-red-600">
                                {{ getFieldError('meta_description') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="meta_keywords">Meta Keywords</Label>
                            <Input
                                id="meta_keywords"
                                v-model="form.meta_keywords"
                                :class="{ 'border-red-500 focus:border-red-500': hasFieldError('meta_keywords') }"
                            />
                            <p v-if="getFieldError('meta_keywords')" class="text-sm text-red-600">
                                {{ getFieldError('meta_keywords') }}
                            </p>
                            <p v-else class="text-sm text-gray-500">Separate keywords with commas</p>
                        </div>
                    </div>
                </CardContent>
                <CardFooter class="flex justify-end space-x-4">
                    <Button type="button" variant="outline" @click="$inertia.visit(route('blogs.index'))">
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        <span v-if="form.processing">Creating...</span>
                        <span v-else>Create Post</span>
                    </Button>
                </CardFooter>
            </form>
        </Card>
    </AuthenticatedLayout>
</template>