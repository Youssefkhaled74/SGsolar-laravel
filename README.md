# 🌞 SgSolar - Solar Water Heater Portfolio Website

A modern, professional Laravel portfolio website for **SgSolar**, a company specializing in solar-powered water heating solutions.

---

## 🎯 Project Overview

**SgSolar** is a clean, static portfolio website built with Laravel, showcasing solar water heating products and services. The website is designed to be:

- **Clean & Professional** - Modern design with eco-friendly aesthetics
- **Fully Configurable** - All content managed from a single config file
- **Mobile Responsive** - Perfect experience on all devices
- **Static (No Database)** - Fast and lightweight

---

## 🎨 Brand Colors

### Primary Colors
- **Yellow**: `#FFDF41` - Energy, warmth, solar power
- **Orange**: `#E3A000` - Action, enthusiasm
- **Dark Green**: `#0C2D1C` - Nature, sustainability
- **Forest Green**: `#115F45` - Growth, reliability
- **Light Green**: `#8CC63F` - Eco-friendly, fresh

### Gradients
- **Yellow-Orange**: Linear gradient from Yellow to Orange
- **Green Gradient**: Linear gradient from Light Green to Forest Green

---

## 📁 Project Structure

```
sgsolar/
├── app/Http/Controllers/       # All page controllers
├── config/website.php          # 🎯 Single source of truth
├── resources/
│   ├── views/
│   │   ├── layouts/           # Main layout
│   │   ├── components/        # Reusable components
│   │   └── pages/             # All pages
│   └── scss/_variables.scss   # SCSS variables
├── public/
│   ├── css/style.css          # Complete styling
│   └── png/                   # All images
└── routes/web.php             # Routes
```

---

## 🚀 Quick Start

1. **Install Dependencies**
   ```bash
   composer install
   ```

2. **Setup Environment**
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

3. **Start Server**
   ```bash
   php artisan serve
   ```

4. **Visit**: `http://localhost:8000`

---

## 📄 Pages

- **Home** (`/`) - Hero, products, why solar, why SgSolar
- **About** (`/about`) - Mission, story, technology, benefits
- **Products** (`/products`) - Full product catalog
- **Services** (`/services`) - Installation, maintenance, consultation
- **Gallery** (`/gallery`) - Project photos, statistics
- **Contact** (`/contact`) - Contact form and information

---

## ⚙️ Configuration

All content in **`config/website.php`**:

✅ Company info (name, logo, slogan)  
✅ Contact details (phone, WhatsApp, email)  
✅ Brand colors  
✅ Products & services  
✅ Gallery images  
✅ Navigation & footer  

### Example:
```php
'name' => 'SgSolar',
'primary_color' => '#FFDF41',
'products' => [...],
```

---

## 🎨 Components

- `<x-navbar />` - Navigation
- `<x-footer />` - Footer
- `<x-logo />` - Company logo
- `<x-hero />` - Hero section
- `<x-product-card :product="$product" />` - Product card
- `<x-section-title title="..." />` - Section headers

---

## 🌟 Features

✅ Fully responsive design  
✅ No database required  
✅ Easy content management  
✅ Mobile navigation  
✅ Image gallery with lightbox  
✅ WhatsApp integration  
✅ Contact form  
✅ SEO-friendly  
✅ Fast loading  

---

## 🚀 Deployment

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Set in `.env`:
```
APP_ENV=production
APP_DEBUG=false
```

---

## 📧 Contact

- Email: info@sgsolar.com
- Phone: +20 123 456 7890
- WhatsApp: +20 123 456 7890

---

## 📄 License

© 2025 SgSolar. All rights reserved.

---

**Built with Laravel 11 - Powering the future with clean solar energy! ☀️**
