<?php
    // 1. Iniciamos la sesión
    session_start();
    // 2. Nos traemos la llave correspondiente a la conexion
    require_once __DIR__."/../db/conexion.php";
    $q = "select * from coches order by id desc";
    // 3. Guardamos el resultado de la consulta
    $resultado=mysqli_query($llave, $q);
    mysqli_close($llave);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!-- cdn fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- cdn sweetalert2 -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <title>Ver Coches</title>
    </head>
    <body style="background-color: #216B46">
        <h3 style="color:white; margin:20px" class="text-center mt-4">Listado de Coches</h3>
        <div class="container" >
            <!-- 5. Añadimos un botón para insertar nuevos vehículos-->
            <a href="nuevo.php" class="btn btn-light my-2">
                <i class="fa-solid fa-car"></i> Añadir Coche
            </a>
            <table align="center" style="width:70%; text-align:center" class="table table-warning table-striped">
                <thead align="center">
                    <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Color</th>
                    <th scope="col">Kilometros</th>
                    <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // 4. Introducimos los datos de la consulta en la tabla
                        while($dato=mysqli_fetch_assoc($resultado)){
                            echo <<<TXT
                            <tr>
                                <td>{$dato['id']}</td>
                                <td>{$dato['marca']}</td>
                                <td>{$dato['modelo']}</td>
                                <td>{$dato['color']}</td>
                                <td>{$dato['kilometros']}</td>
                                <td>
                                    <form class ="form-inline" name="a" method="POST" action="delete.php">
                                        <input type="hidden" name="id" value="{$dato['id']}" />
                                        <a href="update.php?id={$dato['id']}" class="btn btn-warning bt-sm">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <button type="submit" class="btn btn-danger bt-sm">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            TXT;
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
                // 6. Mensaje al insertar un coche correctamente
            if (isset($_SESSION['mensaje'])) {
                echo <<<TXT
                <script> 
                    Swal.fire({
                        title: '{$_SESSION['mensaje']}',
                        imageUrl: '/public/img/img2.png',
                        imageWidth: 500,
                        showConfirmButton: false,
                        timer: 1700,
                    })
                </script>
                TXT;
                unset($_SESSION['mensaje']);
            }
        ?>
    </body>
</html>