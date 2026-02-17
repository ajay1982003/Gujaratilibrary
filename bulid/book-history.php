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

          var table = $('#historyTable').DataTable( {
            ajax: {
                url: './api/search-book-history.php',
                dataSrc: 'data'
            },
            columns: [ 
                    { data: 'sr_no' },
                    { data: 'book_name' },
                    { data: 'issued_to' },
                    { data: 'issue_date' },
                    { data: 'return_date' },
                    { 
                      data: null,
                      render: function(data, type, row) {
                        if (row.status === 'Issued') {
                          let html = '<div class="dropdown">';
                          html += '<button type="button" class=" badge bg-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">';
                          html += 'Issued';
                          html += '</button>';
                          html += '<ul class="dropdown-menu">';
                          html += '<li><a class="dropdown-item" href="javascript:void(0);" onclick="openReturnModal(' + row.book_id + ')">Return Book</a></li>';
                          html += '</ul>';
                          html += '</div>';
                          return html;
                        } else {
                          return '<span class="badge ' + row.status_class + '">' + row.status + '</span>';
                        }
                      }
                    }
            ]
        } );

        window.openReturnModal = function(bookId) {
            document.getElementById('returnBookId').value = bookId;
            // Set default date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('returnDate').value = today;
            const modal = new bootstrap.Modal(document.getElementById('returnBookModal'));
            modal.show();
        };

        window.submitReturnBook = function() {
            const bookId = document.getElementById('returnBookId').value;
            const returnDate = document.getElementById('returnDate').value;

            if (!bookId || !returnDate) {
              alert('Please select a return date');
              return;
            }

            const formData = new FormData();
            formData.append('book_id', bookId);
            formData.append('status', 'available'); 
            formData.append('return_date', returnDate);

            fetch('./api/update-book-status.php', {
              method: 'POST',
              body: formData
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                // Close modal
                const modalElement = document.getElementById('returnBookModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                  modal.hide();
                }
                
                table.ajax.reload();
                alert('Book returned successfully');
              } else {
                alert('Error: ' + data.message);
              }
            })
            .catch(error => {
              console.error('Error:', error);
              alert('Error returning book');
            });
        };

        });

    </script>

      

    <script>
    </script>
</body>
</html>
