<script setup>
import { onMounted, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Button } from '@/Components/ui/button';
import { Textarea } from "@/Components/ui/textarea";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Mail, Phone, MapPin, Send } from 'lucide-vue-next';


const form = useForm({
    name: '',
    email: '',
    phone: '',
    message: '',
    recaptcha_token: ''
});

const recaptchaLoaded = ref(false);

const onRecaptchaLoad = () => {
    recaptchaLoaded.value = true;
};

const onRecaptchaVerify = (token) => {
    form.recaptcha_token = token;
};

const submitForm = () => {
    form.post(route('contact.store'), {
        onSuccess: () => {
            form.reset();
            // Reset reCAPTCHA
            // if (window.grecaptcha) {
            //     window.grecaptcha.reset();
            // }
        },
    });
};
</script>

<template>

        <div class="max-w-7xl mx-auto py-32">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Contact Us</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Have questions or feedback? We'd love to hear from you. Fill out the form below and we'll get back
                    to
                    you as soon as possible.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Contact Information -->
                <div class="lg:col-span-1">
                    <Card>
                        <CardHeader>
                            <CardTitle>Get in Touch</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <Mail class="w-6 h-6 text-primary mt-1" />
                                <div>
                                    <h3 class="font-medium">Email</h3>
                                    <p class="text-gray-600">support@example.com</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <Phone class="w-6 h-6 text-primary mt-1" />
                                <div>
                                    <h3 class="font-medium">Phone</h3>
                                    <p class="text-gray-600">+1 (555) 123-4567</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <MapPin class="w-6 h-6 text-primary mt-1" />
                                <div>
                                    <h3 class="font-medium">Address</h3>
                                    <p class="text-gray-600">
                                        123 Business Street<br />
                                        Suite 100<br />
                                        City, State 12345
                                    </p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Contact Form -->
                <div class="lg:col-span-2">
                    <Card>
                        <CardHeader>
                            <CardTitle>Send us a Message</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <form @submit.prevent="submitForm" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <Label for="name">Full Name</Label>
                                        <Input id="name" v-model="form.name" type="text" required
                                            :class="{ 'border-red-500': form.errors.name }" />
                                        <div v-if="form.errors.name" class="text-sm text-red-500">
                                            {{ form.errors.name }}
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <Label for="email">Email Address</Label>
                                        <Input id="email" v-model="form.email" type="email" required
                                            :class="{ 'border-red-500': form.errors.email }" />
                                        <div v-if="form.errors.email" class="text-sm text-red-500">
                                            {{ form.errors.email }}
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <Label for="phone">Phone Number</Label>
                                    <Input id="phone" v-model="form.phone" type="tel"
                                        :class="{ 'border-red-500': form.errors.phone }" />
                                    <div v-if="form.errors.phone" class="text-sm text-red-500">
                                        {{ form.errors.phone }}
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <Label for="message">Message</Label>
                                    <Textarea id="message" v-model="form.message" rows="5" required
                                        :class="{ 'border-red-500': form.errors.message }" />
                                    <div v-if="form.errors.message" class="text-sm text-red-500">
                                        {{ form.errors.message }}
                                    </div>
                                </div>

                                <!-- Google reCAPTCHA -->
                                <!-- <div class="flex justify-center">
                                    <div v-if="recaptchaLoaded" class="g-recaptcha"
                                        data-sitekey="{{ config('services.recaptcha.site_key') }}"
                                        data-callback="onRecaptchaVerify"></div>
                                </div>
                                <div v-if="form.errors.recaptcha_token" class="text-sm text-red-500 text-center">
                                    {{ form.errors.recaptcha_token }}
                                </div> -->

                                <div class="flex justify-end">
                                    <Button type="submit" :disabled="form.processing" class="flex items-center gap-2">
                                        <Send class="w-4 h-4" />
                                        Send Message
                                    </Button>
                                </div>
                            </form>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>

</template>

<script>
// Add this to your layout or main app file
const loadRecaptcha = () => {
    const script = document.createElement('script');
    script.src = 'https://www.google.com/recaptcha/api.js';
    script.async = true;
    script.defer = true;
    script.onload = onRecaptchaLoad;
    document.head.appendChild(script);
};

// Call this when the component is mounted
onMounted(() => {
    loadRecaptcha();
});
</script>
