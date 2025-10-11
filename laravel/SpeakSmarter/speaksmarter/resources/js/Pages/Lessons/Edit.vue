<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import LessonForm from '@/Components/Lessons/Form.vue';

defineOptions({
    name: 'LessonEdit',
});

const { lesson, categories, levels } = defineProps({
    lesson: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    levels: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: lesson.name,
    description: lesson.description,
    content_uri: lesson.content_uri,
    level_id: lesson.level_id,
    categories: lesson.categories
});
</script>

<template>
    <AppLayout title="Edit Lesson">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Edit Lesson</h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-x-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <LessonForm :form="form" :categories="categories" :levels="levels" :updating="true"
                                @submit="form.put(route('lessons.update', lesson.id))" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
