create table coches (
    id int auto_increment primary key,
    marca enum ("Seat", "Renault", "Peugeot", "Citroen", "Toyota", "Opel", "Fiat"),
    modelo varchar (50),
    color varchar (30),
    kilometros int 
);

-- valores de ejemplo
insert into coches (marca, modelo, color, kilometros) values ("Seat", "Ateca", "Negro", 20000);
insert into coches (marca, modelo, color, kilometros) values ("Citroen", "C4", "Blanco", 110000);
insert into coches (marca, modelo, color, kilometros) values ("Opel", "Astra", "Negro Mate", 185000);
insert into coches (marca, modelo, color, kilometros) values ("Opel", "Mokka", "Gris Metalizado", 17523);
insert into coches (marca, modelo, color, kilometros) values ("Toyota", "Rav4", "Azul Oscuro Metalizado", 20000);