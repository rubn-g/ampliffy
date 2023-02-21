## Desarrollo 1

En este apartado, se pedía construir un árbol para poder obtener los repositorios en los que hacer commit, por tanto,
aquellos repositorios que son "padres" del repositorio en question.

Aunque la prueba menciona una estructura de árbol, creo que este proceso es más rápido utilizando un array plano, por lo que he hecho la implementación utilizando un array plano.
Aún así, he añadido un método ```buildTree``` que monta el árbol, tal como pedía la prueba.

Se ha añadido un test unitario y un test funcional, a modo de demostración de conocimientos creando tests y de como serían los tests, no me ha parecido necesario añadir tests para cada clase y cada método.

## Comando

Commando shell a ejecutar para comprobar el resultado de la prueba:

```docker-compose run --rm laravel php artisan code:commit <repository> <commit_id> <branch>```

Por ejemplo:

>```docker-compose run --rm laravel php artisan code:commit lib2 1 dev```

## Desarrollo 2

Se ha añadido un archivo ```database.sql``` en la raíz del repositorio, con las 2 tablas que se utilizarían para guardar
las dependencias entre repositorios. Solo están los campos necesarios para el ejemplo.

## Desarrollo 3

Dado que mi mayor fortaleza no está en el frontend, no he llegado a una solución para evitar el problema calculando la
altura del iframe.

He tratado de hacer el iframe envíe un mensaje al frame superior con los datos necesarios calculados y escuchar este mensaje desde el frame superior, pero no ha desaparecido el hueco.
