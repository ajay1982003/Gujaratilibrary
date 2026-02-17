<?php
require_once __DIR__ . '/app/core/database.php';
require_once __DIR__ . '/app/controllers/BookingissueController.php';

$bookingIssueController = new BookingissueController();
$issueHistory = $bookingIssueController->getIssueHistory();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management - Gujarati Library</title>
        <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/images/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

     <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="./vendor/fonts/boxicons.css" />


     <!-- Core CSS -->
    <link rel="stylesheet" href="./vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="./vendor/css/theme-default.css" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="./assets/css/style.css" />
    
      <!--datatables css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
       
        <!-- Menu -->
        <?php include 'includes/menu.php'; ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Library /</span> Book History</h4>

              <!-- Book History Table -->
              <div class="card">
                <div class="card-header">
                  <h5 class="mb-0">Book Issue History</h5>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <input type="text" id="searchHistory" class="form-control" placeholder="Search by book name, user name, or status..." />
                  </div>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table table-striped" id="historyTable">
                    <thead>
                      <tr>
                        <th>Sr No</th>
                        <th>નામ (Book Name)</th>
                        <th>વપરાશીનામ (User Name)</th>
                        <th>આધુનિક (Issued On)</th>
                        <th>Return Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                   
                  </table>
                </div>
              </div>
              <!--/ Book History Table -->

            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  © <script>document.write(new Date().getFullYear());</script> Gujarati Library Management System
                </div>
                <div>
                  <a href="#" class="footer-link me-4">Help</a>
                  <a href="#" class="footer-link me-4">Contact</a>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>



    <!-- Bootstrap JS -->
    <script src="./vendor/js/bootstrap.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    
    <script>

        $('document').ready(function(){

          $('#historyTable').DataTable( {
    ajax: {
        url: './api/search-book-history.php',
        dataSrc: 'data'
    },
    columns: [ 
            { data: 'book_id' },
            { data: 'book_name' },
            { data: 'issued_to' },
            { data: 'issue_date' },
            { data: 'return_date' },
            { data: 'status' },
           

    ]
} );

        });

    </script>

      

    <script>
    </script>
</body>
</html>
