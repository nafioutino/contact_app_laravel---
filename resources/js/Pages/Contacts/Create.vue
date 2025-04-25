<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import CountrySelect from '@/Components/CountrySelect.vue';
import { Link } from '@inertiajs/vue3';
import { showSuccessNotification, showErrorNotification } from '@/Components/SweetAlert';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    region: '',
    country: '',
    postal_code: '',
    notes: '',
});

const submit = () => {
    form.post(route('contacts.store'), {
        onSuccess: () => showSuccessNotification('Contact créé avec succès'),
        onError: () => showErrorNotification('Une erreur est survenue lors de la création')
    });
};
</script>

<template>
    <Head title="Nouveau Contact" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Nouveau Contact
                </h2>
                <Link :href="route('contacts.index')" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour aux contacts
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300 hover:shadow-md">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" class="space-y-6 transition-all duration-300">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Prénom -->
                                <div>
                                    <InputLabel for="first_name" value="Prénom" />
                                    <TextInput id="first_name" type="text" class="mt-1 block w-full"
                                        v-model="form.first_name" required autofocus />
                                    <InputError class="mt-2" :message="form.errors.first_name" />
                                </div>

                                <!-- Nom -->
                                <div>
                                    <InputLabel for="last_name" value="Nom" />
                                    <TextInput id="last_name" type="text" class="mt-1 block w-full"
                                        v-model="form.last_name" required />
                                    <InputError class="mt-2" :message="form.errors.last_name" />
                                </div>

                                <!-- Email -->
                                <div>
                                    <InputLabel for="email" value="Email" />
                                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                                    <InputError class="mt-2" :message="form.errors.email" />
                                </div>

                                <!-- Téléphone -->
                                <div>
                                    <InputLabel for="phone" value="Téléphone" />
                                    <TextInput id="phone" type="tel" class="mt-1 block w-full" v-model="form.phone" />
                                    <InputError class="mt-2" :message="form.errors.phone" />
                                </div>

                                <!-- Adresse -->
                                <div class="md:col-span-2">
                                    <InputLabel for="address" value="Adresse" />
                                    <TextInput id="address" type="text" class="mt-1 block w-full"
                                        v-model="form.address" />
                                    <InputError class="mt-2" :message="form.errors.address" />
                                </div>

                                <!-- Pays avec le composant CountrySelect -->
                                <div>
                                    <CountrySelect v-model="form.country" label="Pays" :error="form.errors.country" />
                                </div>

                                <!-- Région -->
                                <div>
                                    <InputLabel for="region" value="Région/État" />
                                    <TextInput id="region" type="text" class="mt-1 block w-full"
                                        v-model="form.region" />
                                    <InputError class="mt-2" :message="form.errors.region" />
                                </div>

                                <!-- Ville -->
                                <div>
                                    <InputLabel for="city" value="Ville" />
                                    <TextInput id="city" type="text" class="mt-1 block w-full" v-model="form.city" />
                                    <InputError class="mt-2" :message="form.errors.city" />
                                </div>





                                <!-- Code postal -->
                                <div>
                                    <InputLabel for="postal_code" value="Code postal" />
                                    <TextInput id="postal_code" type="text" class="mt-1 block w-full"
                                        v-model="form.postal_code" />
                                    <InputError class="mt-2" :message="form.errors.postal_code" />
                                </div>

                                <!-- Notes -->
                                <div class="md:col-span-2">
                                    <InputLabel for="notes" value="Notes" />
                                    <textarea id="notes"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form.notes" rows="4"></textarea>
                                    <InputError class="mt-2" :message="form.errors.notes" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6 space-x-4">
                                <Link :href="route('contacts.index')">
                                <SecondaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="flex items-center transition-all duration-300 hover:bg-gray-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Annuler
                                </SecondaryButton>
                                </Link>
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="flex items-center transition-all duration-300 hover:bg-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Enregistrer
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>