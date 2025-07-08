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
    news: Array,
});

// Search functionality
const searchQuery = ref('');
const filteredNews = ref([]);

const filterNews = () => {
    if (searchQuery.value) {
        filteredNews.value = props.news.filter(news =>
            news.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            news.source_name?.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    } else {
        filteredNews.value = props.news;
    }
};

onMounted(() => {
    filteredNews.value = props.news;
});

const confirmDelete = (newsId) => {
    if (confirm('Are you sure you want to delete this news?')) {
        useForm().delete(route('news.destroy', newsId), {
            preserveScroll: true,
            onSuccess: () => {
                router.visit(route('news.index'), {
                    only: ['news']
                });
            },
        });
    }
};

</script>

<template>

    <Head title="News Management" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader class="pb-3">
                <div class="flex justify-between items-center">
                    <div>
                        <CardTitle class="text-2xl">News Management</CardTitle>
                        <CardDescription>Manage your news</CardDescription>
                    </div>
                    <Link :href="route('news.create')">
                    <Button variant="default" class="flex items-center gap-2">
                        <Plus class="w-4 h-4" />
                        New News
                    </Button>
                    </Link>
                </div>
            </CardHeader>
            <CardContent>
                <!-- Search Bar -->
                <div class="relative mb-6">
                    <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                    <Input v-model="searchQuery" @input="filterNews" placeholder="Search by title or source name..."
                        class="pl-10" />
                </div>

                <!-- News Table -->
                <div class="rounded-md border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-4">#</TableHead>
                                <TableHead>Image</TableHead>
                                <TableHead>Title</TableHead>
                                <TableHead>Author</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(news, index) in filteredNews" :key="news.id">
                                <TableCell>
                                    <div class="flex items-center gap-2">
                                        <Badge variant="outline">
                                            {{ index + 1 }}
                                        </Badge>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="w-16 h-16 rounded-md overflow-hidden">
                                        <img v-if="news.featured_image" :src="news.featured_image" :alt="news.title"
                                            class="w-full h-full object-cover" />
                                        <div v-else class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <ImageIcon class="w-8 h-8 text-gray-400" />
                                        </div>

                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="font-medium">{{ news.title }}</div>
                                    <div class="text-sm text-gray-500">{{ news.source_name }}</div>

                                </TableCell>
                                <TableCell>{{ news.created_by.name }}</TableCell>

                                <TableCell>
                                    <Badge
                                        :class="news.is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'">
                                        {{ news.is_published ? 'Published' : 'Draft' }}
                                    </Badge>
                                    <Badge v-if="news.is_featured" class="ml-1 bg-blue-100 text-blue-800">
                                        Featured
                                    </Badge>
                                </TableCell>

                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Link :href="route('news.edit', news.id)">
                                        <Button variant="outline" size="icon" class="h-8 w-8">
                                            <Edit class="h-4 w-4" />
                                        </Button>
                                        </Link>
                                        <Button variant="outline" size="icon" class="h-8 w-8 text-red-500"
                                            @click="confirmDelete(news.id)">
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="filteredNews.length === 0">
                                <TableCell colspan="8" class="text-center py-8 text-gray-500">
                                    No news found. Try a different search or create a new news.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </CardContent>
            <CardFooter>
                <div class="text-sm text-gray-500">
                    Showing {{ filteredNews.length }} out of {{ props.news.length }} news
                </div>
            </CardFooter>
        </Card>
    </AuthenticatedLayout>
</template>
