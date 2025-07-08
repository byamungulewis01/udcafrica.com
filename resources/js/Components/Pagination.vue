<script setup>
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { ChevronLeft, ChevronRight, ChevronsLeft, ChevronsRight } from 'lucide-vue-next';

const props = defineProps({
    links: {
        type: Object,
        required: true
    },
    // Additional props to preserve when navigating
    preserveParams: {
        type: Object,
        default: () => ({})
    },
    // Route name to use for navigation
    routeName: {
        type: String,
        required: true
    },
    // Loading state
    isLoading: {
        type: Boolean,
        default: false
    }
});

// Compute pagination information
const pagination = computed(() => {
    return {
        currentPage: props.links.current_page,
        lastPage: props.links.last_page,
        from: props.links.from,
        to: props.links.to,
        total: props.links.total
    };
});

// Generate visible page numbers
const visiblePageNumbers = computed(() => {
    const totalPages = pagination.value.lastPage;
    const currentPage = pagination.value.currentPage;
    const delta = 2; // Number of pages to show before and after current page

    const range = [];
    for (let i = Math.max(2, currentPage - delta); i <= Math.min(totalPages - 1, currentPage + delta); i++) {
        range.push(i);
    }

    // Always show first page
    const rangeWithFirstPage = totalPages > 1 ? [1] : [];

    // Add dots if there's a gap after first page
    if (currentPage - delta > 2) {
        rangeWithFirstPage.push("...");
    }

    // Add the range around current page
    rangeWithFirstPage.push(...range);

    // Add dots if there's a gap before last page
    if (currentPage + delta < totalPages - 1) {
        rangeWithFirstPage.push("...");
    }

    // Always show last page if there is more than one page
    if (totalPages > 1) {
        rangeWithFirstPage.push(totalPages);
    }

    return rangeWithFirstPage;
});

// Navigation function
const goToPage = (page) => {
    // Prevent navigation to invalid pages
    if (page < 1 || page > pagination.value.lastPage || page === pagination.value.currentPage) {
        return;
    }

    // Prepare parameters for the request
    const params = {
        ...props.preserveParams,
        page: page
    };

    // Remove empty values
    Object.keys(params).forEach(key => {
        if (!params[key]) delete params[key];
    });

    // Navigate to the page
    router.get(route(props.routeName), params, {
        preserveState: true
    });
};
</script>

<template>
    <div v-if="pagination.lastPage > 1" class="flex justify-end mt-6">
        <div class="flex items-center space-x-2">
            <!-- First Page Button -->
            <Button
                variant="outline"
                size="icon"
                class="h-8 w-8"
                :disabled="pagination.currentPage === 1 || isLoading"
                @click="goToPage(1)"
            >
                <ChevronsLeft class="h-4 w-4" />
            </Button>

            <!-- Previous Page Button -->
            <Button
                variant="outline"
                size="icon"
                class="h-8 w-8"
                :disabled="pagination.currentPage === 1 || isLoading"
                @click="goToPage(pagination.currentPage - 1)"
            >
                <ChevronLeft class="h-4 w-4" />
            </Button>

            <!-- Page Numbers -->
            <div class="flex items-center space-x-1">
                <template v-for="(page, index) in visiblePageNumbers" :key="index">
                    <Button
                        v-if="page !== '...'"
                        :variant="page === pagination.currentPage ? 'default' : 'outline'"
                        size="sm"
                        class="h-8 w-8"
                        :disabled="isLoading"
                        @click="goToPage(page)"
                    >
                        {{ page }}
                    </Button>
                    <span v-else class="px-2">...</span>
                </template>
            </div>

            <!-- Next Page Button -->
            <Button
                variant="outline"
                size="icon"
                class="h-8 w-8"
                :disabled="pagination.currentPage === pagination.lastPage || isLoading"
                @click="goToPage(pagination.currentPage + 1)"
            >
                <ChevronRight class="h-4 w-4" />
            </Button>

            <!-- Last Page Button -->
            <Button
                variant="outline"
                size="icon"
                class="h-8 w-8"
                :disabled="pagination.currentPage === pagination.lastPage || isLoading"
                @click="goToPage(pagination.lastPage)"
            >
                <ChevronsRight class="h-4 w-4" />
            </Button>
        </div>
    </div>
</template>
