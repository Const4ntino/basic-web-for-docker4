CREATE TABLE IF NOT EXISTS mascotas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL,
    tipo VARCHAR(40) NOT NULL,
    sexo CHAR(1) CHECK (sexo IN ('M', 'F')) NOT NULL,
    nacimiento SMALLINT,
    fecha_ingreso DATE NOT NULL
);