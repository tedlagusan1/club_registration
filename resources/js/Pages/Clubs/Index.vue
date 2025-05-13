<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    clubs: Array,
});

function deleteClub(clubId) {
    if (confirm('Are you sure you want to delete this club? This action cannot be undone.')) {
        router.delete(route('clubs.destroy', clubId), {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <Head title="Manage Clubs" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                 <h2 class="text-xl font-semibold leading-tight text-gray-800">Manage Clubs</h2>
                 <Link :href="route('clubs.create')" class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900">
                    Add New Club
                 </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Members</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="club in clubs" :key="club.id">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center">
                                            <div v-if="club.logo" class="h-10 w-10 flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full" :src="'/storage/' + club.logo" alt="Club Logo">
                                            </div>
                                            <div :class="{ 'ml-4': club.logo }">
                                                <div class="text-sm font-medium text-gray-900">{{ club.name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5" :class="club.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                            {{ club.is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                         <Link :href="route('clubs.members.index', club.id)" class="text-indigo-600 hover:text-indigo-900">View Members</Link>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <Link :href="route('clubs.edit', club.id)" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                                        <button @click="deleteClub(club.id)" class="ml-4 text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                                <tr v-if="clubs.length === 0">
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No clubs found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
