<script setup>
import { ref, onMounted, watch } from 'vue';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    placeholder: {
        type: String,
        default: 'Write your content here...'
    },
    lineSpacing: {
        type: String,
        default: 'normal', // 'tight', 'normal', 'relaxed'
    }
});

const emit = defineEmits(['update:modelValue']);

const editorRef = ref(null);
const quill = ref(null);

onMounted(() => {
    const toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],
        [{ 'header': 1 }, { 'header': 2 }],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        [{ 'script': 'sub' }, { 'script': 'super' }],
        [{ 'indent': '-1' }, { 'indent': '+1' }],
        [{ 'direction': 'rtl' }],
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'font': [] }],
        [{ 'align': [] }],
        ['clean'],
        ['link', 'image', 'video']
    ];

    quill.value = new Quill(editorRef.value, {
        modules: {
            toolbar: toolbarOptions
        },
        placeholder: props.placeholder,
        theme: 'snow'
    });

    // Set initial content
    if (props.modelValue) {
        quill.value.root.innerHTML = props.modelValue;
    }

    // Update v-model when content changes
    quill.value.on('text-change', () => {
        emit('update:modelValue', quill.value.root.innerHTML);
    });

    // Handle Enter key for custom line spacing
    quill.value.keyboard.addBinding({
        key: 'Enter'
    }, function(range, context) {
        // Default behavior - let Quill handle it normally
        return true;
    });
});

// Watch for external modelValue changes
watch(() => props.modelValue, (newValue) => {
    if (quill.value && newValue !== quill.value.root.innerHTML) {
        quill.value.root.innerHTML = newValue;
    }
});
</script>

<template>
    <div class="quill-editor" :class="`line-spacing-${lineSpacing}`">
        <div ref="editorRef" class="h-96"></div>
    </div>
</template>

<style>
.quill-editor {
    @apply border rounded-md;
}

.quill-editor .ql-toolbar {
    @apply border-b border-gray-200 bg-gray-50 rounded-t-md;
}

.quill-editor .ql-container {
    @apply rounded-b-md;
}

.quill-editor .ql-editor {
    @apply min-h-[400px] max-w-none;
    /* Remove prose class to avoid default paragraph spacing */
}

/* Custom paragraph spacing options */
.line-spacing-tight .ql-editor p {
    margin-bottom: 0.25rem !important;
    line-height: 1.4;
}

.line-spacing-normal .ql-editor p {
    margin-bottom: 0.5rem !important;
    line-height: 1.5;
}

.line-spacing-relaxed .ql-editor p {
    margin-bottom: 1rem !important;
    line-height: 1.6;
}

/* Default fallback */
.quill-editor .ql-editor p {
    margin-bottom: 0.25rem !important;
    margin-top: 0 !important;
    line-height: 1.2;
}

/* Override Quill's default paragraph margins */
.quill-editor .ql-editor p:first-child {
    margin-top: 0 !important;
}

.quill-editor .ql-editor p:last-child {
    margin-bottom: 0 !important;
}

/* Alternative: Use line breaks instead of paragraphs */
.quill-editor .ql-editor br {
    line-height: 1.2;
}

.quill-editor .ql-editor img {
    @apply max-w-full h-auto;
}

.quill-editor .ql-editor blockquote {
    @apply border-l-4 border-gray-300 pl-4 italic;
    margin: 0.5rem 0 !important;
}

.quill-editor .ql-editor pre {
    @apply bg-gray-100 p-4 rounded-md;
    margin: 0.5rem 0 !important;
}

.quill-editor .ql-editor code {
    @apply bg-gray-100 px-1 rounded;
}

/* Additional spacing controls */
.quill-editor .ql-editor h1,
.quill-editor .ql-editor h2,
.quill-editor .ql-editor h3,
.quill-editor .ql-editor h4,
.quill-editor .ql-editor h5,
.quill-editor .ql-editor h6 {
    margin-top: 1rem !important;
    margin-bottom: 0.5rem !important;
}

.quill-editor .ql-editor h1:first-child,
.quill-editor .ql-editor h2:first-child,
.quill-editor .ql-editor h3:first-child,
.quill-editor .ql-editor h4:first-child,
.quill-editor .ql-editor h5:first-child,
.quill-editor .ql-editor h6:first-child {
    margin-top: 0 !important;
}

.quill-editor .ql-editor ul,
.quill-editor .ql-editor ol {
    margin: 0.5rem 0 !important;
    padding-left: 1.5rem;
}

.quill-editor .ql-editor li {
    margin-bottom: 0.25rem !important;
}
</style>