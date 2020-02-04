<html>
<head>
<title>3D</title>
<meta http-equiv="Content-Language" content="tr">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-9">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="now">
</head>
<body>
<?php
$ShopCode = "3123";  //Banka tarafindan verilen isyeri numarasi
$PurchAmount = "5.64";         //Islem tutari
$Currency = "949"; // Kur Bilgisi - 949 TL
$OrderId = "";      //Siparis Numarasi
$OkUrl = "http://localhost:8080/3DModelOdeme.php";      //Islem basariliysa dönülecek isyeri sayfasi  (3D isleminin ve ödeme isleminin sonucu)
$FailUrl = "http://localhost:8080/3DModelOdeme.php";	//Islem basarisiz ise dönülecek isyeri sayfasi (3D isleminin ve ödeme isleminin sonucu)
$rnd = microtime();    //Tarih veya her seferinde degisen bir deger güvenlik amaçli
$InstallmentCount = "";         //taksit sayisi
$TxnType ="Auth";     //Islem tipi
$MerchantPass = "gDg1N";  //isyeri 3D anahtari
$hashstr = $ShopCode . $OrderId . $PurchAmount . $OkUrl . $FailUrl .$TxnType. $InstallmentCount  .$rnd . $MerchantPass;
$hash = base64_encode(pack('H*',sha1($hashstr)));
?>
<center>
            <form method="post" action="https://sanaltest.denizbank.com/mpi/Default.aspx"> <!-- Test ortam linkidir gercek ortam linki dokumanda yer almaktadir  -->
                <table>
                    <tr>
                        <td>Kredi Kart Numarasi:</td>
                        <td><input type="text" name="Pan" size="20"/>
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
                        <td>Visa/MC secimi</td>
                        <td><select name="CardType">
                            <option value="0">Visa</option>
                            <option value="1">MasterCard</option>
                        </select>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                            <input type="submit" value="Gönder"/>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="ShopCode" value="<?php  echo $ShopCode ?>" />
                <input type="hidden" name="PurchAmount" value="<?php  echo $PurchAmount ?>" />
                <input type="hidden" name="Currency" value="<?php  echo $Currency ?>" />
                <input type="hidden" name="OrderId" value="<?php  echo $OrderId ?>" />
                <input type="hidden" name="OkUrl" value="<?php  echo $OkUrl ?>" />
                <input type="hidden" name="FailUrl" value="<?php  echo $FailUrl ?>" />
                <input type="hidden" name="Rnd" value="<?php  echo $rnd ?>" />
                <input type="hidden" name="Hash" value="<?php  echo $hash ?>" />
                <input type="hidden" name="TxnType" value="<?php  echo $TxnType ?>" />
                <input type="hidden" name="InstallmentCount" value="<?php  echo $InstallmentCount ?>" />
                <input type="hidden" name="SecureType" value="3DModel" />
                <input type="hidden" name="Lang" value="tr" />
            </form>
         </center>
    </body>
</html>