<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Application Details
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium mb-4">Application Information</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Club</label>
                                        <p class="mt-1 text-gray-900">{{ application.club.name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <span
                                            :class="{
                                                'bg-yellow-100 text-yellow-800': application.status === 'pending',
                                                'bg-green-100 text-green-800': application.status === 'approved',
                                                'bg-red-100 text-red-800': application.status === 'rejected',
                                            }"
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                        >
                                            {{ application.status }}
                                        </span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Applied At</label>
                                        <p class="mt-1 text-gray-900">
                                            {{ new Date(application.created_at).toLocaleDateString() }}
                                        </p>
                                    </div>
                                    <div v-if="application.approved_at">
                                        <label class="block text-sm font-medium text-gray-700">Approved At</label>
                                        <p class="mt-1 text-gray-900">
                                            {{ new Date(application.approved_at).toLocaleDateString() }}
                                        </p>
                                    </div>
                                    <div v-if="application.approver">
                                        <label class="block text-sm font-medium text-gray-700">Approved By</label>
                                        <p class="mt-1 text-gray-900">{{ application.approver.name }}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium mb-4">Applicant Information</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Name</label>
                                        <p class="mt-1 text-gray-900">{{ application.user.name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Student ID</label>
                                        <p class="mt-1 text-gray-900">{{ application.user.student_id }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Course</label>
                                        <p class="mt-1 text-gray-900">{{ application.user.course }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Year Level</label>
                                        <p class="mt-1 text-gray-900">{{ application.user.year_level }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Reason for Joining</label>
                                        <p class="mt-1 text-gray-900">{{ application.reason }}</p>
                                    </div>
                                </div>

                                <div v-if="$page.props.auth.user.is_admin && application.status === 'pending'" class="mt-6">
                                    <h3 class="text-lg font-medium mb-4">Admin Actions</h3>
                                    <div class="flex space-x-4">
                                        <button
                                            @click="updateStatus('approved')"
                                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                        >
                                            Approve
                                        </button>
                                        <button
                                            @click="updateStatus('rejected')"
                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                        >
                                            Reject
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    application: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    status: '',
});

const updateStatus = (status) => {
    form.status = status;
    form.put(route('applications.update', props.application.id));
};
</script>
