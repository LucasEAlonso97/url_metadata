# URL Preview Tool

Simple web app that takes a URL and generates a rich preview card (like WhatsApp or Slack).

## 🚀 Features

- Extracts:
  - Title
  - Description
  - Image (Open Graph)
  - Favicon
- YouTube embed support
- Clean UI with basic animations
- Handles real HTTP requests and errors

## 🧠 How it works

1. User submits a URL  
2. The app fetches the HTML  
3. It parses metadata using regex  
4. Renders a preview card  

## 🛠 Tech Stack

- PHP
- Laravel
- TailwindCSS

## 📸 Preview

*(add a screenshot acá si querés)*

## ⚠️ Notes

- Some websites may block requests
- Metadata depends on the target site's HTML

---

Built as a small project to practice backend + real-world data parsing.