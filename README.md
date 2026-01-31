# MotoCRUD API

![PHP Version](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)
![Symfony](https://img.shields.io/badge/Symfony-6.4-000000?logo=symfony)
![API Platform](https://img.shields.io/badge/API%20Platform-4.2-38A3A5)
![MySQL](https://img.shields.io/badge/MySQL-8.4-4479A1?logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Latest-2496ED?logo=docker&logoColor=white)
![Tests](https://img.shields.io/badge/Tests-PHPUnit-3178C6)

API REST para la gestión de motocicletas (CRUD completo) construida con Symfony 6.4 y API Platform 4.2.

## 📑 Tabla de contenidos

- [Requisitos previos](#-requisitos-previos)
- [Instalación](#-instalación)
- [Ejecutar tests](#-ejecutar-tests)
- [Uso de la API](#-uso-de-la-api)
  - [Endpoints disponibles](#endpoints-disponibles)
  - [Ejemplos de uso](#ejemplos-de-uso)
  - [Estructura de datos](#estructura-de-datos)
- [Comandos disponibles](#️-comandos-disponibles)
- [Arquitectura técnica](#️-arquitectura-técnica)
- [Licencia](#-licencia)
- [Autor](#-autor)

## 📋 Requisitos previos

- [Docker](https://docs.docker.com/get-docker/) (versión 20.10 o superior)
  - Docker Compose viene incluido con Docker Desktop
  - Si usas Docker Engine standalone, instala [Docker Compose Plugin](https://docs.docker.com/compose/install/linux/)
- [Make](https://www.gnu.org/software/make/)

## 🚀 Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/Pagorn07/MotoCrudAPI.git
cd motocrudapi
```

### 2. Inicializar el proyecto

Este comando creará los contenedores de Docker e instalará las dependencias de Symfony:
```bash
make init-project
```

### 3. Crear el esquema de la base de datos

Este comando crea la base de datos principal, ejecuta las migraciones y configura la base de datos de testing:
```bash
make update-database-schema
```

### 4. Cargar datos de prueba (opcional)

Para poblar la base de datos con algunas motocicletas de ejemplo:
```bash
make load-fixtures-data
```

### 5. Iniciar el servidor
```bash
make start
```

La API estará disponible en: **http://localhost:8081/api**

## 🧪 Ejecutar tests

Para ejecutar la suite de tests con PHPUnit:
```bash
make test
```

Los tests incluyen:
- Pruebas de CRUD completo (GET, POST, PATCH, DELETE)
- Validaciones de campos
- Verificación de inmutabilidad del campo `limitedEdition`
- Actualización automática de timestamps

**Nota:** Durante los tests de validación, es normal ver mensajes de `ValidationException` en la consola. Estos indican que las validaciones están funcionando correctamente y API Platform las convierte en respuestas HTTP 422.

## 📚 Uso de la API

### Endpoints disponibles

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/motorcycles` | Listar todas las motocicletas |
| GET | `/api/motorcycles/{id}` | Obtener una motocicleta específica |
| POST | `/api/motorcycles` | Crear una nueva motocicleta |
| PATCH | `/api/motorcycles/{id}` | Actualizar una motocicleta |
| DELETE | `/api/motorcycles/{id}` | Eliminar una motocicleta |

### Ejemplos de uso

#### Listar motocicletas
```bash
curl http://localhost:8081/api/motorcycles
```

#### Crear una motocicleta
```bash
curl -X POST http://localhost:8081/api/motorcycles \
  -H "Content-Type: application/json" \
  -d '{
    "model": "Ninja 650",
    "engineCapacity": 650,
    "brand": "Kawasaki",
    "type": "Deportiva",
    "extras": ["ABS", "Control de tracción"],
    "weight": 193,
    "limitedEdition": false
  }'
```

#### Actualizar una motocicleta
```bash
curl -X PATCH http://localhost:8081/api/motorcycles/1 \
  -H "Content-Type: application/merge-patch+json" \
  -d '{
    "model": "Ninja 650 SE"
  }'
```

#### Eliminar una motocicleta
```bash
curl -X DELETE http://localhost:8081/api/motorcycles/1
```

### Estructura de datos

#### Motorcycle

| Campo | Tipo | Requerido | Validaciones | Descripción |
|-------|------|-----------|--------------|-------------|
| `model` | string | Sí | Máx. 50 caracteres | Modelo de la motocicleta |
| `engineCapacity` | integer | Sí | - | Cilindrada en cc |
| `brand` | string | Sí | Máx. 40 caracteres | Marca de la motocicleta |
| `type` | string | Sí | Máx. 50 caracteres | Tipo (Naked, Custom, Classic, etc.) |
| `extras` | array | Sí | Máx. 20 elementos, cada uno string | Extras y equipamiento |
| `weight` | integer | No | - | Peso en kg |
| `limitedEdition` | boolean | Sí (solo al crear) | - | Indica si es edición limitada |
| `createdAt` | datetime | Auto | - | Fecha de creación |
| `updatedAt` | datetime | Auto | - | Fecha de última actualización |

**Importante:** El campo `limitedEdition` solo puede establecerse al crear la motocicleta. Una vez creada, este campo no puede modificarse.

## 🛠️ Comandos disponibles

| Comando | Descripción |
|---------|-------------|
| `make init-project` | Inicializa el proyecto (contenedores + dependencias) |
| `make update-database-schema` | Crea y actualiza el esquema de la base de datos |
| `make load-fixtures-data` | Carga datos de prueba en la base de datos |
| `make start` | Inicia los contenedores de Docker |
| `make stop` | Detiene los contenedores |
| `make test` | Ejecuta los tests con PHPUnit |
| `make clean` | Elimina los contenedores |
| `make clean-all` | Elimina contenedores, volúmenes e imágenes |
| `make logs` | Muestra los logs de los contenedores |
| `make shell-php` | Accede al contenedor PHP |
| `make shell-db` | Accede al cliente MySQL |

## 🏗️ Arquitectura técnica

### Stack principal
- **Lenguaje:** PHP 8.2
- **Framework:** Symfony 6.4
- **API:** API Platform 4.2
- **Base de datos:** MySQL 8.4
- **ORM:** Doctrine

### Testing
- **Framework de tests:** PHPUnit
- **Fixtures:** Doctrine Fixtures Bundle
- **Factory:** Zenstruck Foundry

### Infraestructura
- **Containerización:** Docker & Docker Compose
- **Automatización:** Makefile

## 📄 Licencia

MIT License - Copyright © 2026 Pablo Arbós Jiménez

Este proyecto puede ser utilizado libremente con atribución al autor.


## 👤 Autor

**Pablo Arbós Jiménez**

- GitHub: [@Pagorn07](https://github.com/Pagorn07)
- LinkedIn: [Pablo Arbós Jiménez](https://www.linkedin.com/in/pablo-arb%C3%B3s-jim%C3%A9nez-12624217a/)
- Email: pabloarbos1993@gmail.com

## 🤝 Contribuciones

Este es un proyecto personal de portfolio. Si encuentras algún bug o tienes sugerencias, no dudes en abrir un issue.

---

⭐ Si este proyecto te resulta útil, ¡dale una estrella en GitHub!