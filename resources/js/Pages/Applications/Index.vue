<template>
    <Head :title="userRole === 'admin' ? 'Manage Applications' : 'My Applications'" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                 <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ userRole === 'admin' ? 'Manage Club Applications' : 'My Club Applications' }}
                 </h2>
                 <Link v-if="userRole !== 'admin'" :href="route('applications.create')" class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900">
                    Apply to Club
                 </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-if="applications.length > 0">
                             <!-- Use a table for better layout, especially for admins -->
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th v-if="userRole === 'admin'" scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Applicant</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Club</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Applied</th>
                                        <th v-if="userRole === 'admin'" scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="application in applications" :key="application.id">
                                        <td v-if="userRole === 'admin'" class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ application.user.name }}</div>
                                            <div class="text-sm text-gray-500">{{ application.user.email }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ application.club.name }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5" :class="statusClass(application.status)">
                                                {{ application.status }}
                                            </span>
                                        </td>
                                         <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            {{ new Date(application.created_at).toLocaleDateString() }}
                                        </td>
                                        <td v-if="userRole === 'admin'" class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            <div class="flex space-x-2">
                                                 <PrimaryButton v-if="application.status === 'pending'" @click="updateApplicationStatus(application.id, 'approved')" class="!py-1 !px-2 !text-xs !bg-green-600 hover:!bg-green-700">Approve</PrimaryButton>
                                                 <SecondaryButton v-if="application.status === 'pending'" @click="updateApplicationStatus(application.id, 'rejected')" class="!py-1 !px-2 !text-xs !bg-red-600 hover:!bg-red-700">Reject</SecondaryButton>
                                                 <!-- Optional: Show details link -->
                                                 <!-- <Link :href="route('applications.show', application.id)" class="text-indigo-600 hover:text-indigo-900">Details</Link> -->
                                                  <button @click="deleteApplication(application.id)" class="text-red-600 hover:text-red-900 ml-2">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else>
                            <p>No applications found.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue'; // For actions
import SecondaryButton from '@/Components/SecondaryButton.vue'; // For actions

const props = defineProps({
    applications: Array,
    userRole: String, // Get user role passed from controller
});

function statusClass(status) {
    if (status === 'approved') return 'text-green-600 bg-green-100';
    if (status === 'rejected') return 'text-red-600 bg-red-100';
    return 'text-yellow-600 bg-yellow-100';
}

// Function to handle approve/reject actions
function updateApplicationStatus(applicationId, newStatus) {
    router.put(route('applications.update', applicationId), {
        status: newStatus,
    }, {
        preserveScroll: true, // Keep scroll position after update
        // Add onSuccess/onError handling if needed
    });
}

// Function to handle delete action
function deleteApplication(applicationId) {
    if (confirm('Are you sure you want to delete this application?')) {
        router.delete(route('applications.destroy', applicationId), {
             preserveScroll: true,
        });
    }
}

</script>
