<script setup>
import { Head } from '@inertiajs/vue3'
import WebsiteLayout from '@/Layouts/WebsiteLayout.vue'
import { ref } from 'vue'

const copied = ref(false)
function copyEmail() {
    navigator.clipboard.writeText('contact@udcafrica.com')
        .then(() => {
            copied.value = true
            setTimeout(() => copied.value = false, 1500)
        })
}
</script>

<template>
    <WebsiteLayout>

        <Head title="We’re Hiring: YouTube Presenter | UDC Africa" />
        <main
            class="relative min-h-screen py-28 bg-gradient-to-br from-udc-light via-white to-yellow-50 overflow-hidden">
            <!-- Decorative background shapes -->
            <div class="absolute top-0 left-0 w-96 h-96 bg-udc-gold opacity-10 rounded-full blur-3xl -z-10"
                style="transform: translate(-30%,-30%)"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-udc-dark opacity-5 rounded-full blur-3xl -z-10"
                style="transform: translate(30%,30%)"></div>
            <div class="container mx-auto px-4 max-w-3xl">
                <div class="mb-10 text-center">
                    <span
                        class="inline-block bg-udc-gold text-udc-dark px-4 py-1 rounded-full text-xs font-semibold tracking-widest mb-4">We’re
                        Hiring</span>
                    <h1 class="text-4xl md:text-5xl font-light mb-4 tracking-tight text-udc-dark">YouTube Presenter</h1>
                    <div class="flex flex-wrap justify-center gap-4 text-gray-600 text-sm mb-2">
                        <span class="inline-flex items-center"><svg class="w-4 h-4 mr-1" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17 20h5v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2h5" />
                            </svg>Location: <span class="ml-1 font-medium">Office or Remote</span></span>
                        <span class="inline-flex items-center"><svg class="w-4 h-4 mr-1" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>Project-based</span>
                        <span class="inline-flex items-center"><svg class="w-4 h-4 mr-1" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 7v4a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7" />
                                <path d="M16 21v-4a4 4 0 0 0-8 0v4" />
                            </svg>Media & Communications</span>
                    </div>
                </div>
                <section class="mb-10">
                    <h2 class="text-2xl font-semibold text-udc-dark mb-2">About UDC Africa</h2>
                    <p class="text-base text-gray-700 leading-relaxed mb-4">
                        Universal Design and Construction Ltd (UDC Africa) is a forward-thinking, innovation-driven
                        company leading the charge in sustainable architecture, construction, and smart living solutions
                        across Rwanda and beyond. We are passionate about shaping environments that elevate quality of
                        life; and now we’re bringing that vision to life on-screen through powerful video content.
                    </p>
                </section>
                <section class="mb-10">
                    <h2 class="text-2xl font-semibold text-udc-dark mb-2">The Role: YouTube Presenter</h2>
                    <p class="text-base text-gray-700 leading-relaxed mb-4">
                        Are you a confident communicator with a passion for digital media, storytelling, and on-screen
                        presence? UDC Africa is looking for a dynamic and creative YouTube Presenter to be the face and
                        voice of our brand across YouTube and digital platforms. <br /> As our presenter, you’ll be
                        responsible
                        for hosting our video content, developing engaging storylines, and building a strong connection
                        with our online audience. This is more than just talking on camera; it’s about embodying our
                        construction brand, educating and entertaining our viewers, and helping to grow our online
                        community.
                    </p>
                </section>
                <section class="mb-10">
                    <h3 class="text-xl font-medium text-udc-dark mb-3">Key Responsibilities</h3>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700">
                        <li>You'll host and present video content for UDC Africa’s YouTube channel and other platforms,
                            becoming
                            the on-screen personality that connects with our audience.</li>
                        <li>You’ll join content planning and development sessions, where your input will help shape the
                            topics,
                            direction, and creative flow of upcoming videos. </li>
                        <li>You’ll be expected to write, review, and adapt scripts that reflect UDC Africa’s
                            voice—clear, professional,
                            and engaging. </li>
                        <li>You'll collaborate with the media and marketing teams to align video content with our
                            overall creative
                            direction and brand messaging. </li>
                        <li>You’ll conduct on-camera interviews, narrate content, and present both scripted and
                            spontaneous
                            material, depending on the format and production style. </li>
                        <li>Occasionally, you’ll assist with basic video editing and post-production, helping polish
                            content before it
                            goes live. </li>
                        <li>You’ll also manage the YouTube channel, which includes scheduling uploads, engaging with
                            viewers in
                            the comments, and monitoring performance analytics to help us grow. </li>
                    </ul>
                </section>
                <section class="mb-10">
                    <h3 class="text-xl font-medium text-udc-dark mb-3">What We’re Looking For</h3>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700">
                        <li>Confident public speaker with a natural camera presence.</li>
                        <li>Excellent communication and storytelling skills.</li>
                        <li>Experience in content creation, video production, or digital marketing.</li>
                        <li>Ability to write compelling and audience-focused scripts.</li>
                        <li>Familiarity with YouTube algorithms, SEO, and audience engagement strategies.</li>
                        <li>Knowledge of basic video editing software (e.g., Adobe Premiere Pro, After Effects, or
                            similar).</li>
                        <li>A good eye for visuals, pacing, and sound.</li>
                        <li>Organized, self-motivated, and able to meet deadlines.</li>
                    </ul>
                </section>
                <section class="mb-10">
                    <h3 class="text-xl font-medium text-udc-dark mb-3">What We Offer</h3>
                    <ul class="list-disc pl-6 space-y-2 text-gray-700">
                        <li>A chance to be the face of a bold, growing brand that’s transforming the design and
                            construction space across Rwanda and beyond.</li>
                        <li>A creative and collaborative environment where your ideas and input are valued and
                            encouraged.</li>
                        <li>A competitive salary and plenty of room for professional growth as the channel and brand
                            continue to expand.</li>
                        <li>Flexible work options, including remote or hybrid arrangements depending on your location
                            and preferences.</li>
                    </ul>
                </section>
                <section class="mb-10">
                    <h3 class="text-xl font-medium text-udc-dark mb-3">How to Apply</h3>
                    <p class="text-base text-gray-700 leading-relaxed mb-2">
                        Ready to bring your on-screen personality and creativity to UDC Africa?
                        <br />
                        Submit your <strong>CV</strong> and a brief
                        <strong>cover letter</strong> telling us
                        why you’re the perfect fit.
                        <br />
                        <span class="font-semibold">Note:</span> Videos and heavy designs should be shared as a
                        download/view link.
                    </p>
                    <div class="flex flex-col md:flex-row md:items-center gap-4 mt-4">
                        <a href="mailto:contact@udcafrica.com"
                            class="inline-block bg-udc-gold text-udc-dark font-semibold px-6 py-3 rounded shadow hover:bg-yellow-400 transition-colors">Send
                            Application</a>
                        <span class="text-gray-600 text-sm">📅 Deadline: August 10, 2025</span>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-gray-700 text-sm">Or email us at:</span>
                        <span
                            class="font-mono bg-gray-100 px-2 py-1 rounded text-udc-dark select-all text-sm">contact@udcafrica.com</span>
                        <button @click="copyEmail"
                            class="ml-2 px-2 py-1 text-xs bg-udc-gold text-udc-dark rounded hover:bg-yellow-400 transition-colors"
                            type="button">Copy</button>
                    </div>
                    <span v-if="copied" class="text-green-600 text-xs mt-1 block">Email copied!</span>
                </section>
            </div>
        </main>
    </WebsiteLayout>
</template>
