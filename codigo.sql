CREATE DATABASE dados;
CREATE TABLE usuarios (
id int NOT NULL AUTO_INCREMENT,
cpf bigint (11) NOT NULL,
nome varchar (1000) NOT NULL,
nascimento date,
primary key(id)  
);