# Sistema de Gestión de Prácticas Preprofesionales — Frontend

**Integrantes / Autores:**
- **Quijije Camacho Russell Jordy** — Módulo: Evaluaciones y Documentos
- **Sánchez Mosquera Stin Josue** — Módulos: Estudiantes y Asignación / Reportes y Validación Institucional  
**Materia:** Desarrollo Web — 7mo Semestre  
**Universidad de Guayaquil**

## Módulos Desarrollados

### 1. Evaluaciones y Documentos (Quijije Camacho Russell Jordy)
- **Evaluaciones de Tutores (Rúbricas Oficiales UG):**
  - Listado de evaluaciones (`pages/evaluaciones-listado.html`) con filtros dinámicos, ponderación (50% Tutor Académico / 50% Tutor Empresarial) y modal con desglose de notas.
  - Rúbrica interactiva (`pages/evaluaciones-rubrica.html`) con cálculo en tiempo real de calificaciones /10, niveles de logro (Sobresaliente, Muy Bueno, Aprobado, Reprobado), soporte de impresión nativa y firma electrónica.
- **Informes Parciales y Final (`pages/informes-gestion.html`):**
  - Gestión integral de entregas para Informe Parcial 1 (80h), Informe Parcial 2 (160h) e Informe Final (240h).
  - Modal de revisión del tutor (aprobación / dictamen con observaciones y calificación) y formulario modal para registrar/entregar nuevos informes con adjunto.
- **Carga de Archivos y Repositorio Digital (`pages/documentos-carga.html`):**
  - Carga interactiva con zona Drag & Drop para documentos obligatorios (Carta de aceptación, Carta de compromiso, Informes, Rúbricas y Certificados).
  - Barra de progreso del expediente del estudiante (ej. 86% completado) y checklist de requisitos verificados.
  - Repositorio digital con previsualización de documentos, estado de validación y descarga.
- **Plantillas Descargables (`pages/plantillas-descargables.html`):**
  - Catálogo de formatos institucionales oficiales UG (`UG-FPP-01` a `UG-FPP-09` y Guías).
  - Filtros por categoría y formato (.docx, .xlsx, .pdf), modales de previsualización de estructura y descarga directa de plantillas.

### 2. Estudiantes y Asignación (Sánchez Mosquera Stin Josue)
- Registro de estudiantes (carrera, nivel, requisitos)
- Postulación a vacantes
- Asignación de empresa y tutores
- Estado de la práctica
- Cambios y reasignaciones

### 3. Reportes y Validación Institucional (Sánchez Mosquera Stin Josue)
- Dashboard por rol
- Reportes (por carrera, empresa, estudiante)
- Exportar PDF / Excel
- Validación final del coordinador
- Certificado de cumplimiento
- Notificaciones por correo

## Tecnologías
- HTML5 semántico
- Bootstrap 5.3 (CDN)
- Bootstrap Icons
- CSS custom con variables
- JavaScript vanilla

## Estructura
```
├── index.html          ← Login
├── pages/              ← Todas las vistas
├── assets/css/         ← Estilos
├── assets/js/          ← Scripts
├── Dockerfile          ← Docker config
└── compose.yaml
```

## Ejecutar
Abrir `index.html` en el navegador o servir con Docker / Live Server.
