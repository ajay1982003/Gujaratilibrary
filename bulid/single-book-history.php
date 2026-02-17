<?php

require_once __DIR__ . '/app/helpers/SessionHelper.php';
require_once __DIR__ . '/app/controllers/BookingissueController.php';
require_once __DIR__ . '/app/controllers/BookController.php';




?>
<?php
SessionHelper::requireLogin();
$bookController = new BookController();

$selectedBookId = isset($_GET['book_id']) ? intval($_GET['book_id']) : null;
$bookbyid = $bookController->getBookById($selectedBookId);
$bookTitle = $bookbyid['vishay'] ?? 'Unknown Book';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Book History</title>
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
    <!-- DataTables CSS -->
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
            <?php include 'includes/header.php'; ?>

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Library /</span> Books</h4>

              <!-- Basic Bootstrap Table -->
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">History for: <span class="text-primary"><?php echo htmlspecialchars($bookTitle); ?></span></h5>
                  <a href="books.php" class="btn btn-secondary btn-sm">
                    <i class="bx bx-arrow-back me-1"></i> Back to Books
                  </a>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <input type="text" id="searchBooks" class="form-control" placeholder="Search books by title, author, subject, publisher, or language..." />
                  </div>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table table-striped" id="booksTable">
                      <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Issued To</th>
                                        <th>Contact</th>
                                        <th>Issue Date</th>
                                        <th>Expected Return</th>
                                        <th>Actual Return</th>
                                        <th>Status</th>
                                      
                                    </tr>
                                </thead>
                 
                  </table>
                </div>
                
                  <!-- Pagination Section -->
                <div id="paginationContainer"></div>
              </div>
             
              <!--/ Basic Bootstrap Table -->

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

            <div class="content-backdrop fade" ></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>


  
    <!-- Return Book Modal -->
    <div class="modal fade" id="returnBookModal" tabindex="-1" role="dialog" aria-labelledby="returnBookModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="returnBookModalLabel">Return Book</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="returnBookForm">
              <input type="hidden" id="returnBookId" value="">
              <div class="mb-3">
                <label class="form-label" for="returnDate">પરત કરવાની તારીખ (Return Date)</label>
                <input type="date" class="form-control" id="returnDate" required />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="submitReturnBook()">Return Book</button>
          </div>
        </div>
      </div>
    </div>


</body>
</html>

 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script> 
<script>

 

$(document).ready(function () {
    var table = $('#booksTable').DataTable({
        dom: 'rtip', // Hide default search box
        ajax: {
            url: './api/single-book-history.php',
            type: 'GET',
            data: {
                book_id: <?php echo $selectedBookId ?? 0; ?>
            },
            dataSrc: 'data'
        },
        columns: [
            { data: 'sr_no' },
            { data: 'issued_to' },
            { data: 'issued_to_contact' },
            { data: 'issue_date' },
            { data: 'expected_return_date' },
            { data: 'actual_return_date' },
            { 
              render: function(data, type, row) {
                return '<span class="badge ' + row.status_class + '">' + row.status + '</span>';
              }

              
             },
           
        ],
        language: {
             emptyTable: "No history found for this book."
        }
    });

    // Custom search functionality
    $('#searchBooks').on('keyup', function () {
        table.search(this.value).draw();
    });
});
</script>