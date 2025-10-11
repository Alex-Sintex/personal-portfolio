<script setup>
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import CollectionSelector from '../Common/CollectionSelector.vue';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const redirectToLessonIndex = () => {
    Inertia.visit(route('lessons.index'));
}

defineProps({
    form: { type: Object, required: true },          // useForm object from parent
    updating: { type: Boolean, required: false, default: false },
    categories: { type: Array, required: true },     // expect arrays
    levels: { type: Array, required: true }
});

defineOptions({ name: 'LessonForm' });

// emit 'submit' to parent
const emit = defineEmits(['submit']);

// when CollectionSelector emits selected categories (array of objects),
const categoriesSelected = ref([]);

const onCategories = (_categories) => {
    categoriesSelected.value = _categories; // reactive array of selected category objects
}
</script>

<template>
    <!-- Re-emit submit so parent handles sending -->
    <FormSection @submitted="$emit('submit')">
        <template #title>
            {{ updating ? 'Update Lesson' : 'Create Lesson' }}
        </template>

        <template #description>
            {{ updating ? 'Update The Selected Lesson' : 'Create a New Lesson from Scratch' }}
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="name" value="Name" />
                <TextInput v-model="form.name" id="name" type="text" autocomplete="name" class="mt-1 block w-full" />
                <InputError :message="$page.props.errors.name" class="mt-2" />

                <br />
                <InputLabel for="description" value="Description" />
                <TextInput v-model="form.description" id="description" type="text" class="mt-1 block w-full" />
                <InputError :message="$page.props.errors.description" class="mt-2" />

                <br />
                <InputLabel for="content_uri" value="Content URI" />
                <TextInput v-model="form.content_uri" id="content_uri" type="text" class="mt-1 block w-full" />
                <InputError :message="$page.props.errors.content_uri" class="mt-2" />

                <br />
                <InputLabel value="PDF" />
                <SecondaryButton class="mt-2 mr-2" type="button">Upload PDF</SecondaryButton>
                <InputError :message="$page.props.errors.pdf_uri" class="mt-2" />

                <br />
                <div class="w-full mt-5">
                    <div class="flex">
                        <div class="w-1/2 mr-1">
                            <InputLabel for="level_id" value="Level" class="mt-4" />
                            <!-- IMPORTANT: bind the selected value into form.level_id -->
                            <select v-model="form.level_id" id="level_id" name="level_id"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option disabled value="">Select a level</option>
                                <option v-for="level in levels" :key="level.id" :value="level.id">
                                    {{ level.name }}
                                </option>
                            </select>
                            <InputError :message="$page.props.errors.level_id" class="mt-2" />
                        </div>

                        <div class="w-1/2 ml-1">
                            <InputLabel for="categories" value="Categories" class="mt-4" />
                            <CollectionSelector name="categories" id="categories" :collection="categories"
                                @onCategories="onCategories" />
                            <InputError :message="$page.props.errors.categories" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
            <div class="flex justify-between w-full">
                <button type="button" @click="redirectToLessonIndex"
                    class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                    Cancelar
                </button>

                <PrimaryButton>
                    {{ updating ? 'Update' : 'Create' }}
                </PrimaryButton>
            </div>
        </template>
    </FormSection>
</template>