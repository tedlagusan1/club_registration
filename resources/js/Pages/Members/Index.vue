<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    club: Object,
    members: Array,
});

function removeMember(memberId) {
    if (confirm('Are you sure you want to remove this member from the club?')) {
        router.delete(route('members.destroy', memberId), {
            preserveScroll: true,
        });
    }
}

// Optional: Add function for editing member details (e.g., position) if needed
// function editMember(memberId) { ... }

</script>

<template>
    <Head :title="`Members - ${club.name}`" />

    <AuthenticatedLayout>
        <template #header>
             <h2 class="text-xl font-semibold leading-tight text-gray-800">Members of {{ club.name }}</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                 <div class="mb-4">
                     <Link :href="route('clubs.index')" class="text-sm text-blue-600 underline hover:text-blue-800">
                        &larr; Back to Clubs
                    </Link>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Optional: Add Export Button Here -->

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Student ID</th>
                                     <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Joined At</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="member in members" :key="member.id">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ member.user.name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ member.user.email }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ member.user.student_id }}</td>
                                     <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ new Date(member.joined_at).toLocaleDateString() }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <!-- Optional: Edit member link -->
                                        <!-- <Link :href="route('members.edit', member.id)" class="text-indigo-600 hover:text-indigo-900">Edit</Link> -->
                                        <button @click="removeMember(member.id)" class="ml-4 text-red-600 hover:text-red-900">Remove</button>
                                    </td>
                                </tr>
                                <tr v-if="members.length === 0">
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No members found for this club.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
