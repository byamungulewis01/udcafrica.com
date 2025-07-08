<script setup>
import { ref } from 'vue';
import { Button } from '@/Components/ui/button';
import { ImageIcon, Upload, X, Plus } from 'lucide-vue-next';

const emit = defineEmits(['upload']);

const fileInput = ref(null);
const previewUrls = ref([]);
const selectedFiles = ref([]);
const isDragging = ref(false);

const handleFileSelect = (event) => {
    const files = Array.from(event.target.files);
    if (files.length > 0) {
        processFiles(files);
    }
};

const handleDrop = (event) => {
    event.preventDefault();
    isDragging.value = false;

    const files = Array.from(event.dataTransfer.files);
    if (files.length > 0) {
        processFiles(files);
    }
};

const processFiles = (files) => {
    const validFiles = [];
    const validPreviews = [];

    files.forEach(file => {
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert(`${file.name} is not a valid image file (JPEG, PNG, GIF, or WebP)`);
            return;
        }

        // Validate file size (max 2MB)
        const maxSize = 2 * 1024 * 1024; // 2MB
        if (file.size > maxSize) {
            alert(`${file.name} size should not exceed 2MB`);
            return;
        }

        validFiles.push(file);

        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
            validPreviews.push(e.target.result);

            // Update arrays when all files are processed
            if (validPreviews.length === validFiles.length) {
                selectedFiles.value = [...selectedFiles.value, ...validFiles];
                previewUrls.value = [...previewUrls.value, ...validPreviews];
                emit('upload', selectedFiles.value);
            }
        };
        reader.readAsDataURL(file);
    });
};

const removeImage = (index) => {
    selectedFiles.value.splice(index, 1);
    previewUrls.value.splice(index, 1);

    // Reset file input
    if (fileInput.value) {
        fileInput.value.value = '';
    }

    emit('upload', selectedFiles.value);
};

const clearAll = () => {
    selectedFiles.value = [];
    previewUrls.value = [];

    if (fileInput.value) {
        fileInput.value.value = '';
    }

    emit('upload', []);
};

const handleDragOver = (event) => {
    event.preventDefault();
    isDragging.value = true;
};

const handleDragLeave = () => {
    isDragging.value = false;
};
</script>

<template>
    <div class="w-full space-y-4">
        <!-- Upload Area -->
        <div
            class="relative border-2 border-dashed rounded-lg p-6 transition-colors"
            :class="[
                isDragging ? 'border-primary bg-primary/5' : 'border-gray-300'
            ]"
            @dragover="handleDragOver"
            @dragleave="handleDragLeave"
            @drop="handleDrop"
        >
            <div class="text-center">
                <input
                    ref="fileInput"
                    type="file"
                    accept="image/*"
                    multiple
                    class="hidden"
                    @change="handleFileSelect"
                />
                <div class="flex flex-col items-center justify-center gap-2">
                    <div class="rounded-full bg-gray-100 p-3">
                        <ImageIcon class="h-6 w-6 text-gray-500" />
                    </div>
                    <div class="text-sm text-gray-500">
                        <span class="font-medium text-primary">Click to upload</span> or drag and drop
                    </div>
                    <p class="text-xs text-gray-400">
                        PNG, JPG, GIF or WebP (max. 2MB each)
                    </p>
                    <Button
                        type="button"
                        variant="outline"
                        class="mt-2"
                        @click="fileInput.click()"
                    >
                        <Upload class="h-4 w-4 mr-2" />
                        Select Images
                    </Button>
                </div>
            </div>
        </div>

        <!-- Gallery Preview -->
        <div v-if="previewUrls.length > 0" class="space-y-4">
            <div class="flex items-center justify-between">
                <h4 class="text-sm font-medium text-gray-700">
                    Selected Images ({{ previewUrls.length }})
                </h4>
                <Button
                    type="button"
                    variant="outline"
                    size="sm"
                    @click="clearAll"
                    class="text-red-600 hover:text-red-700 hover:bg-red-50"
                >
                    Clear All
                </Button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div
                    v-for="(preview, index) in previewUrls"
                    :key="index"
                    class="relative group aspect-square"
                >
                    <img
                        :src="preview"
                        :alt="`Preview ${index + 1}`"
                        class="w-full h-full object-cover rounded-lg border"
                    />
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                        <Button
                            type="button"
                            variant="destructive"
                            size="icon"
                            class="h-8 w-8"
                            @click="removeImage(index)"
                        >
                            <X class="h-4 w-4" />
                        </Button>
                    </div>
                    <div class="absolute top-2 left-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                        {{ index + 1 }}
                    </div>
                </div>

                <!-- Add More Button -->
                <div
                    class="aspect-square border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center cursor-pointer hover:border-primary hover:bg-primary/5 transition-colors"
                    @click="fileInput.click()"
                >
                    <div class="text-center">
                        <Plus class="h-6 w-6 text-gray-400 mx-auto mb-2" />
                        <span class="text-xs text-gray-500">Add More</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>