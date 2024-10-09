<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import AppHead from '@/Components/CustomComponents/AppHead.vue';
import TitleBar from '@/Components/CustomComponents/TitleBar.vue';
import Disable2fA from './Partials/Disable2fA.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <AppHead title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <TitleBar title="Profile" :back="true" />
        </template>

        <div class="py-2">
            <div class="sm:px-6 lg:px-8 flex flex-row flex-wrap gap-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg grow shrink basis-1/2">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" class="w-full" />
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg grow shrink basis-1/2">
                    <Disable2fA class="w-full" />
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg grow shrink basis-1/2">
                    <UpdatePasswordForm class="w-full" />
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg grow shrink basis-1/2">
                    <DeleteUserForm class="w-full" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
