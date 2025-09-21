<script setup>
import { ref } from "vue";
import { useSettings } from "./composables/useSettings";

// Global settings composable
const { saveSettings, loading, saved } = useSettings();

const viewRef = ref(null);

const onSave = async () => {
  await saveSettings();
};

// Define navigation items centrally
const navItems = [
  { to: "/logs", label: "Monitor" },
  { to: "/settings", label: "Connection" },
  { to: "/content", label: "Content" },
  { to: "/custom-notification", label: "Custom Notification" },
  { to: "/advanced", label: "Advanced" },
];
</script>

<template>
  <div class="wpnr-wrap max-w-7xl mx-auto">
    <div class="wpnr-content bg-white dark:bg-zinc-950 rounded-2xl">
      <nav
        class="flex items-center gap-4 p-4 border-b border-gray-200 dark:border-zinc-800"
      >
        <router-link
          v-for="item in navItems"
          :key="item.to"
          class="route-link"
          :to="item.to"
        >
          {{ item.label }}
        </router-link>

        <!-- Global Save Button -->
        <button
          :disabled="loading"
          @click="onSave"
          class="ml-auto bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-800 transition-colors disabled:opacity-50 hover:cursor-pointer disabled:cursor-not-allowed"
        >
          <span v-if="loading">Saving...</span>
          <span v-else-if="saved">Saved</span>
          <span v-else>Save</span>
        </button>
      </nav>

      <!-- Route Content -->
      <router-view view-transition-name="page" v-slot="{ Component }">
        <transition>
          <component class="p-6" :is="Component" ref="viewRef" />
        </transition>
      </router-view>
    </div>

    <span class="wpnr-attribution block text-center mt-4 text-sm text-gray-500">
      Crafted with 💚 by Pixite
    </span>
  </div>
</template>

<style scoped>
.route-link {
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  text-decoration: none;
  color: #374151;
  transition: background 0.2s, color 0.2s;
}
.route-link.router-link-exact-active {
  background-color: #eef2ff;
  color: #1e40af;
}
</style>
