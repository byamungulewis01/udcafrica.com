<script setup>
import { ref, computed, watch } from 'vue';
import { Input } from "@/Components/ui/input";
import { Button } from '@/Components/ui/button';
import { X, Check, ChevronDown } from 'lucide-vue-next';
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
} from "@/Components/ui/command";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/Components/ui/popover";

const props = defineProps({
    options: {
        type: Array,
        required: true
    },
    selected: {
        type: Array,
        default: () => []
    },
    placeholder: {
        type: String,
        default: 'Select items...'
    }
});

const emit = defineEmits(['update']);

const open = ref(false);
const searchQuery = ref('');

const selectedItems = ref(props.selected);

// Watch for external selected prop changes
watch(() => props.selected, (newValue) => {
    selectedItems.value = newValue;
});

const filteredOptions = computed(() => {
    if (!searchQuery.value) return props.options;
    return props.options.filter(option =>
        option.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const toggleOption = (option) => {
    const index = selectedItems.value.findIndex(item => item.id === option.id);
    if (index === -1) {
        selectedItems.value = [...selectedItems.value, option];
    } else {
        selectedItems.value = selectedItems.value.filter(item => item.id !== option.id);
    }
    emit('update', selectedItems.value);
};

const removeOption = (option) => {
    selectedItems.value = selectedItems.value.filter(item => item.id !== option.id);
    emit('update', selectedItems.value);
};

const isSelected = (option) => {
    return selectedItems.value.some(item => item.id === option.id);
};
</script>

<template>
    <div class="relative">
        <Popover v-model:open="open">
            <PopoverTrigger as-child>
                <Button
                    variant="outline"
                    role="combobox"
                    :aria-expanded="open"
                    class="w-full justify-between"
                >
                    <div class="flex flex-wrap gap-1">
                        <template v-if="selectedItems.length > 0">
                            <div
                                v-for="item in selectedItems"
                                :key="item.id"
                                class="flex items-center gap-1 bg-primary/10 text-primary px-2 py-1 rounded-md text-sm"
                            >
                                {{ item.name }}
                                <Button
                                    type="button"
                                    variant="ghost"
                                    size="icon"
                                    class="h-4 w-4 hover:bg-primary/20"
                                    @click.stop="removeOption(item)"
                                >
                                    <X class="h-3 w-3" />
                                </Button>
                            </div>
                        </template>
                        <span v-else class="text-muted-foreground">{{ placeholder }}</span>
                    </div>
                    <ChevronDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                </Button>
            </PopoverTrigger>
            <PopoverContent class="w-full p-0">
                <Command>
                    <CommandInput
                        v-model="searchQuery"
                        :placeholder="placeholder"
                        class="h-9"
                    />
                    <CommandList>
                        <CommandEmpty>No results found.</CommandEmpty>
                        <CommandGroup>
                            <CommandItem
                                v-for="option in filteredOptions"
                                :key="option.id"
                                :value="option"
                                @select="toggleOption(option)"
                            >
                                <div class="flex items-center justify-between w-full">
                                    <span>{{ option.name }}</span>
                                    <Check
                                        v-if="isSelected(option)"
                                        class="h-4 w-4 text-primary"
                                    />
                                </div>
                            </CommandItem>
                        </CommandGroup>
                    </CommandList>
                </Command>
            </PopoverContent>
        </Popover>
    </div>
</template>

<style scoped>
.command-list {
    max-height: 200px;
    overflow-y: auto;
}
</style>
