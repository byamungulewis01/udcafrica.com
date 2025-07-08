<script setup>
import { ref, computed, onMounted } from 'vue';

import { Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
const props = defineProps({
    user: Object,
    appName: String
});
import {
    Sheet,
    SheetContent,
    SheetTrigger,
} from '@/Components/ui/sheet';

import {
    Menu,
    X,
    ChevronDown,
    ChevronRight,
    Users,
    Minus,
    Trophy,
    Medal,
    LayoutDashboard,
    BarChart,
    Newspaper,
    Settings,
    Briefcase,
    Package,
    Mail,
} from 'lucide-vue-next';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';


const isMobileMenuOpen = ref(false);

const expandedMenus = ref({});


onMounted(() => {
    initializeExpandedMenus();
});



const toggleSubMenu = (menuKey) => {
    expandedMenus.value[menuKey] = !expandedMenus.value[menuKey];
};

const closeMobileMenu = () => {
    isMobileMenuOpen.value = false;
};


// Define separate menu arrays for each role
const adminMenus = [
    {
        name: 'Dashboard',
        icon: LayoutDashboard, // More specific than Home
        route: 'dashboard'
    },
    {
        name: 'Users',
        icon: Users, // This one is fine
        route: 'users.index',
    },
    {
        name: 'Manage Articles',
        icon: Newspaper,
        route: 'blogs.index',
        children: [
            {
                name: 'Categories',
                route: 'blog-categories.index',
            },
            {
                name: 'Blogs',
                route: 'blogs.index',
            }
        ]
    },
    {
        name: 'Projects',
        icon: Briefcase,
        route: 'projects.index',
        children: [
            {
                name: 'Categories',
                route: 'project-categories.index',
            },
            {
                name: 'Projects',
                route: 'projects.index',
            }
        ]
    },
    {
        name: 'Teams',
        icon: Users,
        route: 'teams.index',
    },
    {
        name: 'News',
        icon: Newspaper,
        route: 'news.index',
    },
    {
        name: 'Services',
        icon: Package,
        route: 'services.index',
    },
    {
        name: 'Partnerships',
        icon: Users,
        route: 'partnerships.index',
    },
    {
        name: 'Contact Requests',
        icon: Mail,
        route: 'contact-requests.index',
    },
    {
        name: 'Settings',
        icon: Settings,
        route: 'settings.index',
    },
];


// Computed property to return the appropriate menu based on user role
const menuItems = computed(() => {
    switch (props.user.role) {
        case 'admin':
        case 'super_admin':
            return adminMenus;

        default:
            return []; // Empty array for unknown roles
    }
});

const initializeExpandedMenus = () => {
    menuItems.value.forEach(item => {
        if (item.children &&
            (item.children.some(child => route().current(child.route)) ||
                route().current(item.route))) {
            expandedMenus.value[item.name] = true;
        }
    });
};

initializeExpandedMenus();
</script>

<template>
    <Sheet :open="isMobileMenuOpen" @update:open="isMobileMenuOpen = $event">
        <SheetTrigger class="lg:hidden fixed z-50 top-4 left-4">
            <Button size="icon" variant="ghost">
                <Menu class="h-6 w-6" />
            </Button>
        </SheetTrigger>
        <SheetContent side="left" class="lg:hidden w-80 p-0 bg-white text-gray-800">
            <div class="flex flex-col h-full">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-2 py-2 ml-2">
                        <ApplicationLogo height="h-12" />
                    </div>
                    <Button size="icon" variant="ghost" @click="closeMobileMenu">
                        <X class="h-5 w-5" />
                    </Button>
                </div>

                <div class="flex flex-col space-y-1 overflow-y-auto">
                    <div v-for="item in menuItems" :key="item.name" class="px-3">
                        <div class="flex items-center">
                            <Link v-if="!item.children" :href="route(item.route)" :class="[
                                'flex items-center w-full px-3 py-2.5 text-sm rounded-md transition-colors',
                                route().current(item.route)
                                    ? 'bg-blue-100 font-medium text-blue-500'
                                    : 'hover:bg-blue-50'
                            ]" @click="closeMobileMenu">
                            <component :is="item.icon" class="mr-2 h-5 w-5" />
                            {{ item.name }}
                            </Link>

                            <Button v-else variant="ghost" :class="[
                                'flex items-center justify-between w-full px-3 py-2 text-sm font-medium rounded-md transition-colors',
                                item.children.some(child => route().current(child.route)) || route().current(item.route)
                                    ? 'bg-blue-100 font-medium text-blue-500'
                                    : 'hover:bg-blue-50'
                            ]" @click="toggleSubMenu(item.name)">
                                <div class="flex items-center">
                                    <component :is="item.icon" class="mr-2 h-5 w-5" />
                                    {{ item.name }}
                                </div>
                                <ChevronDown v-if="expandedMenus[item.name]" class="h-4 w-4" />
                                <ChevronRight v-else class="h-4 w-4" />
                            </Button>
                        </div>

                        <div v-if="item.children && expandedMenus[item.name]" class="ml-4 mt-1 space-y-1">
                            <Link v-for="child in item.children" :key="child.name"
                                :href="child.params ? route(child.route, child.params) : route(child.route)" :class="[
                                    'block px-3 py-2 text-sm rounded-md transition-colors',
                                    (child.params
                                        ? route().current(child.route, child.params)
                                        : route().current(child.route))
                                        ? 'bg-blue-100 font-medium text-blue-500'
                                        : 'hover:bg-blue-50'
                                ]" @click="closeMobileMenu">
                            <div class="flex items-center">
                                <Minus class="mr-1 h-3 w-3" />
                                {{ child.name }}
                            </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </SheetContent>
    </Sheet>

    <!-- Desktop Sidebar -->
    <div class="hidden lg:flex lg:w-72 lg:flex-col lg:fixed lg:inset-y-0 border">
        <div class="flex flex-col flex-grow bg-white text-gray-800">
            <div class="flex items-center space-x-2 px-4 py-4 ml-2">
                <ApplicationLogo height="h-12" />
            </div>
            <div class="flex-1 flex flex-col overflow-y-auto ">
                <nav class="flex-1 space-y-1">
                    <div class="flex flex-col space-y-1 overflow-y-auto">
                        <div v-for="item in menuItems" :key="item.name" class="px-3">
                            <div class="flex items-center">
                                <Link v-if="!item.children" :href="route(item.route)" :class="[
                                    'flex items-center w-full px-3 py-2.5 text-sm rounded-md transition-colors',
                                    route().current(item.route)
                                        ? 'bg-blue-100 font-medium text-blue-500'
                                        : 'hover:bg-blue-50'
                                ]" @click="closeMobileMenu">
                                <component :is="item.icon" class="mr-2 h-5 w-5" />
                                {{ item.name }}
                                </Link>

                                <Button v-else variant="ghost" :class="[
                                    'flex items-center justify-between w-full px-3 py-2 text-sm font-medium rounded-md transition-colors',
                                    item.children.some(child => route().current(child.route)) || route().current(item.route)
                                        ? 'bg-blue-100 font-medium text-blue-500'
                                        : 'hover:bg-blue-50'
                                ]" @click="toggleSubMenu(item.name)">
                                    <div class="flex items-center">
                                        <component :is="item.icon" class="mr-2 h-5 w-5" />
                                        {{ item.name }}
                                    </div>
                                    <ChevronDown v-if="expandedMenus[item.name]" class="h-4 w-4" />
                                    <ChevronRight v-else class="h-4 w-4" />
                                </Button>
                            </div>

                            <div v-if="item.children && expandedMenus[item.name]" class="ml-4 mt-1 space-y-1">
                                <Link v-for="child in item.children" :key="child.name"
                                    :href="child.params ? route(child.route, child.params) : route(child.route)" :class="[
                                        'block px-3 py-2 text-sm rounded-md transition-colors',
                                        (child.params
                                            ? route().current(child.route, child.params)
                                            : route().current(child.route))
                                            ? 'bg-blue-100 font-medium text-blue-500'
                                            : 'hover:bg-blue-50'
                                    ]" @click="closeMobileMenu">
                                <div class="flex items-center">
                                    <Minus class="mr-1 h-3 w-3" />
                                    {{ child.name }}
                                </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

</template>
