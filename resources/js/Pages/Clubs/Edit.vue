<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    club: Object,
});

const form = useForm({
    _method: 'PUT', // Need this for proper PUT request handling with file uploads
    name: props.club.name,
    description: props.club.description,
    logo: null, // Will be handled separately for upload
    is_active: props.club.is_active,
    existing_logo: props.club.logo, // Keep track of existing logo
});

function handleLogoChange(event) {
  form.logo = event.target.files[0];
}

const submit = () => {
    form.post(route('clubs.update', props.club.id), {
        forceFormData: true, // Important for file uploads
        // Reset logo field in form after submit if needed
        // onFinish: () => form.reset('logo'),
    });
};
</script>

<template>
    <Head title="Edit Club" />

    <AuthenticatedLayout>
        <template #header>
             <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit Club: {{ club.name }}</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-md sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <!-- Name -->
                            <div class="mb-4">
                                <InputLabel for="name" value="Club Name" />
                                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <InputLabel for="description" value="Description (Optional)" />
                                <TextArea id="description" class="mt-1 block w-full" v-model="form.description" rows="4" />
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>

                            <!-- Logo -->
                            <div class="mb-4">
                                <InputLabel for="logo" value="Update Logo (Optional)" />
                                <input id="logo" type="file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" @change="handleLogoChange" accept="image/*" />
                                <InputError class="mt-2" :message="form.errors.logo" />
                                <div v-if="form.existing_logo" class="mt-2">
                                    <p class="text-sm text-gray-500">Current Logo:</p>
                                    <img :src="'/storage/' + form.existing_logo" alt="Current Logo" class="mt-1 h-20 w-20 rounded-full object-cover">
                                </div>
                            </div>

                             <!-- Is Active -->
                            <div class="block mb-4">
                                <label class="flex items-center">
                                    <Checkbox name="is_active" v-model:checked="form.is_active" />
                                    <span class="ms-2 text-sm text-gray-600">Active</span>
                                </label>
                                 <InputError class="mt-2" :message="form.errors.is_active" />
                            </div>

                            <div class="mt-6 flex items-center justify-between">
                                <Link :href="route('clubs.index')" class="text-sm text-gray-600 underline hover:text-gray-900">
                                    Cancel
                                </Link>
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Update Club
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
