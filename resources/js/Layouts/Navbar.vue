<script setup>
import { Button } from '@/Components/ui/button';
import { Avatar, AvatarFallback, AvatarImage } from '@/Components/ui/avatar';

import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu';
import {
    LogOut,
    User,
    ChevronDown
} from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const props = defineProps({
    user: Object,
    appName: String
});

</script>

<template>
    <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-10">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center lg:hidden ml-8 space-x-2">
                    <ApplicationLogo height="h-10" />
                </div>

                <div class="flex-1 flex items-center justify-end">
                    <div class="flex items-center space-x-4">

                        <!-- Profile Dropdown -->
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Button variant="ghost" class="flex items-center space-x-2">
                                    <Avatar class="h-8 w-8">
                                        <AvatarImage src="/placeholder-avatar.png" alt="User" />
                                        <AvatarFallback>
                                            {{ user?.name?.charAt(0) || 'U' }}
                                        </AvatarFallback>
                                    </Avatar>
                                    <div class="hidden md:flex flex-col items-start">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{
                                            user?.name || 'User'
                                        }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{
                                            user?.role_label }}</span>
                                    </div>

                                    <ChevronDown class="h-4 w-4" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuLabel>My Account</DropdownMenuLabel>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem>
                                    <Link :href="route('profile.edit')" class="flex w-full">
                                    <User class="mr-2 h-4 w-4" />
                                    Profile
                                    </Link>
                                </DropdownMenuItem>

                                <DropdownMenuSeparator />
                                <DropdownMenuItem>
                                    <Link :href="route('logout')" method="post" as="button"
                                        class="flex w-full text-red-600 dark:text-red-400">
                                    <LogOut class="mr-2 h-4 w-4" />
                                    Logout
                                    </Link>
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
