<script setup>
import { onMounted } from "vue";
import { useSettings } from "../composables/useSettings";

const { settings, status, loadSettings, saveSettings } = useSettings();

onMounted(() => {
  loadSettings();
});
</script>

<template>
  <div class="wrap">
    <h1>General Settings</h1>

    <form @submit.prevent="saveSettings">
      <div style="margin-bottom: 1rem">
        <label for="api_key" style="display: block; font-weight: bold">
          API Key
        </label>
        <input type="text" id="api_key" v-model="settings.api_key" />
      </div>

      <div style="margin-bottom: 1rem">
        <label for="enable_feature" style="display: block; font-weight: bold">
          Enable Feature
        </label>
        <input
          type="checkbox"
          id="enable_feature"
          v-model="settings.enable_feature"
        />
      </div>

      <div style="margin-bottom: 1rem">
        <label for="items_per_page" style="display: block; font-weight: bold">
          Items Per Page
        </label>
        <input
          type="number"
          id="items_per_page"
          v-model.number="settings.items_per_page"
        />
      </div>

      <button type="submit">Save Settings</button>
    </form>

    <p>{{ status }}</p>
  </div>
</template>
