📌 Proyecto Vue + Laravel

Este proyecto está dividido en dos carpetas: backend (Laravel) y frontend (Vue). Cada una tiene su propio archivo .env.example que se puede copiar para configurar las variables de entorno.

📂 Estructura del Proyecto

Proyecto/
│-- backend/      # Laravel API
│   │-- .env.example
│   │-- migrations/
│   │-- routes/
│   │-- app/
│-- frontend/     # Vue.js Frontend
│   │-- .env.example
│   │-- src/
│   │-- public/
│-- README.md     # Documentación

🚀 Instalación

🛠 Backend (Laravel)

Ir a la carpeta del backend:

cd backend

Instalar dependencias:

composer install

Copiar archivo de entorno:

cp .env.example .env

Generar clave de la aplicación:

php artisan key:generate

Ejecutar migraciones:

php artisan migrate

Iniciar el servidor:

php artisan serve

🎨 Frontend (Vue)

Ir a la carpeta del frontend:

cd frontend

Instalar dependencias:

npm install

Iniciar el servidor de desarrollo:

npm run dev

📝 Notas

Asegúrate de que la API de Laravel esté corriendo antes de probar el frontend.

Configura correctamente las variables de entorno en ambos .env según tus necesidades.

Si utilizas bases de datos, verifica la configuración en config/database.php.

📢 Contribuciones y mejoras son bienvenidas 🎉