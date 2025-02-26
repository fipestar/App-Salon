# 🏥 Plataforma de Gestión de Citas

![PHP](https://img.shields.io/badge/PHP-8.0%2B-blue) 
![MySQL](https://img.shields.io/badge/MySQL-Database-orange) 
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-yellow) 
![Sass](https://img.shields.io/badge/Sass-CSS%20Preprocessor-pink) 

Plataforma web para la gestión de citas en negocios de servicios. Permite a los usuarios registrarse, iniciar sesión, seleccionar servicios y programar citas, mientras que los administradores pueden gestionar clientes y servicios desde un panel de administración.

---

## 🚀 Características Principales

✅ **Autenticación y Seguridad**
- Registro de usuarios con confirmación por correo (PHPMailer).
- Inicio de sesión y recuperación de contraseña con validaciones.
- Protección de rutas y acceso según roles (usuarios y administradores).

✅ **Gestión de Citas**
- Selección de servicios desde una API y validación de disponibilidad.
- Resumen de cita con datos del usuario y total a pagar.
- Almacenamiento de citas en la base de datos con relación a servicios.

✅ **Panel de Administración**
- Gestión de citas con búsqueda y filtrado por fecha.
- Creación, actualización y eliminación de servicios.
- Cálculo del total a pagar por cada cita.

✅ **Interfaz Dinámica y API REST**
- Navegación por pestañas (tabs) para mejorar la experiencia del usuario.
- Consumo de API con Fetch y manejo asíncrono con Async/Await.
- Alertas dinámicas con SweetAlert para mejor interacción.

✅ **Seguridad y Optimización**
- Validación en frontend y backend para evitar datos incorrectos.
- Protección de rutas en PHP para impedir accesos no autorizados.
- Uso de sesiones para la autenticación y control de usuarios.

---

## 🛠️ Tecnologías Utilizadas

| Tecnología | Descripción |
|------------|-------------|
| **PHP (POO)** | Lógica de negocio, autenticación y API |
| **MySQL** | Base de datos para almacenar usuarios, citas y servicios |
| **JavaScript (ES6)** | Dinamismo en el frontend y consumo de API |
| **Sass (CSS Preprocesador)** | Diseño modular y optimizado |
| **PHPMailer** | Envío de correos electrónicos (confirmación, recuperación) |
| **SweetAlert** | Alertas y notificaciones interactivas |

---

