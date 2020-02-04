<html>
<head>
<title>3D HOST</title>
  <meta http-equiv="Content-Language" content="tr">
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-9">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="now">
</head>

	<body>
	<?php
		$shopCode = "3123";  //Banka tarafindan verilen isyeri numarasi
		$purchaseAmount = "2.02";         //Islem tutari
		$orderId = "";      //Siparis Numarasi
		$currency = "949"; // Kur Bilgisi - 949 TL
		$okUrl = "http://localhost:8080/3DHostingOdeme.php";         //Islem basariliysa dönülecek isyeri sayfasi  (3D isleminin ve ödeme isleminin sonucu)
		$failUrl = "http://localhost:8080/3DHostingOdeme.php";     //Islem basarisiz ise dönülecek isyeri sayfasi (3D isleminin ve ödeme isleminin sonucu)
		$rnd = microtime();    //Tarih veya her seferinde degisen bir deger güvenlik amaçli
		$installmentCount = "";         //taksit sayisi
		$txnType ="Auth";     //Islem tipi
		$merchantPass = "gDg1N";  //isyeri 3D anahtari
		// hash hesabinda taksit ve islemtipi de kullanilir.
		$hashstr = $shopCode . $orderId . $purchaseAmount . $okUrl . $failUrl .$txnType. $installmentCount  .$rnd . $merchantPass;
		$hash = base64_encode(pack('H*',sha1($hashstr)));
	?>

		<center>
            <form method="post" action="https://test.inter-vpos.com.tr/mpi/3DHost.aspx">   <!-- Test ortam linkidir gercek ortam linki dokumanda yer almaktadir -->
                <input type="hidden" name="ShopCode" value="<?php  echo $shopCode ?>">
                <input type="hidden" name="PurchAmount" value="<?php  echo $purchaseAmount ?>">
                <input type="hidden" name="Currency" value="<?php  echo $currency ?>">
                <input type="hidden" name="OrderId" value="<?php  echo $orderId ?>">
                <input type="hidden" name="OkUrl" value="<?php  echo $okUrl ?>">
                <input type="hidden" name="FailUrl" value="<?php  echo $failUrl ?>">
                <input type="hidden" name="Rnd" value="<?php  echo $rnd ?>" >
                <input type="hidden" name="Hash" value="<?php  echo $hash ?>" >
                <input type="hidden" name="TxnType" value="<?php  echo $txnType ?>" />
                <input type="hidden" name="InstallmentCount" value="<?php  echo $installmentCount ?>" />
                <input type="hidden" name="SecureType" value="3DHost" >
                <input type="hidden" name="Lang" value="tr">
                <input type="submit" value="Devam" />
            </form>
        </center>
</body>
</html>