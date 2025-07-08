<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const submitMessage = ref('')

const form = useForm({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: ''
})

const subjects = [
    'General Inquiry',
    'Project Consultation',
    'Career Opportunities',
    'Media Inquiry',
    'Other'
]

const submitForm = () => {
    form.post(route('contact.store'), {
        preserveScroll: true,
        onSuccess: () => {
            submitMessage.value = 'Thank you for your message! We\'ll get back to you soon.'
            form.reset()
            setTimeout(() => {
                submitMessage.value = ''
            }, 5000)
        },
        onError: () => {
            submitMessage.value = 'An error occurred. Please try again.'
            setTimeout(() => {
                submitMessage.value = ''
            }, 5000)
        },
    })
}
</script>

<template>
    <form @submit.prevent="submitForm" class="space-y-6">
        <!-- Success Message -->
        <div v-if="submitMessage" class="bg-green-50 border border-green-200 text-green-800 p-4 mb-6">
            {{ submitMessage }}
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-udc-dark mb-1">
                Name *
            </label>
            <input
                v-model="form.name"
                type="text"
                id="name"
                name="name"
                class="w-full px-4 py-2 border border-udc-gold focus:outline-none focus:ring-2 focus:ring-udc-gold focus:border-transparent bg-udc-light text-udc-dark"
                :class="{ 'border-red-500': form.errors.name }"
                placeholder="Your name"
                required
            />
            <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-udc-dark mb-1">
                Email *
            </label>
            <input
                v-model="form.email"
                type="email"
                id="email"
                name="email"
                class="w-full px-4 py-2 border border-udc-gold focus:outline-none focus:ring-2 focus:ring-udc-gold focus:border-transparent bg-udc-light text-udc-dark"
                :class="{ 'border-red-500': form.errors.email }"
                placeholder="Your email address"
                required
            />
            <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-udc-dark mb-1">
                Phone
            </label>
            <input
                v-model="form.phone"
                type="tel"
                id="phone"
                name="phone"
                class="w-full px-4 py-2 border border-udc-gold focus:outline-none focus:ring-2 focus:ring-udc-gold focus:border-transparent bg-udc-light text-udc-dark"
                placeholder="Your phone number (optional)"
            />
        </div>

        <div>
            <label for="subject" class="block text-sm font-medium text-udc-dark mb-1">
                Subject
            </label>
            <select
                v-model="form.subject"
                id="subject"
                name="subject"
                class="w-full px-4 py-2 border border-udc-gold focus:outline-none focus:ring-2 focus:ring-udc-gold focus:border-transparent bg-udc-light text-udc-dark"
            >
                <option value="">Select a subject</option>
                <option v-for="subject in subjects" :key="subject" :value="subject">{{ subject }}</option>
            </select>
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-udc-dark mb-1">
                Message *
            </label>
            <textarea
                v-model="form.message"
                id="message"
                name="message"
                rows="5"
                class="w-full px-4 py-2 border border-udc-gold focus:outline-none focus:ring-2 focus:ring-udc-gold focus:border-transparent bg-udc-light text-udc-dark"
                :class="{ 'border-red-500': form.errors.message }"
                placeholder="Your message..."
                required
            ></textarea>
            <div v-if="form.errors.message" class="text-red-500 text-sm mt-1">{{ form.errors.message }}</div>
        </div>

        <button
            type="submit"
            :disabled="form.processing"
            class="bg-udc-gold text-udc-dark px-8 py-3 inline-block font-semibold rounded transition-colors"
            :class="{ 'opacity-70 cursor-not-allowed': form.processing, 'hover:bg-yellow-400': !form.processing }"
        >
            {{ form.processing ? 'Sending...' : 'Send Message' }}
        </button>
    </form>
</template>