<?php
session_start();
require_once __DIR__ . '/app/core/database.php';
require_once __DIR__ . '/app/models/book.php';
require_once __DIR__ . '/app/controllers/BookController.php';
require_once __DIR__ . '/app/helpers/SessionHelper.php';

// Check if user is logged in
SessionHelper::requireLogin();

$controller = new BookController();

// Pagination settings
$items_per_page = 10;
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Get paginated books
$books = $controller->getBooksPaginated($current_page, $items_per_page);
$total_books = $controller->getTotalBooks();
$total_pages = ceil($total_books / $items_per_page);

// Calculate starting row number
$offset = ($current_page - 1) * $items_per_page;
$sr_no = $offset + 1;

$book = $controller->getAllBooks();



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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <style>  
    /* Pagination Styling */
      #paginationContainer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
      }
      
      .page-link {
        color: #696cff;
        border-color: #e3e6f0;
        transition: all 0.3s ease;
      }
      
      .page-link:hover {
        color: #fff;
        background-color: #696cff;
        border-color: #696cff;
        box-shadow: 0 4px 12px rgba(105, 108, 255, 0.2);
      }
      
      .page-item.active .page-link {
        background-color: #696cff;
        border-color: #696cff;
        box-shadow: 0 4px 12px rgba(105, 108, 255, 0.3);
      }
      
      .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
      }
      
      #paginationContainer .pagination {
        gap: 4px;
      }
      
      #paginationContainer .page-link {
        padding: 0.5rem 0.75rem;
        font-weight: 500;
      }
    </style>
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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Library /</span> Books</h4>

              <!-- Basic Bootstrap Table -->
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Book List</h5>
                </div>
                <div class="card-body">
                  <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="languageSwitch" checked>
                      <label class="form-check-label" for="languageSwitch">
                        Gujarati Typing
                      </label>
                  </div>
                  <div class="mb-3">
                    <input type="text" id="searchBooks" class="form-control" placeholder="Search books by title, author, subject, publisher, or language..." />
                  </div>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table table-striped" id="booksTable">
                    <thead>
                      <tr>
                        <th>Sr No</th>
                        <th><i class='bx bx-history'></i></th>
                        <th>નામ (Title)</th>
                        <th>ગ્રંથકાર (Author)</th>
                        <th>વિષય (Subject)</th>
                        <th>પ્રકાશક (Publisher)</th>
                        <th>Status</th>
                        <th>ભાષા (Language)</th>
                        <th>Pages</th>
                        <th>Subject Name</th>
                        <th>Category</th>
                      </tr>
                    </thead>
                    <tbody id="booksTableBody">
                      <tr><td colspan="11" class="text-center text-muted py-4"><i class="bx bx-loader bx-spin"></i> Loading books...</td></tr>
                    </tbody>
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

    <!-- Issue Book Modal -->
    <div class="modal fade" id="issueBookModal" tabindex="-1" role="dialog" aria-labelledby="issueBookModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <?php

