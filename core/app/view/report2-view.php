<?php 

if(isset($_GET["start_at"]) && isset($_GET['finish_at'])){
$contacts = PaymentData::getAllByRange($_GET['start_at'],$_GET['finish_at']);

}else{
  $contacts= array();
}


  ?>





            <div class="row">
            <div class="col-md-12">
              <div class="card mb-4">
                <div class="card-header">Reporte de Pagos</div>
                <div class="card-body">


<form >
<div class="row">
  <div class="col-md-6">
  <div class="form-group">
    <label for="exampleInputEmail1">Inicio</label>
    <input type="date" name="start_at" class="form-control" required>

  </div>
  </div>
  <div class="col-md-6">
  <div class="form-group">
    <label for="exampleInputEmail1">Fin</label>
    <input type="date" name="finish_at" class="form-control" required>

  </div>
  </div>
</div>
<input type="hidden" name="view" value="report2">



<br>
  <div class="d-grid gap-2">
  <button type="submit" class="btn btn-primary ">Generar Reporte</button>
</div>
</form>


                  <!-- /.row--><br><br>
                  <div class="table-responsive">

<?php if(count($contacts)>0):?>
                    <table class="table border mb-0">
                      <thead class="table-light fw-semibold">
                        <tr class="align-middle">

                          <th>#</th>
                          <th class="">Paciente</th>
                          <th class="">Prueba(s)</th>
                          <th class="">$ Monto</th>
                          <th class="">Estado</th>
                          <th class="">Fecha</th>

                          
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>

    <?php $total=0; foreach($contacts as $con):
      $sell = SellData::getById($con->sell_id);
      $p = PersonData::getById($sell->person_id);
        $amount = 0;
        $tests = array();
        $exams = ExamData::getAllBy("sell_id",$con->sell_id);
        foreach($exams as $ex){ $l = LabData::getById($ex->lab_id); $amount+=$l->price; $tests[]=$l->name;}
        ?>
      <tr>
        <td><a href="./?view=sells&opt=open&id=<?php echo $con->id; ?>" class="btn btn-link btn-sm">#<?php echo $con->id; ?></a></td>
        <td><?php echo $p->name." ".$p->lastname; ?></td>
        <td><?php echo implode(",",$tests); ?></td>
        <td>$ <?php echo number_format($amount,2,".",","); ?></td>
        
        <td>
            <span class="badge text-bg-success">Finalizado</span>

</td>
        <td><?php echo $con->created_at; ?></td>

        <td>

        </td>
      </tr>
    <?php $total+=$amount; endforeach; ?>
                      </tbody>
                    </table>
<h1>Total: $<?php echo number_format($total,2,".",","); ?></h1>

<?php else:?>
  <p class="alert alert-warning">No hay Ventas</p>
<?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col-->
          </div>





