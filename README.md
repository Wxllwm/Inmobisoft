# INMOBISOFT — Implementación en 3 Capas (Versión mínima)

## ¿Qué hace este proyecto?

Implementa el **CUS 1** del sistema INMOBISOFT:
- Formulario de **registro** con validación completa de la entidad Usuario
- Formulario de **login** con validación de credenciales
- **Dashboard** protegido (solo accesible con sesión activa)

## Instalación (XAMPP / WAMP)

1. Copia la carpeta `inmobisoft_minimo/` a `htdocs/`
2. Abre: `http://localhost/inmobisoft_minimo/public/`
3. No necesita MySQL ni configuración extra

## Credenciales de prueba

| Perfil      | Correo              | Contraseña   |
|-------------|---------------------|--------------|
| Arrendador  | arrendador@demo.pe  | 12345678Aa   |
| Inquilino   | inquilino@demo.pe   | 12345678Aa   |

## Estructura del proyecto (3 Capas MVC)

```
inmobisoft_minimo/
│
├── public/
│   └── index.php              ← ENTRADA ÚNICA (Front Controller)
│
├── core/                      ← NÚCLEO DEL FRAMEWORK
│   ├── Controlador.php        ← Clase base de controladores
│   └── Enrutador.php          ← Lee URL y ejecuta el controlador
│
├── config/
│   └── datos.php              ← Almacén de datos en sesión (simula BD)
│
└── app/
    ├── models/                ← CAPA MODELO (datos + validaciones)
    │   └── Usuario.php        ← Entidad con todas las reglas de negocio
    │
    ├── controllers/           ← CAPA CONTROLADOR (lógica de la app)
    │   ├── AuthControlador.php
    │   └── DashboardControlador.php
    │
    └── views/                 ← CAPA VISTA (HTML que ve el usuario)
        ├── layouts/
        │   └── cabecera.php
        ├── auth/
        │   ├── login.php
        │   └── registro.php
        └── dashboard/
            └── inicio.php
```

## Validaciones implementadas en la Entidad Usuario

| Campo      | Regla                                              |
|------------|----------------------------------------------------|
| nombre     | Obligatorio, 2-50 chars, solo letras               |
| apellido   | Obligatorio, 2-50 chars, solo letras               |
| email      | Formato válido, no repetido en el sistema          |
| telefono   | 9 dígitos numéricos, empieza con 9 (formato Perú)  |
| dni        | Exactamente 8 dígitos, no repetido en el sistema   |
| perfil     | Solo "arrendador" o "inquilino"                    |
| password   | Mín. 8 chars, al menos 1 mayúscula, 1 número       |
| password2  | Debe coincidir con password                        |
