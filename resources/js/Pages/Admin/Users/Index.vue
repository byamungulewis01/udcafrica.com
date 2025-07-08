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
import { Search, Edit, Trash2, Mail, Phone, UserPlus } from 'lucide-vue-next';

const props = defineProps({
    users: Array,
});

// Search functionality
const searchQuery = ref('');
const filteredUsers = ref([]);

const filterUsers = () => {
    if (searchQuery.value) {
        filteredUsers.value = props.users.filter(user =>
            user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            user.email.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    } else {
        filteredUsers.value = props.users;
    }
};

onMounted(() => {
    filteredUsers.value = props.users;
});

// Combined create/edit user dialog
const showUserDialog = ref(false);
const isEditMode = ref(false);
const form = useForm({
    id: null,
    name: '',
    email: '',
    phone: '',
    role: '',
    status: ''
});

const resetForm = () => {
    form.reset();
    form.clearErrors();
};

const openCreateDialog = () => {
    resetForm();
    isEditMode.value = false;
    showUserDialog.value = true;
};

const openEditDialog = (user) => {
    resetForm();
    isEditMode.value = true;

    // Fill form with user data
    form.id = user.id;
    form.name = user.name;
    form.email = user.email;
    form.phone = user.phone;
    form.status = user.status;
    form.role = user.role;

    showUserDialog.value = true;
};


const submitForm = () => {
    if (isEditMode.value) {
        form.put(route('users.update', form.id), {
            onSuccess: () => {
                showUserDialog.value = false;
                resetForm();
                router.visit(route('users.index'), {
                    only: ['users']
                });
            },
            onError: (errors) => {
                console.log('Validation errors:', errors);
            }
        });
    } else {
        // Create new user
        form.post(route('users.store'), {
            onSuccess: () => {
                showUserDialog.value = false;
                resetForm();
                router.visit(route('users.index'), {
                    only: ['users']
                });
            },
            onError: (errors) => {
                console.log('Validation errors:', errors);
            }
        });
    }
};

const confirmDelete = (userId) => {
    if (confirm('Are you sure you want to delete this user?')) {
        useForm().delete(route('users.destroy', userId), {
            onSuccess: () => {
                router.visit(route('users.index'), {
                    only: ['users']
                });
            }
        });
    }
};

const getStatusColor = (status) => {
    switch (status) {
        case 'active':
            return 'bg-green-100 text-green-800';
        case 'inactive':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};

const formatDate = (dateString) => {
    if (!dateString) return 'Never';

    const date = new Date(dateString);
    return date.toLocaleString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>

<template>

    <Head title="Users" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader class="pb-3">
                <div class="flex justify-between items-center">
                    <div>
                        <CardTitle class="text-2xl">Users Management</CardTitle>
                    </div>
                    <Button @click="openCreateDialog" variant="default" class="flex items-center gap-2">
                        <UserPlus class="w-4 h-4" />
                        Add User
                    </Button>
                </div>
            </CardHeader>
            <CardContent>
                <!-- Search Bar -->
                <div class="relative mb-6">
                    <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                    <Input v-model="searchQuery" @input="filterUsers" placeholder="Search users by name or email..."
                        class="pl-10" />
                </div>

                <!-- Users Table -->
                <div class="rounded-md border px-2">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-4">#</TableHead>
                                <TableHead>Name</TableHead>
                                <TableHead>Email</TableHead>
                                <TableHead>Phone</TableHead>
                                <TableHead>Role</TableHead>
                                <TableHead>Last Login</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(user, index) in filteredUsers" :key="user.id">
                                <TableCell>
                                    <Badge variant="outline">
                                        {{ index + 1 }}
                                    </Badge>
                                </TableCell>
                                <TableCell class="font-medium">{{ user.name }}</TableCell>
                                <TableCell>
                                    <div class="flex items-center gap-1">
                                        <Mail class="w-4 h-4 text-gray-500" />
                                        <span class="text-sm">{{ user.email }}</span>
                                    </div>

                                </TableCell>
                                <TableCell>
                                    <div class="flex items-center gap-1">
                                        <Phone class="w-4 h-4 text-gray-500" />
                                        <span class="text-sm">{{ user.phone }}</span>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <Badge variant="outline">
                                        {{ user.role_label }}
                                    </Badge>
                                </TableCell>
                                <TableCell>
                                    <div class="text-xs text-gray-400">{{ formatDate(user.last_login) }}</div>
                                </TableCell>

                                <TableCell>
                                    <Badge :class="getStatusColor(user.status)">
                                        {{ user.status.charAt(0).toUpperCase() + user.status.slice(1) }}
                                    </Badge>
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Button variant="outline" size="icon" class="h-8 w-8"
                                            @click="openEditDialog(user)">
                                            <Edit class="h-4 w-4" />
                                        </Button>
                                        <Button variant="outline" size="icon" class="h-8 w-8 text-red-500"
                                            @click="confirmDelete(user.id)">
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="filteredUsers.length === 0">
                                <TableCell colspan="7" class="text-center py-8 text-gray-500">
                                    No users found. Try a different search or add a new user.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </CardContent>
            <CardFooter>
                <div class="text-sm text-gray-500">
                    Showing {{ filteredUsers.length }} out of {{ props.users.length }} users
                </div>
            </CardFooter>
        </Card>

        <!-- Combined Create/Edit User Dialog -->
        <Dialog :open="showUserDialog" @update:open="showUserDialog = $event">
            <DialogContent class="max-w-md">
                <DialogHeader>
                    <DialogTitle>{{ isEditMode ? 'Edit User' : 'Add New User' }}</DialogTitle>
                </DialogHeader>
                <form @submit.prevent="submitForm">
                    <div class="grid gap-4 py-4">
                        <div class="grid gap-2">
                            <Label for="name">Full Name</Label>
                            <Input id="name" v-model="form.name" placeholder="Enter user's full name" required />
                            <div v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</div>
                        </div>
                        <div class="grid gap-2">
                            <Label for="email">Email Address</Label>
                            <Input id="email" type="email" v-model="form.email" placeholder="email@example.com"
                                required />
                            <div v-if="form.errors.email" class="text-sm text-red-500">{{ form.errors.email }}</div>
                        </div>
                        <div class="grid gap-2">
                            <Label for="phone">Phone Number</Label>
                            <Input id="phone" v-model="form.phone" placeholder="+256 7XX XXX XXX" required />
                            <div v-if="form.errors.phone" class="text-sm text-red-500">{{ form.errors.phone }}</div>
                        </div>
                        <div class="grid gap-2">
                            <Label for="role">Role</Label>
                            <select id="role" v-model="form.role"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                <option value="" disabled>Select user role</option>
                                <option value="admin">Administrator</option>
                                <option value="editor">Editor</option>
                            </select>
                            <div v-if="form.errors.role" class="text-sm text-red-500">{{ form.errors.role }}</div>
                        </div>

                        <div v-if="isEditMode" class="grid gap-2">
                            <Label for="status">Status</Label>
                            <select id="status" v-model="form.status"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div v-if="form.errors.status" class="text-sm text-red-500">{{ form.errors.status }}</div>
                        </div>
                    </div>
                    <DialogFooter>
                        <Button type="button" variant="outline" @click="showUserDialog = false">Cancel</Button>
                        <Button type="submit" :disabled="form.processing">{{ isEditMode ? 'Update User' : 'Save User'
                        }}</Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </AuthenticatedLayout>
</template>
