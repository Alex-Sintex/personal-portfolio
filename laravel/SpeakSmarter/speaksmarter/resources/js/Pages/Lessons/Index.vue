<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'

defineProps({
    lessons: {
        type: Object,
        required: true
    }
});

defineOptions({
    name: 'LessonsIndex'
});

const deleteLesson = (id) => {
    if (confirm('Are you sure?')) {
        router.delete(route('lessons.destroy', id));
    }
}
</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Lessons</h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between" v-if="$page.props.user.permissions.includes('create lessons')">
                        <Link :href="route('lessons.create')"
                            class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
                            v-if="$page.props.user.permissions.includes('create lessons')">
                        CREATE LESSON
                        </Link>
                    </div>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200"
                                v-for="lesson in lessons.data" :key="lesson.id">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ lesson.name }}
                                </th>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ lesson.description }}
                                </th>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <Link :href="route('lessons.edit', lesson.id)"
                                        v-if="$page.props.user.permissions.includes('update lessons')"
                                        class="px-6 py-4 font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    Edit</Link>
                                    <Link @click="deleteLesson(lesson.id)"
                                        v-if="$page.props.user.permissions.includes('delete lessons')"
                                        class="px-6 py-4 font-medium text-red-600 dark:text-red-500 hover:underline">
                                    Delete
                                    </Link>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-between mt-2"
                        v-if="$page.props.user.permissions.includes('create lessons')">
                        <Link v-if="lessons.current_page > 1"  :href="lessons.prev_page_url" class="py-2 px-4 rounded">
                        PREVIOUS
                        </Link>
                        <div v-else></div>
                        <Link v-if="lessons.current_page < lessons.last_page" :href="lessons.next_page_url" class="py-2 px-4 rounded">
                        NEXT
                        </Link>
                        <div v-else></div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
