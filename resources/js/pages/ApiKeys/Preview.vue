<template>
  <AppShell>
    <template #header>
      <AppHeader>
        <template #title>API Response Preview</template>
        <template #actions>
          <button
            @click="copyToClipboard"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
            </svg>
            Copy JSON
          </button>
        </template>
      </AppHeader>
    </template>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <!-- API Key Information Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-8">
          <div class="px-6 py-8">
            <div class="flex items-center justify-between">
              <div>
                <h3 class="text-2xl font-bold text-gray-900">API Key Information</h3>
                <div class="mt-4 space-y-3">
                  <div class="flex items-center">
                    <span class="text-sm font-medium text-gray-500 w-20">Name:</span>
                    <span class="text-sm text-gray-900">{{ apiKey.name }}</span>
                  </div>
                  <div class="flex items-center">
                    <span class="text-sm font-medium text-gray-500 w-20">Key:</span>
                    <code class="text-sm bg-gray-100 px-3 py-1 rounded-lg text-gray-900">{{ apiKey.key }}</code>
                  </div>
                </div>
              </div>
              <div class="h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center">
                <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- API Response Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-8">
          <div class="px-6 py-8">
            <div class="flex items-center justify-between mb-6">
              <h3 class="text-2xl font-bold text-gray-900">API Response</h3>
              <span class="px-3 py-1 text-sm font-medium text-green-600 bg-green-100 rounded-full">
                {{ playlists.length }} {{ playlists.length === 1 ? 'Playlist' : 'Playlists' }}
              </span>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
              <pre class="text-sm text-gray-900 overflow-auto max-h-[600px] font-mono">{{ formattedJson }}</pre>
            </div>
          </div>
        </div>

        <!-- How to Use Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
          <div class="px-6 py-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">How to use this API</h3>
            <div class="space-y-6">
              <div>
                <h4 class="text-sm font-medium text-gray-900 mb-2">Make a GET request to:</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                  <code class="text-sm font-mono text-gray-900">http://localhost:8000/api/playlists</code>
                </div>
              </div>
              
              <div>
                <h4 class="text-sm font-medium text-gray-900 mb-2">With the header:</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                  <code class="text-sm font-mono text-gray-900">x-api-key: {{ apiKey.key }}</code>
                </div>
              </div>

              <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex">
                  <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Pro Tip</h3>
                    <div class="mt-2 text-sm text-blue-700">
                      <p>You can use this API key in your applications to fetch playlists programmatically. Make sure to keep your API key secure and never share it publicly.</p>
                    </div>
                  </div>
                </div>
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