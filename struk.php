<?php
  include('server/connection.php');

  $order_id = $_GET['order_id'];

  $query = "SELECT * FROM order_item WHERE order_id = '$order_id'";
  $result = mysqli_query($conn, $query);

  $subtotal = 0; 
  $ongkir = 20000; 
  $total = 0; 

  while ($row = $result->fetch_assoc()){
    $subtotal += $row['product_price'] * $row['product_quantity'];
  }

  $total = $subtotal + $ongkir; 
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Bangers|Roboto'>
    <link rel="stylesheet" href="css/stylestruk.css">
</head>
<body>
  <div class="receipt-wrapper">
    <div class="receipt" style="padding: 30px;">
      <div class="headerTitle">
        <img style="width: 200px; margin-top: -20px;" src="img/Jlogo.png" alt="">
      </div>
      <div class="headerSubTitle">
        J-House | Sajian Hidangan Autentik.
      </div>
      <div id="date">
        <?php
          // Fetching order date
          $query2 = "SELECT * FROM order_item WHERE order_id = '$order_id'";
          $result2 = mysqli_query($conn, $query2);
          $row = $result2->fetch_assoc();
        ?>
          <h5>
            Order date: <?php echo $row['order_date']; ?>
          </h5>
      </div>
      <hr>

      <!-- Items Purchased -->
      <div class="items">
        <?php 
        // Fetching items purchased
        $result = mysqli_query($conn, $query);
        while ($row = $result->fetch_assoc()) { 
        ?>
        <div class="item" style="margin-bottom: 15px;">
            <div class="itemRow">
              <div class="itemName"><?php echo $row['product_name']; ?></div>
              <div class="itemPrice">Rp. <?php echo $row['product_price'];?></div>
            </div>
            <div class="itemRow">
              <div class="itemData1"></div>
              <div class="itemData2"></div>
              <div class="itemData3 itemQuantity"><?php echo $row['product_quantity'];?></div>
            </div>
            <div class="itemRow">
              <div class="itemData1"></div>
              <div class="itemData2"></div>
              <div class="itemData3">Rp. <?php echo $row['product_price'] * $row['product_quantity'];?></div>
            </div>
          </div>
        <?php } ?>
      </div>

      <!-- Totals -->
      <hr>
      <div class="flex">
        <div id="qrcode"></div>
        <div class="totals">
          <div class="section">
            <div class="row">
              <div class="col1"></div>
              <div class="col2"style="margin-right: 10px;">Subtotal</div>
              <div class="col3" ><span style="margin-right: 10px;">Rp.</span><?php echo $subtotal; ?></div>
            </div>
            <div class="row">
              <div class="col1"></div>
              <div class="col2"style="margin-right: 10px;">Ongkos Kirim</div>
              <div class="col3"><span style="margin-right: 10px;">Rp.</span><?php echo $ongkir; ?></div>
            </div>
          </div>
          <div class="section">
            <div class="row">
              <div class="col1"></div>
              <div class="col2" style="margin-right: 10px; font-weight: 700;">Total</div>
              <div class="col3" style="font-weight: 700;"><span style="margin-right: 10px;">Rp.</span><?php echo $total; ?></div>
            </div>
          </div>
        </div>
      </div>
      <br><br>
      <div class="headerSubTitle">
        Thank you for shopping with us
      </div>
      <div class="headerSubTitle">
        Follow us on Instagram @jatinangorhouse
      </div>
    </div>
  </div>
</body>
</html>
