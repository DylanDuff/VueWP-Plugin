import { ref } from "vue";
import schema from "../../settings.json";

export function useSettings() {
  const prefix = schema.prefix.default;
  const defaults = {};
  for (const key in schema) {
    if (key !== "prefix") defaults[key] = schema[key].default;
  }

  const settings = ref({ ...defaults });
  const status = ref("");

  async function loadSettings() {
    try {
      const res = await fetch(
        `${VueOptionsData.ajax_url}?action=${prefix}get_settings&_ajax_nonce=${VueOptionsData.nonce}`
      );
      const json = await res.json();
      if (json.success) {
        Object.assign(settings.value, json.data.settings || {});
        status.value = "Settings loaded.";
      } else {
        status.value = "Failed to load settings.";
      }
    } catch (err) {
      status.value = "Error loading settings.";
      console.error(err);
    }
  }

  async function saveSettings() {
    try {
      const res = await fetch(
        `${VueOptionsData.ajax_url}?action=${prefix}save_settings&_ajax_nonce=${VueOptionsData.nonce}`,
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(settings.value),
        }
      );
      const json = await res.json();
      status.value = json.success ? "Settings saved." : "Failed to save.";
    } catch (err) {
      status.value = "Error saving settings.";
      console.error(err);
    }
  }

  return { settings, status, loadSettings, saveSettings };
}
