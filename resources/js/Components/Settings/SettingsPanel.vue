<template>
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Settings</h1>

    <div class="bg-white rounded-lg shadow">
      <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            @click="activeTab = tab.id"
            :class="[
              'px-4 py-2 text-sm font-medium',
              activeTab === tab.id
                ? 'border-b-2 border-blue-500 text-blue-600'
                : 'text-gray-500 hover:text-gray-700'
            ]"
          >
            {{ tab.name }}
          </button>
        </nav>
      </div>

      <div class="p-6">
        <!-- Site Settings -->
        <div v-if="activeTab === 'site'" class="space-y-6">
          <div class="grid grid-cols-1 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700">Site Title</label>
              <input
                v-model="siteSettings.site_title"
                type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Site Description</label>
              <textarea
                v-model="siteSettings.site_description"
                rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              ></textarea>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Logo</label>
              <input
                type="file"
                @change="handleLogoUpload"
                accept="image/*"
                class="mt-1 block w-full"
              />
              <img
                v-if="siteSettings.logo"
                :src="siteSettings.logo"
                alt="Site Logo"
                class="mt-2 h-20 w-auto"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Favicon</label>
              <input
                type="file"
                @change="handleFaviconUpload"
                accept="image/x-icon,image/png"
                class="mt-1 block w-full"
              />
              <img
                v-if="siteSettings.favicon"
                :src="siteSettings.favicon"
                alt="Favicon"
                class="mt-2 h-8 w-8"
              />
            </div>
          </div>
        </div>

        <!-- Email Settings -->
        <div v-if="activeTab === 'email'" class="space-y-6">
          <div class="grid grid-cols-1 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700">SMTP Host</label>
              <input
                v-model="emailSettings.smtp_host"
                type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">SMTP Port</label>
              <input
                v-model="emailSettings.smtp_port"
                type="number"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">SMTP Username</label>
              <input
                v-model="emailSettings.smtp_username"
                type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">SMTP Password</label>
              <input
                v-model="emailSettings.smtp_password"
                type="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">SMTP Encryption</label>
              <select
                v-model="emailSettings.smtp_encryption"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              >
                <option value="tls">TLS</option>
                <option value="ssl">SSL</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">From Address</label>
              <input
                v-model="emailSettings.mail_from_address"
                type="email"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">From Name</label>
              <input
                v-model="emailSettings.mail_from_name"
                type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              />
            </div>
          </div>
        </div>

        <!-- Localization Settings -->
        <div v-if="activeTab === 'localization'" class="space-y-6">
          <div class="grid grid-cols-1 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700">Timezone</label>
              <select
                v-model="localizationSettings.timezone"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              >
                <option v-for="tz in timezones" :key="tz" :value="tz">{{ tz }}</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Language</label>
              <select
                v-model="localizationSettings.language"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              >
                <option value="en">English</option>
                <option value="es">Spanish</option>
                <option value="fr">French</option>
                <!-- Add more languages as needed -->
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Date Format</label>
              <select
                v-model="localizationSettings.date_format"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              >
                <option value="Y-m-d">YYYY-MM-DD</option>
                <option value="d/m/Y">DD/MM/YYYY</option>
                <option value="m/d/Y">MM/DD/YYYY</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Time Format</label>
              <select
                v-model="localizationSettings.time_format"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              >
                <option value="H:i">24-hour</option>
                <option value="h:i A">12-hour</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        <button
          @click="saveSettings"
          class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
          Save Changes
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import axios from 'axios'

export default {
  name: 'SettingsPanel',
  setup() {
    const activeTab = ref('site')
    const siteSettings = ref({})
    const emailSettings = ref({})
    const localizationSettings = ref({})
    const timezones = ref([])

    const tabs = [
      { id: 'site', name: 'Site Settings' },
      { id: 'email', name: 'Email Settings' },
      { id: 'localization', name: 'Localization' }
    ]

    const loadSettings = async () => {
      try {
        const response = await axios.get('/api/settings')
        siteSettings.value = response.data.site
        emailSettings.value = response.data.email
        localizationSettings.value = response.data.localization
      } catch (error) {
        console.error('Error loading settings:', error)
      }
    }

    const loadTimezones = () => {
      timezones.value = Intl.supportedValuesOf('timeZone')
    }

    const handleLogoUpload = (event) => {
      const file = event.target.files[0]
      if (file) {
        const formData = new FormData()
        formData.append('logo', file)
        // Handle logo upload
      }
    }

    const handleFaviconUpload = (event) => {
      const file = event.target.files[0]
      if (file) {
        const formData = new FormData()
        formData.append('favicon', file)
        // Handle favicon upload
      }
    }

    const saveSettings = async () => {
      try {
        switch (activeTab.value) {
          case 'site':
            await axios.post('/api/settings/site', siteSettings.value)
            break
          case 'email':
            await axios.post('/api/settings/email', emailSettings.value)
            break
          case 'localization':
            await axios.post('/api/settings/localization', localizationSettings.value)
            break
        }
        // Show success message
      } catch (error) {
        console.error('Error saving settings:', error)
        // Show error message
      }
    }

    onMounted(() => {
      loadSettings()
      loadTimezones()
    })

    return {
      activeTab,
      tabs,
      siteSettings,
      emailSettings,
      localizationSettings,
      timezones,
      handleLogoUpload,
      handleFaviconUpload,
      saveSettings
    }
  }
}
</script>
