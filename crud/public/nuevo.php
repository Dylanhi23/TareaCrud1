<?php
    // 1. Iniciamos la sesión
    session_start();

    // 2. Creamos una función en caso de errores
    function mostrarErrores($marca){
        if(isset($_SESSION[$marca])){
            echo "<p class='text-danger mt-2'>{$_SESSION[$marca]}</p>";
            unset($_SESSION[$marca]);
        }
    }

    // Condición si se pulsa el  botón de Guardar
    if(isset($_POST['boton'])){
        $error=false;
        // 3. Nos traemos los datos 
        require_once __DIR__."/../db/conexion.php";
        $marca=trim($_POST['marca']);
        $modelo=trim($_POST['modelo']);
        $color=trim($_POST['color']);
        $kilometros=trim($_POST['kilometros']);

        // 4. Creamos las condiciones para cada elemento
        // Condición para MARCA
            // La marca introducida será una de las indicadas
        if(($marca) !== "Seat" && ($marca) !== "Renault" && ($marca) !== "Peugeot" && 
        ($marca) !== "Citroen" && ($marca) !=="Toyota" && ($marca) !== "Opel" && ($marca) !== "Fiat"){
            $error=true;
            $_SESSION['marca']="Error: La marca del vehículo debe de ser una de las permitidas 
                                (Seat, Renault, Peugeot, Citroen, Toyota, Opel, Fiat)";
        }
        
        // Condición para MODELO
        if(strlen($modelo)== " "){
            $error=true;
            $_SESSION['modelo']="Error: Hay que indicar el modelo del coche";
        }

        // Condición para COLOR
        if(strlen($color)== " "){
            $error=true;
            $_SESSION['color']="Error: Hay que indicar el color del coche";
        }

        // Condición para KILOMETROS
        if(strlen($kilometros)== " "){
            $error=true;
            $_SESSION['kilometros']="Error: Hay que indicar los kilometros del coche";
        }

        if($error){
            mysqli_close($llave);
            header("Location:nuevo.php");
            die();
        }
        // No compruebo que exista un vehículo con los mismos datos puesto 
        // que no importa que haya dos vehículos iguales (solo tiene que ser de distinto código)
        
        // 5. Procedemos a insertar el coche en la base de datos
        $q="insert into coches(marca, modelo, color, kilometros) values(?, ?, ?,?)";
        $stmt=mysqli_stmt_init($llave);
        if(mysqli_stmt_prepare($stmt, $q)){
            mysqli_stmt_bind_param($stmt, 'sssi', $marca, $modelo, $color, $kilometros);
            mysqli_stmt_execute($stmt);
        }else{
            die("Se ha producido un error al insertar el coche");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($llave);
        $_SESSION['mensaje']="Coche añadido con éxito";
        header("Location:main.php");
        die();

    }
    else{
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
        <script src="https://kit.fontawesome.com/255d22f002.js" crossorigin="anonymous"></script>
        <title>Añadir coche</title>
    </head>
    <body style="background-color: #216B46">
        <h3 style="color:white; margin:20px" class="text-center mt-4">Añadir un nuevo Coche</h3>
        <div class="container" >
                <!-- Botón para volver atrás -->
            <a href="main.php" class="btn btn-light my-2">
                <i class="fa-solid fa-rotate-left"></i> Volver a la lista de coches
            </a>
                <!-- Formulario para crear el coche-->
            <form name="nuevocoche" action="nuevo.php" method="POST" class="text-light">
                <div class="mb-3">
                    <label for="ma" class="form-label">Marca del Coche: </label>
                    <input type="text" class="form-control" id="ma" 
                    placeholder="Seat, Renault, Peugeot, Citroen, Toyota, Opel, Fiat" name="marca">
                    <?php
                        mostrarErrores("marca");
                    ?>
                </div>
                <div class="mb-3">
                    <label for="mo" class="form-label">Modelo del Coche:</label>
                    <input type="text" class="form-control" id="mo" placeholder="Su modelo" name="modelo">
                    <?php
                        mostrarErrores("modelo");
                    ?>
                </div>

                <div class="mb-3">
                    <label for="co" class="form-label">Color del Coche:</label>
                    <select class="form-select" name="color" id="co" placeholder="Su color">
                        <option label="Elija un color" selected> </option>
                        <option value="Negro Mate">Negro Mate</option>
                        <option value="Negro Metalizado">Negro Metalizado</option>
                        <option value="Gris Metalizado">Gris Metalizado</option>
                        <option value="Blanco">Blanco</option>
                        <option value="Azul Oscuro Metalizado">Azul Oscuro Metalizado</option>
                        <option value="Azul Claro Metalizado">Azul Claro Metalizado</option>
                        <option value="Rojo Metalizado">Rojo Metalizado</option>
                        <option value="Rojo Vino Metalizado">Rojo Vino Metalizado</option>
                        <option value="Amarillo Fosforito">Amarillo Fosforito</option>
                        <option value="Verde Metalizado">Verde Metalizado</option>
                    </select>
                    <?php
                        mostrarErrores("color");
                    ?>
                </div>
                <div class="mb-3">
                    <label for="ki" class="form-label">Kilometros del Coche:</label>
                    <input type="number" class="form-control" id="ki" placeholder="Sus kilometros" name="kilometros">
                    <?php
                        mostrarErrores("kilometros");
                    ?>
                </div>
                    <!-- Botones de la parte inferior -->
                <div class="d-flex">
                    <button type="submit" class="btn btn-primary"  name="boton">
                        <i class="fa-regular fa-square-check"></i> Guardar
                    </button>&nbsp;
                    <button type="reset" class="btn btn-warning">
                        <i class="fa-solid fa-broom"></i> Limpiar
                    </button>
                </div>

            </form>
        </div>

    </body>

</html>
<?php } ?>