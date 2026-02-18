<?php
session_start();
require_once __DIR__ . '/app/helpers/SessionHelper.php';
require_once __DIR__ . '/app/controllers/BookController.php';

// Check if user is logged in
SessionHelper::requireLogin();

$bookController = new BookController();
$error = '';
$success = '';

// Get book ID from URL
$book_id = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;

if (!$book_id) {
    header('Location: books.php');
    exit();
}

// Fetch existing book data
$book = $bookController->getBookById($book_id);

if (!$book) {
    header('Location: books.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST['id'] = $book_id; // Ensure ID is set for update
    $result = $bookController->updateBook($_POST);
    if ($result['success']) {
        $success = $result['message'];
        // Re-fetch book data after update
        $book = $bookController->getBookById($book_id);
    }
    else {
        $error = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book - Gujarati Library</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/images/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="./vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="./vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="./vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="./assets/css/style.css" />

    <!-- Helpers -->
    <script src="./vendor/js/helpers.js"></script>
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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Books /</span> Update Book</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Update Book Details</h5>
                    
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
endif; ?>

                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <?php echo htmlspecialchars($success); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
endif; ?>

                        <form method="POST" action="">
                            
                            <!-- Basic Information -->
                            <h6 class="mb-3">1. Basic Information</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="naam" class="form-label">Book Name (Naam) *</label>
                                    <input type="text" class="form-control" id="naam" name="naam" value="<?php echo htmlspecialchars($book['naam'] ?? ''); ?>" required />
                                </div>
                                <div class="col-md-6">
                                    <label for="bhasha" class="form-label">Language (Bhasha)</label>
                                    <input type="text" class="form-control" id="bhasha" name="bhasha" value="<?php echo htmlspecialchars($book['bhasha'] ?? ''); ?>" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="categoryName" class="form-label">Category</label>
                                    <input type="text" class="form-control" id="categoryName" name="categoryName" value="<?php echo htmlspecialchars($book['categoryName'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-4">
                                    <label for="vishay" class="form-label">Subject Code (Vishay)</label>
                                    <input type="text" class="form-control" id="vishay" name="vishay" value="<?php echo htmlspecialchars($book['vishay'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-4">
                                    <label for="subject_name" class="form-label">Subject Name</label>
                                    <input type="text" class="form-control" id="subject_name" name="subject_name" value="<?php echo htmlspecialchars($book['subject_name'] ?? ''); ?>" />
                                </div>
                            </div>
                             <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="pages" class="form-label">Pages</label>
                                    <input type="number" class="form-control" id="pages" name="pages" value="<?php echo htmlspecialchars($book['pages'] ?? ''); ?>" />
                                </div>
                             </div>

                            <hr class="my-4" />

                            <!-- Identification -->
                            <h6 class="mb-3">2. Identification & Codes</h6>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="sr_no" class="form-label">SR No</label>
                                    <input type="text" class="form-control" id="sr_no" name="sr_no" value="<?php echo htmlspecialchars($book['sr_no'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-4">
                                    <label for="excel_iD" class="form-label">Excel ID</label>
                                    <input type="text" class="form-control" id="excel_iD" name="excel_iD" value="<?php echo htmlspecialchars($book['excel_iD'] ?? ''); ?>" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="old_sub_id" class="form-label">Old Sub ID</label>
                                    <input type="text" class="form-control" id="old_sub_id" name="old_sub_id" value="<?php echo htmlspecialchars($book['old_sub_id'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-4">
                                    <label for="new_sub_id" class="form-label">New Sub ID</label>
                                    <input type="text" class="form-control" id="new_sub_id" name="new_sub_id" value="<?php echo htmlspecialchars($book['new_sub_id'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-4">
                                    <label for="new_sub_id_2901" class="form-label">New Sub ID (2901)</label>
                                    <input type="text" class="form-control" id="new_sub_id_2901" name="new_sub_id_2901" value="<?php echo htmlspecialchars($book['new_sub_id_2901'] ?? ''); ?>" />
                                </div>
                            </div>

                            <hr class="my-4" />

                            <!-- Authors -->
                            <h6 class="mb-3">3. Authors & Contributors</h6>
                             <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="granthkar" class="form-label">Author (Granthkar)</label>
                                    <input type="text" class="form-control" id="granthkar" name="granthkar" value="<?php echo htmlspecialchars($book['granthkar'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label for="granthkar_0811" class="form-label">Author (0811)</label>
                                    <input type="text" class="form-control" id="granthkar_0811" name="granthkar_0811" value="<?php echo htmlspecialchars($book['granthkar_0811'] ?? ''); ?>" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="punah_granthkar" class="form-label">Co-Author (Punah Granthkar)</label>
                                    <input type="text" class="form-control" id="punah_granthkar" name="punah_granthkar" value="<?php echo htmlspecialchars($book['punah_granthkar'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label for="punah_granthkar_0811" class="form-label">Co-Author (0811)</label>
                                    <input type="text" class="form-control" id="punah_granthkar_0811" name="punah_granthkar_0811" value="<?php echo htmlspecialchars($book['punah_granthkar_0811'] ?? ''); ?>" />
                                </div>
                            </div>
                             <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="teekakar" class="form-label">Commentator (Teekakar)</label>
                                    <input type="text" class="form-control" id="teekakar" name="teekakar" value="<?php echo htmlspecialchars($book['teekakar'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label for="teekakar_0811" class="form-label">Commentator (0811)</label>
                                    <input type="text" class="form-control" id="teekakar_0811" name="teekakar_0811" value="<?php echo htmlspecialchars($book['teekakar_0811'] ?? ''); ?>" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="anuvadak" class="form-label">Translator (Anuvadak)</label>
                                    <input type="text" class="form-control" id="anuvadak" name="anuvadak" value="<?php echo htmlspecialchars($book['anuvadak'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label for="anuvadak_0811" class="form-label">Translator (0811)</label>
                                    <input type="text" class="form-control" id="anuvadak_0811" name="anuvadak_0811" value="<?php echo htmlspecialchars($book['anuvadak_0811'] ?? ''); ?>" />
                                </div>
                            </div>
                             <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="sampadak" class="form-label">Editor (Sampadak)</label>
                                    <input type="text" class="form-control" id="sampadak" name="sampadak" value="<?php echo htmlspecialchars($book['sampadak'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label for="sampadak_0811" class="form-label">Editor (0811)</label>
                                    <input type="text" class="form-control" id="sampadak_0811" name="sampadak_0811" value="<?php echo htmlspecialchars($book['sampadak_0811'] ?? ''); ?>" />
                                </div>
                            </div>
                             <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="punah_sampadak" class="form-label">Co-Editor (Punah Sampadak)</label>
                                    <input type="text" class="form-control" id="punah_sampadak" name="punah_sampadak" value="<?php echo htmlspecialchars($book['punah_sampadak'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label for="punah_sampadak_0811" class="form-label">Co-Editor (0811)</label>
                                    <input type="text" class="form-control" id="punah_sampadak_0811" name="punah_sampadak_0811" value="<?php echo htmlspecialchars($book['punah_sampadak_0811'] ?? ''); ?>" />
                                </div>
                            </div>

                            <hr class="my-4" />

                            <!-- Publication -->
                            <h6 class="mb-3">4. Publication Details</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="prakashak" class="form-label">Publisher (Prakashak)</label>
                                    <input type="text" class="form-control" id="prakashak" name="prakashak" value="<?php echo htmlspecialchars($book['prakashak'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label for="prakashak_0811" class="form-label">Publisher (0811)</label>
                                    <input type="text" class="form-control" id="prakashak_0811" name="prakashak_0811" value="<?php echo htmlspecialchars($book['prakashak_0811'] ?? ''); ?>" />
                                </div>
                            </div>
                             <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="purva_prakashak" class="form-label">Previous Publisher</label>
                                    <input type="text" class="form-control" id="purva_prakashak" name="purva_prakashak" value="<?php echo htmlspecialchars($book['purva_prakashak'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label for="purva_prakashak_0811" class="form-label">Previous Publisher (0811)</label>
                                    <input type="text" class="form-control" id="purva_prakashak_0811" name="purva_prakashak_0811" value="<?php echo htmlspecialchars($book['purva_prakashak_0811'] ?? ''); ?>" />
                                </div>
                            </div>

                             <hr class="my-4" />

                            <!-- Additional Info -->
                            <h6 class="mb-3">5. Additional Details</h6>
                             <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name1" class="form-label">Alt Name 1</label>
                                    <input type="text" class="form-control" id="name1" name="name1" value="<?php echo htmlspecialchars($book['name1'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label for="name2" class="form-label">Alt Name 2</label>
                                    <input type="text" class="form-control" id="name2" name="name2" value="<?php echo htmlspecialchars($book['name2'] ?? ''); ?>" />
                                </div>
                            </div>
                             <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name3" class="form-label">Alt Name 3</label>
                                    <input type="text" class="form-control" id="name3" name="name3" value="<?php echo htmlspecialchars($book['name3'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label for="name4" class="form-label">Alt Name 4</label>
                                    <input type="text" class="form-control" id="name4" name="name4" value="<?php echo htmlspecialchars($book['name4'] ?? ''); ?>" />
                                </div>
                            </div>
                             <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="shelf_detail" class="form-label">Shelf Details</label>
                                    <input type="text" class="form-control" id="shelf_detail" name="shelf_detail" value="<?php echo htmlspecialchars($book['shelf_detail'] ?? ''); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label for="remark" class="form-label">Remark</label>
                                    <input type="text" class="form-control" id="remark" name="remark" value="<?php echo htmlspecialchars($book['remark'] ?? ''); ?>" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">Update Book</button>
                                <a href="books.php" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
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
                  © <script>document.write(new Date().getFullYear());</script> Gujarati Library Management System
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

    <!-- Core JS -->
    <script src="./vendor/libs/jquery/jquery.js"></script>
    <script src="./vendor/libs/popper/popper.js"></script>
    <script src="./vendor/js/bootstrap.js"></script>
    <script src="./vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="./vendor/js/menu.js"></script>
    <script src="./assets/js/main.js"></script>
</body>
</html>