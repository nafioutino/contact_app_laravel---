<script setup>
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
  country: {
    type: String,
    required: true
  }
});

const flagUrl = ref('');
const countryCode = ref('');

async function fetchCountryData() {
  try {
    if (!props.country) return;
    
    const response = await fetch(`https://restcountries.com/v3.1/name/${encodeURIComponent(props.country)}`);
    const data = await response.json();
    
    if (data && data[0]) {
      countryCode.value = data[0].cca2.toLowerCase();
      flagUrl.value = `https://flagcdn.com/${countryCode.value}.svg`;
    }
  } catch (error) {
    console.error('Error fetching country data:', error);
  }
}

onMounted(() => {
  fetchCountryData();
});

watch(() => props.country, () => {
  fetchCountryData();
});
</script>

<template>
  <img
    v-if="flagUrl"
    :src="flagUrl"
    :alt="`Drapeau ${country}`"
    class="w-6 h-4 object-cover rounded"
  />
</template>