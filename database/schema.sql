SET NAMES utf8mb4;

CREATE TABLE usuarios (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  rol ENUM('admin','coordinador','tutor_academico','tutor_empresarial','estudiante') NOT NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE empresas (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  ruc VARCHAR(20) UNIQUE,
  direccion VARCHAR(255),
  contacto_nombre VARCHAR(120),
  contacto_email VARCHAR(150),
  contacto_telefono VARCHAR(30)
) ENGINE=InnoDB;

CREATE TABLE convenios (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  empresa_id INT UNSIGNED NOT NULL,
  fecha_inicio DATE NOT NULL,
  fecha_fin DATE NOT NULL,
  estado ENUM('vigente','vencido','suspendido') NOT NULL DEFAULT 'vigente',
  archivo_pdf VARCHAR(255),
  FOREIGN KEY (empresa_id) REFERENCES empresas(id)
) ENGINE=InnoDB;

CREATE TABLE vacantes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  convenio_id INT UNSIGNED NOT NULL,
  titulo VARCHAR(150) NOT NULL,
  descripcion TEXT,
  cupos INT UNSIGNED NOT NULL DEFAULT 1,
  abierta TINYINT(1) NOT NULL DEFAULT 1,
  FOREIGN KEY (convenio_id) REFERENCES convenios(id)
) ENGINE=InnoDB;

CREATE TABLE estudiantes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT UNSIGNED NOT NULL UNIQUE,
  cedula VARCHAR(15) NOT NULL UNIQUE,
  carrera VARCHAR(120) NOT NULL,
  nivel TINYINT UNSIGNED NOT NULL,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

CREATE TABLE asignaciones (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  estudiante_id INT UNSIGNED NOT NULL,
  vacante_id INT UNSIGNED NOT NULL,
  tutor_academico_id INT UNSIGNED,
  tutor_empresarial_id INT UNSIGNED,
  horas_meta SMALLINT UNSIGNED NOT NULL DEFAULT 240,
  estado ENUM('activa','finalizada','cancelada') NOT NULL DEFAULT 'activa',
  FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id),
  FOREIGN KEY (vacante_id) REFERENCES vacantes(id),
  FOREIGN KEY (tutor_academico_id) REFERENCES usuarios(id),
  FOREIGN KEY (tutor_empresarial_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

CREATE TABLE registros_horas (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  asignacion_id INT UNSIGNED NOT NULL,
  fecha DATE NOT NULL,
  horas DECIMAL(4,2) NOT NULL,
  actividad VARCHAR(500) NOT NULL,
  estado ENUM('pendiente','aprobado','rechazado') NOT NULL DEFAULT 'pendiente',
  observacion VARCHAR(255),
  FOREIGN KEY (asignacion_id) REFERENCES asignaciones(id)
) ENGINE=InnoDB;

CREATE TABLE evaluaciones (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  asignacion_id INT UNSIGNED NOT NULL,
  evaluador_id INT UNSIGNED NOT NULL,
  tipo ENUM('parcial','final') NOT NULL,
  puntaje DECIMAL(5,2) NOT NULL,
  comentario TEXT,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (asignacion_id) REFERENCES asignaciones(id),
  FOREIGN KEY (evaluador_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

CREATE TABLE documentos (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  asignacion_id INT UNSIGNED NOT NULL,
  tipo VARCHAR(60) NOT NULL,
  archivo VARCHAR(255) NOT NULL,
  subido_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (asignacion_id) REFERENCES asignaciones(id)
) ENGINE=InnoDB;

CREATE TABLE validaciones (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  asignacion_id INT UNSIGNED NOT NULL UNIQUE,
  coordinador_id INT UNSIGNED NOT NULL,
  aprobada TINYINT(1) NOT NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (asignacion_id) REFERENCES asignaciones(id),
  FOREIGN KEY (coordinador_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

CREATE TABLE notificaciones (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT UNSIGNED NOT NULL,
  mensaje VARCHAR(255) NOT NULL,
  leida TINYINT(1) NOT NULL DEFAULT 0,
  creada_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;
