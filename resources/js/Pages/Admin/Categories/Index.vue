<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Input } from "@/Components/ui/input";
import { Button } from '@/Components/ui/button';
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
import { Search, Edit, Trash2, Plus, ArrowUp, ArrowDown, Image as ImageIcon } from 'lucide-vue-next';
import axios from 'axios';

const props = defineProps({
    categories: Array,
});

// Search functionality
const searchQuery = ref('');
const filteredCategories = ref([]);

const filterCategories = () => {
    if (searchQuery.value) {
        filteredCategories.value = props.categories.filter(category =>
            category.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    } else {
        filteredCategories.value = props.categories;
    }
};

onMounted(() => {
    filteredCategories.value = props.categories;
});

const confirmDelete = (categoryId) => {
    if (confirm('Are you sure you want to delete this category?')) {
        useForm().delete(route('categories.destroy', categoryId), {
            preserveScroll: true,
            onSuccess: () => {
                router.visit(route('categories.index'), {
                    only: ['categories']
                });
            },
        });
    }
};

const moveItem = async (index, direction) => {
    if (
        (direction === 'up' && index === 0) ||
        (direction === 'down' && index === filteredCategories.value.length - 1)
    ) {
        return;
    }

    const newIndex = direction === 'up' ? index - 1 : index + 1;
    const items = [...filteredCategories.value];
    const item = items[index];
    const otherItem = items[newIndex];

    // Swap orders
    const tempOrder = item.order;
    item.order = otherItem.order;
    otherItem.order = tempOrder;

    // Update the array
    items[index] = otherItem;
    items[newIndex] = item;
    filteredCategories.value = items;

    // Send update to server
    try {
        await axios.post(route('categories.reorder'), {
            items: items.map((item, index) => ({
                id: item.id,
                order: index
            }))
        });
    } catch (error) {
        console.error('Failed to update order:', error);
        // Revert the order if the server update fails
        filteredCategories.value = props.categories;
    }
};
</script>

<template>
    <Head title="Category Management" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader class="pb-3">
                <div class="flex justify-between items-center">
                    <div>
                        <CardTitle class="text-2xl">Category Management</CardTitle>
                        <CardDescription>Manage your blog categories</CardDescription>
                    </div>
                    <Link :href="route('categories.create')">
                        <Button variant="default" class="flex items-center gap-2">
                            <Plus class="w-4 h-4" />
                            New Category
                        </Button>
                    </Link>
                </div>
            </CardHeader>
            <CardContent>
                <!-- Search Bar -->
                <div class="relative mb-6">
                    <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                    <Input v-model="searchQuery" @input="filterCategories"
                        placeholder="Search categories..." class="pl-10" />
                </div>

                <!-- Categories Table -->
                <div class="rounded-md border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-4">#</TableHead>
                                <TableHead>Image</TableHead>
                                <TableHead>Name</TableHead>
                                <TableHead>Description</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(category, index) in filteredCategories" :key="category.id">
                                <TableCell>
                                    <div class="flex items-center gap-2">
                                        <Badge variant="outline">
                                            {{ index + 1 }}
                                        </Badge>
                                        <div class="flex flex-col">
                                            <Button
                                                variant="ghost"
                                                size="icon"
                                                class="h-6 w-6"
                                                :disabled="index === 0"
                                                @click="moveItem(index, 'up')"
                                            >
                                                <ArrowUp class="h-4 w-4" />
                                            </Button>
                                            <Button
                                                variant="ghost"
                                                size="icon"
                                                class="h-6 w-6"
                                                :disabled="index === filteredCategories.length - 1"
                                                @click="moveItem(index, 'down')"
                                            >
                                                <ArrowDown class="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="w-16 h-16 rounded-md overflow-hidden">
                                        <img v-if="category.image" :src="category.image" :alt="category.name"
                                            class="w-full h-full object-cover" />
                                        <div v-else
                                            class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <ImageIcon class="w-8 h-8 text-gray-400" />
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="font-medium">{{ category.name }}</div>
                                    <div class="text-sm text-gray-500">{{ category.slug }}</div>
                                </TableCell>
                                <TableCell>
                                    <div class="text-sm text-gray-500 line-clamp-2">
                                        {{ category.description }}
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <Badge :class="category.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                        {{ category.is_active ? 'Active' : 'Inactive' }}
                                    </Badge>
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Link :href="route('categories.edit', category.id)">
                                            <Button variant="outline" size="icon" class="h-8 w-8">
                                                <Edit class="h-4 w-4" />
                                            </Button>
                                        </Link>
                                        <Button variant="outline" size="icon" class="h-8 w-8 text-red-500"
                                            @click="confirmDelete(category.id)">
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="filteredCategories.length === 0">
                                <TableCell colspan="6" class="text-center py-8 text-gray-500">
                                    No categories found. Try a different search or create a new category.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </CardContent>
            <CardFooter>
                <div class="text-sm text-gray-500">
                    Showing {{ filteredCategories.length }} out of {{ props.categories.length }} categories
                </div>
            </CardFooter>
        </Card>
    </AuthenticatedLayout>
</template>
