CREATE TABLE bodegas (id SERIAL PRIMARY KEY, nombre VARCHAR(100));
CREATE TABLE sucursales (id SERIAL PRIMARY KEY, nombre VARCHAR(100), bodega_id INT REFERENCES bodegas(id));
CREATE TABLE monedas (id SERIAL PRIMARY KEY, simbolo VARCHAR(5));

-- Datos de prueba
INSERT INTO bodegas (nombre) VALUES ('Bodega 1'), ('Bodega 2');
INSERT INTO sucursales (nombre, bodega_id) VALUES ('Sucursal 1', 1), ('Sucursal 2', 1), ('Sucursal 1', 2);
INSERT INTO monedas (simbolo) VALUES ('CLP'), ('USD');

CREATE TABLE productos (
    id SERIAL PRIMARY KEY,
    codigo VARCHAR(15) UNIQUE NOT NULL,
    nombre TEXT NOT NULL,
    bodega_id INT REFERENCES bodegas(id),
    sucursal_id INT REFERENCES sucursales(id),
    moneda_id INT REFERENCES monedas(id),
    precio NUMERIC(10,2) NOT NULL,
    materiales TEXT[] NOT NULL,
    descripcion TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);