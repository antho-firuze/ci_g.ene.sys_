   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Access Denied !
				<small>You are not authorized to access this page/process.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Unauthorized !</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> 580</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! You are not authorized.</h3>
					
          <p>
            Sorry !, we could not grant the access. Because you are not authorized to do this process.<br>
            Meanwhile, you may <a href="#" onclick="window.history.back();">return to previous page</a>.
          </p>

					{$message}

        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
