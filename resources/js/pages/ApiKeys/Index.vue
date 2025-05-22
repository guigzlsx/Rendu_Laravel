<template>
  <AppShell>
    <template #header>
      <AppHeader>
        <template #title>API Keys</template>
      </AppHeader>
    </template>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <div class="bg-white shadow sm:rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Create New API Key</h3>
            <div class="mt-2 max-w-xl text-sm text-gray-500">
              <p>Create a new API key to access your playlists programmatically.</p>
            </div>
            <form @submit.prevent="createApiKey" class="mt-5 sm:flex sm:items-center">
              <div class="w-full sm:max-w-xs">
                <label for="name" class="sr-only">Name</label>
                <input
                  type="text"
                  name="name"
                  id="name"
                  v-model="form.name"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  placeholder="My API Key"
                  required
                />
              </div>
              <button
                type="submit"
                class="mt-3 inline-flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
              >
                Create
              </button>
            </form>
          </div>
        </div>

        <div class="mt-8 bg-white shadow sm:rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Your API Keys</h3>
            <div class="mt-5">
              <div v-if="apiKeys.length === 0" class="text-center py-4 text-gray-500">
                No API keys found. Create one above.
              </div>
              <ul v-else class="divide-y divide-gray-200">
                <li v-for="key in apiKeys" :key="key.id" class="py-4">
                  <div class="flex items-center justify-between">
                    <div>
                      <p class="text-sm font-medium text-gray-900">{{ key.name }}</p>
                      <p class="text-sm text-gray-500">Key: {{ key.key }}</p>
                      <p class="text-xs text-gray-400">Created: {{ new Date(key.created_at).toLocaleDateString() }}</p>
                    </div>
                    <button
                      @click="deleteApiKey(key)"
                      class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                    >
                      Delete
                    </button>
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