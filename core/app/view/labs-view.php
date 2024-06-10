<?php 
// si el usuario no esta logeado
if(!isset($_SESSION["user_id"])){ Core::redir("./");}
$user= UserData::getById($_SESSION["user_id"]);
// si el id  del usuario no existe.
if($user==null){ Core::redir("./");}
?>
<?php if(isset($_GET["opt"]) && $_GET['opt']=="all"):
$contacts = LabData::getAll();
  ?>










            <div class="row">
            <div class="col-md-12">
              <div class="card mb-4">
                <div class="card-header">Pruebas de Laboratorio</div>
                <div class="card-body">
<a href="./?view=labs&opt=new" class="btn btn-secondary">Nueva Prueba</a>
                  <!-- /.row--><br><br>
                  <div class="table-responsive">

<?php if(count($contacts)>0):?>
                    <table class="table border mb-0">
                      <thead class="table-light fw-semibold">
                        <tr class="align-middle">

                          <th>#</th>
                          <th >Nombre</th>

                          <th >Precio</th>
                          
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>

    <?php foreach($contacts as $con):?>
      <tr>
        <td><a href="./?view=labs&opt=open&id=<?php echo $con->id; ?>" class="btn btn-link btn-sm">#<?php echo $con->id; ?></a></td>
        <td><?php echo $con->name; ?></td>
        <td>$ <?php echo number_format($con->price,2,".",","); ?></td>

        <td>
          <a href="./?view=labs&opt=items&id=<?php echo $con->id; ?>" class="btn btn-info btn-sm"><i class="bi-pencil"></i> Parametros</a>
          <a href="./?view=labs&opt=edit&id=<?php echo $con->id; ?>" class="btn btn-warning btn-sm"><i class="bi-pencil"></i></a>
          <a href="./?action=labs&opt=del&id=<?php echo $con->id; ?>" class="btn btn-danger btn-sm"><i class="bi-trash"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
                      </tbody>
                    </table>
<?php else:?>
  <p class="alert alert-warning">No hay Pruebas de Laboratorio</p>
<?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col-->
          </div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<div class="">
<div class="row">
<div class="col-md-12">

              <div class="card mb-4">
                <div class="card-header">Pruebas de Laboratorio</div>
                <div class="card-body">
<h2>Nueva Prueba</h2>

                <div class="row">
                  <div class="col-md-6">
<form method="post" action="./?action=labs&opt=add">
  <div class="form-group">
    <label for="exampleInputEmail1">Nombre</label>
    <input type="text" required name="name" class="form-control" id="exampleInputEmail1" placeholder="Nombre">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Descripcion</label>
    <input type="text" required name="description" class="form-control" id="exampleInputEmail1" placeholder="Descripcion">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Precio $</label>
    <input type="text" required name="price" class="form-control" id="exampleInputEmail1" placeholder="Precio">
  </div>
<br>
  <div class="d-grid gap-2">
  <button type="submit" class="btn btn-primary ">Guardar</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):
$contact = LabData::getById($_GET["id"]);
  ?>
  <div class="">
<div class="row">
<div class="col-md-12">

              <div class="card mb-4">
                <div class="card-header">Pruebas de Laboratorio</div>
                <div class="card-body">
<h2>Editar Prueba</h2>
<div class="row">
  <div class="col-md-6">
<form method="post" action="./?action=labs&opt=update">
  <input type="hidden" name="_id" value="<?php echo $contact->id; ?>">
  <div class="form-group">
    <label for="exampleInputEmail1">Nombre</label>
    <input type="text" required name="name" value="<?php echo $contact->name; ?>" class="form-control" id="exampleInputEmail1" placeholder="Nombre">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Descripcion</label>
    <input type="text" required name="description" value="<?php echo $contact->description; ?>" class="form-control" id="exampleInputEmail1" placeholder="Descripcion">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Precio</label>
    <input type="text" required name="price" value="<?php echo $contact->price; ?>" class="form-control" id="exampleInputEmail1" placeholder="Precio">
  </div>
  <br>
  <div class="d-grid gap-2">
  <button type="submit" class="btn btn-success ">Actualizar</button>
</div>
</form>

</div>
</div>

</div>
</div>

</div>
</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="items"):
  $contacts = ItemData::getAllBy("lab_id",$_GET["id"]);
  ?>





<!-- Button trigger modal -->






            <div class="row">
            <div class="col-md-12">
              <div class="card mb-4">
                <div class="card-header">Parametros de Pruebas de Laboratorio</div>
                <div class="card-body">
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#exampleModal">
  Nuevo Parametro
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo parametro para la prueba</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form method="post" action="./?action=items&opt=add2">
  <input type="hidden" name="lab_id" value="<?php echo $_GET['id']?>">
  <div class="form-group">
    <label for="exampleInputEmail1">Nombre</label>
    <input type="text" required name="name" class="form-control" id="exampleInputEmail1" placeholder="Nombre">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Unidad</label>
    <input type="text" required name="unit" class="form-control" id="exampleInputEmail1" placeholder="Unidad">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Minimo</label>
    <input type="text" required name="minimum" class="form-control" id="exampleInputEmail1" placeholder="Minimo">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Maximo</label>
    <input type="text" required name="maximum" class="form-control" id="exampleInputEmail1" placeholder="Maximo">
  </div>

<br><br>
  <div class="d-grid gap-2">
  <button type="submit" class="btn btn-primary ">Guardar</button>
</div>
</form>

      </div>


    </div>
  </div>
</div>

                  <!-- /.row--><br><br>
                  <div class="table-responsive">

<?php if(count($contacts)>0):?>
                    <table class="table border mb-0">
                      <thead class="table-light fw-semibold">
                        <tr class="align-middle">

                          <th>#</th>
                          <th class="">Prueba</th>
                          <th class="">Parametro</th>
                          <th class="">Unidad</th>
                          <th class="">Min</th>
                          <th class="">Max</th>

                          
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>

    <?php foreach($contacts as $con):?>
      <tr>
        <td><a href="./?view=items&opt=open&id=<?php echo $con->id; ?>" class="btn btn-link btn-sm">#<?php echo $con->id; ?></a></td>
        <td><?php echo LabData::getByID($con->lab_id)->name; ?></td>
        <td><?php echo $con->name; ?></td>
        <td><?php echo $con->unit; ?></td>
        <td><?php echo $con->minimum; ?></td>
        <td><?php echo $con->maximum; ?></td>

        <td>
          <a href="./?action=items&opt=del2&id=<?php echo $con->id; ?>" class="btn btn-danger btn-sm"><i class="bi-trash"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
                      </tbody>
                    </table>
<?php else:?>
  <p class="alert alert-warning">No hay Parametros agregados.</p>
<?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col-->
          </div>
<?php endif; ?>
