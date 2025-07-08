<script setup>
import { ref } from 'vue';
import { Button } from '@/Components/ui/button';
import { ImageIcon, Upload, X } from 'lucide-vue-next';

const emit = defineEmits(['upload']);

const fileInput = ref(null);
const previewUrl = ref(null);
const isDragging = ref(false);

const handleFileSelect = (event) => {
    const file = event.target.files[0];
    if (file) {
        validateAndProcessFile(file);
    }
};

const handleDrop = (event) => {
    event.preventDefault();
    isDragging.value = false;

    const file = event.dataTransfer.files[0];
    if (file) {
        validateAndProcessFile(file);
    }
};

const validateAndProcessFile = (file) => {
    // Validate file type
    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!validTypes.includes(file.type)) {
        alert('Please upload a valid image file (JPEG, PNG, GIF, or WebP)');
        return;
    }

    // Validate file size (max 2MB)
    const maxSize = 2 * 1024 * 1024; // 2MB
    if (file.size > maxSize) {
        alert('Image size should not exceed 2MB');
        return;
    }

    // Create preview
    const reader = new FileReader();
    reader.onload = (e) => {
        previewUrl.value = e.target.result;
    };
    reader.readAsDataURL(file);

    // Emit the file
    emit('upload', file);
};

const removeImage = () => {
    previewUrl.value = null;
    if (fileInput.value) {
        fileInput.value.value = '';
    }
    emit('upload', null);
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
    <div class="w-full">
        <div
            class="relative border-2 border-dashed rounded-lg p-6 transition-colors"
            :class="[
                isDragging ? 'border-primary bg-primary/5' : 'border-gray-300',
                previewUrl ? 'border-none p-0' : ''
            ]"
            @dragover="handleDragOver"
            @dragleave="handleDragLeave"
            @drop="handleDrop"
        >
            <!-- Preview -->
            <div v-if="previewUrl" class="relative group">
                <img
                    :src="previewUrl"
                    alt="Preview"
                    class="w-full h-48 object-cover rounded-lg"
                />
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                    <Button
                        type="button"
                        variant="destructive"
                        size="icon"
                        class="h-8 w-8"
                        @click="removeImage"
                    >
                        <X class="h-4 w-4" />
                    </Button>
                </div>
            </div>

            <!-- Upload Area -->
            <div v-else class="text-center">
                <input
                    ref="fileInput"
                    type="file"
                    accept="image/*"
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
                        PNG, JPG, GIF or WebP (max. 2MB)
                    </p>
                    <Button
                        type="button"
                        variant="outline"
                        class="mt-2"
                        @click="fileInput.click()"
                    >
                        <Upload class="h-4 w-4 mr-2" />
                        Select Image
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>
