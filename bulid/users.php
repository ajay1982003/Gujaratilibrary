

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    




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
            <?php include 'includes/header.php'; ?>

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Library /</span> Books</h4>

              <!-- Basic Bootstrap Table -->
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Book List</h5>
                  <a href="add-user.php" class="btn btn-primary">Add User</a>
                </div>
                <div class="card-body">
                  
                  <div class="mb-3">
                    <input type="text" id="searchBooks" class="form-control" placeholder="Search books by title, author, subject, publisher, or language..." />
                  </div>
                </div>
                <div class="table-responsive text-nowrap p-1">
                  <table class="table table-striped" id="usersTable">
                    <thead>
                      <tr>
                        <th>Sr No</th>
                        <th>Name</th>
                        <th>Email</th>
                        
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="usersTableBody">
                      <tr><td colspan="11" class="text-center text-muted py-4"><i class="bx bx-loader bx-spin"></i> Loading users...</td></tr>
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
      $(document).ready(function(){
        
        var table = $('#usersTable').DataTable({
           dom: 'rtip',
          ajax: {
            url: "api/get-users.php",
            type: "POST"
          },
          columns: [
            { data: "sr_no" },
            { data: "name" },
            { data: "email" },
           
            { data: "actions", render: function(data, type, row) {
              return '<a href="delete-user.php?user_id=' + row.id + '" class="text-danger" onclick="return confirm(\'Are you sure you want to delete this user?\')" title="Delete User"><i class="bx bx-trash bx-sm"></i></a>'
                }}
          ]
        });

        $('#searchBooks').on('keyup', function() {
          table.search(this.value).draw();
        });
      })
    </script>
    
</body>
</html>