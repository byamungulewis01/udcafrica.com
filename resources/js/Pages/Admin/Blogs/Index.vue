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
    blogs: Array,
});

// Search functionality
const searchQuery = ref('');
const filteredBlogs = ref([]);

const filterBlogs = () => {
    if (searchQuery.value) {
        filteredBlogs.value = props.blogs.filter(blog =>
            blog.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            blog.author?.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    } else {
        filteredBlogs.value = props.blogs;
    }
};

onMounted(() => {
    filteredBlogs.value = props.blogs;
});

const confirmDelete = (blogId) => {
    if (confirm('Are you sure you want to delete this blog post?')) {
        useForm().delete(route('blogs.destroy', blogId), {
            preserveScroll: true,
            onSuccess: () => {
                router.visit(route('blogs.index'), {
                    only: ['blogs']
                });
            },
        });
    }
};

const moveItem = async (index, direction) => {
    if (
        (direction === 'up' && index === 0) ||
        (direction === 'down' && index === filteredBlogs.value.length - 1)
    ) {
        return;
    }

    const newIndex = direction === 'up' ? index - 1 : index + 1;
    const items = [...filteredBlogs.value];
    const item = items[index];
    const otherItem = items[newIndex];

    // Swap orders
    const tempOrder = item.order;
    item.order = otherItem.order;
    otherItem.order = tempOrder;

    // Update the array
    items[index] = otherItem;
    items[newIndex] = item;
    filteredBlogs.value = items;

    // Send update to server
    try {
        await axios.post(route('blogs.reorder'), {
            items: items.map((item, index) => ({
                id: item.id,
                order: index
            }))
        });
    } catch (error) {
        console.error('Failed to update order:', error);
        // Revert the order if the server update fails
        filteredBlogs.value = props.blogs;
    }
};
</script>

<template>

    <Head title="Blog Management" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader class="pb-3">
                <div class="flex justify-between items-center">
                    <div>
                        <CardTitle class="text-2xl">Blog Management</CardTitle>
                        <CardDescription>Manage your blog posts</CardDescription>
                    </div>
                    <Link :href="route('blogs.create')">
                    <Button variant="default" class="flex items-center gap-2">
                        <Plus class="w-4 h-4" />
                        New Post
                    </Button>
                    </Link>
                </div>
            </CardHeader>
            <CardContent>
                <!-- Search Bar -->
                <div class="relative mb-6">
                    <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                    <Input v-model="searchQuery" @input="filterBlogs" placeholder="Search by title or author..."
                        class="pl-10" />
                </div>

                <!-- Blogs Table -->
                <div class="rounded-md border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-4">#</TableHead>
                                <TableHead>Image</TableHead>
                                <TableHead>Title</TableHead>
                                <TableHead>Author</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead>Published</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(blog, index) in filteredBlogs" :key="blog.id">
                                <TableCell>
                                    <div class="flex items-center gap-2">
                                        <Badge variant="outline">
                                            {{ index + 1 }}
                                        </Badge>
                                        <div class="flex flex-col">
                                            <Button variant="ghost" size="icon" class="h-6 w-6" :disabled="index === 0"
                                                @click="moveItem(index, 'up')">
                                                <ArrowUp class="h-4 w-4" />
                                            </Button>
                                            <Button variant="ghost" size="icon" class="h-6 w-6"
                                                :disabled="index === filteredBlogs.length - 1"
                                                @click="moveItem(index, 'down')">
                                                <ArrowDown class="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="w-16 h-16 rounded-md overflow-hidden">
                                        <img v-if="blog.featured_image" :src="blog.featured_image" :alt="blog.title"
                                            class="w-full h-full object-cover" />
                                        <div v-else class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <ImageIcon class="w-8 h-8 text-gray-400" />
                                        </div>

                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="font-medium">{{ blog.title }}</div>
                                    <div class="text-sm text-gray-500">{{ blog.reading_time }}</div>
                                    <Badge v-if="blog.category" variant="outline">
                                        {{ blog.category.name }}
                                    </Badge>
                                </TableCell>
                                <TableCell>{{ blog.author }}</TableCell>

                                <TableCell>
                                    <Badge
                                        :class="blog.is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'">
                                        {{ blog.is_published ? 'Published' : 'Draft' }}
                                    </Badge>
                                    <Badge v-if="blog.is_featured" class="ml-1 bg-blue-100 text-blue-800">
                                        Featured
                                    </Badge>
                                </TableCell>
                                <TableCell>
                                    {{ blog.formatted_published_at || 'Not published' }}
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Link :href="route('blogs.edit', blog.id)">
                                        <Button variant="outline" size="icon" class="h-8 w-8">
                                            <Edit class="h-4 w-4" />
                                        </Button>
                                        </Link>
                                        <Button variant="outline" size="icon" class="h-8 w-8 text-red-500"
                                            @click="confirmDelete(blog.id)">
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="filteredBlogs.length === 0">
                                <TableCell colspan="8" class="text-center py-8 text-gray-500">
                                    No blog posts found. Try a different search or create a new post.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </CardContent>
            <CardFooter>
                <div class="text-sm text-gray-500">
                    Showing {{ filteredBlogs.length }} out of {{ props.blogs.length }} blog posts
                </div>
            </CardFooter>
        </Card>
    </AuthenticatedLayout>
</template>
