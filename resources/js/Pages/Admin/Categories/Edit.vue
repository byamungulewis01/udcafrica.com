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
    category: {
        type: Object,
        required: true
    }
});

const form = useForm({
    name: props.category.name,
    slug: props.category.slug,
    description: props.category.description,
    image: null,
    is_active: props.category.is_active,
    order: props.category.order,
    _method: 'PUT'
});

const handleSubmit = () => {
    form.post(route('categories.update', props.category.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const handleImageUpload = (file) => {
    form.image = file;
};
</script>

<template>
    <Head title="Edit Category" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader>
                <CardTitle class="text-2xl">Edit Category</CardTitle>
                <CardDescription>Update the category details</CardDescription>
            </CardHeader>
            <form @submit.prevent="handleSubmit">
                <CardContent class="space-y-6">
                    <!-- Name and Slug -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <Label for="name">Name</Label>
                            <Input id="name" v-model="form.name" required />
                        </div>
                        <div class="space-y-2">
                            <Label for="slug">Slug</Label>
                            <Input id="slug" v-model="form.slug" />
                            <p class="text-sm text-gray-500">Leave empty to generate automatically</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <Label for="description">Description</Label>
                        <Textarea id="description" v-model="form.description" rows="3" />
                    </div>

                    <!-- Image -->
                    <div class="space-y-2">
                        <Label>Category Image</Label>
                        <div v-if="category.image_url" class="mb-4">
                            <img :src="category.image_url" :alt="category.name" class="w-32 h-32 object-cover rounded-lg" />
                        </div>
                        <ImageUpload @upload="handleImageUpload" />
                    </div>

                    <!-- Status -->
                    <div class="flex items-center space-x-2">
                        <Switch id="is_active" v-model="form.is_active" />
                        <Label for="is_active">Active</Label>
                    </div>
                </CardContent>
                <CardFooter class="flex justify-end space-x-4">
                    <Button type="button" variant="outline" @click="$inertia.visit(route('categories.index'))">
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        Update Category
                    </Button>
                </CardFooter>
            </form>
        </Card>
    </AuthenticatedLayout>
</template>
