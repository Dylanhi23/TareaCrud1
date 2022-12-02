<?php
    session_start();

        // Función de errores
    function mostrarErrores($marca){
        if(isset($_SESSION[$marca])){
            echo "<p class='text-danger mt-2'><b>{$_SESSION[$marca]}</b></p>";
            unset($_SESSION[$marca]);
        }
    }

        // Retorno a main.php en caso de no coger id por GET
    if(!isset($_GET['id'])){
        header("Location:main.php");
        die();
    }
        // Cogemos por GET el id
    $id=$_GET['id'];

        // Establecemos la conexión con la base de datos desde conexion.php
    require_once __DIR__."/../db/conexion.php";
        // Hacemos la consulta para luego coger los datos del id correspondiente
    $q="select * from coches where id=?";
    $stmt = mysqli_stmt_init($llave);
    if(mysqli_stmt_prepare($stmt, $q)){
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $marca, $modelo, $color, $kilometros);
        mysqli_stmt_fetch($stmt);
    }
    mysqli_stmt_close($stmt); 

        // Condición si pulsamos el botón
    if(isset($_POST['boton'])){
            // Procesamos los campos
        $marcaF=trim($_POST['marca']);
        $modeloF=trim($_POST['modelo']);
        $colorF=trim($_POST['color']);
        $kilometrosF=trim($_POST['kilometros']);

        // Creamos las condiciones para cada elemento
        if(($marcaF) !== "Seat" && ($marcaF) !== "Renault" && ($marcaF) !== "Peugeot" && 
        ($marcaF) !== "Citroen" && ($marcaF) !=="Toyota" && ($marcaF) !== "Opel" && ($marcaF) !== "Fiat"){
            $_SESSION['marca']="Error: La marca del vehículo debe de ser una de las permitidas 
            (Seat, Renault, Peugeot, Citroen, Toyota, Opel, Fiat)";
            mysqli_close($llave);
            header("Location:update.php?id=$id");
            die();
        }

        if(strlen($modeloF)== " "){
            $_SESSION['modelo']="Error: Hay que indicar el modelo del coche";
            mysqli_close($llave);
            header("Location:update.php?id=$id");
            die();
        }

        if(strlen($colorF)== " "){
            $_SESSION['color']="Error: Hay que indicar el color del coche";
            mysqli_close($llave);
            header("Location:update.php?id=$id");
            die();
        }

        if(strlen($kilometrosF)== " "){
            $_SESSION['kilometros']="Error: Hay que indicar los kilometros del coche";
            mysqli_close($llave);
            header("Location:update.php?id=$id");
            die();
        }

        // Procedemos a actualizar la tabla con los datos que hemos cogido
        $q="update coches set marca=?, modelo=?, color=?, kilometros=? where id=?";
        $stmt = mysqli_stmt_init($llave);
        if(mysqli_stmt_prepare($stmt, $q)){
            mysqli_stmt_bind_param($stmt, 'sssii', $marcaF, $modeloF, $colorF, $kilometrosF, $id);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
        mysqli_close($llave);
        $_SESSION['mensaje']="El coche de id: $id ha sido actualizado";
        header("Location:main.php");
        die();

    }else{
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
        <title>Editar coche</title>
    </head>
    <body style="background-color: #216B46">
        <h3 style="color:white; margin:20px" class="text-center mt-4">Editar Coche</h3>
        <div class="container" >
                <!-- Formulario para crear el coche-->
            <form name="editarcoche" action="update.php?id=<?php echo $id; ?>" method="POST" class="text-light">
                    <!-- La marca del coche -->
                <div class="mb-3">
                    <label for="ma" class="form-label">Marca del Coche: </label>
                    <input type="text" class="form-control" id="ma" placeholder="Su marca" 
                    name="marca" value="<?php echo $marca ?>">
                    <?php
                        mostrarErrores("marca");
                    ?>
                </div>
                    <!-- El modelo del coche -->
                <div class="mb-3">
                    <label for="mo" class="form-label">Modelo del Coche:</label>
                    <input type="text" class="form-control" id="mo" placeholder="Su modelo" 
                    name="modelo" value="<?php echo $modelo ?>">
                    <?php
                        mostrarErrores("modelo");
                    ?>
                </div>
                    <!-- El color del coche -->
                <div class="mb-3">
                    <label for="co" class="form-label">Color del Coche:</label>
                    <select class="form-select" name="color" id="co" placeholder="Su color">
                        <option value="<?php echo $color ?>"><?php echo $color ?></option>
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
                    <!-- Los kilometros del coche -->
                <div class="mb-3">
                    <label for="ki" class="form-label">Kilometros del Coche:</label>
                    <input type="number" class="form-control" id="ki" placeholder="Sus kilometros" 
                    name="kilometros" value="<?php echo $kilometros ?>">
                    <?php
                        mostrarErrores("kilometros");
                    ?>
                </div>
                    <!-- Botones de la parte inferior -->
                <div class="d-flex">
                    <button type="submit" class="btn btn-warning my-2"  name="boton">
                        <i class="fa-regular fa-pen-to-square"></i> Editar
                    </button>&nbsp;
                    <a href="main.php" class="btn btn-light my-2">
                        <i class="fa-solid fa-rotate-left"></i> Volver a la lista de coches
                    </a>
                </div>
            </form>
        </div>
    </body>
</html>
<?php } ?>