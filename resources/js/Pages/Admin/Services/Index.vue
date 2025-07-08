<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
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
import { Search, Edit, Trash2, UserPlus, Image as ImageIcon, ArrowUp, ArrowDown } from 'lucide-vue-next';
import axios from 'axios';

const props = defineProps({
    services: Array,
});

// Search functionality
const searchQuery = ref('');
const filteredServices = ref([]);

const filterServices = () => {
    if (searchQuery.value) {
        filteredServices.value = props.services.filter(service =>
            service.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            service.description?.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    } else {
        filteredServices.value = props.services;
    }
};

onMounted(() => {
    filteredServices.value = props.services;
});

// Combined create/edit team dialog
const showServiceDialog = ref(false);
const isEditMode = ref(false);
const form = useForm({
    id: null,
    name: '',
    description: '',
    image: null,
    icon: '',
    is_active: true
});

const resetForm = () => {
    form.reset();
    form.clearErrors();
};

const openCreateDialog = () => {
    resetForm();
    isEditMode.value = false;
    showServiceDialog.value = true;
};

const openEditDialog = (service) => {
    resetForm();
    isEditMode.value = true;

    // Fill form with team data
    form.id = service.id;
    form.name = service.name;
    form.description = service.description;
    form.icon = service.icon;
    form.is_active = service.is_active;
    form._method = 'PUT';

    showServiceDialog.value = true;
};

const handleImageUpload = (event) => {
    form.image = event.target.files[0];
};

const submitForm = () => {
    if (isEditMode.value) {
        form.post(route('services.update', form.id), {
            preserveScroll: true,
            onSuccess: () => {
                showServiceDialog.value = false;
                resetForm();
                router.visit(route('services.index'), {
                    only: ['services']
                });
            },
        });
    } else {
        form.post(route('services.store'), {
            preserveScroll: true,
            onSuccess: () => {
                showServiceDialog.value = false;
                resetForm();
                router.visit(route('services.index'), {
                    only: ['services']
                });
            },
        });
    }
};

const confirmDelete = (serviceId) => {
    if (confirm('Are you sure you want to delete this service?')) {
        useForm().delete(route('services.destroy', serviceId), {
            preserveScroll: true,
            onSuccess: () => {
                router.visit(route('services.index'), {
                    only: ['services']
                });
            },
        });
    }
};


const moveItem = async (index, direction) => {
    if (
        (direction === 'up' && index === 0) ||
        (direction === 'down' && index === filteredServices.value.length - 1)
    ) {
        return;
    }

    const newIndex = direction === 'up' ? index - 1 : index + 1;
    const items = [...filteredServices.value];
    const item = items[index];
    const otherItem = items[newIndex];

    // Swap orders
    const tempOrder = item.order;
    item.order = otherItem.order;
    otherItem.order = tempOrder;

    // Update the array
    items[index] = otherItem;
    items[newIndex] = item;
    filteredServices.value = items;

    // Send update to server
    try {
        await axios.put(route('services.reorder'), {
            items: items.map((item, index) => ({
                id: item.id,
                order: index
            }))
        });
    } catch (error) {
        console.error('Failed to update order:', error);
        // Revert the order if the server update fails
        filteredServices.value = props.services;
    }
};
</script>

<template>

    <Head title="Service Management" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader class="pb-3">
                <div class="flex justify-between items-center">
                    <div>
                        <CardTitle class="text-2xl">Service Management</CardTitle>
                        <CardDescription>Manage your services</CardDescription>
                    </div>
                    <Button @click="openCreateDialog" variant="default" class="flex items-center gap-2">
                        <UserPlus class="w-4 h-4" />
                        Add New
                    </Button>
                </div>
            </CardHeader>
            <CardContent>
                <!-- Search Bar -->
                <div class="relative mb-6">
                    <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                    <Input v-model="searchQuery" @input="filterServices" placeholder="Search by name or description..."
                        class="pl-10" />
                </div>

                <!-- Teams Table -->
                <div class="rounded-md border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-4">#</TableHead>
                                <TableHead>Image</TableHead>
                                <TableHead>Name</TableHead>
                                <TableHead>Description</TableHead>
                                <TableHead>Icon</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(service, index) in filteredServices" :key="service.id">
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
                                                :disabled="index === filteredServices.length - 1"
                                                @click="moveItem(index, 'down')">
                                                <ArrowDown class="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="w-12 h-12 rounded-md overflow-hidden">
                                        <img v-if="service.image" :src="service.image" :alt="service.name"
                                            class="w-full h-full object-cover" />
                                        <div v-else class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <ImageIcon class="w-5 h-5 text-gray-400" />
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell class="font-medium">{{ service.name }}</TableCell>
                                <TableCell>{{ service.description }}</TableCell>
                                <TableCell>
                                    <div v-if="service.icon" v-html="service.icon" class="w-5 h-5"></div>
                                </TableCell>
                                <TableCell>
                                    <Badge
                                        :class="service.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                        {{ service.is_active ? 'Active' : 'Inactive' }}
                                    </Badge>
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Button variant="outline" size="icon" class="h-8 w-8"
                                            @click="openEditDialog(service)">
                                            <Edit class="h-4 w-4" />
                                        </Button>
                                        <Button variant="outline" size="icon" class="h-8 w-8 text-red-500"
                                            @click="confirmDelete(service.id)">
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="filteredServices.length === 0">
                                <TableCell colspan="7" class="text-center py-8 text-gray-500">
                                    No services found. Try a different search or add a new service.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </CardContent>
            <CardFooter>
                <div class="text-sm text-gray-500">
                    Showing {{ filteredServices.length }} out of {{ props.services.length }} services
                </div>
            </CardFooter>
        </Card>

        <!-- Combined Create/Edit Team Dialog -->
        <Dialog :open="showServiceDialog" @update:open="showServiceDialog = $event">
            <DialogContent class="max-w-xl">
                <DialogHeader>
                    <DialogTitle>{{ isEditMode ? 'Edit Service' : 'Add New Service' }}</DialogTitle>
                </DialogHeader>
                <form @submit.prevent="submitForm">
                    <div class="grid gap-4 py-4">
                        <div class="grid gap-2">
                            <Label for="name">Name</Label>
                            <Input id="name" v-model="form.name" placeholder="Enter name" required />
                            <div v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</div>
                        </div>

                        <div class="grid gap-2">
                            <Label for="icon">Icon</Label>
                            <Input id="icon" v-model="form.icon" placeholder="Enter icon" />
                            <div v-if="form.errors.icon" class="text-sm text-red-500">
                                {{ form.errors.icon }}
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

                        <div class="grid gap-2">
                            <Label for="image">Image</Label>
                            <Input type="file" id="image" @change="handleImageUpload" accept="image/*" />
                            <div v-if="form.errors.image" class="text-sm text-red-500">{{ form.errors.image }}</div>
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
                        <Button type="button" variant="outline" @click="showServiceDialog = false">Cancel</Button>
                        <Button type="submit" :disabled="form.processing">
                            {{ isEditMode ? 'Update' : 'Save' }}
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </AuthenticatedLayout>
</template>
