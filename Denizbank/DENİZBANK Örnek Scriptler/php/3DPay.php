<html>
<head>
<title>3D PAY</title>
<meta http-equiv="Content-Language" content="tr">

  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-9">

  <meta http-equiv="Pragma" content="no-cache">

  <meta http-equiv="Expires" content="now">



</head>

<body>

<?php

$shopCode = "3123";  //Banka tarafindan verilen isyeri numarasi
$purchaseAmount = "5.64";         //Islem tutari
$orderId = "";      //Siparis Numarasi
$currency = "949"; // Kur Bilgisi - 949 TL

$okUrl = "http://localhost:8080/3DPayOdeme.php";        //Islem basariliysa dönülecek isyeri sayfasi  (3D isleminin ve ödeme isleminin sonucu)
$failUrl = "http://localhost:8080/3DPayOdeme.php";      //Islem basarisiz ise dönülecek isyeri sayfasi (3D isleminin ve ödeme isleminin sonucu)

$rnd = microtime();    //Tarih veya her seferinde degisen bir deger güvenlik amaçli
$installmentCount = "";         //taksit sayisi
$txnType ="Auth";     //Islem tipi
$merchantPass = "gDg1N";  //isyeri 3D anahtari
// hash hesabinda taksit ve islemtipi de kullanilir.

$hashstr = $shopCode . $orderId . $purchaseAmount . $okUrl . $failUrl .$txnType. $installmentCount  .$rnd . $merchantPass;


$hash = base64_encode(pack('H*',sha1($hashstr)));
?>

<center>
            <form method="post" action="https://sanaltest.denizbank.com/mpi/Default.aspx">     <!-- Test ortam linkidir gercek ortam linki dokumanda yer almaktadir  -->
                <table>
                    <tr>
                        <td>Kredi Kart Numarasi:</td>
                        <td><input type="text" name="Pan" size="20" value=""/>
                    </tr>

                    <tr>
                        <td>Güvenlik Kodu:</td>
                        <td><input type="text" name="Cvv2" size="4" value=""/></td>
                    </tr>

                    <tr>
                        <td>Son Kullanma Tarihi (MMYY):</td>
                        <td><input type="text" name="Expiry" value=""/></td>
                    </tr>
                    <tr>
                        <td>Bonus:</td>
                        <td><input type="text" name="BonusAmount" value=""/></td>
                    </tr>
                    <tr>
                        <td>Visa/MC secimi</td>
                        <td><select name="CardType">
                            <option value="0">Visa</option>
                            <option value="1">MasterCard</option>
                        </select>
                    </tr>

                    <tr>
                        <td align="center" colspan="2">
                            <input type="submit" value="Ödemeyi Tamamla"/>
                        </td>
                    </tr>

                </table>
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
                <input type="hidden" name="SecureType" value="3DPay" >
                <input type="hidden" name="Lang" value="tr">
</form>
        </center>
    </body>
</html>