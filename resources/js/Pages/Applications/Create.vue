<template>
    <Head title="Apply to Club" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Apply to a Club</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-md sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <!-- Club Selection -->
                            <div class="mb-4">
                                <InputLabel for="club_id" value="Select Club" />
                                <select
                                    id="club_id"
                                    v-model="form.club_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                                    <option :value="null" disabled>-- Select a Club --</option>
                                    <option v-for="club in clubs" :key="club.id" :value="club.id">
                                        {{ club.name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.club_id" />
                            </div>

                            <!-- Reason for Applying (Optional) -->
                            <div class="mb-4">
                                <InputLabel for="reason" value="Reason for Applying (Optional)" />
                                <TextArea
                                    id="reason"
                                    class="mt-1 block w-full"
                                    v-model="form.reason"
                                    rows="4"
                                />
                                <InputError class="mt-2" :message="form.errors.reason" />
                            </div>

                            <div class="mt-6 flex justify-end">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Submit Application
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    clubs: Array,
});

const form = useForm({
    club_id: null,
    reason: '',
});

const submit = () => {
    form.post(route('applications.store'));
};
</script>
