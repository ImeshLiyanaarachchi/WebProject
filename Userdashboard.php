
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing Script:wght@400;700&display=swap">
    <title>Dulmi Skincare | Dashboard</title>
</head>
<body style="background-image: url(women.png);">
    <nav class="nav1">
    <label class="logo" style = "font-family: 'Dancing Script', sans-serif; font-size:40px">Dulmi SkinCare</label>
    </nav>
    <nav class="nav2">
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fa fa-bars"></i>
        </label>
        <ul>
            <li><a href="#" class="logout" onclick="confirmLogout(event)">Logout</a></li>
        </ul>
    </nav>
    <section>
        <?php include 'includes/Userdashboard.inc.php'; ?>
        <!-- The content from dashboard.inc.php will be inserted here -->
            <h1 style="color: #be994e "> Welcome, <?php echo htmlspecialchars($_SESSION['userUid']); ?>!</h1>
            <p style="color: #be994e">  >Here is your dashboard overview:</p>
      
        <!-- Additional dynamic content goes here -->
    </section>
    <!-- Logout Confirmation Modal -->
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