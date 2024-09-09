<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Link Css -->
    <link rel="stylesheet" href="css/style.css" />

    <!-- link favicon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

    <!-- Box Icons -->
    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <title>New Rk Jewellers</title>

</head>

<body>
    <div class="notification-wrapper">
        <div class="notification-toast">
            <div class="notification-content">
                <div class="notification-icon"><i class="uil uil-wifi"></i></div>
                <div class="notification-details">
                    <span>You're online now</span>
                    <p>Hurray! Internet is connected.</p>
                </div>
            </div>
            <div class="notification-close-icon"><i class="uil uil-times"></i></div>
        </div>
    </div>
    <script>
        // Selecting all required elements
        const notificationWrapper = document.querySelector(".notification-wrapper"),
            notificationToast = notificationWrapper.querySelector(".notification-toast"),
            notificationTitle = notificationToast.querySelector("span"),
            notificationSubTitle = notificationToast.querySelector("p"),
            notificationWifiIcon = notificationToast.querySelector(".notification-icon"),
            notificationCloseIcon = notificationToast.querySelector(".notification-close-icon");

        // Function to update the notification based on online/offline status
        function updateOnlineStatus() {
            if (navigator.onLine) {
                notificationToast.classList.remove("offline");
                notificationTitle.innerText = "You're online now";
                notificationSubTitle.innerText = "Hurray! Internet is connected.";
                notificationWifiIcon.innerHTML = '<i class="uil uil-wifi"></i>';
                notificationWrapper.classList.remove("hide");

                // Hide the toast notification automatically after 5 seconds
                setTimeout(() => {
                    notificationWrapper.classList.add("hide");
                }, 5000);
            } else {
                offline();
            }
        }

        // Function for offline status
        function offline() {
            notificationWrapper.classList.remove("hide");
            notificationToast.classList.add("offline");
            notificationTitle.innerText = "You're offline now";
            notificationSubTitle.innerText = "Oops! Internet is disconnected.";
            notificationWifiIcon.innerHTML = '<i class="uil uil-wifi-slash"></i>';
        }

        // Event listeners for online and offline events
        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);

        // Initially hide the notification wrapper
        notificationWrapper.classList.add("hide");

        // Close icon click event
        notificationCloseIcon.onclick = () => {
            notificationWrapper.classList.add("hide");
        };
    </script>