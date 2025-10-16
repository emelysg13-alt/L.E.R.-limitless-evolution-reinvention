CREATE DATABASE lerxport;

USE lerxport;

CREATE TABLE contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    importante TINYINT(1) DEFAULT 0
);


CREATE TABLE articulos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  categoria VARCHAR(50),
  descripcion TEXT,
  imagen_url VARCHAR(255),
  enlace_externo VARCHAR(255),
  precio DECIMAL(10,2) NOT NULL DEFAULT 0
);



CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(100) NOT NULL UNIQUE,
  telefono VARCHAR(20) not null,
  contraseña VARCHAR(255) NOT NULL);
  
  
  CREATE TABLE cotizaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    productos TEXT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);
  


  Create table administrador (
   id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(100) NOT NULL UNIQUE,
  contraseña VARCHAR(255) NOT NULL);
  
   Insert into administrador (nombre, correo, contraseña)
   Values ("Emely", "admin@gmail.com", '$2y$10$3rSsx8h0Ru0g14WBXl4ZaeDSq0j51Hn/r6qo102XduR6qMLHXWRWy'),
   ("Gamez", "admin2@gmail.com", '$2y$10$3rSsx8h0Ru0g14WBXl4ZaeDSq0j51Hn/r6qo102XduR6qMLHXWRWy');
   

CREATE TABLE loopy (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  mensaje TEXT NOT NULL,
  autor ENUM('usuario', 'loopy') NOT NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  destinatario VARCHAR(100) DEFAULT NULL,
importante TINYINT(1) DEFAULT 0
);



CREATE TABLE faq (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta_clave VARCHAR(255) NOT NULL,
    respuesta TEXT NOT NULL,
    palabras_clave TEXT,
    categoria VARCHAR(50),
    confianza INT DEFAULT 1 /*opcional*/
);


CREATE TABLE carrito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES articulos(id) ON DELETE CASCADE,
    UNIQUE (user_id, producto_id) -- evita duplicados del mismo producto
);


