CREATE DATABASE test;
CREATE TABLE test.contribuyentes (
    rut INT NOT NULL,
    digito_verificador TINYINT,
    razon_social VARCHAR(100),
    tipo_persona TINYINT, --1: Persona natural - 2: Persona juridica
    giro 
);