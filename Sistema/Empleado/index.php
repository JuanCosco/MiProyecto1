<?php
require 'empleado.php';

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD con php y MySQL (simple)</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</head>

<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Empleado</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <input type="hidden" required name="txtID" value="<?php echo $txtID; ?> " placeholder="" id="txtID" require="">
                                <div class="form-group col-md-4">
                                    <label for="">Nombre(s):</label>
                                    <input type="text" name="txtNombre" class="form-control <?php echo (isset($error['Nombre'])) ? "is-invalid" : ""; ?> " require value="<?php echo $txtNombre; ?>" placeholder="" id="txtNombre" require="">
                                    <div class="invalid-feedback">
                                        <?php echo (isset($error['Nombre'])) ? $error['Nombre'] : ""; ?>
                                    </div>
                                    <br>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Apellido Paterno:</label>
                                    <input type="text" name="txtApellidoP" class="form-control <?php echo (isset($error['ApellidoP'])) ? "is-invalid" : ""; ?> " require value="<?php echo $txtApellidoP; ?>" placeholder="" id="txtApellidoP" require="">
                                    <div class="invalid-feedback">
                                        <?php echo (isset($error['ApellidoP'])) ? $error['ApellidoP'] : ""; ?>
                                    </div>
                                    <br>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Apellido Materno:</label>
                                    <input type="text" class="form-control <?php echo (isset($error['ApellidoM'])) ? "is-invalid" : ""; ?> " name="txtApellidoM" require value="<?php echo $txtApellidoM; ?>" placeholder="" id="txtApellidoM" require="">
                                    <div class="invalid-feedback">
                                        <?php echo (isset($error['ApellidoM'])) ? $error['ApellidoM'] : ""; ?>
                                    </div>
                                    <br>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">Correo:</label>
                                    <input type="email" class="form-control <?php echo (isset($error['Correo'])) ? "is-invalid" : ""; ?> " name="txtCorreo" require value="<?php echo $txtCorreo; ?>" placeholder="" id="txtCorreo" require="">
                                    <div class="invalid-feedback">
                                        <?php echo (isset($error['Correo'])) ? $error['Correo'] : ""; ?>
                                    </div>
                                    <br>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">Foto:</label>
                                    <?php if ($txtFoto != "") { ?>
                                        <br>
                                        <img class="img-thumbnail rounded mx-auto d-block" width="100px" src="../Imagenes/<?php echo $txtFoto; ?>" />
                                        <br />
                                        <br />
                                    <?php } ?>
                                    <input type="file" class="form-control" accept="image/*" name="txtFoto" value="<?php echo $txtFoto; ?> " placeholder="" id="txtFoto" require="">
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" value="btnAgregar" <?php echo $accionAgregar; ?> type="submit" name="accion">Agregar</button>
                            <button class="btn btn-warning" value="btnModificar" <?php echo $accionModificar; ?> type="submit" name="accion">Modificar</button>
                            <button class="btn btn-danger" value="btnEliminar" onclick=" return Confirmar('¿Realmente deseas borrar?');" <?php echo $accionEliminar; ?> type="submit" name="accion">Eliminar</button>
                            <button class="btn btn-primary" value="btnCancelar" <?php echo $accionCancelar; ?> type="submit" name="accion">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Agregar nuevo registro +
            </button>
            <br>
            <br>
        </form>

        <div class="row">
            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Foto</th>
                        <th>Nombre Completo</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <?php foreach ($listaEmpleados as $empleado) { ?>
                    <tr>
                        <td> <img class="img-thumbnail" width="100px" src="../Imagenes/<?php echo $empleado['Foto']; ?>" /></td>
                        <td><?php echo $empleado['Nombre']; ?> <?php echo $empleado['ApellidoP']; ?> <?php echo $empleado['ApellidoM']; ?></td>
                        <td><?php echo $empleado['Correo']; ?></td>
                        <td>
                            <form action="" method="post">

                                <input type="hidden" name="txtID" value="<?php echo $empleado['ID']; ?>">
                                <input type="submit" value="Seleccionar" class="btn btn-info" name="accion">
                                <button class="btn btn-danger" value="btnEliminar" onclick=" return Confirmar('¿Realmente deseas borrar?');" type="submit" name="accion">Eliminar</button>
                            </form>
                        </td>



                    </tr>
                <?php } ?>
            </table>

        </div>
        <?php if ($mostrarModal) { ?>
            <<script>
                $('#exampleModal').modal('show');
                </script>

            <?php } ?>
            <script>
                function Confirmar(Mensaje) {
                    return (confirm(Mensaje)) ? true : false;
                }
            </script>
    </div>
</body>

</html>