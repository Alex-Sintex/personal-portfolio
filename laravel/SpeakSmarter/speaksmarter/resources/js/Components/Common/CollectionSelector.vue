<script setup>
import { ref } from 'vue';

defineProps({
    collection: {
        type: Array,
        required: true
    }
})

const currentSelection = ref(null)
const selection = ref([])
const emit = defineEmits(['onCategories'])

const handleAddToSelection = () => {
    if (!currentSelection.value) return;

    // Avoid duplicates by category ID
    const alreadyExists = selection.value.some(item => item.id === currentSelection.value.id);
    if (alreadyExists) return;

    selection.value.push(currentSelection.value); // Add selected item to selection

    // Emit only the IDs to the parent component
    emit('onCategories', selection.value.map(i => i.id));
}

const handleRemoveSelection = (id) => {
    // Remove the category by its ID
    selection.value = selection.value.filter(item => item.id !== id);

    // Emit the updated IDs to the parent component
    emit('onCategories', selection.value.map(i => i.id));
}
</script>

<template>
    <div class="w-full">
        <div class="flex">
            <select v-model="currentSelection"
                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option :value="null" disabled>Select a category</option>
                <option v-for="(item, index) in collection" :key="index" :value="item">
                    {{ item.name }}
                </option>
            </select>
            <button type="button" class="text-white bg-indigo-500 hover:bg-indigo-700 py-2 px-4 rounded ml-1"
                @click="handleAddToSelection">
                Add
            </button>
        </div>
        <div>
            <ul>
                <li v-for="(item) in selection" :key="item.id"
                    class="text-white bg-indigo-500 hover:bg-indigo-700 py-2 px-4 rounded ml-1 mt-1 mb-1 cursor-pointer"
                    @click="handleRemoveSelection(item.id)">
                    {{ item.name }}
                    <span class="float-right cursor-pointer">X</span>
                </li>
            </ul>
        </div>
    </div>
</template>
