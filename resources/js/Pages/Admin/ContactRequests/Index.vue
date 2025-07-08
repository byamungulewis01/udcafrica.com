<script setup>
import { ref, watch } from 'vue';
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
import { Search, Download, Eye, Trash2, Mail, Phone, Calendar, Filter, ChevronLeft, ChevronRight } from 'lucide-vue-next';

const props = defineProps({
    contactRequests: Object,
    filters: Object
});

// Search and filter functionality
const searchQuery = ref(props.filters.search || '');
const statusFilter = ref(props.filters.status || 'all');
const dateFilter = ref(props.filters.date_filter || 'all');

// Debounce search
let searchTimeout = null;
const handleSearch = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        router.get(
            route('contact-requests.index'),
            { search: searchQuery.value, status: statusFilter.value, date_filter: dateFilter.value },
            { preserveState: true, preserveScroll: true }
        );
    }, 300);
};

// Watch for filter changes
watch([statusFilter, dateFilter], () => {
    router.get(
        route('contact-requests.index'),
        { search: searchQuery.value, status: statusFilter.value, date_filter: dateFilter.value },
        { preserveState: true, preserveScroll: true }
    );
});

// Status update form
const statusForm = useForm({
    status: ''
});

const updateStatus = (request, newStatus) => {
    statusForm.status = newStatus;
    statusForm.patch(route('contact-requests.status.update', request.id), {
        preserveScroll: true,
        onSuccess: () => {
            // Close dialog if open
            if (showRequestDialog.value) {
                showRequestDialog.value = false;
            }
        }
    });
};

