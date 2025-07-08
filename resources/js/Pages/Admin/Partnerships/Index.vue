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
    partnerships: Array,
});

// Search functionality
const searchQuery = ref('');
const filteredPartnerships = ref([]);

const filterPartnerships = () => {
    if (searchQuery.value) {
        filteredPartnerships.value = props.partnerships.filter(partnership =>
            partnership.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            partnership.description?.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    } else {
        filteredPartnerships.value = props.partnerships;
    }
};

onMounted(() => {
    filteredPartnerships.value = props.partnerships;
});

// Combined create/edit team dialog
const showPartnershipDialog = ref(false);
const isEditMode = ref(false);
const form = useForm({
    id: null,
    name: '',
    description: '',
    image: null,
    is_active: true
});

const resetForm = () => {
    form.reset();
    form.clearErrors();
};

const openCreateDialog = () => {
    resetForm();
    isEditMode.value = false;
    showPartnershipDialog.value = true;
};

const openEditDialog = (partnership) => {
    resetForm();
    isEditMode.value = true;

    // Fill form with team data
    form.id = partnership.id;
    form.name = partnership.name;
    form.description = partnership.description;
    form.is_active = partnership.is_active;

    showPartnershipDialog.value = true;
};

const handleImageUpload = (event) => {
    form.image = event.target.files[0];
};

const submitForm = () => {
    if (isEditMode.value) {
        form.post(route('partnerships.update', form.id), {
            preserveScroll: true,
            onSuccess: () => {
                showPartnershipDialog.value = false;
                resetForm();
                router.visit(route('partnerships.index'), {
                    only: ['partnerships']
                });
            },
        });
    } else {
        form.post(route('partnerships.store'), {
            preserveScroll: true,
            onSuccess: () => {
                showPartnershipDialog.value = false;
                resetForm();
                router.visit(route('partnerships.index'), {
                    only: ['partnerships']
                });
            },
        });
    }
};

const confirmDelete = (partnershipId) => {
    if (confirm('Are you sure you want to delete this partnership?')) {
        useForm().delete(route('partnerships.destroy', partnershipId), {
            preserveScroll: true,
            onSuccess: () => {
                router.visit(route('partnerships.index'), {
                    only: ['partnerships']
                });
            },
        });
    }
};


const moveItem = async (index, direction) => {
    if (
        (direction === 'up' && index === 0) ||
        (direction === 'down' && index === filteredPartnerships.value.length - 1)
    ) {
        return;
    }

    const newIndex = direction === 'up' ? index - 1 : index + 1;
    const items = [...filteredPartnerships.value];
    const item = items[index];
    const otherItem = items[newIndex];

    // Swap orders
    const tempOrder = item.order;
    item.order = otherItem.order;
    otherItem.order = tempOrder;

    // Update the array
    items[index] = otherItem;
    items[newIndex] = item;
    filteredPartnerships.value = items;

    // Send update to server
    try {
        await axios.put(route('partnerships.reorder'), {
            items: items.map((item, index) => ({
                id: item.id,
                order: index
            }))
        });
    } catch (error) {
        console.error('Failed to update order:', error);
        // Revert the order if the server update fails
        filteredPartnerships.value = props.partnerships;
    }
};
</script>

<template>

    <Head title="Partnerships Management" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader class="pb-3">
                <div class="flex justify-between items-center">
                    <div>
                        <CardTitle class="text-2xl">Partnerships Management</CardTitle>
                        <CardDescription>Manage your partnerships</CardDescription>
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
                    <Input v-model="searchQuery" @input="filterPartnerships"
                        placeholder="Search by name or description..." class="pl-10" />
                </div>

                <!-- Partnerships Table -->
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
                            <TableRow v-for="(partnership, index) in filteredPartnerships" :key="partnership.id">
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
                                                :disabled="index === filteredPartnerships.length - 1"
                                                @click="moveItem(index, 'down')">
                                                <ArrowDown class="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="w-12 h-12 rounded-md overflow-hidden">
                                        <img v-if="partnership.image" :src="partnership.image" :alt="partnership.name"
                                            class="w-full h-full object-cover" />
                                        <div v-else class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <ImageIcon class="w-5 h-5 text-gray-400" />
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell class="font-medium">{{ partnership.name }}</TableCell>
                                <TableCell>{{ partnership.description }}</TableCell>
                                <TableCell>
                                    <Badge
                                        :class="partnership.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                        {{ partnership.is_active ? 'Active' : 'Inactive' }}
                                    </Badge>
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Button variant="outline" size="icon" class="h-8 w-8"
                                            @click="openEditDialog(partnership)">
                                            <Edit class="h-4 w-4" />
                                        </Button>
                                        <Button variant="outline" size="icon" class="h-8 w-8 text-red-500"
                                            @click="confirmDelete(partnership.id)">
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="filteredPartnerships.length === 0">
                                <TableCell colspan="7" class="text-center py-8 text-gray-500">
                                    No partnerships found. Try a different search or add a new partnership.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </CardContent>
            <CardFooter>
                <div class="text-sm text-gray-500">
                    Showing {{ filteredPartnerships.length }} out of {{ props.partnerships.length }} partnerships
                </div>
            </CardFooter>
        </Card>

        <!-- Combined Create/Edit Team Dialog -->
        <Dialog :open="showPartnershipDialog" @update:open="showPartnershipDialog = $event">
            <DialogContent class="max-w-xl">
                <DialogHeader>
                    <DialogTitle>{{ isEditMode ? 'Edit Partnership' : 'Add New Partnership' }}</DialogTitle>
                </DialogHeader>
                <form @submit.prevent="submitForm">
                    <div class="grid gap-4 py-4">
                        <div class="grid gap-2">
                            <Label for="name">Name</Label>
                            <Input id="name" v-model="form.name" placeholder="Enter name" required />
                            <div v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</div>
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
                        <Button type="button" variant="outline" @click="showPartnershipDialog = false">Cancel</Button>
                        <Button type="submit" :disabled="form.processing">
                            {{ isEditMode ? 'Update' : 'Save' }}
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </AuthenticatedLayout>
</template>
