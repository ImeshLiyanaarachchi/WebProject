<!--add categories into the list box when the page load-->
<?php
    include 'includes/categoryList.inc.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing Script:wght@400;700&display=swap">
    <title>Dulmi Skincare | Dashboard</title>
</head>
<body style="background-image : url(back3.png)">
    <nav class="nav1">
    <label class="logo" style = "font-family: 'Dancing Script', sans-serif; font-size:40px">Dulmi SkinCare</label>
    </nav>
    <nav class="nav2">
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fa fa-bars"></i>
        </label>
        <ul>
            <li><a href="Dashboard.php">Dashboard</a></li>
            <li><a href="User Management.php">User Management</a></li>
            <li><a href="Inventory Management.php">Inventory Management</a></li>
            <li><a href="Inventory Tracking.php">Inventory Tracking</a></li>
            <li><button class="btn btn-danger logout" onclick="confirmLogout(event)">Logout</button></li>
        </ul>
    </nav>
    
    <section>
        <!----------------------- Main Container for add new Item -------------------------->
        <div class="container d-flex justify-content-center align-items-center min-vh-70" style="margin-bottom: 20px;">
        
        <div class="row border rounded-5 p-3 shadow box-area d-flex justify-content-center align-items-center" style="background-color: rgba(0,0,0,0.4)" >
        
        <div class="col-md-6 right-box">
            <div class="row align-items-center">
                <div class="header-text mb-4">
                    <h2 style = "color:#be994e"><i class="fas fa-user"></i> &nbsp; Add New Item</h2>
                    <hr>
                </div>

                <?php
                // Check if there are query parameters indicating a form submission
                if (isset($_GET['form'])) {
                    $form = $_GET['form'];
                    $message = '';
                    $messageType = ''; // To determine if the message is an error or success

                    // Check if the form is 'item'
                    if ($form === 'item') {
                        // Handle errors
                        if (isset($_GET['error'])) {
                            $messageType = 'danger'; // For errors
                            switch ($_GET['error']) {
                                case 'emptyfields':
                                    $message = 'Please fill in all fields for the item form.';
                                    break;
                                case 'invalidprice':
                                    $message = 'The price entered is invalid.';
                                    break;
                                case 'uploadfailed':
                                    $message = 'Image upload failed. Please try again.';
                                    break;
                                case 'sqlerror':
                                    $message = 'An SQL error occurred. Please try again.';
                                    break;
                                case 'categorynotfound':
                                    $message = 'The selected category was not found.';
                                    break;
                                default:
                                    $message = 'An unknown error occurred.';
                                    break;
                            }
                        } 
                        // Handle success
                        elseif (isset($_GET['success']) && $_GET['success'] === 'itemadded') {
                            $messageType = 'success'; // For success
                            $message = 'Item added successfully!';
                        }

                        // Display the message if it's not empty
                        if (!empty($message)) {
                            echo '<div id="item-message" class="alert alert-' . htmlspecialchars($messageType) . ' alert-dismissible fade show" role="alert">';
                            echo htmlspecialchars($message);
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                        }
                    }
                }
            ?>

                <!----------------Add new item Form----------------------------------->

                <form action="includes/addItem.inc.php" method="post" id="item">
                <input type="hidden" name="form_type" value="item">
                    <div class="input-group mb-3 ">
                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                    <input type="text" name="Iname" placeholder="Item Name" class="form-control form-control-lg bg-light fs-6"  ></div>

                    <div class="input-group mb-3 ">
                    <span class="input-group-text"><i class="fas fa-file"></i></span>
                    <input type="file" name="image" id = "image" accept = ".jpg, .jpeg, .png" value = "Insert an image "class="form-control form-control-lg bg-light fs-6"></div>


                    <div class="input-group mb-3 ">
                    <span class="input-group-text"><i class="fa fa-cubes"></i></span>
                    <input type="number" name="quantity" placeholder="Quantity" class="form-control form-control-lg bg-light fs-6" pattern="[0-9]+"required ></div>

                    
                    <div class="input-group mb-3 ">
                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    <input type="number" name="price" placeholder="Price" class="form-control form-control-lg bg-light fs-6" pattern="^\d+(\.\d{1,2})?$" required ></div>

                    <div class="input-group mb-4 ">
                    <span class="input-group-text"><i class="fa fa-th-large"></i></span>
                    <select id="category" name="category" class="form-select form-control-lg bg-light fs-6" required>
                    <option value="" disabled selected> Select a Category </option> 
                    <?php
                        if (!empty($categories)) {
                            // Output each category as an option in the dropdown
                            foreach ($categories as $category) {
                                echo "<option>" . htmlspecialchars($category) . "</option>";
                            }
                        } 
                        else {
                            echo "<option>No categories available</option>";
                        }
                        ?>
                    
                    </select></div>

                    <div class="input-group mb-3 ">
                    <textarea id="description" name="description" class="form-control form-control-lg bg-light fs-6" rows="4" placeholder="Description"></textarea>
                    </div>

                    <div class="input-group mb-1">
                    <button type="submit" name="submititem" class="btn btn-lg custom-button w-100 fs-6">Add Item</button></div>
                </form>
                
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </section>

    <!----------------------- Main Container for add new category -------------------------->
    <div class="container d-flex justify-content-center align-items-center min-vh-70" style="margin-bottom: 20px;" id="addCategory">
        
        <div class="row border rounded-5 p-3 shadow box-area d-flex justify-content-center align-items-center" style="background-color: rgba(0,0,0,0.4)" >
        
        <div class="col-md-6 right-box">
            <div class="row align-items-center">
                <div class="header-text mb-4">
                <h2 style = "color:#be994e"><i class="fas fa-th-large"></i> &nbsp; Add New Category</h2>
                <hr>
            </div>

            
                    <?php
                    if (isset($_GET['form'])) {
                        $form = $_GET['form'];
                        $message = '';
                        $messageType = ''; // To determine if the message is error or success

                        if ($form === 'category') {
                            if (isset($_GET['error'])) {
                                $messageType = 'danger'; // For errors
                                if ($_GET['error'] === 'emptyfields') {
                                    $message = 'Please fill in all fields for the category form.';
                                } elseif ($_GET['error'] === 'categorytaken') {
                                    $message = 'This category already exists.';
                                } elseif ($_GET['error'] === 'sqlerror') {
                                    $message = 'An SQL error occurred. Please try again.';
                                }
                            } elseif (isset($_GET['success']) && $_GET['success'] === 'categoryadded') {
                                $messageType = 'success'; // For success
                                $message = 'Category added successfully!';
                            }

                            if (!empty($message)) {
                                echo '<div id="category-message" class="alert alert-' . $messageType . ' alert-dismissible fade show" role="alert">';
                                echo $message;
                                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                echo '</div>';
                            }
                        }
                    }
        ?>

             <!------------------------add new category form------------------------------------------->   

                <form action="includes/addCategory.inc.php" method="post" id="category">
                <input type="hidden" name="form_type" value="category">
                <div class="input-group mb-3 ">
                <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                <input type="text" name="Cname" placeholder="Category Name" class="form-control form-control-lg bg-light fs-6" required></div>
                <div class="input-group mb-1">
                <button type="submit" name="submit" class="btn btn-lg custom-button w-100 fs-6">Add Category</button></div>
                </form>
                
            </div>
        </div>
        
    
       
        <!------------------------------- Logout Confirmation Modal --------------------------------------->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to log out?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmLogoutBtn">Logout</button>
            </div>
            </div>
        </div>
        </div>

                <!--------------- javascript for logout----------------------------->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function confirmLogout(event) {
                event.preventDefault();
                var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'), {
                    backdrop: 'static'
                });
                logoutModal.show();

                document.getElementById('confirmLogoutBtn').onclick = function () {
                    window.location.href = "includes/logout.inc.php";
                };
            }
        </script>
</body>
</html>