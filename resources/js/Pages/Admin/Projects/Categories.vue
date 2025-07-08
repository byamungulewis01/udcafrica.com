<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Button } from '@/Components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogFooter,
} from "@/Components/ui/dialog";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/Components/ui/table";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import { Badge } from "@/Components/ui/badge";
import { Edit, Trash2, UserPlus, ArrowUp, ArrowDown } from 'lucide-vue-next';
import axios from 'axios';

const props = defineProps({
    categories: Array,
});


// Combined create/edit dialog
const showDialog = ref(false);
const isEditMode = ref(false);
const form = useForm({
    id: null,
    slug: '',
    name: '',
    description: '',
    is_active: true
});

const resetForm = () => {
    form.reset();
    form.clearErrors();
};

const openCreateDialog = () => {
    resetForm();
    isEditMode.value = false;
    showDialog.value = true;
};

const openEditDialog = (category) => {
    resetForm();
    isEditMode.value = true;

    // Fill form with category data
    form.id = category.id;
    form.name = category.name;
    form.slug = category.slug;
    form.description = category.description;
    form.is_active = category.is_active;
    showDialog.value = true;
};


const submitForm = () => {
    if (isEditMode.value) {
        form.put(route('project-categories.update', form.id), {
            preserveScroll: true,
            onSuccess: () => {
                showDialog.value = false;
                resetForm();
                router.visit(route('project-categories.index'), {
                    only: ['categories']
                });
            },
        });
    } else {
        form.post(route('project-categories.store'), {
            preserveScroll: true,
            onSuccess: () => {
                showDialog.value = false;
                resetForm();
                router.visit(route('project-categories.index'), {
                    only: ['categories']
                });
            },
        });
    }
};

const confirmDelete = (categoryId) => {
    if (confirm('Are you sure you want to delete this category?')) {
        useForm().delete(route('project-categories.destroy', categoryId), {
            preserveScroll: true,
            onSuccess: () => {
                router.visit(route('project-categories.index'), {
                    only: ['categories']
                });
            },
        });
    }
};


const moveItem = async (index, direction) => {
    if (
        (direction === 'up' && index === 0) ||
        (direction === 'down' && index === props.categories.length - 1)
    ) {
        return;
    }

    const newIndex = direction === 'up' ? index - 1 : index + 1;
    const items = [...props.categories];
    const item = items[index];
    const otherItem = items[newIndex];

    // Swap orders
    const tempOrder = item.order;
    item.order = otherItem.order;
    otherItem.order = tempOrder;

    // Update the array
    items[index] = otherItem;
    items[newIndex] = item;
    props.categories = items;

    // Send update to server
    try {
        await axios.post(route('project-categories.reorder'), {
            items: items.map((item, index) => ({
                id: item.id,
                order: index
            }))
        });
        router.visit(route('project-categories.index'), {
            only: ['categories']
        });

    } catch (error) {
        console.error('Failed to update order:', error);
    }
};
</script>

<template>

    <Head title="Project Categories" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader class="pb-3">
                <div class="flex justify-between items-center">
                    <div>
                        <CardTitle class="text-2xl">Project Categories</CardTitle>
                        <CardDescription>Manage your project categories</CardDescription>
                    </div>
                    <Button @click="openCreateDialog" variant="default" class="flex items-center gap-2">
                        <UserPlus class="w-4 h-4" />
                        Add New
                    </Button>
                </div>
            </CardHeader>
            <CardContent>
                <!-- Categories Table -->
                <div class="rounded-md border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-4">#</TableHead>
                                <TableHead>Name</TableHead>
                                <TableHead>Slug</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(category, index) in categories" :key="category.id">
                                <TableCell>
                                    <div class="flex items-center gap-2">
                                        <Badge variant="outline">
                                            {{ index + 1 }}
                                        </Badge>
                                        <div class="flex items-center gap-2">
                                            <Button variant="ghost" size="icon" class="h-6 w-6" :disabled="index === 0"
                                                @click="moveItem(index, 'up')">
                                                <ArrowUp class="h-4 w-4" />
                                            </Button>
                                            <Button variant="ghost" size="icon" class="h-6 w-6"
                                                :disabled="index === categories.length - 1"
                                                @click="moveItem(index, 'down')">
                                                <ArrowDown class="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </div>
                                </TableCell>

                                <TableCell class="font-medium">{{ category.name }}</TableCell>
                                <TableCell>{{ category.slug }}</TableCell>

                                <TableCell>
                                    <Badge
                                        :class="category.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                        {{ category.is_active ? 'Active' : 'Inactive' }}
                                    </Badge>
                                </TableCell>

                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Button variant="outline" size="icon" class="h-8 w-8"
                                            @click="openEditDialog(category)">
                                            <Edit class="h-4 w-4" />
                                        </Button>
                                        <Button variant="outline" size="icon" class="h-8 w-8 text-red-500"
                                            @click="confirmDelete(category.id)">
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="categories.length === 0">
                                <TableCell colspan="5" class="text-center py-8 text-gray-500">
                                    No categories found. Try a different search or add a new category.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </CardContent>

        </Card>

        <!-- Combined Create/Edit Category Dialog -->
        <Dialog :open="showDialog" @update:open="showDialog = $event">
            <DialogContent class="max-w-lg">
                <DialogHeader>
                    <DialogTitle>{{ isEditMode ? 'Edit Category' : 'Add New Category' }}</DialogTitle>
                </DialogHeader>
                <form @submit.prevent="submitForm">
                    <div class="grid gap-4 py-4">
                        <div class="grid gap-2">
                            <Label for="name">Name</Label>
                            <Input id="name" v-model="form.name" placeholder="Enter name" required />
                            <div v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</div>
                        </div>

                        <div class="grid gap-2">
                            <Label for="slug">Slug</Label>
                            <Input id="slug" v-model="form.slug" placeholder="Enter slug" />
                            <p class="text-sm text-gray-500">Leave empty to generate automatically</p>
                            <div v-if="form.errors.slug" class="text-sm text-red-500">
                                {{ form.errors.slug }}
                            </div>
                        </div>

                        <div class="grid gap-2">
                            <Label for="description">Description</Label>
                            <textarea id="description" v-model="form.description" rows="3"
                                class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                placeholder="Enter description"></textarea>
                            <div v-if="form.errors.description" class="text-sm text-red-500">
                                {{ form.errors.description }}
                            </div>
                        </div>

                        <div v-if="isEditMode" class="grid gap-2">
                            <Label for="is_active">Status</Label>
                            <select id="is_active" v-model="form.is_active"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                <option :value="true">Active</option>
                                <option :value="false">Inactive</option>
                            </select>
                            <div v-if="form.errors.is_active" class="text-sm text-red-500">
                                {{ form.errors.is_active }}
                            </div>
                        </div>
                    </div>
                    <DialogFooter>
                        <Button type="button" variant="outline" @click="showDialog = false">Cancel</Button>
                        <Button type="submit" :disabled="form.processing">
                            {{ isEditMode ? 'Update' : 'Save' }}
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </AuthenticatedLayout>
</template>
