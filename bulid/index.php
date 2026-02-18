
<?php
session_start();
require_once __DIR__ . '/app/controllers/BookController.php';
require_once __DIR__ . '/app/models/BookIssue.php';
require_once __DIR__ . '/app/helpers/SessionHelper.php';
require_once __DIR__ . '/app/controllers/BookingissueController.php';

// Check if user is logged in
SessionHelper::requireLogin();

$controller = new BookController();
$bookissue = new BookingissueController();
$countbooks = $controller->getTotalBooks();
$issuedbooks = $controller->getissuedtotalbooks();
$availablebooks = $controller->getavailableBooks();

$issueHistory = $bookissue->getissuedBooks();




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

    <!-- Helpers -->
    <script src="./vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="./assets/js/config.js"></script>
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
              <!-- Welcome Banner -->
              <div class="row mb-4">
                <div class="col-12">
                  <div class="card bg-primary text-white">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <h3 class="card-title text-white mb-2">આપનું સ્વાગત છે!</h3>
                          <p class="mb-0">ગુજરાતી લાઇબ્રેરી મેનેજમેન્ટ સિસ્ટમમાં આપનું સ્વાગત છે</p>
                        </div>
                        <div class="text-end">
                          <i class="bx bx-book bx-lg"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Statistics Cards -->
              <div class="row mb-4">
                <!-- Total Books Card -->
                <div class="col-lg-3 col-md-6 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <span class="d-block mb-2">કુલ પુસ્તકો</span>
                          <h3 class="card-title mb-2"><?php echo $countbooks; ?></h3>
                          <small class="text-success"><i class="bx bx-up-arrow-alt"></i> +5.2%</small>
                        </div>
                        <div class="text-primary">
                          <i class="bx bx-book bx-lg"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Issued Books Card -->
                <div class="col-lg-3 col-md-6 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <span class="d-block mb-2">જારી કરેલ પુસ્તકો</span>
                          <h3 class="card-title mb-2"><?php echo $issuedbooks; ?></h3>
                          <small class="text-warning"><i class="bx bx-circle"></i> 27.4%</small>
                        </div>
                        <div class="text-warning">
                          <i class="bx bx-send bx-lg"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Available Books Card -->
                <div class="col-lg-3 col-md-6 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <span class="d-block mb-2">ઉપલબ્ધ પુસ્તકો</span>
                          <h3 class="card-title mb-2"><?php echo $availablebooks; ?></h3>
                          <small class="text-success"><i class="bx bx-check-circle"></i> અચલ</small>
                        </div>
                        <div class="text-success">
                          <i class="bx bx-check-circle bx-lg"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Total Users Card -->
                <div class="col-lg-3 col-md-6 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <span class="d-block mb-2">કુલ ભોક્તાઓ</span>
                          <h3 class="card-title mb-2">156</h3>
                          <small class="text-success"><i class="bx bx-up-arrow-alt"></i> +2.1%</small>
                        </div>
                        <div class="text-info">
                          <i class="bx bx-user bx-lg"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Charts Row -->
              <div class="row mb-4">
                <!-- Books Distribution Chart -->
                <div class="col-lg-6 mb-3">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-title mb-0">પુસ્તક વર્ગીકરણ</h5>
                    </div>
                    <div class="card-body">
                      <canvas id="categoryChart"></canvas>
                    </div>
                  </div>
                </div>

                <!-- Monthly Activity Chart -->
                <div class="col-lg-6 mb-3">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-title mb-0">માસિક સંચالન</h5>
                    </div>
                    <div class="card-body">
                      <canvas id="activityChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Recent Activity -->
              <div class="row mb-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="card-title mb-0">તાજેતરની પુસ્તક જારીકરણ</h5>
                      <a href="book-history.php" class="btn btn-sm btn-primary">તમામ જોઈ</a>
                    </div>
                    <div class="table-responsive text-nowrap pb-5">
                      <table class="table table-hover">
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
                        <tbody>
                          <?php
