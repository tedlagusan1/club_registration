<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    memberships: Array, // Added prop for memberships
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>
                </div>

                <!-- Display Member Lists -->
                <div v-if="memberships && memberships.length > 0" class="mt-6">
                    <div v-for="membership in memberships" :key="membership.id" class="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="border-b border-gray-200 bg-white p-6">
                            <h3 class="text-lg font-semibold">Members of {{ membership.club.name }}</h3>
                        </div>
                        <div class="p-6 text-gray-900">
                            <ul v-if="membership.club.members && membership.club.members.length > 0" class="divide-y divide-gray-200">
                                <li v-for="member in membership.club.members" :key="member.id" class="py-3">
                                    {{ member.user.name }} ({{ member.user.email }})
                                    <!-- Add other member details as needed -->
                                </li>
                            </ul>
                            <p v-else>No members found for this club.</p>
                        </div>
                    </div>
                </div>
                <div v-else class="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                     <div class="p-6 text-gray-900">
                        You are not currently a member of any clubs.
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
