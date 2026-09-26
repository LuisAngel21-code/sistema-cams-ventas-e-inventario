CREATE DATABASE tienda_cams;
GO

USE tienda_cams;
GO

SET QUOTED_IDENTIFIER ON;
GO

-- =========================
-- TABLAS
-- =========================

CREATE TABLE sucursales (
    id INT IDENTITY PRIMARY KEY,
    nombre NVARCHAR(100) NOT NULL,
    direccion NVARCHAR(200),
    telefono NVARCHAR(20),
    activo BIT DEFAULT 1
);

CREATE TABLE usuarios (
    id INT IDENTITY PRIMARY KEY,
    username NVARCHAR(100) NOT NULL UNIQUE,
    password_hash NVARCHAR(255) NOT NULL,
    rol NVARCHAR(30) NOT NULL CHECK (
        rol IN ('administrador', 'jefe', 'encargado_almacen', 'encargado_tienda')
    ),
    sucursal_id INT NULL REFERENCES sucursales(id),
    activo BIT DEFAULT 1,
    two_factor_secret NVARCHAR(255),
    remember_token NVARCHAR(100) NULL,
    created_at DATETIME2 DEFAULT GETDATE()
);

CREATE TABLE productos (
    id INT IDENTITY PRIMARY KEY,
    codigo NVARCHAR(50) NOT NULL UNIQUE,
    nombre NVARCHAR(100) NOT NULL,
    descripcion NVARCHAR(500),
    categoria NVARCHAR(50) NOT NULL,
    marca NVARCHAR(50),
    proveedor NVARCHAR(100),
    imagen NVARCHAR(255),
    costo DECIMAL(10,2) DEFAULT 0,
    precio_base DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    stock_minimo INT DEFAULT 2,
    activo BIT DEFAULT 1,
    created_at DATETIME2 DEFAULT GETDATE()
);

CREATE TABLE stock (
    id INT IDENTITY PRIMARY KEY,
    producto_id INT NOT NULL REFERENCES productos(id),
    sucursal_id INT NOT NULL REFERENCES sucursales(id),
    cantidad INT DEFAULT 0,
    UNIQUE(producto_id, sucursal_id)
);

CREATE TABLE movimientos (
    id INT IDENTITY PRIMARY KEY,
    producto_id INT NOT NULL REFERENCES productos(id),
    sucursal_id INT NOT NULL REFERENCES sucursales(id),
    tipo NVARCHAR(20) NOT NULL CHECK (tipo IN ('entrada', 'salida')),
    cantidad INT NOT NULL CHECK (cantidad > 0),
    motivo NVARCHAR(200),
    usuario_id INT NULL REFERENCES usuarios(id),
    fecha DATETIME2 DEFAULT GETDATE()
);

CREATE TABLE compras (
    id INT IDENTITY PRIMARY KEY,
    fecha DATETIME2 DEFAULT GETDATE(),
    sucursal_id INT NOT NULL REFERENCES sucursales(id),
    usuario_id INT NULL REFERENCES usuarios(id),
    total DECIMAL(10,2) DEFAULT 0
);

CREATE TABLE detalle_compras (
    id INT IDENTITY PRIMARY KEY,
    compra_id INT NOT NULL REFERENCES compras(id),
    producto_id INT NOT NULL REFERENCES productos(id),
    cantidad INT NOT NULL CHECK (cantidad > 0),
    costo DECIMAL(10,2) NOT NULL
);

CREATE TABLE ventas (
    id INT IDENTITY PRIMARY KEY,
    fecha DATETIME2 DEFAULT GETDATE(),
    subtotal DECIMAL(10,2),
    descuento DECIMAL(10,2) DEFAULT 0,
    total DECIMAL(10,2) NOT NULL,
    tipo_pago NVARCHAR(20),
    comprobante_tipo NVARCHAR(20),
    cliente_nombre NVARCHAR(100),
    vendedor_nombre NVARCHAR(100),
    estado NVARCHAR(20) DEFAULT 'completada',
    sucursal_id INT NOT NULL REFERENCES sucursales(id),
    usuario_id INT NOT NULL REFERENCES usuarios(id)
);

