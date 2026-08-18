create database restaurante_db;
use restaurante_db;

create table usuario (
    id int auto_increment primary key,
    nome varchar(100) not null,
    email varchar(100) not null
);

create table prato (
    id int auto_increment primary key,
    nome varchar(100) not null,
    descricao text not null,
    preco decimal(10,2) not null,
    categoria varchar(100) not null,
    usuario_responsavel int not null,
    foreign key (usuario_responsavel) references usuario(id)
);

insert into usuario (nome, email) values
('André', 'andre@email.com'),
('Brayan', 'brayan@email.com');

insert into prato 
(nome, descricao, preco, categoria, usuario_responsavel) 
values
('Lasanha', 'Lasanha de carne com queijo', 35.90, 'Massas', 1),
('Hambúrguer', 'Hambúrguer artesanal com queijo', 28.00, 'Lanches', 2);