// Export functionality
const exportToCSV = () => {
    const headers = ['First Name', 'Last Name', 'Email', 'Phone', 'Message', 'Status', 'Created At'];
    const csvContent = [
        headers.join(','),
        ...props.contactRequests.data.map(request => [
            request.firstName,
            request.lastName,
            request.email,
            request.phone,
            `"${request.message.replace(/"/g, '""')}"`,
            request.status,
            request.created_at
        ].join(','))
    ].join('\n');

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `contact-requests-${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
};

// View request details
const showRequestDialog = ref(false);
const selectedRequest = ref(null);

const openRequestDialog = (request) => {
    selectedRequest.value = request;
    showRequestDialog.value = true;
};

const confirmDelete = (requestId) => {
    if (confirm('Are you sure you want to delete this contact request?')) {
        useForm().delete(route('contact-requests.destroy', requestId), {
            preserveScroll: true
        });
    }
};

const getStatusColor = (status) => {
    switch (status) {
        case 'new':
            return 'bg-blue-100 text-blue-800';
        case 'in_progress':
            return 'bg-yellow-100 text-yellow-800';
        case 'completed':
            return 'bg-green-100 text-green-800';
        case 'spam':
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
    <Head title="Contact Requests" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader class="pb-3">
                <div class="flex justify-between items-center">
                    <div>
                        <CardTitle class="text-2xl">Contact Requests</CardTitle>
                        <CardDescription>Manage and respond to contact form submissions</CardDescription>
                    </div>
                    <Button @click="exportToCSV" variant="outline" class="flex items-center gap-2">
                        <Download class="w-4 h-4" />
                        Export CSV
                    </Button>
                </div>
            </CardHeader>
            <CardContent>
                <!-- Search and Filters -->
                <div class="space-y-4 mb-6">
                    <div class="flex gap-4">
                        <div class="relative flex-1">
                            <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                            <Input v-model="searchQuery" @input="handleSearch" placeholder="Search by name, email, or message..."
                                class="pl-10" />
                        </div>
                        <div class="flex items-center gap-2">
                            <Filter class="w-4 h-4 text-gray-500" />
                            <select v-model="statusFilter" class="flex h-10 w-40 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                                <option value="all">All Status</option>
                                <option value="new">New</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="spam">Spam</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-2">
                            <Calendar class="w-4 h-4 text-gray-500" />
                            <select v-model="dateFilter" class="flex h-10 w-40 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                                <option value="all">All Time</option>
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="last_week">Last 7 Days</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Contact Requests Table -->
                <div class="rounded-md border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Contact Info</TableHead>
                                <TableHead>Message</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead>Date</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="request in contactRequests.data" :key="request.id">
                                <TableCell class="font-medium">{{ request.firstName }} {{ request.lastName }}</TableCell>
                                <TableCell>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-1">
                                            <Mail class="w-4 h-4 text-gray-500" />
                                            <span class="text-sm">{{ request.email }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <Phone class="w-4 h-4 text-gray-500" />
                                            <span class="text-sm">{{ request.phone }}</span>
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="max-w-xs truncate">{{ request.message }}</div>
                                </TableCell>
                                <TableCell>
                                    <select v-model="request.status" @change="updateStatus(request, $event.target.value)"
                                        class="text-sm rounded-md border-0 bg-transparent focus:ring-0">
                                        <option value="new">New</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                        <option value="spam">Spam</option>
                                    </select>
                                </TableCell>
                                <TableCell>
                                    <div class="text-xs text-gray-400">{{ formatDate(request.created_at) }}</div>
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Button variant="outline" size="icon" class="h-8 w-8"
                                            @click="openRequestDialog(request)">
                                            <Eye class="h-4 w-4" />
                                        </Button>
                                        <Button variant="outline" size="icon" class="h-8 w-8 text-red-500"
                                            @click="confirmDelete(request.id)">
                                            <Trash2 class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="contactRequests.data.length === 0">
                                <TableCell colspan="6" class="text-center py-8 text-gray-500">
                                    No contact requests found. Try adjusting your filters.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>

                <!-- Pagination -->
                <div class="flex items-center justify-between mt-4">
                    <div class="text-sm text-gray-500">
                        Showing {{ contactRequests.from }} to {{ contactRequests.to }} of {{ contactRequests.total }} results
                    </div>
                    <div class="flex gap-2">
                        <Button v-for="link in contactRequests.links" :key="link.label"
                            :disabled="!link.url"
                            :class="{ 'opacity-50 cursor-not-allowed': !link.url }"
                            variant="outline"
                            size="sm"
                            @click="link.url && router.visit(link.url)"
                            v-html="link.label === '&laquo; Previous' ? '<ChevronLeft class=\'w-4 h-4\' />' : link.label === 'Next &raquo;' ? '<ChevronRight class=\'w-4 h-4\' />' : link.label">
                        </Button>
                    </div>
                </div>
            </CardContent>
        </Card>

        <!-- View Request Dialog -->
        <Dialog :open="showRequestDialog" @update:open="showRequestDialog = $event">
            <DialogContent class="max-w-2xl">
                <DialogHeader>
                    <DialogTitle>Contact Request Details</DialogTitle>
                </DialogHeader>
                <div v-if="selectedRequest" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <Label>Name</Label>
                            <div class="mt-1">{{ selectedRequest.name }}</div>
                        </div>
                        <div>
                            <Label>Email</Label>
                            <div class="mt-1">{{ selectedRequest.email }}</div>
                        </div>
                        <div>
                            <Label>Phone</Label>
                            <div class="mt-1">{{ selectedRequest.phone }}</div>
                        </div>
                        <div>
                            <Label>Status</Label>
                            <div class="mt-1">
                                <select v-model="selectedRequest.status" @change="updateStatus(selectedRequest, $event.target.value)"
                                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                                    <option value="new">New</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="spam">Spam</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <Label>Message</Label>
                        <div class="mt-1 p-4 bg-gray-50 rounded-md whitespace-pre-wrap">{{ selectedRequest.message }}</div>
                    </div>
                    <div>
                        <Label>Submitted</Label>
                        <div class="mt-1">{{ formatDate(selectedRequest.created_at) }}</div>
                    </div>
                </div>
                <DialogFooter>
                    <Button type="button" variant="outline" @click="showRequestDialog = false">Close</Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AuthenticatedLayout>
</template>
