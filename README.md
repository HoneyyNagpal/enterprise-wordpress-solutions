# Enterprise WordPress Solutions

A custom enterprise-grade WordPress theme built to demonstrate scalable CMS architecture, secure data handling, and extensibility using WordPress core APIs.

---

## 🚀 Features

- Custom WordPress theme developed from scratch
- Custom Post Type (CPT): **Services**
- ACF-like custom meta boxes built **without plugins**
  - Client Name
  - Tech Stack
  - Project Duration
- Secure data handling
  - Nonce verification (CSRF protection)
  - Input sanitization
  - Safe output escaping
- REST API endpoints for headless CMS usage
- Performance optimizations (proper asset loading, emoji removal)

---

## 🛠 Tech Stack

- PHP
- WordPress Core
- MySQL
- REST API
- HTML5
- CSS3
- Git

---


---

## ⚙️ Setup Instructions (Local)

1. Install **LocalWP**
2. Create a new WordPress site
3. Copy this theme into: wp-content/themes/
4. Activate **Enterprise WordPress Solutions** from: WP Admin → Appearance → Themes

---

## 🧪 Testing Features

### Services (CPT)
- WP Admin → Services → Add New
- Add service content and custom metadata
- Publish and view on frontend

### REST API
Access services data via: /wp-json/enterprise/v1/services

---

## 🔐 Security Practices Implemented

- CSRF protection using WordPress nonces
- Sanitization of all user input before database storage
- Escaping output before rendering on frontend
- Permission and autosave checks

---

## 📌 Purpose

This project focuses on **backend WordPress engineering** and CMS design principles rather than UI styling.  
It is intended to demonstrate production-ready WordPress development skills suitable for internships and junior roles.

---

## 👤 Author

**Honey Nagpal**






