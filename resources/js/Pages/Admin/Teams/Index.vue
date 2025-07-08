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
    teams: Array,
});

// Search functionality
const searchQuery = ref('');
const filteredTeams = ref([]);

const filterTeams = () => {
    if (searchQuery.value) {
        filteredTeams.value = props.teams.filter(team =>
            team.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            team.position?.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    } else {
        filteredTeams.value = props.teams;
    }
};

onMounted(() => {
    filteredTeams.value = props.teams;
});

// Combined create/edit team dialog
const showTeamDialog = ref(false);
const isEditMode = ref(false);
const form = useForm({
    id: null,
    name: '',
    position: '',
    description: '',
    image: null,
    facebook: '',
    twitter: '',
    linkedin: '',
    instagram: '',
    is_active: true
});

const resetForm = () => {
    form.reset();
    form.clearErrors();
};

const openCreateDialog = () => {
    resetForm();
    isEditMode.value = false;
    showTeamDialog.value = true;
};

const openEditDialog = (team) => {
    resetForm();
    isEditMode.value = true;

    // Fill form with team data
    form.id = team.id;
    form.name = team.name;
    form.position = team.position;
    form.description = team.description;
    form.facebook = team.facebook;
    form.twitter = team.twitter;
    form.linkedin = team.linkedin;
    form.instagram = team.instagram;
    form.is_active = team.is_active;

    showTeamDialog.value = true;
};

const handleImageUpload = (event) => {
    form.image = event.target.files[0];
};

const submitForm = () => {
    if (isEditMode.value) {
        form.post(route('teams.update', form.id), {
            preserveScroll: true,
            onSuccess: () => {
                showTeamDialog.value = false;
                resetForm();
                router.visit(route('teams.index'), {
                    only: ['teams']
                });
            },
        });
    } else {
        form.post(route('teams.store'), {
            preserveScroll: true,
            onSuccess: () => {
                showTeamDialog.value = false;
                resetForm();
                router.visit(route('teams.index'), {
                    only: ['teams']
                });
            },
        });
    }
};

const confirmDelete = (teamId) => {
    if (confirm('Are you sure you want to delete this team member?')) {
        useForm().delete(route('teams.destroy', teamId), {
            preserveScroll: true,
            onSuccess: () => {
                router.visit(route('teams.index'), {
                    only: ['teams']
                });
            },
        });
    }
};


const moveItem = async (index, direction) => {
    if (
        (direction === 'up' && index === 0) ||
        (direction === 'down' && index === filteredTeams.value.length - 1)
    ) {
        return;
    }

    const newIndex = direction === 'up' ? index - 1 : index + 1;
    const items = [...filteredTeams.value];
    const item = items[index];
    const otherItem = items[newIndex];

    // Swap orders
    const tempOrder = item.order;
    item.order = otherItem.order;
    otherItem.order = tempOrder;

    // Update the array
    items[index] = otherItem;
    items[newIndex] = item;
    filteredTeams.value = items;

    // Send update to server
    try {
        await axios.put(route('teams.reorder'), {
            items: items.map((item, index) => ({
                id: item.id,
                order: index
            }))
        });
    } catch (error) {
        console.error('Failed to update order:', error);
        // Revert the order if the server update fails
        filteredTeams.value = props.teams;
    }
};
</script>

<template>
    <Head title="Team Management" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader class="pb-3">
                <div class="flex justify-between items-center">
                    <div>
                        <CardTitle class="text-2xl">Team Management</CardTitle>
                        <CardDescription>Manage your team members</CardDescription>
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
                    <Input v-model="searchQuery" @input="filterTeams"
                        placeholder="Search by name or position..." class="pl-10" />
                </div>

                <!-- Teams Table -->
                <div class="rounded-md border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-4">#</TableHead>
                                <TableHead>Image</TableHead>
                                <TableHead>Name</TableHead>
                                <TableHead>Position</TableHead>
                                <TableHead>Social Media</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(team, index) in filteredTeams" :key="team.id">
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
                                                :disabled="index === filteredTeams.length - 1"
                                                @click="moveItem(index, 'down')"
                                            >
                                                <ArrowDown class="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="w-12 h-12 rounded-md overflow-hidden">
                                        <img v-if="team.image" :src="team.image" :alt="team.name"
                                            class="w-full h-full object-cover" />
                                        <div v-else
                                            class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <ImageIcon class="w-5 h-5 text-gray-400" />
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell class="font-medium">{{ team.name }}</TableCell>
                                <TableCell>{{ team.position }}</TableCell>
                                <TableCell>
                                    <div class="flex gap-2">
                                        <a v-if="team.facebook" :href="team.facebook" target="_blank" class="text-blue-600 hover:text-blue-800">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                                        </a>
                                        <a v-if="team.twitter" :href="team.twitter" target="_blank" class="text-blue-400 hover:text-blue-600">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                                        </a>
                                        <a v-if="team.linkedin" :href="team.linkedin" target="_blank" class="text-blue-700 hover:text-blue-900">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                                        </a>
                                        <a v-if="team.instagram" :href="team.instagram" target="_blank" class="text-pink-600 hover:text-pink-800">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 011.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 01-1.153 1.772 4.915 4.915 0 01-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 01-1.772-1.153 4.904 4.904 0 01-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 011.153-1.772A4.897 4.897 0 015.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 100 10 5 5 0 000-10zm6.5-.25a1.25 1.25 0 10-2.5 0 1.25 1.25 0 002.5 0zM12 9a3 3 0 110 6 3 3 0 010-6z"/></svg>
                                        </a>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <Badge :class="team.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                        {{ team.is_active ? 'Active' : 'Inactive' }}
                                    </Badge>
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Button variant="outline" size="icon" class="h-8 w-8"
                                            @click="openEditDialog(team)">
                                            <Edit class="h-4 w-4" />
                                        </Button>
                                        <Button variant="outline" size="icon" class="h-8 w-8 text-red-500"
                                            @click="confirmDelete(team.id)">
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="filteredTeams.length === 0">
                                <TableCell colspan="7" class="text-center py-8 text-gray-500">
                                    No team members found. Try a different search or add a new member.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </CardContent>
            <CardFooter>
                <div class="text-sm text-gray-500">
                    Showing {{ filteredTeams.length }} out of {{ props.teams.length }} team members
                </div>
            </CardFooter>
        </Card>

        <!-- Combined Create/Edit Team Dialog -->
        <Dialog :open="showTeamDialog" @update:open="showTeamDialog = $event">
            <DialogContent class="max-w-2xl">
                <DialogHeader>
                    <DialogTitle>{{ isEditMode ? 'Edit Team Member' : 'Add New Team Member' }}</DialogTitle>
                </DialogHeader>
                <form @submit.prevent="submitForm">
                    <div class="grid gap-4 py-4">
                        <div class="grid gap-2">
                            <Label for="name">Name</Label>
                            <Input id="name" v-model="form.name" placeholder="Enter name" required />
                            <div v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</div>
                        </div>

                        <div class="grid gap-2">
                            <Label for="position">Position</Label>
                            <Input id="position" v-model="form.position" placeholder="Enter position" />
                            <div v-if="form.errors.position" class="text-sm text-red-500">
                                {{ form.errors.position }}
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

                        <div class="grid gap-4">
                            <Label>Social Media Links</Label>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="grid gap-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                                        <Input v-model="form.facebook" placeholder="Facebook URL" />
                                    </div>
                                    <div v-if="form.errors.facebook" class="text-sm text-red-500">{{ form.errors.facebook }}</div>
                                </div>

                                <div class="grid gap-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                                        <Input v-model="form.twitter" placeholder="Twitter URL" />
                                    </div>
                                    <div v-if="form.errors.twitter" class="text-sm text-red-500">{{ form.errors.twitter }}</div>
                                </div>

                                <div class="grid gap-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-700" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                                        <Input v-model="form.linkedin" placeholder="LinkedIn URL" />
                                    </div>
                                    <div v-if="form.errors.linkedin" class="text-sm text-red-500">{{ form.errors.linkedin }}</div>
                                </div>

                                <div class="grid gap-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 011.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 01-1.153 1.772 4.915 4.915 0 01-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 01-1.772-1.153 4.904 4.904 0 01-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 011.153-1.772A4.897 4.897 0 015.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 100 10 5 5 0 000-10zm6.5-.25a1.25 1.25 0 10-2.5 0 1.25 1.25 0 002.5 0zM12 9a3 3 0 110 6 3 3 0 010-6z"/></svg>
                                        <Input v-model="form.instagram" placeholder="Instagram URL" />
                                    </div>
                                    <div v-if="form.errors.instagram" class="text-sm text-red-500">{{ form.errors.instagram }}</div>
                                </div>
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
                        <Button type="button" variant="outline" @click="showTeamDialog = false">Cancel</Button>
                        <Button type="submit" :disabled="form.processing">
                            {{ isEditMode ? 'Update' : 'Save' }}
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </AuthenticatedLayout>
</template>
