# Graphical Abstract Plugin for OJS

This plugin adds a **Graphical Abstract** tab to the submission workflow in **Open Journal Systems (OJS)**. It allows authors and editors to upload graphical abstracts during the submission or editing process — with **no core modifications** required.

---

## 📦 Features

- Adds a new tab in the submission workflow for uploading a graphical abstract.
- Supports image preview and replacement.
- Validates file type (JPEG/PNG).
- Available in **English** and **Hindi**.
- Works with the standard OJS plugin architecture.

---

## 🚀 Installation

1. Download the latest release from the [Releases](https://github.com/yourusername/ojs-graphical-abstract-plugin/releases).
2. Extract the folder and rename it to `graphicalAbstract`.
3. Place it into the `plugins/generic/` directory of your OJS installation.
4. Enable the plugin via **Dashboard > Website Settings > Plugins**.

---

## 🌐 Localization

- `locale/en_US/locale.po`: English
- `locale/hi_IN/locale.po`: Hindi

You can add additional language files as needed.

---

## 🛠️ Development

To modify or extend:
- PHP logic is in `GraphicalAbstractPlugin.inc.php` and `GraphicalAbstractTabHandler.inc.php`.
- UI Template is `templates/tab.tpl`.

The plugin uses OJS hooks to inject itself into the workflow, keeping the core untouched.

---

## 🧪 Tested On

- OJS version: **3.3.x - 3.4.x**

---

## 📄 License

GNU General Public License v3. See `docs/COPYING` in your OJS install for more.

---

## 🙌 Credits

Developed with ❤️ for journals needing a streamlined visual abstract system.
