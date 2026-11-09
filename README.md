# The Valley Indian — WordPress Block Theme

> **Independent. Inclusive. Community first.**  
> A refined editorial community news theme for Clark County Indian Community, built with modern semantic HTML and SCSS design system for WordPress Full Site Editing (FSE).

---

## ⚡ Live Demo (WordPress Playground)

Launch the theme in a fully functional WordPress instance directly in your browser (no server or setup required):

👉 **[Open Live Demo in WordPress Playground](https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/rehanlodhi/valley-indian/main/blueprint.json)**

---

## 📁 Theme Structure

```
valley-indian/
├── assets/
│   ├── css/                   # Compiled stylesheet & source maps
│   ├── js/                    # Theme JavaScript (desk, modal, toasts, search)
│   └── scss/                  # Modular SCSS design system
├── inc/
│   ├── post-types.php         # Custom post types: Events & Directory Listings
│   ├── taxonomies.php         # Custom taxonomies: Event Categories & Listing Types
│   ├── submission-handler.php # Story & event submission endpoint
│   └── seeder.php             # Automated demo data seeder
├── parts/
│   ├── header.html            # Site header template part
│   └── footer.html            # Site footer template part
├── patterns/                  # Gutenberg Block Patterns (Hero, Grids, Forms, Pages)
├── templates/                 # Block templates (front-page, single, page, archive, etc.)
├── dummy-content.xml          # Full sample content export
├── functions.php              # Theme initialization & asset enqueuing
├── style.css                  # Theme header & master stylesheet
├── theme.json                 # FSE design tokens, typography, and palette presets
└── blueprint.json             # WordPress Playground configuration
```

---

## 🚀 Features

- **Full Site Editing (FSE)**: Block templates and block patterns for all key pages.
- **Automated Data Seeder**: Built-in sample content generation for instant demonstrations (`valley_indian_seed_data()`).
- **Interactive Newsroom Desk**: Dedicated editor queue and story review workflow.
- **Community Calendar & Directory**: Custom post types with date badging and category filters.
- **Story Submission Form**: Public submissions that route into WordPress's pending review queue.
- **Design System**: Georgia serif headings, warm newsprint palette (`#f8f6ef`), terracotta accents (`#ba4c2c`), and dark emerald ink (`#183c39`).

---

## 📄 License

GPL v2 or later.
