<template>
  <button
    @click="goBack"
    class="flex items-center text-primary hover:text-blue-700 font-semibold transition"
  >
    <svg
      class="w-5 h-5 mr-2"
      fill="none"
      stroke="currentColor"
      stroke-width="2"
      viewBox="0 0 24 24"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
    </svg>
    Back
  </button>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const goBack = () => {
  router.back()
}
</script>

<style scoped>
/* You can add additional styling here if needed */
</style>
