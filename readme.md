# Vue Options Plugin for WordPress

A boilerplate WordPress plugin with a Vue.js-powered options page.

---

## 🔧 Features

- Vue 3 SPA for WP Admin settings page
- Built with Vite
- Clean separation of concerns (`vue-src/` for Vue, `dist/` for output)
- Custom admin menu in the WP sidebar

---

## 🏗️ Project Structure

```
vue-options-plugin/
├── vue-options-plugin.php       # Main WP plugin file
├── vite.config.js               # Vite build config
├── package.json                 # NPM scripts and deps
├── dist/                        # Compiled JS/CSS (auto-generated)
├── assets/                      # Static assets like icons
└── vue-src/                     # Vue app source
    ├── App.vue
    ├── main.js
    └── components/
```

---

## 🚀 Getting Started

### 1. Install dependencies

```bash
npm install
```

### 2. Build Vue app

```bash
npm run build
```

> Output goes to `dist/`, loaded automatically in WP admin

### 3. Activate Plugin

Copy or symlink this folder to `wp-content/plugins/`, then activate it in the WordPress admin panel.

---

## 🛠️ Development Workflow

Keep source files in `vue-src/`, then run:

```bash
npm run build
```

To rebuild after changes.

---

## 📌 To Do

- Add persistent settings via `wp_options` and `admin-ajax.php`
- Add dev server with proxy for hot module reload (HMR)

---

## 🧪 Tested With

- WordPress 6.x
- Node 18+
- Vite 6+
- Vue 3.x
