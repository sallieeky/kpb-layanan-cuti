<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ITK - Layanan Permohonan Cuti</title>
    {{-- favicon --}}
    <link rel="icon" href="{{ asset('template/img/itk.png') }}">

    <!-- Custom fonts for this template-->
    <link href="{{ asset("template") }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="{{ asset("template") }}/https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset("template") }}/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="{{ asset("template") }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    @yield("css")

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                {{-- <div class="sidebar-brand-icon rotate-n-15"> --}}
                <div class="sidebar-brand-icon">
                    {{-- <i class="fas fa-laugh-wink"></i> --}}
                    <img src="{{ asset('template/img/itk.png') }}" alt="ITK Logo" width="50">
                </div>
                <div class="sidebar-brand-text mx-3">Layanan Cuti</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="/">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a class="nav-link" href="/logout">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <hr class="sidebar-divider">
            </li>

            <!-- Heading -->
            {{-- <div class="sidebar-heading">
                Admin
            </div>

            <li class="nav-item">
                <a class="nav-link" href="/tambah-data">
                    <i class="fas fa-fw fa-plus-square"></i>
                    <span>Tambah Data</span>
                </a>
                <a class="nav-link" href="/history">
                    <i class="fas fa-fw fa-history"></i>
                    <span>History</span>
                </a>
                <a class="nav-link" href="/logout">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li> --}}

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <h6>Layanan Permohonan Cuti</h6>
                    

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div style="min-height: 77vh">
                  @yield("content")
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; ITK (Layanan Permohonan Cuti) 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="{{ asset("template") }}/#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset("template") }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset("template") }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset("template") }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset("template") }}/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="{{ asset("template") }}/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset("template") }}/js/demo/chart-area-demo.js"></script>
    <script src="{{ asset("template") }}/js/demo/chart-pie-demo.js"></script>

    <script src="{{ asset("template") }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset("template") }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset("template") }}/js/demo/datatables-demo.js"></script>

    @yield("script")

</body>

</html>