<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { usePage, Link, Head, router } from '@inertiajs/vue3'
import { ArrowLeft, ArrowRight, ChevronLeft } from 'lucide-vue-next'
import ProjectGallery from '@/Components/Website/projects/ProjectGallery.vue'
import RelatedProjects from '@/Components/Website/projects/RelatedProjects.vue'
import WebsiteLayout from '@/Layouts/WebsiteLayout.vue'

// Props from Inertia
const props = defineProps({
    project: Object,
    prevProject: Object,
    nextProject: Object,
    relatedProjects: Array
})
const project = props.project.data;

const relatedProjects = props.relatedProjects;


const loading = ref(false)


onMounted(() => {
    if (!project) {
        router.visit('/404')
    }
})
</script>

<template>
    <WebsiteLayout>

        <Head :title="project?.title" />

        <main class="pb-20">
            <!-- Loading state -->
            <div v-if="loading || !project"
                class="container mx-auto px-4 py-24 flex justify-center items-center min-h-[60vh]">
                <div class="animate-pulse">
                    <div class="h-8 w-64 bg-gray-200 mb-8 rounded"></div>
                    <div class="h-96 w-full bg-gray-200 rounded"></div>
                </div>
            </div>

            <template v-else>
                <!-- Hero Section -->
                <div class="relative h-[70vh] bg-gray-900">
                    <div class="absolute inset-0">
                        <img :src="project.coverImage" :alt="project.title"
                            class="w-full h-full object-cover opacity-80" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    <div class="container mx-auto px-4 h-full flex flex-col justify-end pb-16 relative z-10">
                        <span class="text-white/80 mb-2">{{ project.category }}</span>
                        <h1 class="text-4xl md:text-6xl font-light text-white tracking-tight mb-4">
                            {{ project.title }}
                        </h1>
                        <div class="text-white/90">
                            <span class="inline-block mr-6">
                                <span class="opacity-70 mr-2">Location:</span> {{ project.location }}
                            </span>
                            <span class="inline-block mr-6">
                                <span class="opacity-70 mr-2">Year:</span> {{ project.year }}
                            </span>
                            <span class="inline-block">
                                <span class="opacity-70 mr-2">Size:</span> {{ project.size }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Back to projects -->
                <div class="container mx-auto px-4 pt-8">
                    <Link href="/projects"
                        class="inline-flex items-center text-gray-600 hover:text-black transition-colors">
                    <ChevronLeft :size="20" class="mr-1" />
                    Back to All Projects
                    </Link>
                </div>

                <!-- Project Content -->
                <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-12 gap-12 mt-12">
                    <div class="md:col-span-8">
                        <div class="prose prose-lg max-w-none mb-4 text-gray-700" v-html="project.content"></div>

                        <ProjectGallery :images="project.gallery || []" />
                    </div>

                    <div class="md:col-span-4">
                        <div class="sticky top-32">
                            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                                <h3 class="text-xl font-medium mb-4">Project Information</h3>
                                <dl class="space-y-4">
                                    <div>
                                        <dt class="text-gray-500">Client</dt>
                                        <dd class="font-medium">{{ project.client }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-500">Architect</dt>
                                        <dd class="font-medium">{{ project.architect }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-500">Location</dt>
                                        <dd class="font-medium">{{ project.location }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-500">Year</dt>
                                        <dd class="font-medium">{{ project.year }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-500">Size</dt>
                                        <dd class="font-medium">{{ project.size }}</dd>
                                    </div>
                                    <div v-if="project.awards">
                                        <dt class="text-gray-500">Awards</dt>
                                        <dd class="font-medium">{{ project.awards }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="flex justify-between items-center mt-12">
                                <template v-if="prevProject">
                                    <Link :href="`/projects/${prevProject.slug}`"
                                        class="flex items-center text-gray-700 hover:text-black transition-colors group">
                                    <ArrowLeft :size="20"
                                        class="mr-2 transform group-hover:-translate-x-1 transition-transform" />
                                    <span>Previous Project</span>
                                    </Link>
                                </template>
                                <template v-else>
                                    <div></div>
                                </template>

                                <template v-if="nextProject">
                                    <Link :href="`/projects/${nextProject.slug}`"
                                        class="flex items-center text-gray-700 hover:text-black transition-colors group ml-auto">
                                    <span>Next Project</span>
                                    <ArrowRight :size="20"
                                        class="ml-2 transform group-hover:translate-x-1 transition-transform" />
                                    </Link>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Projects -->
                <!-- <RelatedProjects :currentProjectId="project.id" :category="project.category" /> -->
            </template>
        </main>
    </WebsiteLayout>
</template>