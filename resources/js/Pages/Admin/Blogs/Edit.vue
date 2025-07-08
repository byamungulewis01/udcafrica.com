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
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/Components/ui/select";
import { Label } from "@/Components/ui/label";
import { Switch } from "@/Components/ui/switch";
import ImageUpload from '@/Components/ImageUpload.vue';
import QuillEditor from '@/Components/QuillEditor.vue';

const props = defineProps({
    blog: Object,
    categories: Array,
});

const form = useForm({
    title: props.blog.title,
    slug: props.blog.slug,
    excerpt: props.blog.excerpt,
    content: props.blog.content,
    featured_image: null,
    meta_title: props.blog.meta_title,
    meta_description: props.blog.meta_description,
    meta_keywords: props.blog.meta_keywords,
    author: props.blog.author,
    published_at: new Date(props.blog.published_at).toISOString().slice(0, 16) || '',
    is_featured: props.blog.is_featured,
    is_published: props.blog.is_published,
    category_id: props.blog.category_id,
    _method: 'PUT',
});

const handleSubmit = () => {
    form.post(route('blogs.update', props.blog.id), {
        preserveScroll: true,
    });
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
    <Head title="Edit Blog Post" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader>
                <CardTitle class="text-2xl">Edit Blog Post</CardTitle>
                <CardDescription>Update the blog post details</CardDescription>
            </CardHeader>
            <form @submit.prevent="handleSubmit">
                <CardContent class="space-y-6">
                    <!-- Title and Slug -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <Label for="title">Title</Label>
                            <Input id="title" v-model="form.title" required />
                            <p v-if="hasFieldError('title')" class="text-sm text-red-500">
                                {{ getFieldError('title') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="slug">Slug</Label>
                            <Input id="slug" v-model="form.slug" />
                            <p class="text-sm text-gray-500">Leave empty to generate automatically</p>
                            <p v-if="hasFieldError('slug')" class="text-sm text-red-500">
                                {{ getFieldError('slug') }}
                            </p>
                        </div>
                    </div>

                    <!-- Excerpt and Content -->
                    <div class="space-y-2">
                        <Label for="excerpt">Excerpt</Label>
                        <Textarea id="excerpt" v-model="form.excerpt" rows="3" />
                        <p v-if="hasFieldError('excerpt')" class="text-sm text-red-500">
                            {{ getFieldError('excerpt') }}
                        </p>
                    </div>
                    <div class="space-y-2">
                        <Label for="content">Content</Label>
                        <QuillEditor v-model="form.content" placeholder="Write your blog post content here..." />
                        <p v-if="hasFieldError('content')" class="text-sm text-red-500">
                            {{ getFieldError('content') }}
                        </p>
                    </div>

                    <!-- Featured Image -->
                    <div class="space-y-2">
                        <Label>Featured Image</Label>
                        <div v-if="blog.featured_image" class="mb-4">
                            <img :src="blog.featured_image" :alt="blog.title" class="w-32 h-32 object-cover rounded-md" />
                        </div>
                        <ImageUpload @upload="handleImageUpload" />
                        <p class="text-sm text-gray-500">Upload a new image to replace the current one</p>
                    </div>



                    <!-- Author and Publishing -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <Label for="author">Author</Label>
                            <Input id="author" v-model="form.author" required />
                            <p v-if="hasFieldError('author')" class="text-sm text-red-500">
                                {{ getFieldError('author') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="published_at">Publish Date</Label>
                            <Input id="published_at" type="datetime-local" v-model="form.published_at" />
                            <p v-if="hasFieldError('published_at')" class="text-sm text-red-500">
                                {{ getFieldError('published_at') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="category_id">Category</Label>
                            <Select id="category_id" v-model="form.category_id" required>
                                <SelectTrigger>
                                    <SelectValue placeholder="Select a category" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <p v-if="hasFieldError('category_id')" class="text-sm text-red-500">
                                {{ getFieldError('category_id') }}
                            </p>
                        </div>
                    </div>

                    <!-- Status Toggles -->
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <Switch id="is_featured" v-model="form.is_featured" />
                            <Label for="is_featured">Featured Post</Label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <Switch id="is_published" v-model="form.is_published" />
                            <Label for="is_published">Published</Label>
                        </div>
                    </div>
                     <!-- Meta Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium">Meta Information</h3>
                        <div class="space-y-2">
                            <Label for="meta_title">Meta Title</Label>
                            <Input id="meta_title" v-model="form.meta_title" />
                            <p v-if="hasFieldError('meta_title')" class="text-sm text-red-500">
                                {{ getFieldError('meta_title') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="meta_description">Meta Description</Label>
                            <Textarea id="meta_description" v-model="form.meta_description" rows="2" />
                            <p v-if="hasFieldError('meta_description')" class="text-sm text-red-500">
                                {{ getFieldError('meta_description') }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <Label for="meta_keywords">Meta Keywords</Label>
                            <Input id="meta_keywords" v-model="form.meta_keywords" />
                            <p class="text-sm text-gray-500">Separate keywords with commas</p>
                            <p v-if="hasFieldError('meta_keywords')" class="text-sm text-red-500">
                                {{ getFieldError('meta_keywords') }}
                            </p>
                        </div>
                    </div>

                </CardContent>
                <CardFooter class="flex justify-end space-x-4">
                    <Button type="button" variant="outline" @click="$inertia.visit(route('blogs.index'))">
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        Update Post
                    </Button>
                </CardFooter>
            </form>
        </Card>
    </AuthenticatedLayout>
</template>
