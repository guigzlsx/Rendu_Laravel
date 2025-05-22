<template>
  <AppShell>
    <template #header>
      <AppHeader>
        <template #title>API Response Preview</template>
        <template #actions>
          <button
            @click="copyToClipboard"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Copy JSON
          </button>
        </template>
      </AppHeader>
    </template>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <div class="bg-white shadow sm:rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <div class="mb-4">
              <h3 class="text-lg font-medium leading-6 text-gray-900">API Key Information</h3>
              <p class="mt-1 text-sm text-gray-500">Name: {{ apiKey.name }}</p>
              <p class="text-sm text-gray-500">Key: {{ apiKey.key }}</p>
            </div>

            <div class="mt-6">
              <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">API Response</h3>
              <div class="bg-gray-50 rounded-lg p-4">
                <pre class="text-sm text-gray-800 overflow-auto max-h-[600px]">{{ formattedJson }}</pre>
              </div>
            </div>

            <div class="mt-6">
              <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">How to use this API</h3>
              <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm text-gray-800 mb-2">Make a GET request to:</p>
                <code class="block bg-gray-100 p-2 rounded text-sm mb-4">http://localhost:8000/api/playlists</code>
                
                <p class="text-sm text-gray-800 mb-2">With the header:</p>
                <code class="block bg-gray-100 p-2 rounded text-sm">x-api-key: {{ apiKey.key }}</code>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppShell>
</template>

<script setup>
import { computed } from 'vue'
import AppShell from '@/Components/AppShell.vue'
import AppHeader from '@/Components/AppHeader.vue'

const props = defineProps({
  apiKey: {
    type: Object,
    required: true
  },
  playlists: {
    type: Array,
    required: true
  }
})

const formattedJson = computed(() => {
  return JSON.stringify(props.playlists, null, 2)
})

const copyToClipboard = () => {
  navigator.clipboard.writeText(formattedJson.value)
    .then(() => {
      alert('JSON copied to clipboard!')
    })
    .catch(err => {
      console.error('Failed to copy text: ', err)
    })
}
</script> 