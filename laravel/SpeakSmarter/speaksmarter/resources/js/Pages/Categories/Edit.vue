<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import CategoryForm from '@/Components/Categories/Form.vue';

defineOptions({
    name: 'CategoryEdit',
});

const { category } = defineProps({
    category: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: category.name,
});
</script>

<template>
    <AppLayout title="Edit Category">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Edit Category</h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-x-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <CategoryForm :form="form" :updating="true"
                                @submit="form.put(route('categories.update', category.id))" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>