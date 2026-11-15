/**
 * App.js — Interacciones globales
 */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {

    // ───── SIDEBAR TOGGLE ─────
    const wrapper  = document.querySelector('.wrapper');
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.querySelector('.sidebar-overlay');
    const btnToggle = document.getElementById('btnToggleSidebar');

    if (btnToggle) {
      btnToggle.addEventListener('click', function () {
        const isDesktop = window.innerWidth >= 992;
        if (isDesktop) {
          wrapper.classList.toggle('sidebar-collapsed');
        } else {
          sidebar.classList.toggle('show');
          if (overlay) overlay.classList.toggle('show');
        }
      });
    }

    // Cerrar sidebar en mobile al hacer click en overlay
    if (overlay) {
      overlay.addEventListener('click', function () {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
      });
    }

    // ───── TOOLTIPS (Bootstrap) ─────
    const tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipEls.forEach(el => new bootstrap.Tooltip(el));

    // ───── BÚSQUEDA EN TABLAS ─────
    const searchInputs = document.querySelectorAll('[data-search-table]');
    searchInputs.forEach(input => {
      input.addEventListener('input', function () {
        const tableId = this.getAttribute('data-search-table');
        const table = document.getElementById(tableId);
        if (!table) return;
        const term = this.value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
          const text = row.textContent.toLowerCase();
          row.style.display = text.includes(term) ? '' : 'none';
        });
      });
    });

    // ───── SELECT ALL CHECKBOXES ─────
    const selectAllCbs = document.querySelectorAll('[data-select-all]');
    selectAllCbs.forEach(cb => {
      cb.addEventListener('change', function () {
        const tableId = this.getAttribute('data-select-all');
        const checkboxes = document.querySelectorAll(`#${tableId} tbody .row-check`);
        checkboxes.forEach(c => c.checked = this.checked);
      });
    });

    // ───── CONFIRMAR ACCIONES DESTRUCTIVAS ─────
    document.querySelectorAll('[data-confirm]').forEach(btn => {
      btn.addEventListener('click', function (e) {
        const msg = this.getAttribute('data-confirm') || '¿Estás seguro?';
        if (!confirm(msg)) e.preventDefault();
      });
    });

    // ───── AUTO-DISMISS ALERTS ─────
    document.querySelectorAll('.alert-auto-dismiss').forEach(alert => {
      setTimeout(() => {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
        bsAlert.close();
      }, 4000);
    });
  });
})();
