# CONSULTAS DE UNA TABLA

# Seleccionar todos los libros de la tabla libros
SELECT * FROM libros;

# Seleccinar los 10 primeros libros de la tabla libros
SELECT * FROM libro LIMIT 10;

# Seleccionar los libros del 11 al 20 
SELECT * FROM libro LIMIT 11, 20;

# Seleccionar titulo de la tabla libro, el genero novela
SELECT titulo FROM `libro` WHERE genero = 'novela';

# Seleccionar titulo y genero de las novelas
SELECT titulo,genero FROM libro WHERE genero = 'novela';

# Seleccionar todos los lectores que sellaman daniel
SELECT * from lector WHERE nombre = 'daniel';

# Seleccionar el isbn de los libros publicados 1950 /1970
SELECT * FROM libro WHERE anio >1950 AND anio <1970;
otra forma en este caso se utiliza el between que significa entre
SELECT * FROM libro WHERE anio BETWEEN 1950 AND 1970;

# Cuando se creo el lector con id 4
SELECT fecha FROM lector WHERE id = 4;

# Cuando se creo el lector con id 4 y su nombre
SELECT fecha , nombre FROM lector WHERE id = 4;

# Cuantos libros hay en cada genero
funcion count(*) y group by para que me lo e por generos
SELECT genero, COUNT(*) FROM libro GROUP BY genero;

y para que en la tabla se quede con nombre se pone "as" que es como un alias para decir esto se llama asi
SELECT genero as Genero, COUNT(*) as Cantidad FROM libro GROUP BY genero;

# Quien tiene libros sin devolver
se pone is  para indiar el = de null

SELECT lector.nombre, prestamo.fecha_prestamo
FROM prestamo,lector
WHERE lector.id = prestamo.id_lector
AND prestamo.fecha_devolucion IS null;

# Numero de libros que ha cogido cada lector
SELECT lector.nombre, COUNT(*) as 'numero de libros' FROM lector, prestamo WHERE prestamo.id_lector = lector.id GROUP BY prestamo.id_lector;


# Quien lee mas
esto ordena quien ha leido mas con desc
SELECT lector.nombre, COUNT(*) as numero FROM lector, prestamo WHERE prestamo.id_lector = lector.id GROUP BY prestamo.id_lector ORDER BY 'numero' DESC

# ponemos limit 1 al primero que ha leido mas
SELECT lector.nombre, COUNT(*) as numero FROM lector, prestamo WHERE prestamo.id_lector = lector.id GROUP BY prestamo.id_lector ORDER BY numero DESC LIMIT 1;

# Titulo que no se ha llevado nadie el left join es para juntar dos tablas
SELECT l.titulo FROM libro l LEFT JOIN prestamo p ON p.id_libro = l.id WHERE p.id IS NULL;

# titulo mas prestado
SELECT libro.titulo, COUNT(*) as prestamos FROM libro, prestamo WHERE libro.id = prestamo.id_libro GROUP BY prestamo.id_libro ORDER BY 'numero' DESC LIMIT 1;

SELECT libro.titulo, COUNT(*) as prestamos FROM libro, prestamo WHERE libro.id = prestamo.id_libro GROUP BY prestamo.id_libro ORDER BY prestamos DESC LIMIT 1;