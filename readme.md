# WP Notification Relay

A lightweight WordPress plugin to relay push notifications to a custom webhook when posts are published. Perfect for integrating with notification services, Slack, Discord, or custom systems.

---

## 🔧 Features

- 🔔 **Automatic Notifications** on post publish
- ✍️ **Custom Templates** for title and message with dynamic variables
- 🎯 **Per-Post-Type Control** for which types trigger notifications
- 👥 **Role-Based Permissions** to restrict who can send
- ⏱️ **Optional Delay** before notifications are sent
- 🚦 **Rate Limiting** to avoid flooding your webhook
- 🧪 **Test Mode** to simulate notifications during setup
- 🧪 **Send Test Notification** to verify configuration instantly
- 📦 **Built-in Logging** of webhook success/failure

---

## 🧹 Setup & Configuration

After activating the plugin, go to:

**WordPress Dashboard → Settings → Notification Relay**

You’ll see four tabs:

### 1. **Monitor**

- Toggle to globally enable or disable webhook notifications.

### 2. **Connection**

- Enter your Webhook URL and Secret.

### 3. **Content**

- ✅ Choose post types that trigger notifications (Post, Page, Product, Event, etc.)
- ✏️ Define title/message templates using smart tags:

  - `{{title}}`, `{{excerpt}}`, `{{slug}}`, `{{author}}`, `{{category}}`, `{{date}}`

- 🧪 Send a test notification to verify your setup.

### 4. **Advanced**

- 🕒 Enable delay before sending notifications
- 👤 Restrict sending to specific user roles (Administrator, Editor, etc.)
- 🚥 Set a maximum number of notifications per hour
- 🧪 Enable Test Mode (notifications will not be sent to users)

---

## 📤 Test Notification

Use the **Send Test Notification** button to simulate a post and trigger a real webhook. A dummy payload with placeholder data will be sent.

You’ll see success/error feedback depending on the response from your webhook endpoint.

---

## 📄 Payload Structure

Example payload sent to your webhook:

```json
{
  "action": "post_published",
  "post": {
    "id": 123,
    "title": { "rendered": "Post Title" },
    "excerpt": { "rendered": "Post Excerpt" },
    "slug": "post-title",
    "date": "2025-06-14T10:00:00+00:00",
    "categories": [1, 2],
    "_embedded": {
      "wp:term": [[{ "name": "News", "slug": "news" }]],
      "wp:featuredmedia": [{ "source_url": "https://example.com/image.jpg" }]
    }
  },
  "notification": {
    "title": "New News post: Post Title by Author",
    "message": "Post Excerpt (Posted on June 14, 2025)"
  }
}
```

---

## ⚠️ Error Logging

If a webhook call fails, the error is:

- Logged via `error_log`
- Saved to the WordPress options table under `vue_plugin_webhook_error`
- Displayed as an admin notice on the dashboard
- Saved in a rotating webhook log (up to 50 entries)

---

## 🧪 Developer Notes

- Notifications are sent on the `transition_post_status` hook.
- Webhook calls are made using `wp_remote_post`.
- Delayed notifications (if enabled) are scheduled with `wp_schedule_single_event`.

---

## ✅ Requirements

- WordPress 5.0+
- PHP 7.4+

---

## 🚀 Roadmap

- ✅ Add test mode
- ✅ Add rate limiting
- ✅ View logs in the UI
- ⏳ Optional retry logic
- ⏳ Support for other trigger types
- ⏳ Manual notifications

---
