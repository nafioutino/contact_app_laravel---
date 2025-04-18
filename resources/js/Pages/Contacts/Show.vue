<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import CountryFlag from '@/Components/CountryFlag.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  contact: Object,
});

const form = useForm({});

const deleteContact = () => {
  if (confirm(`Êtes-vous sûr de vouloir supprimer ${props.contact.first_name} ${props.contact.last_name}?`)) {
    form.delete(route('contacts.destroy', props.contact.id));
  }
};
</script>

<template>
  <Head :title="`${contact.first_name} ${contact.last_name}`" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Détails du contact</h2>
        <Link :href="route('contacts.index')" class="text-indigo-600 hover:text-indigo-900">
          Retour aux contacts
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex flex-col md:flex-row">
              <!-- Avatar/Initiales -->
              <div class="flex-shrink-0 flex justify-center mb-6 md:mb-0 md:mr-8">
                <div class="w-32 h-32 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 font-bold text-4xl">
                  {{ contact.first_name[0] }}{{ contact.last_name[0] }}
                </div>
              </div>
              
              <!-- Informations du contact -->
              <div class="flex-grow">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ contact.first_name }} {{ contact.last_name }}</h1>
                
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
                  <h3 class="text-lg font-medium text-gray-800 mb-2">Notes</h3>
                  <div class="bg-gray-50 p-4 rounded-md">
                    <p class="text-gray-700 whitespace-pre-line">{{ contact.notes }}</p>
                  </div>
                </div>
                
                <!-- Actions -->
                <div class="mt-8 flex justify-between items-center">
                  <DangerButton @click="deleteContact">
                    Supprimer
                  </DangerButton>
                  
                  <Link :href="route('contacts.edit', contact.id)">
                    <PrimaryButton>
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