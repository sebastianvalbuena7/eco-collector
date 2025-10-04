# 🌱 Eco Collector

**Eco Collector** es una aplicación web desarrollada con **Laravel 12** que permite a los usuarios registrar, programar y hacer seguimiento de sus **recolecciones de residuos**, promoviendo hábitos sostenibles y el cuidado del medio ambiente.  
Incluye autenticación, panel de usuario, estadísticas y generación de reportes en PDF.

---

## 🚀 Características principales

- ✅ **Autenticación completa** (registro, login, logout)
- ♻️ **Gestión de recolecciones:**
  - Crear, editar y eliminar recolecciones
  - Visualizar próximas fechas y tipos de residuos
- 📊 **Reportes personalizados:**
  - Estadísticas de reciclaje por usuario
  - Impacto ambiental estimado (CO₂ evitado, energía ahorrada, árboles equivalentes)
  - Exportación a **PDF**
- 🔐 **Control de acceso por sesión**:
  - Redirección automática a `/dashboard` si el usuario ya inició sesión
- 🖼️ Interfaz sencilla y responsiva (Blade + Bootstrap)

---

## 🧩 Tecnologías utilizadas

| Componente | Versión / Descripción |
|-------------|----------------------|
| **Laravel** | 12.32.5 |
| **PHP** | 8.2.12 |
| **Base de datos** | MySQL |
| **Frontend** | Blade Templates + Bootstrap 5 |
| **PDF** | barryvdh/laravel-dompdf |
| **Autenticación** | Laravel Breeze / Auth |
| **ORM** | Eloquent |

---

## ⚙️ Instalación y configuración
🧩 Requisitos previos
- PHP 8.2 o superior
- Composer
- XAMPP (o cualquier servidor con MySQL)

⚙️ Configuración del entorno
1️⃣ Clonar el repositorio
git clone https://github.com/sebastianvalbuena7/eco-collector.git
cd eco-collector

2️⃣ Instalar dependencias
composer install
npm install
npm run build   # o npm run dev si estás en modo desarrollo

3️⃣ Crear el archivo .env

Copia el archivo de ejemplo:
.env

4️⃣ Configurar la base de datos

Abre XAMPP y asegúrate de que MySQL esté ejecutándose.

En http://localhost/phpmyadmin
, crea una base de datos llamada:

eco_collect


Abre el archivo .env y configura las variables así:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eco_collect
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file

5️⃣ Generar la key de la aplicación
php artisan key:generate

6️⃣ Ejecutar las migraciones

Esto creará todas las tablas necesarias en la base de datos:

php artisan migrate

7️⃣ Iniciar el servidor
php artisan serve


Luego abre en tu navegador:
👉 http://127.0.0.1:8000
