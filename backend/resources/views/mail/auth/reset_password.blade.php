<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .button {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            background: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Hola, {{ $user->name }}</h2>
    <p>Recibimos una solicitud para restablecer tu contraseña.</p>
    <p>Haz clic en el siguiente enlace para cambiar tu contraseña:</p>
    <a href="{{ $resetUrl }}" class="button">Restablecer Contraseña</a>
    <p>Si no solicitaste este cambio, ignora este mensaje.</p>
    <p>Gracias,<br>El equipo de {{ config('app.name') }}</p>
</body>
</html>
