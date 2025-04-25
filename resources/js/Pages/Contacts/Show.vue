<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import CountryFlag from '@/Components/CountryFlag.vue';
import { useForm } from '@inertiajs/vue3';
import { showConfirmDialog, showSuccessNotification, showErrorNotification } from '@/Components/SweetAlert';

const props = defineProps({
  contact: Object,
});

const form = useForm({});

const deleteContact = async () => {
  const result = await showConfirmDialog(
    'Confirmation de suppression',
    `Êtes-vous sûr de vouloir supprimer ${props.contact.first_name} ${props.contact.last_name}?`
  );
  
  if (result.isConfirmed) {
    form.delete(route('contacts.destroy', props.contact.id), {
      onSuccess: () => showSuccessNotification('Contact supprimé avec succès'),
      onError: () => showErrorNotification('Une erreur est survenue lors de la suppression')
    });
  }
};
</script>

<template>
  <Head :title="`${contact.first_name} ${contact.last_name}`" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
          Détails du contact
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
            <div class="flex flex-col md:flex-row">
              <!-- Avatar/Initiales -->
              <div class="flex-shrink-0 flex justify-center mb-6 md:mb-0 md:mr-8">
                <div class="w-32 h-32 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-4xl shadow-lg transform transition-all duration-300 hover:scale-105">
                  {{ contact.first_name[0] }}{{ contact.last_name[0] }}
                </div>
              </div>
              
              <!-- Informations du contact -->
              <div class="flex-grow">
                <h1 class="text-2xl font-bold text-gray-800 mb-4 border-b-2 border-indigo-200 pb-2 inline-block">{{ contact.first_name }} {{ contact.last_name }}</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                  <!-- Email -->
                  <div v-if="contact.email" class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <div>
                      <p class="text-sm text-gray-500">Email</p>
                      <p class="text-gray-800">{{ contact.email }}</p>
                    </div>
                  </div>
                  
                  <!-- Téléphone -->
                  <div v-if="contact.phone" class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <div>
                      <p class="text-sm text-gray-500">Téléphone</p>
                      <p class="text-gray-800">{{ contact.phone }}</p>
                    </div>
                  </div>
                  
                  <!-- Adresse -->
                  <div v-if="contact.address" class="flex items-start md:col-span-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                      <p class="text-sm text-gray-500">Adresse</p>
                      <p class="text-gray-800">{{ contact.address }}</p>
                      <p v-if="contact.city || contact.region || contact.postal_code" class="text-gray-800">
                        {{ [contact.city, contact.region, contact.postal_code].filter(Boolean).join(', ') }}
                      </p>
                      <div v-if="contact.country" class="flex items-center gap-2 mt-1">
                        <CountryFlag :country="contact.country" />
                        <p class="text-gray-800">{{ contact.country }}</p>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Notes -->
                <div v-if="contact.notes" class="mt-6">
                  <h3 class="text-lg font-medium text-gray-800 mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Notes
                  </h3>
                  <div class="bg-gray-50 p-4 rounded-md shadow-sm border-l-4 border-indigo-300 transition-all duration-300 hover:shadow">
                    <p class="text-gray-700 whitespace-pre-line">{{ contact.notes }}</p>
                  </div>
                </div>
                
                <!-- Actions -->
                <div class="mt-8 flex justify-between items-center">
                  <DangerButton @click="deleteContact" class="flex items-center transition-all duration-300 hover:bg-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Supprimer
                  </DangerButton>
                  
                  <Link :href="route('contacts.edit', contact.id)">
                    <PrimaryButton class="flex items-center transition-all duration-300 hover:bg-indigo-600">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                      Modifier
                    </PrimaryButton>
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>