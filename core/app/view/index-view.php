<div class="row">
            <div class="col-sm-6 col-lg-3">
              <div class="card mb-4 text-white bg-primary">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fs-4 fw-semibold"><?php echo count(ExamData::getAll()); ?> </div>
                    <div>Examenes</div>
                  </div>
                  <!--
                  <div class="dropdown">
                    <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <svg class="icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                      </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                  </div>
                -->
                </div>
                <br>

              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card mb-4 text-white bg-info">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fs-4 fw-semibold"><?php echo count(SellData::getAll()); ?> </div>
                    <div>Ventas</div>
                  </div>
                  <!--
                  <div class="dropdown">
                    <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <svg class="icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                      </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                  </div>
                -->
                </div>
                <br>

              </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
              <div class="card mb-4 text-white bg-warning">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fs-4 fw-semibold"><?php echo count(PersonData::getAll()); ?> </div>
                    <div>Pacientes</div>
                  </div>
                  <!--
                  <div class="dropdown">
                    <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <svg class="icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                      </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                  </div>
                -->
                </div>
                <br>

              </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
              <div class="card mb-4 text-white bg-success">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fs-4 fw-semibold"><?php echo count(UserData::getAll()); ?></div>
                    <div>Usuarios</div>
                  </div>
                  <!--
                  <div class="dropdown">
                    <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <svg class="icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                      </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                  </div>
                -->
                </div>
                <br>

              </div>
            </div>
            <!-- /.col-->
          </div>
<?php
  $amount = 0;
foreach(SellData::getAll() as $con){
  $tests = array();
  $exams = ExamData::getAllBy("sell_id",$con->id);
  foreach($exams as $ex){ $l = LabData::getById($ex->lab_id); $amount+=$l->price; $tests[]=$l->name;
  }
}
$exams_pending = ExamData::getAllBy("status",0);
$exams_done = ExamData::getAllBy("status",1);
?>
          <div class="row g-4">
                      <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-primary text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-money"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-6 fw-semibold text-primary">$<?php echo $amount ; ?></div>
                              <div class="text-body-secondary text-uppercase fw-semibold small">Ventas Hoy</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-info text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-money"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-6 fw-semibold text-info">$<?php echo $amount ; ?></div>
                              <div class="text-body-secondary text-uppercase fw-semibold small">Ventas Totales</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-primary text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-check"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-6 fw-semibold text-primary"><?php echo count($exams_done); ?></div>
                              <div class="text-body-secondary text-uppercase fw-semibold small">EXAMENES HECHOS</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-danger text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-clock"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-6 fw-semibold text-danger"><?php echo count($exams_pending   ); ?></div>
                              <div class="text-body-secondary text-uppercase fw-semibold small">EXAMENES PENDIENTES</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-->
                    </div>

<br><br>
            <div class="row">
            <div class="col-md-12">
              <div class="card mb-4">
                <div class="card-header">Bienvenido</div>
                <div class="card-body">
                  <p>Bienvenido al Sistema.</p>

                </div>
              </div>
            </div>
            <!-- /.col-->
          </div>