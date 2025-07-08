<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Button } from '@/Components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/Components/ui/tabs";

const props = defineProps({
    settings: Object,
});

const activeTab = ref('site');

const siteForm = useForm({
    site_title: props.settings.site.site_title || '',
    site_description: props.settings.site.site_description || '',
    logo: null,
    favicon: null,
});

const emailForm = useForm({
    smtp_host: props.settings.email.smtp_host || '',
    smtp_port: props.settings.email.smtp_port || '',
    smtp_username: props.settings.email.smtp_username || '',
    smtp_password: props.settings.email.smtp_password || '',
    smtp_encryption: props.settings.email.smtp_encryption || 'tls',
    mail_from_address: props.settings.email.mail_from_address || '',
    mail_from_name: props.settings.email.mail_from_name || '',
});

const localizationForm = useForm({
    timezone: props.settings.localization.timezone || '',
    language: props.settings.localization.language || 'en',
    date_format: props.settings.localization.date_format || 'Y-m-d',
    time_format: props.settings.localization.time_format || 'H:i',
});

const timezones = ref([]);

const handleLogoUpload = (event) => {
    siteForm.logo = event.target.files[0];
};

const handleFaviconUpload = (event) => {
    siteForm.favicon = event.target.files[0];
};

const submitSiteSettings = () => {
    siteForm.post(route('settings.site.update'), {
        preserveScroll: true,
        onSuccess: () => {
            // Handle success
        },
    });
};

const submitEmailSettings = () => {
    emailForm.post(route('settings.email.update'), {
        preserveScroll: true,
        onSuccess: () => {
            // Handle success
        },
    });
};

const submitLocalizationSettings = () => {
    localizationForm.post(route('settings.localization.update'), {
        preserveScroll: true,
        onSuccess: () => {
            // Handle success
        },
    });
};

onMounted(() => {
    timezones.value = Intl.supportedValuesOf('timeZone');
});
</script>