if (!empty($issueHistory)) {
  $sr_no = 1;
  $count = 0;
  foreach ($issueHistory as $record) {
    if ($count >= 5)
      break; // Show only the 5 most recent records

    $book_name = htmlspecialchars($record['book_name'] ?? 'Unknown');
    $issued_to = htmlspecialchars($record['issued_to'] ?? 'N/A');
    $issue_date = date('Y-m-d', strtotime($record['issue_date']));
    $actual_return = $record['actual_return_date'] ? date('Y-m-d', strtotime($record['actual_return_date'])) : '—';
    $status = strtolower($record['status'] ?? 'issued');

    $badgeClass = ($status === 'returned') ? 'bg-label-success' : 'bg-label-warning';
    $badgeText = ucfirst($status);
?>
                              <tr>
                                <td><?php echo $sr_no; ?></td>
                                <td><strong><?php echo $book_name; ?></strong></td>
                                <td><?php echo $issued_to; ?></td>
                                <td><?php echo $issue_date; ?></td>
                                <td><?php echo $actual_return; ?></td>
                                <td>
                                  <?php if ($status === 'issued'): ?>
                                    <div class="dropdown">
                                      <button type="button" class="btn btn-sm btn-label-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Issued
                                      </button>
                                      <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="openReturnModal(<?php echo $record['book_id']; ?>)">Return Book</a></li>
                                      </ul>
                                    </div>
                                  <?php
    else: ?>
                                    <span class="badge <?php echo $badgeClass; ?> me-1"><?php echo $badgeText; ?></span>
                                  <?php
    endif; ?>
                                </td>
                              </tr>
                          <?php
    $sr_no++;
    $count++;
  }
}
else {
?>
                        <tr>
                          <td colspan="6" class="text-center text-muted py-4">No book issue history found</td>
                        </tr>
<?php
}
?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Alerts Section -->
              <div class="row">
                <div class="col-12">
                  <div class="card border-left-4 border-left-warning">
                    <div class="card-header bg-light">
                      <h5 class="card-title mb-0"><i class="bx bx-time-five me-2"></i>ધ્યાન આપવાના બાબત</h5>
                    </div>
                    <div class="card-body">
                      <div class="alert alert-warning mb-3" role="alert">
                        <strong>મુદતીશ પુસ્તકો!</strong> 3 પુસ્તકો આજે સુધીમાં મુદતી છે. તમે આ પુસ્તકો તરત જ ફરી કરજો.
                      </div>
                      <div class="alert alert-info mb-0" role="alert">
                        <strong>અધવચ્ચી સ્થિતિ:</strong> આ મહિનામાં 1,245 પુસ્તકોમાંથી 342 (27.4%) જારી છે અને 903 (72.6%) ઉપલબ્ધ છે.
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  © <script>document.write(new Date().getFullYear());</script> Gujarati Library Management System - સર્વ હક્ક આરક્ષિત
                </div>
                <div>
                  <a href="#" class="footer-link me-4">મદદ</a>
                  <a href="#" class="footer-link me-4">સંપર્ક</a>
                  <a href="#" class="footer-link me-4">ગોપનીયતા</a>
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

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="./vendor/libs/jquery/jquery.js"></script>
    <script src="./vendor/libs/popper/popper.js"></script>
    <script src="./vendor/js/bootstrap.js"></script>
    <script src="./vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    
    <script src="./vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Main JS -->
    <script src="./assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="./assets/js/dashboards-analytics.js"></script>

    <script>
      // Category Distribution Chart
      const categoryCtx = document.getElementById('categoryChart').getContext('2d');
      new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
          labels: ['ગલ્પ', 'ધર્મશાસ્ત્ર', 'ઇતિહાસ', 'વિજ્ઞાન', 'જીવનચરિત'],
          datasets: [{
            label: 'પુસ્તક સંખ્યા',
            data: [350, 280, 220, 195, 200],
            backgroundColor: [
              'rgba(105, 108, 255, 0.8)',
              'rgba(254, 180, 73, 0.8)',
              'rgba(80, 227, 194, 0.8)',
              'rgba(255, 129, 130, 0.8)',
              'rgba(130, 202, 255, 0.8)'
            ],
            borderColor: [
              'rgba(105, 108, 255, 1)',
              'rgba(254, 180, 73, 1)',
              'rgba(80, 227, 194, 1)',
              'rgba(255, 129, 130, 1)',
              'rgba(130, 202, 255, 1)'
            ],
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });

      // Monthly Activity Chart
      const activityCtx = document.getElementById('activityChart').getContext('2d');
      new Chart(activityCtx, {
        type: 'line',
        data: {
          labels: ['જાન્યુ', 'ફેબ્રુ', 'માર્ચ', 'એપ્રિલ', 'મે', 'જુન'],
          datasets: [{
            label: 'બહાર આવેલ પુસ્તક',
            data: [280, 320, 310, 340, 335, 342],
            borderColor: 'rgba(105, 108, 255, 1)',
            backgroundColor: 'rgba(105, 108, 255, 0.1)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: 'rgba(105, 108, 255, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
          },
          {
            label: 'પરત પુસ્તક',
            data: [240, 260, 280, 290, 310, 320],
            borderColor: 'rgba(80, 227, 194, 1)',
            backgroundColor: 'rgba(80, 227, 194, 0.1)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: 'rgba(80, 227, 194, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom'
            }
          },
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });

      
    </script>
</body>
</html>
