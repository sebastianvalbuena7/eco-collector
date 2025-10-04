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

### 1️⃣ Clonar el repositorio
```bash
git clone https://github.com/sebastianvalbuena7/eco-collector.git
cd eco-collector