CREATE TABLE detalle_ventas (
    id INT IDENTITY PRIMARY KEY,
    venta_id INT NOT NULL REFERENCES ventas(id),
    producto_id INT NOT NULL REFERENCES productos(id),
    cantidad INT NOT NULL CHECK (cantidad > 0),
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal AS (cantidad * precio_unitario) PERSISTED
);

CREATE TABLE recovery_tokens (
    id INT IDENTITY PRIMARY KEY,
    usuario_id INT NOT NULL REFERENCES usuarios(id),
    token NVARCHAR(255) NOT NULL,
    expira_en DATETIME2 NOT NULL,
    usado BIT DEFAULT 0
);

CREATE TABLE otp_codes (
    id INT IDENTITY PRIMARY KEY,
    usuario_id INT NOT NULL REFERENCES usuarios(id),
    codigo NVARCHAR(10) NOT NULL,
    expira_en DATETIME2 NOT NULL,
    verificado BIT DEFAULT 0
);

CREATE INDEX idx_ventas_fecha ON ventas(fecha);
CREATE INDEX idx_movimientos_fecha ON movimientos(fecha);
GO

-- =========================
-- DATOS DE PRUEBA
-- =========================

INSERT INTO sucursales (nombre, direccion, telefono, activo) VALUES
('Tienda Central', 'Av. Principal 123', '987654321', 1),
('Sucursal Norte', 'Av. Norte 456', '987654322', 1);

INSERT INTO usuarios (username, password_hash, rol, sucursal_id, activo) VALUES
('admin@cams.com',  '$2y$10$GgGBcAHwTinkv9rTZ9gJ1uTGDlA2N1tAs9H5Lg2L2u9KlmDPIn/Cy', 'administrador',       1, 1),
('jefe@cams.com',   '$2y$10$GgGBcAHwTinkv9rTZ9gJ1uTGDlA2N1tAs9H5Lg2L2u9KlmDPIn/Cy', 'jefe',                1, 1),
('almacen@cams.com','$2y$10$GgGBcAHwTinkv9rTZ9gJ1uTGDlA2N1tAs9H5Lg2L2u9KlmDPIn/Cy', 'encargado_almacen',   1, 1),
('tienda@cams.com', '$2y$10$GgGBcAHwTinkv9rTZ9gJ1uTGDlA2N1tAs9H5Lg2L2u9KlmDPIn/Cy', 'encargado_tienda',    2, 1);

INSERT INTO productos (codigo, nombre, descripcion, categoria, marca, costo, precio_base, stock, stock_minimo) VALUES
('CAMA-001',    'Cama Queen Clasica',      'Madera solida',       'Camas',     'Cams',  2500.00, 3500.00, 10, 2),
('COLCHON-001', 'Colchon Queen Ortopedico','Espuma viscoelastica','Colchones', 'Rosen', 1800.00, 2520.00, 20, 5),
('BASE-001',    'Base Queen',              'Madera',              'Bases',     'Cams',   800.00, 1120.00, 12, 3);

INSERT INTO stock (producto_id, sucursal_id, cantidad) VALUES
(1, 1, 10), (1, 2, 10),
(2, 1, 20), (2, 2, 20),
(3, 1, 12), (3, 2, 12);

INSERT INTO compras (fecha, sucursal_id, usuario_id, total) VALUES
(GETDATE(), 1, 3, 9000.00);

INSERT INTO detalle_compras (compra_id, producto_id, cantidad, costo) VALUES
(1, 2, 5, 1800.00);

INSERT INTO ventas (fecha, subtotal, descuento, total, tipo_pago, comprobante_tipo, cliente_nombre, vendedor_nombre, estado, sucursal_id, usuario_id) VALUES
(GETDATE(), 7000.00, 0, 7000.00, 'efectivo', 'boleta', 'Juan Perez', 'Maria Garcia', 'completada', 1, 4);

INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario) VALUES
(1, 1, 2, 3500.00);

INSERT INTO movimientos (producto_id, sucursal_id, tipo, cantidad, motivo, usuario_id) VALUES
(2, 1, 'entrada', 5, 'Compra #1', 3),
(1, 1, 'salida', 2, 'Venta #1', 4);

GO