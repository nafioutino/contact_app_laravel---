<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, computed } from 'vue';

const props = defineProps({
  contacts: Array,
});

const searchQuery = ref('');

const filteredContacts = computed(() => {
  if (!searchQuery.value) return props.contacts;
  
  const query = searchQuery.value.toLowerCase();
  return props.contacts.filter(contact => 
    contact.full_name.toLowerCase().includes(query) ||
    (contact.email && contact.email.toLowerCase().includes(query)) ||
    (contact.phone && contact.phone.toLowerCase().includes(query))
  );
});
</script>

<template>
  <Head title="Contacts" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contacts</h2>
        <Link :href="route('contacts.create')" class="inline-flex items-center">
          <PrimaryButton>Nouveau Contact</PrimaryButton>
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <!-- Barre de recherche -->
            <div class="mb-6">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Rechercher un contact..."
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              />
            </div>

            <!-- Liste des contacts -->
            <div v-if="filteredContacts.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div v-for="contact in filteredContacts" :key="contact.id" 
                   class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-lg">
                <Link :href="route('contacts.show', contact.id)" class="block">
                  <div class="p-4">
                    <div class="flex items-center mb-3">
                      <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 font-bold text-lg mr-3">
                        {{ contact.first_name[0] }}{{ contact.last_name[0] }}
                      </div>
                      <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ contact.full_name }}</h3>
                        <p v-if="contact.country" class="text-sm text-gray-600">{{ contact.country }}</p>
                      </div>
                    </div>
                    <div class="space-y-1">
                      <p v-if="contact.email" class="text-sm text-gray-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ contact.email }}
                      </p>
                      <p v-if="contact.phone" class="text-sm text-gray-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        {{ contact.phone }}
                      </p>
                    </div>
                  </div>
                  <div class="bg-gray-50 px-4 py-3 flex justify-end space-x-2">
                    <Link :href="route('contacts.edit', contact.id)" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                      Modifier
                    </Link>
                    <span class="text-gray-300">|</span>
                    <Link :href="route('contacts.show', contact.id)" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                      Détails
                    </Link>
                  </div>
                </Link>
              </div>
            </div>

            <!-- Message si aucun contact -->
            <div v-else class="text-center py-12">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <p class="mt-4 text-lg text-gray-600">
                {{ searchQuery ? 'Aucun contact ne correspond à votre recherche' : 'Aucun contact trouvé' }}
              </p>
              <div class="mt-6">
                <Link :href="route('contacts.create')">
                  <PrimaryButton>Ajouter un contact</PrimaryButton>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>