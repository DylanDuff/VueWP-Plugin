<script setup>
import { ref, onMounted } from "vue";

const settings = ref({ example: "" });
const status = ref("");

const loadSettings = async () => {
  const res = await fetch(VueOptionsData.ajax_url + "?action=get_vue_options", {
    headers: {
      "X-WP-Nonce": VueOptionsData.nonce,
    },
  });
  const json = await res.json();
  if (json.success) settings.value = json.data;
};

const saveSettings = async () => {
  const res = await fetch(
    VueOptionsData.ajax_url + "?action=save_vue_options",
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-WP-Nonce": VueOptionsData.nonce,
      },
      body: JSON.stringify(settings.value),
    }
  );
  const json = await res.json();
  status.value = json.success ? "Saved!" : "Failed";
};

onMounted(loadSettings);
</script>

<template>
  <div
    class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-6"
  >
    <div class="bg-white shadow-md rounded-2xl p-8 w-full max-w-md">
      <h1 class="text-2xl font-bold mb-6 text-gray-800">Vue Options Page</h1>

      <label class="block mb-4 text-gray-700">
        <span class="block mb-1 font-medium">Example Setting:</span>
        <input
          v-model="settings.example"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </label>

      <button
        @click="saveSettings"
        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors"
      >
        Save
      </button>

      <p class="mt-4 text-sm text-gray-600">{{ status }}</p>
    </div>
  </div>
</template>
