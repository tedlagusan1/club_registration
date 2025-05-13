<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Add clubs prop
defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    clubs: Array, // Receive clubs from controller
});

const form = useForm({
    name: '',
    student_id: '',
    course: '',
    year_level: '',
    grade: '',
    id_photo: null,
    club_id: null, // Add club_id to form
    email: '',
    password: '',
    password_confirmation: '',
});

// Helper function to handle file input changes
function handleIdPhotoChange(event) {
  form.id_photo = event.target.files[0];
}

const submit = () => {
    // IMPORTANT: When posting files, Inertia needs the data object to be sent directly
    // without the `.data` property, and it performs a multipart/form-data request automatically.
    form.post(route('register'), {
        forceFormData: true, // Ensure multipart/form-data
        onFinish: () => form.reset('password', 'password_confirmation', 'id_photo'), // Reset photo field too
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit" class="monochrome-form">
            <div>
                <InputLabel for="name" value="Name" />
                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Student ID -->
            <div class="mt-4">
                <InputLabel for="student_id" value="Student ID" />
                <TextInput id="student_id" type="text" class="mt-1 block w-full" v-model="form.student_id" required />
                <InputError class="mt-2" :message="form.errors.student_id" />
            </div>

            <!-- Course -->
            <div class="mt-4">
                <InputLabel for="course" value="Course" />
                <TextInput id="course" type="text" class="mt-1 block w-full" v-model="form.course" required />
                <InputError class="mt-2" :message="form.errors.course" />
            </div>

            <!-- Year Level -->
            <div class="mt-4">
                <InputLabel for="year_level" value="Year Level" />
                <TextInput id="year_level" type="text" class="mt-1 block w-full" v-model="form.year_level" required />
                <InputError class="mt-2" :message="form.errors.year_level" />
            </div>

            <!-- Grade -->
            <div class="mt-4">
                <InputLabel for="grade" value="Grade" />
                <TextInput id="grade" type="text" class="mt-1 block w-full" v-model="form.grade" required />
                <InputError class="mt-2" :message="form.errors.grade" />
            </div>

            <!-- Club Selection -->
            <div class="mt-4">
                <InputLabel for="club_id" value="Select Club to Join" />
                <select
                    id="club_id"
                    v-model="form.club_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 monochrome-select"
                    required
                >
                    <option :value="null" disabled>-- Select a Club --</option>
                    <option v-for="club in clubs" :key="club.id" :value="club.id">
                        {{ club.name }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.club_id" />
            </div>

            <!-- ID Photo -->
            <div class="mt-4">
                <InputLabel for="id_photo" value="ID Photo (Optional)" />
                <input id="id_photo" type="file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 monochrome-input-file" @change="handleIdPhotoChange" accept="image/*" />
                <InputError class="mt-2" :message="form.errors.id_photo" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton class="ms-4 monochrome-button" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
            <div class="mt-4 text-center">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 monochrome-link"
                >
                    Already registered? Log in
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>

<style scoped>
form.monochrome-form {
  filter: grayscale(100%);
  background-color: #f3f4f6; /* Tailwind gray-100 */
  color: #1f2937; /* Tailwind gray-800 */
}

.monochrome-text {
  color: #4b5563 !important; /* Tailwind gray-600 */
}

.monochrome-link {
  color: #4b5563 !important;
  text-decoration: underline;
}

.monochrome-link:hover {
  color: #111827 !important; /* Tailwind gray-900 */
}

.monochrome-button {
  background-color: #374151 !important; /* Tailwind gray-700 */
  color: white !important;
}

.monochrome-button:hover {
  background-color: #1f2937 !important; /* Tailwind gray-800 */
}
</style>
