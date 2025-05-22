<template>
  <AppShell>
    <template #header>
      <AppHeader>
        <template #title>API Keys</template>
      </AppHeader>
    </template>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <!-- Create New API Key Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden transform transition-all duration-300 hover:shadow-xl">
          <div class="px-6 py-8">
            <div class="flex items-center justify-between mb-6">
              <div>
                <h3 class="text-2xl font-bold text-gray-900">Create New API Key</h3>
                <p class="mt-2 text-sm text-gray-600">Generate a new API key to access your playlists programmatically.</p>
              </div>
              <div class="h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center">
                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
              </div>
            </div>
            <form @submit.prevent="createApiKey" class="mt-5">
              <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                  <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Key Name</label>
                  <input
                    type="text"
                    name="name"
                    id="name"
                    v-model="form.name"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-colors duration-200 text-gray-900 placeholder-gray-400"
                    placeholder="e.g., Production API Key"
                    required
                  />
                </div>
                <div class="sm:self-end">
                  <button
                    type="submit"
                    class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 text-white font-medium text-sm leading-tight rounded-lg shadow-md hover:bg-indigo-700 hover:shadow-lg focus:bg-indigo-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-indigo-800 active:shadow-lg transition duration-150 ease-in-out flex items-center justify-center"
                  >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Create Key
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- API Keys List -->
        <div class="mt-8 bg-white shadow-lg rounded-xl overflow-hidden">
          <div class="px-6 py-8">
            <div class="flex items-center justify-between mb-6">
              <h3 class="text-2xl font-bold text-gray-900">Your API Keys</h3>
              <span class="px-3 py-1 text-sm font-medium text-indigo-600 bg-indigo-100 rounded-full">
                {{ apiKeys.length }} {{ apiKeys.length === 1 ? 'Key' : 'Keys' }}
              </span>
            </div>

            <div class="mt-6">
              <div v-if="apiKeys.length === 0" class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No API keys</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new API key.</p>
              </div>

              <ul v-else class="divide-y divide-gray-200">
                <li v-for="key in apiKeys" :key="key.id" class="py-6">
                  <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                      <div class="flex items-center">
                        <div class="h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                          <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                          </svg>
                        </div>
                        <div class="ml-4">
                          <h4 class="text-lg font-medium text-gray-900">{{ key.name }}</h4>
                          <div class="mt-1 flex items-center">
                            <span class="text-sm text-gray-500">Key: </span>
                            <code class="ml-1 text-sm bg-gray-100 px-2 py-1 rounded text-gray-900">{{ key.key }}</code>
                          </div>
                          <p class="mt-1 text-sm text-gray-500">Created {{ new Date(key.created_at).toLocaleDateString() }}</p>
                        </div>
                      </div>
                    </div>
                    <div class="flex space-x-3">
                      <a
                        :href="route('api-keys.preview', key.uuid)"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
                      >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        View Response
                      </a>
                      <button
                        @click="deleteApiKey(key)"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200"
                      >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                      </button>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppShell>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppShell from '@/Components/AppShell.vue'
import AppHeader from '@/Components/AppHeader.vue'

const props = defineProps({
  apiKeys: {
    type: Array,
    required: true
  }
})

const form = ref({
  name: ''
})

const createApiKey = () => {
  router.post(route('api-keys.store'), form.value, {
    onSuccess: () => {
      form.value.name = ''
    }
  })
}

const deleteApiKey = (key) => {
  if (confirm('Are you sure you want to delete this API key?')) {
    router.delete(route('api-keys.destroy', key.uuid))
  }
}
</script> 