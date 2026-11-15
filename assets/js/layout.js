/**
 * Layout Component — Sidebar + Topbar
 * Genera dinámicamente el sidebar y topbar para evitar duplicación.
 * Cada página indica su ID activo con <body data-page="...">.
 */

(function () {
  'use strict';

  // Detectar profundidad de ruta para enlaces relativos
  const isRoot = !window.location.pathname.includes('/pages/');
  const P = isRoot ? 'pages/' : ''; // prefijo de ruta a páginas
  const A = isRoot ? '' : '../';     // prefijo de ruta a assets/root

  // ───── SIDEBAR HTML ─────
  const sidebarHTML = `
    <div class="sidebar-brand">
      <i class="bi bi-mortarboard-fill"></i>
      <h5>Gestión de Prácticas<br><small class="fw-normal" style="font-size:.7rem;color:#a8b0c5;">Preprofesionales</small></h5>
    </div>

    <div class="sidebar-menu">

      <!-- ══════ MÓDULO 1: ESTUDIANTES Y ASIGNACIÓN ══════ -->
      <div class="menu-header">Estudiantes y Asignación</div>

      <!-- Estudiantes -->
      <a class="nav-link collapse-toggle" data-bs-toggle="collapse" href="#menuEstudiantes" role="button" aria-expanded="false" aria-controls="menuEstudiantes">
        <i class="bi bi-people-fill"></i> Estudiantes
      </a>
      <div class="collapse sidebar-submenu" id="menuEstudiantes">
        <a class="nav-link" href="${P}estudiantes-registro.html" data-page="est-registro">
          Registro de Estudiantes
        </a>
        <a class="nav-link" href="${P}estudiantes-listado.html" data-page="est-listado">
          Listado de Estudiantes
        </a>
        <a class="nav-link" href="${P}estudiantes-postulacion.html" data-page="est-postulacion">
          Postulación a Vacantes
        </a>
      </div>

      <!-- Asignación -->
      <a class="nav-link collapse-toggle" data-bs-toggle="collapse" href="#menuAsignacion" role="button" aria-expanded="false" aria-controls="menuAsignacion">
        <i class="bi bi-diagram-3-fill"></i> Asignación
      </a>
      <div class="collapse sidebar-submenu" id="menuAsignacion">
        <a class="nav-link" href="${P}asignacion-asignar.html" data-page="asig-asignar">
          Asignar Empresa / Tutor
        </a>
        <a class="nav-link" href="${P}asignacion-estado.html" data-page="asig-estado">
          Estado de Práctica
        </a>
        <a class="nav-link" href="${P}asignacion-reasignacion.html" data-page="asig-reasignacion">
          Cambios y Reasignaciones
        </a>
      </div>

      <!-- ══════ MÓDULO 2: REPORTES Y VALIDACIÓN INSTITUCIONAL ══════ -->
      <div class="menu-header mt-3">Reportes y Validación</div>

      <!-- Reportes -->
      <a class="nav-link collapse-toggle" data-bs-toggle="collapse" href="#menuReportes" role="button" aria-expanded="false" aria-controls="menuReportes">
        <i class="bi bi-bar-chart-line-fill"></i> Reportes
      </a>
      <div class="collapse sidebar-submenu" id="menuReportes">
        <a class="nav-link" href="${P}reportes-dashboard.html" data-page="rep-dashboard">
          Dashboard
        </a>
        <a class="nav-link" href="${P}reportes-por-carrera.html" data-page="rep-carrera">
          Por Carrera
        </a>
        <a class="nav-link" href="${P}reportes-por-empresa.html" data-page="rep-empresa">
          Por Empresa
        </a>
        <a class="nav-link" href="${P}reportes-por-estudiante.html" data-page="rep-estudiante">
          Por Estudiante
        </a>
        <a class="nav-link" href="${P}reportes-exportar.html" data-page="rep-exportar">
          Exportar PDF / Excel
        </a>
      </div>

      <!-- Validación -->
      <a class="nav-link collapse-toggle" data-bs-toggle="collapse" href="#menuValidacion" role="button" aria-expanded="false" aria-controls="menuValidacion">
        <i class="bi bi-patch-check-fill"></i> Validación
      </a>
      <div class="collapse sidebar-submenu" id="menuValidacion">
        <a class="nav-link" href="${P}validacion-final.html" data-page="val-final">
          Validación Final
        </a>
      </div>

      <!-- Notificaciones -->
      <a class="nav-link" href="${P}notificaciones.html" data-page="notificaciones">
        <i class="bi bi-bell-fill"></i> Notificaciones
      </a>

      <!-- Certificados -->
      <a class="nav-link" href="${P}certificados.html" data-page="certificados">
        <i class="bi bi-file-earmark-check-fill"></i> Certificados
      </a>

    </div>
  `;

  // ───── TOPBAR HTML ─────
  const topbarHTML = `
    <div class="d-flex align-items-center gap-3">
      <button class="btn-toggle-sidebar" id="btnToggleSidebar" title="Toggle menú">
        <i class="bi bi-list"></i>
      </button>
      <nav aria-label="breadcrumb" id="breadcrumb-container">
        <ol class="breadcrumb mb-0" id="breadcrumb"></ol>
      </nav>
    </div>
    <div class="topbar-right">
      <div class="notification-badge">
        <button class="btn-icon" title="Notificaciones" onclick="window.location.href='${P}notificaciones.html'">
          <i class="bi bi-bell"></i>
        </button>
        <span class="badge rounded-pill bg-danger">3</span>
      </div>
      <div class="dropdown">
        <div class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="user-avatar">SM</div>
          <div class="user-info d-none d-md-block">
            <div class="name">Stin Sánchez</div>
            <div class="role">Coordinador</div>
          </div>
          <i class="bi bi-chevron-down ms-1" style="font-size:.65rem;color:#6c757d;"></i>
        </div>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Mi Perfil</a></li>
          <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Configuración</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="${A}index.html"><i class="bi bi-box-arrow-left me-2"></i>Cerrar Sesión</a></li>
        </ul>
      </div>
    </div>
  `;

  // ───── INYECTAR COMPONENTES ─────
  document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const topbar = document.getElementById('topbar');

    if (sidebar) sidebar.innerHTML = sidebarHTML;
    if (topbar) topbar.innerHTML = topbarHTML;

    // Marcar enlace activo y abrir su collapse
    const activePage = document.body.getAttribute('data-page');
    if (activePage && sidebar) {
      const activeLink = sidebar.querySelector(`[data-page="${activePage}"]`);
      if (activeLink) {
        activeLink.classList.add('active');
        // Abrir submenú padre
        const parentCollapse = activeLink.closest('.collapse');
        if (parentCollapse) {
          parentCollapse.classList.add('show');
          const toggle = sidebar.querySelector(`[href="#${parentCollapse.id}"]`);
          if (toggle) toggle.setAttribute('aria-expanded', 'true');
        }
      }
    }

    // Generar breadcrumb
    buildBreadcrumb();
  });

  // ───── BREADCRUMB AUTOMÁTICO ─────
  function buildBreadcrumb() {
    const bc = document.getElementById('breadcrumb');
    if (!bc) return;
    const title = document.title.split(' — ')[0] || 'Inicio';
    const section = document.body.getAttribute('data-section') || '';

    let html = `<li class="breadcrumb-item"><a href="${A}index.html"><i class="bi bi-house-door"></i></a></li>`;
    if (section) {
      html += `<li class="breadcrumb-item">${section}</li>`;
    }
    html += `<li class="breadcrumb-item active" aria-current="page">${title}</li>`;
    bc.innerHTML = html;
  }
})();
