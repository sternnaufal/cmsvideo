<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Logout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="icon" href="assets/sakurapai.png" type="image/png">
</head>
<body>
    <!-- Modal Konfirmasi Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: black; color: white;">
                <div class="modal-header" style="background-color: #333;">
                    <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin logout?
                </div>
                <div class="modal-footer">
                    <a href="../index.php" class="btn btn-secondary">Batal</a>
                    <a href="logout_process.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Menampilkan modal konfirmasi logout -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Menampilkan modal
        var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
        logoutModal.show();
    </script>
</body>
</html>