<template>
    <Head title="Settings" />

    <AuthenticatedLayout>
        <Card>
            <CardHeader>
                <CardTitle class="text-2xl">Settings</CardTitle>
                <CardDescription>Manage your application settings</CardDescription>
            </CardHeader>

            <CardContent>
                <Tabs v-model="activeTab" class="w-full">
                    <TabsList class="grid w-full grid-cols-3">
                        <TabsTrigger value="site">Site Settings</TabsTrigger>
                        <TabsTrigger value="email">Email Settings</TabsTrigger>
                        <TabsTrigger value="localization">Localization</TabsTrigger>
                    </TabsList>

                    <!-- Site Settings -->
                    <TabsContent value="site">
                        <form @submit.prevent="submitSiteSettings" class="space-y-6">
                            <div class="grid gap-4">
                                <div class="grid gap-2">
                                    <Label for="site_title">Site Title</Label>
                                    <Input id="site_title" v-model="siteForm.site_title" />
                                    <div v-if="siteForm.errors.site_title" class="text-sm text-red-500">
                                        {{ siteForm.errors.site_title }}
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="site_description">Site Description</Label>
                                    <Input id="site_description" v-model="siteForm.site_description" />
                                    <div v-if="siteForm.errors.site_description" class="text-sm text-red-500">
                                        {{ siteForm.errors.site_description }}
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="logo">Logo</Label>
                                    <Input type="file" id="logo" @change="handleLogoUpload" accept="image/*" />
                                    <img v-if="settings.site.logo" :src="settings.site.logo" alt="Site Logo"
                                        class="mt-2 h-20 w-auto" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="favicon">Favicon</Label>
                                    <Input type="file" id="favicon" @change="handleFaviconUpload"
                                        accept="image/x-icon,image/png" />
                                    <img v-if="settings.site.favicon" :src="settings.site.favicon" alt="Favicon"
                                        class="mt-2 h-8 w-8" />
                                </div>
                            </div>

                            <Button type="submit" :disabled="siteForm.processing">Save Changes</Button>
                        </form>
                    </TabsContent>

                    <!-- Email Settings -->
                    <TabsContent value="email">
                        <form @submit.prevent="submitEmailSettings" class="space-y-6">
                            <div class="grid gap-4">
                                <div class="grid gap-2">
                                    <Label for="smtp_host">SMTP Host</Label>
                                    <Input id="smtp_host" v-model="emailForm.smtp_host" />
                                    <div v-if="emailForm.errors.smtp_host" class="text-sm text-red-500">
                                        {{ emailForm.errors.smtp_host }}
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="smtp_port">SMTP Port</Label>
                                    <Input id="smtp_port" type="number" v-model="emailForm.smtp_port" />
                                    <div v-if="emailForm.errors.smtp_port" class="text-sm text-red-500">
                                        {{ emailForm.errors.smtp_port }}
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="smtp_username">SMTP Username</Label>
                                    <Input id="smtp_username" v-model="emailForm.smtp_username" />
                                    <div v-if="emailForm.errors.smtp_username" class="text-sm text-red-500">
                                        {{ emailForm.errors.smtp_username }}
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="smtp_password">SMTP Password</Label>
                                    <Input id="smtp_password" type="password" v-model="emailForm.smtp_password" />
                                    <div v-if="emailForm.errors.smtp_password" class="text-sm text-red-500">
                                        {{ emailForm.errors.smtp_password }}
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="smtp_encryption">SMTP Encryption</Label>
                                    <select id="smtp_encryption" v-model="emailForm.smtp_encryption"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                        <option value="tls">TLS</option>
                                        <option value="ssl">SSL</option>
                                    </select>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="mail_from_address">From Address</Label>
                                    <Input id="mail_from_address" type="email" v-model="emailForm.mail_from_address" />
                                    <div v-if="emailForm.errors.mail_from_address" class="text-sm text-red-500">
                                        {{ emailForm.errors.mail_from_address }}
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="mail_from_name">From Name</Label>
                                    <Input id="mail_from_name" v-model="emailForm.mail_from_name" />
                                    <div v-if="emailForm.errors.mail_from_name" class="text-sm text-red-500">
                                        {{ emailForm.errors.mail_from_name }}
                                    </div>
                                </div>
                            </div>

                            <Button type="submit" :disabled="emailForm.processing">Save Changes</Button>
                        </form>
                    </TabsContent>

                    <!-- Localization Settings -->
                    <TabsContent value="localization">
                        <form @submit.prevent="submitLocalizationSettings" class="space-y-6">
                            <div class="grid gap-4">
                                <div class="grid gap-2">
                                    <Label for="timezone">Timezone</Label>
                                    <select id="timezone" v-model="localizationForm.timezone"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                        <option v-for="tz in timezones" :key="tz" :value="tz">{{ tz }}</option>
                                    </select>
                                    <div v-if="localizationForm.errors.timezone" class="text-sm text-red-500">
                                        {{ localizationForm.errors.timezone }}
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="language">Language</Label>
                                    <select id="language" v-model="localizationForm.language"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                        <option value="en">English</option>
                                        <option value="es">Spanish</option>
                                        <option value="fr">French</option>
                                    </select>
                                    <div v-if="localizationForm.errors.language" class="text-sm text-red-500">
                                        {{ localizationForm.errors.language }}
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="date_format">Date Format</Label>
                                    <select id="date_format" v-model="localizationForm.date_format"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                        <option value="Y-m-d">YYYY-MM-DD</option>
                                        <option value="d/m/Y">DD/MM/YYYY</option>
                                        <option value="m/d/Y">MM/DD/YYYY</option>
                                    </select>
                                    <div v-if="localizationForm.errors.date_format" class="text-sm text-red-500">
                                        {{ localizationForm.errors.date_format }}
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="time_format">Time Format</Label>
                                    <select id="time_format" v-model="localizationForm.time_format"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                        <option value="H:i">24-hour</option>
                                        <option value="h:i A">12-hour</option>
                                    </select>
                                    <div v-if="localizationForm.errors.time_format" class="text-sm text-red-500">
                                        {{ localizationForm.errors.time_format }}
                                    </div>
                                </div>
                            </div>

                            <Button type="submit" :disabled="localizationForm.processing">Save Changes</Button>
                        </form>
                    </TabsContent>
                </Tabs>
            </CardContent>
        </Card>
    </AuthenticatedLayout>
</template>
