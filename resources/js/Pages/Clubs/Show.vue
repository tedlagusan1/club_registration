<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ club.name }}</h2>
                <div class="flex space-x-4">
                    <Link
                        v-if="$page.props.auth.user.is_admin"
                        :href="route('clubs.edit', club.id)"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Edit Club
                    </Link>
                    <Link
                        v-if="!isMember"
                        :href="route('applications.create')"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Join Club
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium mb-4">Club Information</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Description</label>
                                        <p class="mt-1 text-gray-900">{{ club.description }}</p>
                                    </div>
                                    <div v-if="club.logo">
                                        <label class="block text-sm font-medium text-gray-700">Logo</label>
                                        <img
                                            :src="club.logo"
                                            :alt="club.name"
                                            class="mt-1 h-32 w-32 object-cover rounded-lg"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium mb-4">Members</h3>
                                <div class="space-y-4">
                                    <div
                                        v-for="member in club.members"
                                        :key="member.id"
                                        class="flex items-center justify-between p-4 bg-gray-50 rounded-lg"
                                    >
                                        <div>
                                            <p class="font-medium">{{ member.user.name }}</p>
                                            <p class="text-sm text-gray-500">{{ member.position || 'Member' }}</p>
                                        </div>
                                        <div v-if="$page.props.auth.user.is_admin" class="flex space-x-2">
                                            <button
                                                @click="editMember(member)"
                                                class="text-indigo-600 hover:text-indigo-900"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                @click="removeMember(member)"
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                Remove
                                            </button>
                                        </div>
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
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    club: {
        type: Object,
        required: true,
    },
});

const isMember = computed(() => {
    return props.club.members.some(
        (member) => member.user_id === props.$page.props.auth.user.id
    );
});

const editMember = (member) => {
    // Implement member editing logic
};

const removeMember = (member) => {
    if (confirm('Are you sure you want to remove this member?')) {
        router.delete(route('members.destroy', member.id));
    }
};
</script>