?>
          <div class="modal-header">
            <h5 class="modal-title" id="issueBookModalLabel">Issue Book of </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="issueBookForm">
              <input type="hidden" id="issueBookId" value="">
              <div class="mb-3">
                <label class="form-label" for="issuedName">વ્યક્તિનું નામ (Name)</label>
                <input type="text" class="form-control" id="issuedName" placeholder="નામ દાખલ કરો" required />
              </div>
              <div class="mb-3">
                <label class="form-label" for="issuedPhone">ફોન નંબર (Phone Number)</label>
                <input type="tel" class="form-control" id="issuedPhone" placeholder="ફોન નંબર દાખલ કરો" required />
              </div>
              <div class="mb-3">
                <label class="form-label" for="issuedEmail">ઇમેઇલ (Email)</label>
                <input type="email" class="form-control" id="issuedEmail" placeholder="ઇમેઇલ દાખલ કરો" />
              </div>
              <div class="mb-3">
                <label class="form-label" for="issuedDate">ઇશ્યૂ તારીખ (Issue Date)</label>
                <input type="date" class="form-control" id="issuedDate" required />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="submitIssueBook()">Issue Book</button>
          </div>
        </div>
      </div>
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
      let dataTable;

      function changeBookStatus(bookId, status) {
        if (!bookId || !status) {
          alert('Error: Invalid parameters');
          return;
        }

        const formData = new FormData();
        formData.append('book_id', bookId);
        formData.append('status', status);

        fetch('./api/update-book-status.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            dataTable.ajax.reload(); // Refresh DataTable
            alert('Book status updated successfully');
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error updating book status');
        });
      }

      function openIssueModal(bookId) {
        document.getElementById('issueBookId').value = bookId;
        document.getElementById('issuedName').value = '';
        document.getElementById('issuedPhone').value = '';
        document.getElementById('issuedEmail').value = '';
        
        // Set default date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('issuedDate').value = today;
        
        const modal = new bootstrap.Modal(document.getElementById('issueBookModal'));
        modal.show();
      }

      function submitIssueBook() {
        const bookId = document.getElementById('issueBookId').value;
        const issuedName = document.getElementById('issuedName').value.trim();
        const issuedPhone = document.getElementById('issuedPhone').value.trim();
        const issuedEmail = document.getElementById('issuedEmail').value.trim();
        const issuedDate = document.getElementById('issuedDate').value;

        if (!bookId || !issuedName || !issuedPhone || !issuedDate) {
          alert('Please fill in all required fields');
          return;
        }

        const formData = new FormData();
        formData.append('book_id', bookId);
        formData.append('status', 'issued');
        formData.append('issued_to', issuedName);
        formData.append('issued_to_contact', issuedPhone);
        formData.append('issued_to_email', issuedEmail);
        formData.append('issue_date', issuedDate);

        fetch('./api/update-book-status.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Close modal
            const modalElement = document.getElementById('issueBookModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
              modal.hide();
            }
            
            dataTable.ajax.reload(); // Refresh DataTable
            alert('Book issued successfully to ' + issuedName);
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error issuing book');
        });
      }

      function openReturnModal(bookId) {
        document.getElementById('returnBookId').value = bookId;
        // Set default date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('returnDate').value = today;
        const modal = new bootstrap.Modal(document.getElementById('returnBookModal'));
        modal.show();
      }

      function submitReturnBook() {
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
            
            dataTable.ajax.reload();
            alert('Book returned successfully');
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error returning book');
        });
      }

      // Initialize DataTable
      $(document).ready(function() {
        dataTable = $('#booksTable').DataTable({
          processing: true,
          serverSide: true,
          lengthChange: true,
          pageLength: 10,
          ajax: {
            url: './api/search-books-ajax.php',
            type: 'GET',
            data: function(d) {
              // Add search query from input
              d.search = {
                value: $('#searchBooks').val() || ''
              };
            }
          },
          columns: [
            { data: 'sr_no', orderable: false },
            {
              data: null,
              render: function(data, type, row) {
                return '<a href="single-book-history.php?book_id=' + row.id + '" class="text-secondary" title="View History"><i class="bx bx-history bx-sm"></i></a>';
              },
              orderable: false
            },
            { data: 'naam' },
            { data: 'granthkar' },
            { data: 'subject_name' },
            { data: 'prakashak' },
            {
              data: null,
              render: function(data, type, row) {
                let html = '<div class="dropdown">';
                html += '<button type="button" class="btn btn-l dropdown-toggle" data-bs-toggle="dropdown" style="padding: 0.25rem 0.5rem;">';
                html += '<span class="badge ' + row.status_class + '">' + row.status + '</span>';
                html += '</button>';
                html += '<ul class="dropdown-menu">';
                if(row.available_status === 'issued'){
                  html += '<li><a class="dropdown-item" href="javascript:void(0);" onclick="openReturnModal(' + row.id + ')">Mark is Return</a></li>';
                } else {
                  html += '<li><a class="dropdown-item" href="javascript:void(0);" onclick="openIssueModal(' + row.id + ')">Issued</a></li>';
                }
                html += '</ul>';
                html += '</div>';
                return html;
              },
              orderable: false
            },
            { data: 'bhasha' },
            { data: 'pages' },
            { data: 'subject_name' },
            { 
               data: 'category'
            }
          ],
          drawCallback: function() {
            // Reinitialize Bootstrap dropdowns after new content is loaded
            document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(element => {
              new bootstrap.Dropdown(element);
            });
          },
          order: [[0, 'asc']],
          language: {
            search: "Search books:",
            searchPlaceholder: "Type to search...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ books",
            infoEmpty: "No books found",
            zeroRecords: "No matching books found"
          }
        });

        // Reload table when search input changes
        $('#searchBooks').on('keyup', function() {
          dataTable.search($('#searchBooks').val()).draw();
        });

        // Reinitialize dropdowns on pagination
        $('#booksTable').on('draw.dt', function() {
          document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(element => {
            new bootstrap.Dropdown(element);
          });
        });
      });
    </script>
</body>
</html>

<script src="https://www.google.com/jsapi"></script>

<script>
google.load("elements", "1", {
  packages: "transliteration"
});

let transliterationControl;

function onLoad() {

  const options = {
    sourceLanguage: 'en',
    destinationLanguage: ['gu'],
    transliterationEnabled: true
  };

  transliterationControl =
    new google.elements.transliteration.TransliterationControl(options);

  transliterationControl.makeTransliteratable(['searchBooks']);
}

google.setOnLoadCallback(onLoad);


// Switch ON/OFF logic
document.getElementById('languageSwitch')
  .addEventListener('change', function () {

    transliterationControl.enableTransliteration(this.checked);

});
</script>
