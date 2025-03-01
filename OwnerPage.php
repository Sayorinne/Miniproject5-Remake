<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Owner Dashboard</title>

  <!-- External CSS -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  <!-- Internal CSS -->
  <link rel="stylesheet" href="CSS/ownerStyle.css">
  <link rel="stylesheet" href="CSS/ownerDashboard.css">
  <link rel="stylesheet" href="CSS/ownerNavbar.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- JQuery -->

  <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>


  <!-- JavaScript -->
  <script src="JS/profile.js" defer></script>
  <script src="JS/texteditor.js" defer></script>


</head>

<body>
  <div class="layout expanded home-page">


    <?php
    include "database.php";
    ?>


    <!-- Right Main -->
    <div class="right-main">
      <div class="top-nav">
        <div class="inside">
          <div class="left-icon">
            <!-- Account validate -->
            <?php if (isset($_SESSION['Owner_ID'])): ?>
              <div class="profile-button">
                <p class=" fa fa-user" style="margin: 10px" onclick="toggloeMenu()">
                  <?php echo $_SESSION['Username_Owner']; ?> </p>
              </div>
              <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                  <div class="user-info">
                    <img src="Picture/Sihba_07.jpg">
                    <h2><?php echo $_SESSION['Username_Owner']; ?></h2>
                    <h3>ID:<?php echo $_SESSION['Owner_ID']; ?></h3>
                  </div>

                  <hr>
                  <a href="#" class="sub-menu-link">
                    <img src="images/profile.png">
                    <p>Edit Profile</p>
                    <span></span>
                  </a>

                  <a href="logout.php" class="sub-menu-link">
                    <img src="images/profile.png">
                    <p>Logout</p>
                    <span></span>
                  </a>
                </div>
              </div>
            <?php else: ?>
              <a role="button" tabindex="0" href="login.php" class="login-button btn btn-primary">
                <span>Login</span>
              </a>
              <a role="button" tabindex="0" href="registration.php" class="login-button btn btn-primary">
                <span>Register</span>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Main Content Row -->
      <div class="admin-wrapper">
        <div class="left-menu">

          <hr>
          <div class="left-menu-content">
            <div class="ms-auto nav">
              <a aria-current="page" class href="OwnerPage.php">
                <span class="nav-link"><span>แดชบอร์ด</span></span>
              </a>

              <a href="OwnerHistory.php">
                <span class="nav-link"><span>ประวัติการทำรายการ</span></span>
              </a>

              <a class href="OwnerEmployeePage.php">
                <span class="nav-link"><span>จัดการ "พนักงาน"</span></span>
              </a>
            </div>
            <hr>
          </div>
        </div>





        <div class="admin-content">
          <h1>Your Stripe Dashboard</h1>

          <div id="balance" class="card"></div>

          <div class="card">
            <h2>Recent Payments</h2>
            <table id="payments-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Amount</th>
                  <th>Customer Name</th>
                  <th>Customer Email</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

          <div class="card">
            <h2>Recent Customers</h2>
            <table id="customers-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Created</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

          <div class="card">
            <h2>Active Subscriptions</h2>
            <table id="subscriptions-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Customer</th>
                  <th>Status</th>
                  <th>Current Period End</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

          <div class="card">
            <h2>Products</h2>
            <table id="products-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>ID</th>
                  <th>Active</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

          <script>
            async function loadStripeDashboard() {
              try {
                const response = await fetch('StripeDashboard.php');
                const data = await response.json();

                if (data.error) {
                  console.error('Stripe API error:', data.error);
                  return;
                }

                // Display balance
                const balanceElement = document.getElementById('balance');
                balanceElement.textContent = `Available balance: ${data.balance.available[0].amount / 100} ${data.balance.available[0].currency}`;

                // Display payments
                const paymentsBody = document.querySelector('#payments-table tbody');
                data.payments.forEach(payment => {
                  const row = paymentsBody.insertRow();
                  row.insertCell(0).textContent = payment.id;
                  row.insertCell(1).textContent = `${payment.amount / 100} ${payment.currency}`;

                  // Get customer name from billing details or customer object
                  let customerName = 'N/A';
                  if (payment.payment_method && payment.payment_method.billing_details.name) {
                    customerName = payment.payment_method.billing_details.name;
                  } else if (payment.customer && payment.customer.name) {
                    customerName = payment.customer.name;
                  }
                  let customerEmail = 'N/A';
                  if (payment.payment_method && payment.payment_method.billing_details.email) {
                    customerEmail = payment.payment_method.billing_details.email;
                  } else if (payment.customer && payment.customer.email) {
                    customerEmail = payment.customer.email;
                  }
                  row.insertCell(2).textContent = customerName;
                  row.insertCell(3).textContent = customerEmail;
                  row.insertCell(4).textContent = payment.status;
                });

                // Display customers
                const customersBody = document.querySelector('#customers-table tbody');
                data.customers.forEach(customer => {
                  const row = customersBody.insertRow();
                  row.insertCell(0).textContent = customer.name || 'N/A';
                  row.insertCell(1).textContent = customer.email || 'N/A';
                  row.insertCell(2).textContent = new Date(customer.created * 1000).toLocaleDateString();
                });

                // Display subscriptions
                const subscriptionsBody = document.querySelector('#subscriptions-table tbody');
                data.subscriptions.forEach(subscription => {
                  const row = subscriptionsBody.insertRow();
                  row.insertCell(0).textContent = subscription.id;
                  row.insertCell(1).textContent = subscription.customer.email || 'N/A';
                  row.insertCell(2).textContent = subscription.status;
                  row.insertCell(3).textContent = new Date(subscription.current_period_end * 1000).toLocaleDateString();
                });

                // Display products
                const productsBody = document.querySelector('#products-table tbody');
                data.products.forEach(product => {
                  const row = productsBody.insertRow();
                  row.insertCell(0).textContent = product.name;
                  row.insertCell(1).textContent = product.id;
                  row.insertCell(2).textContent = product.active ? 'Yes' : 'No';
                });

              } catch (error) {
                console.error('Error fetching dashboard data:', error);
              }
            }

            loadStripeDashboard();
          </script>
        </div>
      </div>
    </div>
  </div>
  </div>

</body>

</html>