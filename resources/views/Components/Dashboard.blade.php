@extends('Layouts.Admin')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <h1 class="m-0 font-weight-bold p-2 tabTitle">DASHBOARD</h1>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-gradient-info card card-primary elevation-3">
                        <div class="inner">
                            <h3 class="font-weight-bold text-white totalMembers">0</h3>
                            <h5 class="font-weight-bold text-white">Total Members</h5>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-gradient-success card card-primary elevation-3">
                        <div class="inner">
                            <h3 class="font-weight-bold text-white totalMigs">0</h3>
                            <h5 class="font-weight-bold text-white">Total MIGS</h5>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-gradient-primary card card-primary elevation-3">
                        <div class="inner">
                            <h3 class="font-weight-bold text-white totalNONMIGS">0</h3>
                            <h5 class="font-weight-bold text-white">Total NON-MIGS</h5>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="small-box bg-gradient-danger card card-primary elevation-3">
                        <div class="inner">
                            <h3 class="font-weight-bold text-white totalReceived">0</h3>
                            <h5 class="font-weight-bold text-white">Total Received</h5>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline elevation-3 p-2">
                        <div class="table-responsive">
                             <table id="dashboardTable" class="table table-hover table-bordered table-striped m-0">
                                 <thead>
                                    <tr class="bg-primary">
                                        <th class="p-2 text-center align-middle">
                                            <h5 class="font-weight-bolder m-0 p-0">BRANCH</h5>
                                        </th>
                                        <th class="p-2 text-center align-middle" width="50%">
                                            <h5 class="font-weight-bolder m-0 p-0">Total Received</h5>
                                         </th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 </tbody>
                             </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection