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
import DangerButton from '@/Components/DangerButton.vue';
import { showConfirmDialog, showSuccessNotification, showErrorNotification } from '@/Components/SweetAlert';

const props = defineProps({
  contact: Object,
});

const form = useForm({
  first_name: props.contact.first_name,
  last_name: props.contact.last_name,
  email: props.contact.email,
  phone: props.contact.phone,
  address: props.contact.address,
  city: props.contact.city,
  region: props.contact.region,
  country: props.contact.country,
  postal_code: props.contact.postal_code,
  notes: props.contact.notes,
});

const submit = () => {
  form.patch(route('contacts.update', props.contact.id), {
    onSuccess: () => showSuccessNotification('Contact modifié avec succès'),
    onError: () => showErrorNotification('Une erreur est survenue lors de la modification')
  });
};

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
  <Head title="Modifier Contact" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier Contact</h2>
        <Link :href="route('contacts.index')" class="text-indigo-600 hover:text-indigo-900">
          Retour aux contacts
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <form @submit.prevent="submit" class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Prénom -->
                <div>
                  <InputLabel for="first_name" value="Prénom" />
                  <TextInput
                    id="first_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.first_name"
                    required
                    autofocus
                  />
                  <InputError class="mt-2" :message="form.errors.first_name" />
                </div>

                <!-- Nom -->
                <div>
                  <InputLabel for="last_name" value="Nom" />
                  <TextInput
                    id="last_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.last_name"
                    required
                  />
                  <InputError class="mt-2" :message="form.errors.last_name" />
                </div>

                <!-- Email -->
                <div>
                  <InputLabel for="email" value="Email" />
                  <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                  />
                  <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <!-- Téléphone -->
                <div>
                  <InputLabel for="phone" value="Téléphone" />
                  <TextInput
                    id="phone"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                  />
                  <InputError class="mt-2" :message="form.errors.phone" />
                </div>

                <!-- Adresse -->
                <div class="md:col-span-2">
                  <InputLabel for="address" value="Adresse" />
                  <TextInput
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address"
                  />
                  <InputError class="mt-2" :message="form.errors.address" />
                </div>

                <!-- Ville -->
                <div>
                  <InputLabel for="city" value="Ville" />
                  <TextInput
                    id="city"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.city"
                  />
                  <InputError class="mt-2" :message="form.errors.city" />
                </div>

                <!-- Région -->
                <div>
                  <InputLabel for="region" value="Région/État" />
                  <TextInput
                    id="region"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.region"
                  />
                  <InputError class="mt-2" :message="form.errors.region" />
                </div>

                <!-- Pays avec le composant CountrySelect -->
                <div>
                  <CountrySelect
                    v-model="form.country"
                    label="Pays"
                    :error="form.errors.country"
                  />
                </div>

                <!-- Code postal -->
                <div>
                  <InputLabel for="postal_code" value="Code postal" />
                  <TextInput
                    id="postal_code"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.postal_code"
                  />
                  <InputError class="mt-2" :message="form.errors.postal_code" />
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                  <InputLabel for="notes" value="Notes" />
                  <textarea
                    id="notes"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    v-model="form.notes"
                    rows="4"
                  ></textarea>
                  <InputError class="mt-2" :message="form.errors.notes" />
                </div>
              </div>

              <div class="flex items-center justify-between mt-6">
                <DangerButton @click="deleteContact" type="button">
                  Supprimer
                </DangerButton>
                
                <div class="flex space-x-4">
                  <Link :href="route('contacts.index')">
                    <SecondaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                      Annuler
                    </SecondaryButton>
                  </Link>
                  <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Mettre à jour
                  </PrimaryButton>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>