<?php 
include 'connection/db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proceed to Pay</title>
      <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="payment-qr-container" style="max-width: 420px; margin: 40px auto; padding: 24px; border: 1px solid #ddd; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); text-align: center; font-family: 'Inter', sans-serif;">
        <h1 style="font-size: 1.4rem; margin-bottom: 18px; color: #102a43;">Pay Fees with QR Code</h1>
        <p style="font-size: 1rem; margin-bottom: 24px; color: #334e68;">Scan the QR code below with your banking or payment app to complete the transaction.</p>
        <div class="qr-code" style="width: 240px; height: 240px; margin: 0 auto 22px auto; background: #f8fafc; border: 1px solid #cbd5e1; display: 
        flex; align-items: center; justify-content: center; border-radius: 16px;">
            <!-- <span style="color: #94a3b8;">QR code placeholder</span> -->
            <img src="assets/qrcode.png" alt="QR Code" style="width: 80%; height: 80%; object-fit: contain;">
        </div>
        <p style="font-size: 0.95rem; color: #475569; margin-bottom: 12px;">Amount due: <strong>₦0.00</strong></p>
        <button type="button" style="background: #2563eb; color: #fff; border: none; padding: 12px 24px; border-radius: 999px; cursor: pointer; font-size: 0.95rem;">Refresh QR</button>

    <div class="container">
        <div class="sub-container">
        <p style="font-size: 0.95rem; color: #475569; margin-bottom: 12px;">After completing the payment, please upload your transaction proof below.</p>
             <input type="file" placeholder="Upload transaction proof" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; margin-bottom: 16px; font-size: 0.95rem;">
            <button type="button" style="background: #2563eb; color: #fff; border: none; padding: 12px 24px; border-radius: 999px; cursor: pointer; font-size: 0.95rem;">Submit</button>

             <a href="index.php">Back to Home</a>
        </div>
   
    </div>

</body>
</html>