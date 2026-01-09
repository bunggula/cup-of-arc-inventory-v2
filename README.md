# 📦 Cup of Arc: Advanced Inventory Management System (v2)

A robust, web-based inventory solution designed to automate stock monitoring and shopping requirements for **Cup of Arc Cafe**. This system focuses on operational efficiency and real-time stock tracking to prevent business downtime.

## 🧠 System Architecture & Flow
Built on the **Laravel Framework**, the system follows the **Model-View-Controller (MVC)** design pattern. It uses **PHP** for core logic and database operations, while **Laravel Eloquent ORM** ensures seamless data handling.

The system flow monitors product levels in real-time. When an item hits the **"Low Stock Threshold,"** the system automatically triggers logic to include the item in the **Shopping List Module**, ensuring that supplies are replenished before they run out.

## ✨ Key Features
- **Automated Shopping List:** Intelligent logic that lists down supplies once they reach a predefined low-stock limit.
- **Real-time Inventory Monitoring:** Dynamic badges in the navigation menu reflect live database changes.
- **Modern Dark-Mode UI:** A sleek, professional aesthetic built with **Tailwind CSS**.
- **Interactive UX:** Powered by **Alpine.js** for seamless sidebar toggles and UI transitions without full-page refreshes.
- **Stock Threshold Alerts:** Visual indicators and automated counting for critical inventory levels.

## 🛠️ Tech Stack
- **Backend:** Laravel 11 (PHP 8.x)
- **Frontend:** Tailwind CSS (Styling), Alpine.js (Interactivity), Blade Templates
- **Database:** MySQL (Structured Inventory Data)
- **Pattern:** MVC (Model-View-Controller)
