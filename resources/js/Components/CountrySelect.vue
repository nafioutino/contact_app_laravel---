<script setup>
import { ref, onMounted } from 'vue';
import { useDebounceFn } from '@vueuse/core';
import axios from 'axios';

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  label: {
    type: String,
    default: 'Pays'
  },
  error: {
    type: String,
    default: ''
  }
});

const emit = defineEmits(['update:modelValue']);

const countries = ref([]);
const loading = ref(false);
const searchQuery = ref('');
const showDropdown = ref(false);
const selectedCountry = ref(props.modelValue);

const fetchCountries = async (query) => {
  if (!query || query.length < 2) return;
  
  loading.value = true;
  try {
    const response = await axios.get(`https://restcountries.com/v3.1/name/${query}`);
    countries.value = response.data.map(country => ({
      name: country.name.common,
      code: country.cca2,
      flag: country.flags.svg
    })).sort((a, b) => a.name.localeCompare(b.name));
  } catch (error) {
    console.error('Erreur lors de la récupération des pays:', error);
    countries.value = [];
  } finally {
    loading.value = false;
  }
};

const debouncedFetch = useDebounceFn(fetchCountries, 300);

const handleSearch = (event) => {
  searchQuery.value = event.target.value;
  debouncedFetch(searchQuery.value);
  showDropdown.value = true;
};

const selectCountry = (country) => {
  selectedCountry.value = country.name;
  emit('update:modelValue', country.name);
  showDropdown.value = false;
};

onMounted(() => {
  if (props.modelValue) {
    selectedCountry.value = props.modelValue;
  }
});
</script>

<template>
  <div class="relative">
    <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1">{{ label }}</label>
    
    <div class="relative">
      <input
        type="text"
        v-model="selectedCountry"
        @input="handleSearch"
        @focus="showDropdown = true"
        @blur="setTimeout(() => showDropdown = false, 200)"
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        :class="{ 'border-red-500': error }"
        placeholder="Rechercher un pays..."
      />
      
      <div v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</div>
      
      <div v-if="showDropdown && (countries.length > 0 || loading)" 
           class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base overflow-auto focus:outline-none sm:text-sm">
        <div v-if="loading" class="px-4 py-2 text-gray-500">Chargement...</div>
        
        <ul v-else class="divide-y divide-gray-200">
          <li v-for="country in countries" :key="country.code" 
              @mousedown="selectCountry(country)"
              class="px-4 py-2 hover:bg-indigo-50 cursor-pointer flex items-center">
            <img :src="country.flag" alt="drapeau" class="w-6 h-4 mr-2" />
            <span>{{ country.name }}</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>