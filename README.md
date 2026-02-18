# BalearTrek API

· Base de datos 
· API REST 
· Seeders 
· Triggers 
· Autenticación

BalearTrek es una plataforma dedicada a la gestión de **excursiones (treks), encuentros (meetings), usuarios, lugares interesantes y comentarios**.


## 1. Configuración necesaria (JSON de seeders)

Los seeders leen los JSON desde una ruta interna del proyecto:

```
database/seeders/data/
```


## 2. Cómo cargan los seeders los JSON

```php
$jsonData = File::get(database_path('seeders/data/treks.json'));
$data = json_decode($jsonData, true);
```


## 3. Instalación y ejecución del proyecto

```bash
composer install
cp .env.example .env
php artisan migrate:fresh --seed
php artisan serve
```


## 4. Capa de datos (modelo, migraciones, seeders y triggers)

### Migraciones
- users, roles  
- treks  
- meetings  
- comments  
- images  
- place_types, places, place_trek  
- municipalities, islands, zones  
- meeting_user (pivot)

### Seeders
Orden ejecutado por `DatabaseSeeder`:

1. RoleSeeder  
2. IslandSeeder  
3. ZoneSeeder  
4. MunicipalitySeeder  
5. UserSeeder (admin + guías JSON)  
6. TrekSeeder  
7. PlaceSeeder  
8. UserFactory (100 visitants)  
9. MeetingUserSeeder  
10. ImageFactory (1000 imágenes)

### Factories
- UserFactory  
- ImageFactory  

### Modelos y relaciones
Relaciones 1:N y N:N definidas según el modelo ER del proyecto.

### Triggers sobre `comments`
Actualizan:
- meetings.totalScore  
- meetings.countScore  

### Triggers sobre `meetings`
Actualizan:
- treks.totalScore  
- treks.countScore  


## 5. Estructura esperada de los JSON

### users.json
```json
{
  "usuaris": {
    "usuari": [
      { "nom": "...", "llinatges": "...", "dni": "...", "telefon": "...", "email": "...", "password": "..." }
    ]
  }
}
```

### municipalities.json
Tres formatos posibles.

### treks.json
Incluye treks, meetings y comments.

### places.json
Incluye place_types, interesting_places y place_trek.


## 6. API REST

### Autenticación
- **Por credenciales**: register, login, logout (Sanctum).
- **Por API-KEY**: header `API-KEY` con el valor de `APP_KEY`.

### Middlewares
- `auth.or.api.key` (Sanctum o API-KEY).
- `check.role.admin` (solo administradores).

### Route model binding personalizado
- **Users**: `{user}` acepta **ID** o **email**.
- **Treks**: `{trek}` acepta **ID** o **regNumber**.

### Requests y Resources
- Requests: `UserUpdateRequest`, `UserDestroyRequest`, `TrekStoreRequest`, `LoginRequest`.
- Resources: `UserResource`, `UserSummaryResource`, `TrekResource`, `MeetingResource`, `CommentResource`,
  `MunicipalityResource`, `PlaceTypeResource`, `InterestingPlaceResource`.


## 7. Endpoints principales

Base URL típica: `http://127.0.0.1:8000/api`

### Autenticación
- `POST /register`
- `POST /login`
- `POST /logout` (protegido)

### Usuarios
- `GET /users` (admin)
- `GET /users/{user}` (admin)
- `PUT /users/{user}` (admin)
- `DELETE /users/{user}` (admin o propio)
- `GET /user` (usuario autenticado)
- `PUT /user` (usuario autenticado)
- `DELETE /user` (usuario autenticado)

### Treks
- `GET /treks`
- `GET /treks/{trek}`
- `POST /treks` (admin)


## 8. Mini documentación de uso

### Autenticación con token Sanctum
1. `POST /login`
2. Usar `Authorization: Bearer <token>` en las rutas protegidas.

### Autenticación con API-KEY
En cualquier ruta protegida, enviar:
```
API-KEY: <APP_KEY>
```

### Filtros
- `GET /treks?illa=Mallorca` o `GET /treks?island_id=1`

### Updates parciales de usuario
`PUT /user` acepta solo los campos que quieras modificar.