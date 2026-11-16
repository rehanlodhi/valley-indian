# Vegas Indian Pulse — WordPress Block Theme (`valley-indian`)

> **Many roots. One community.**
> Editorial news, events, and local business directory block theme for Clark County’s Indian community, built with WordPress Full Site Editing (FSE) and modular SCSS.

---

## 📁 Theme Structure

```
valley-indian/
├── assets/
│   ├── css/                   # Compiled stylesheet & source maps
│   ├── images/                # Vegas Indian Pulse logo & icon (.webp)
│   ├── js/                    # Filtering, submissions, and editor desk helper
│   └── scss/                  # Modular SCSS design system
├── inc/
│   ├── post-types.php         # Event, Directory Listing, private Subscriber/Inquiry CPTs
│   ├── taxonomies.php         # Area & Directory Category taxonomies
│   ├── submission-handler.php # REST API validation & authenticated desk moderation
│   └── seeder.php             # Automated sample data seeder
├── parts/                     # Header and footer template parts
├── patterns/                  # Reusable FSE block patterns
├── templates/                 # FSE block templates (front-page, page, single, archive)
├── functions.php              # Theme setup, asset enqueue, query & block enhancements
├── style.css                  # Compiled WordPress stylesheet
└── theme.json                 # FSE color palette, typography, and layout presets
```

---

## 🎨 Design System

- **Palette:** Cream canvas (`#faf7ef`), midnight charcoal (`#060b14`), deep navy ink (`#111b25`), gold (`#edba46`), civic teal (`#007b70`), and saffron (`#ce580b`).
- **Typography:** `Georgia` serif headings (`clamp(32px, 4.3vw, 58px)` H1) paired with `system-ui` 16px body copy.

---

## 📄 License

GPL v2 or later.
