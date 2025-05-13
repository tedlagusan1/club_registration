<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue'; // Added for description
import Checkbox from '@/Components/Checkbox.vue'; // Added for is_active
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    description: '',
    logo: null,
    is_active: true, // Default to active
});

function handleLogoChange(event) {
  form.logo = event.target.files[0];
}

const submit = () => {
    form.post(route('clubs.store'), {
        forceFormData: true, // Needed for file upload
        // No need to reset logo here as we navigate away
    });
};
</script>

<template>
    <Head title="Add New Club" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Add New Club</h2>
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
                                <InputLabel for="logo" value="Logo (Optional)" />
                                <input id="logo" type="file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" @change="handleLogoChange" accept="image/*" />
                                <InputError class="mt-2" :message="form.errors.logo" />
                            </div>

                            <!-- Is Active -->
                            <div class="block mb-4">
                                <label class="flex items-center">
                                    <Checkbox name="is_active" v-model:checked="form.is_active" />
                                    <span class="ms-2 text-sm text-gray-600">Active</span>
                                </label>
                                 <InputError class="mt-2" :message="form.errors.is_active" />
                            </div>

                            <div class="mt-6 flex justify-end">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Create Club
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
