<?php 
// si el usuario no esta logeado
if(!isset($_SESSION["user_id"])){ Core::redir("./");}
$user= UserData::getById($_SESSION["user_id"]);
// si el id  del usuario no existe.
if($user==null){ Core::redir("./");}
?>
<?php if(isset($_GET["opt"]) && $_GET['opt']=="all"):
$contacts = ItemData::getAll();
  ?>










            <div class="row">
            <div class="col-md-12">
              <div class="card mb-4">
                <div class="card-header">Parametros de Pruebas de Laboratorio</div>
                <div class="card-body">
<a href="./?view=items&opt=new" class="btn btn-info">Nuevo Parametro</a>
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
          <a href="./?view=items&opt=edit&id=<?php echo $con->id; ?>" class="btn btn-warning btn-sm"><i class="bi-pencil"></i></a>
          <a href="./?action=items&opt=del&id=<?php echo $con->id; ?>" class="btn btn-danger btn-sm"><i class="bi-trash"></i></a>
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
                <div class="card-header">Parametros de Pruebas de Laboratorio</div>
                <div class="card-body">
<h2>Nuevo Parametro</h2>

                <div class="row">
                  <div class="col-md-6">
<form method="post" action="./?action=items&opt=add">
  <div class="form-group">
    <label for="exampleInputEmail1">Prueba de Laboratorio</label>
    <select name="lab_id" required class="form-control">
      <option value="">-- SELECCIONE --</option>
      <?php foreach(LabData::getAll() as $lab):?>
        <option value="<?php echo $lab->id;?>"><?php echo $lab->name;?></option>
      <?php endforeach; ?>
    </select>

  </div>
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
$contact = ItemData::getById($_GET["id"]);
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
<form method="post" action="./?action=items&opt=update">
  <input type="hidden" name="_id" value="<?php echo $contact->id; ?>">
  <div class="form-group">
    <label for="exampleInputEmail1">Nombre</label>
    <input type="text" required name="name" value="<?php echo $contact->name; ?>" class="form-control" id="exampleInputEmail1" placeholder="Nombre">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Unidad</label>
    <input type="text" required name="unit" value="<?php echo $contact->unit; ?>" class="form-control" id="exampleInputEmail1" placeholder="Unidad">
  </div>
    <div class="form-group">
    <label for="exampleInputEmail1">Minimo</label>
    <input type="text" required name="minimum" value="<?php echo $contact->minimum; ?>" class="form-control" id="exampleInputEmail1" placeholder="Minimo">
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Maximo</label>
    <input type="text" required name="maximum" value="<?php echo $contact->maximum; ?>" class="form-control" id="exampleInputEmail1" placeholder="Maximo">
  </div>

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
<?php endif; ?>
