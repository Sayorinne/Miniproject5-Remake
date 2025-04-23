<?php
include "../../database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle AJAX request to fetch the latest notification
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetch_notification'])) {
    // Fetch the latest unread notification
    $sql = "SELECT * FROM notifications WHERE status = 'unread' ORDER BY create_time DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $notification = mysqli_fetch_assoc($result);

        // Mark the notification as read
        $noti_id = $notification['noti_id'];
        $update_sql = "UPDATE notifications SET status = 'read' WHERE noti_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("i", $noti_id);
        $stmt->execute();

        echo json_encode($notification, JSON_UNESCAPED_UNICODE); // Return the notification as JSON
    } else {
        echo json_encode([]); // Return an empty JSON array if no unread notifications
    }

    mysqli_close($conn);
    exit(); // Stop further execution for AJAX requests
}
?>

<!-- Include Toastr.js and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
    $(document).ready(function () {
        // Toastr configuration
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right", // Position of the toast
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000", // Auto-hide after 5 seconds
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Function to fetch the latest notification
        function fetchNotification() {
            $.ajax({
                url: './Template/popup/notificationPopup.php?fetch_notification=true', // Corrected path
                type: 'GET',
                success: function (data) {
                    try {
                        const notification = JSON.parse(data); // Parse the JSON response
                        if (notification && notification.content) {
                            const message = notification.content; // Get the notification content
                            const title = notification.title || 'New Notification'; // Get the notification title
                            toastr.info(message, title); // Show the toast notification
                        }
                    } catch (error) {
                        console.error('Invalid JSON response:', data);
                    }
                },
                error: function () {
                    console.error('Failed to fetch notification.');
                }
            });
        }

        // Check for new notifications every 5 seconds
        setInterval(fetchNotification, 5000);
    });
</script>