<template>
  <Head title="Project Management" />

  <AuthenticatedLayout>
    <Card>
      <CardHeader class="pb-3">
        <div class="flex justify-between items-center">
          <div>
            <CardTitle class="text-2xl">Project Management</CardTitle>
            <CardDescription>Manage your projects</CardDescription>
          </div>
          <div class="flex space-x-4">
            <Link :href="route('projects.create')">
              <Button variant="default" class="flex items-center gap-2">
                <Plus class="w-4 h-4" />
                New Project
              </Button>
            </Link>
          </div>
        </div>
      </CardHeader>
      <CardContent>
        <!-- Search Bar -->
        <div class="relative mb-6">
          <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
          <Input v-model="searchQuery" @input="filterProjects" placeholder="Search by title or client..."
            class="pl-10" />
        </div>

        <!-- Projects Table -->
        <div class="rounded-md border">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead class="w-4">#</TableHead>
                <TableHead>Image</TableHead>
                <TableHead>Title</TableHead>
                <TableHead>Category</TableHead>
                <TableHead>Status</TableHead>
                <TableHead class="text-right">Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="(project, index) in filteredProjects" :key="project.id">
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
                        :disabled="index === filteredProjects.length - 1"
                        @click="moveItem(index, 'down')">
                        <ArrowDown class="h-4 w-4" />
                      </Button>
                    </div>
                  </div>
                </TableCell>
                <TableCell>
                  <div class="w-16 h-16 rounded-md overflow-hidden">
                    <img v-if="project.featured_image" :src="project.featured_image" :alt="project.title"
                      class="w-full h-full object-cover" />
                    <div v-else class="w-full h-full bg-gray-100 flex items-center justify-center">
                      <ImageIcon class="w-8 h-8 text-gray-400" />
                    </div>
                  </div>
                </TableCell>
                <TableCell>
                  <div class="font-medium">{{ project.title }}</div>
                  <div class="text-sm text-gray-500">{{ project.client }}</div>
                </TableCell>
                <TableCell>
                  <Badge v-if="project.category" variant="outline">
                    {{ project.category.name }}
                  </Badge>
                  <Badge v-else variant="outline" class="text-gray-500">
                    Uncategorized
                  </Badge>
                </TableCell>
                <TableCell>
                  <Badge
                    :class="project.is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'">
                    {{ project.is_published ? 'Published' : 'Draft' }}
                  </Badge>
                  <Badge v-if="project.is_featured" class="ml-1 bg-blue-100 text-blue-800">
                    Featured
                  </Badge>
                </TableCell>
                <TableCell class="text-right">
                  <div class="flex justify-end gap-2">
                    <Link :href="route('projects.edit', project.id)">
                      <Button variant="outline" size="icon" class="h-8 w-8">
                        <Edit class="h-4 w-4" />
                      </Button>
                    </Link>
                    <Button variant="outline" size="icon" class="h-8 w-8 text-red-500"
                      @click="confirmDelete(project.id)">
                      <Trash2 class="h-4 w-4" />
                    </Button>
                  </div>
                </TableCell>
              </TableRow>
              <TableRow v-if="filteredProjects.length === 0">
                <TableCell colspan="6" class="text-center py-8 text-gray-500">
                  No projects found. Try a different search or create a new project.
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </div>
      </CardContent>
      <CardFooter>
        <div class="text-sm text-gray-500">
          Showing {{ filteredProjects.length }} out of {{ props.projects.length }} projects
        </div>
      </CardFooter>
    </Card>
  </AuthenticatedLayout>
</template>

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
  projects: Array,
});

// Search functionality
const searchQuery = ref('');
const filteredProjects = ref([]);

const filterProjects = () => {
  if (searchQuery.value) {
    filteredProjects.value = props.projects.filter(project =>
      project.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      project.client?.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  } else {
    filteredProjects.value = props.projects;
  }
};

onMounted(() => {
  filteredProjects.value = props.projects;
});

const confirmDelete = (projectId) => {
  if (confirm('Are you sure you want to delete this project?')) {
    useForm().delete(route('projects.destroy', projectId), {
      preserveScroll: true,
      onSuccess: () => {
        router.visit(route('projects.index'), {
          only: ['projects']
        });
      },
    });
  }
};

const moveItem = async (index, direction) => {
  if (
    (direction === 'up' && index === 0) ||
    (direction === 'down' && index === filteredProjects.value.length - 1)
  ) {
    return;
  }

  const newIndex = direction === 'up' ? index - 1 : index + 1;
  const items = [...filteredProjects.value];
  const item = items[index];
  const otherItem = items[newIndex];

  // Swap orders
  const tempOrder = item.order;
  item.order = otherItem.order;
  otherItem.order = tempOrder;

  // Update the array
  items[index] = otherItem;
  items[newIndex] = item;
  filteredProjects.value = items;

  // Send update to server
  try {
    await axios.post(route('projects.reorder'), {
      items: items.map((item, index) => ({
        id: item.id,
        order: index
      }))
    });
  } catch (error) {
    console.error('Failed to update order:', error);
    // Revert the order if the server update fails
    filteredProjects.value = props.projects;
  }
};
</script>
