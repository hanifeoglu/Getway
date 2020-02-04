<html>
<head>
<title>3D</title>
<meta http-equiv="Content-Language" content="tr">

  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-9">

  <meta http-equiv="Pragma" content="no-cache">

  <meta http-equiv="Expires" content="now">



</head>

<body>

<h1>3D Ödeme Sayfasi</h1>


<h3>3D Dönen Parametreler</h3>
    <table border="1">
        <tr>
            <td><b>Parametre Ismi</b></td>
            <td><b>Parametre Degeri</b></td>
        </tr>
<?php
	$odemeparametreleri = array("AuthCode","Response","HostRefNum","ProcReturnCode","TransId","ErrorMessage");
	foreach($_POST as $key => $value)
	{
		$check=1;
		for($i=0;$i<6;$i++)
		{
			if($key == $odemeparametreleri[$i])
			{
				$check=0;
				break;
			}
		}
		if($check == 1)
		{
			echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
		}
	}

?>

</table>
<br>
<br>
<?php

	 /* Yollanan hash ve gelen parametrelerle yeni olusturulan hash kontrol ediliyor */


	 $hashparams = $_POST["HASHPARAMS"];
    	 $hashparamsval = $_POST["HASHPARAMSVAL"];
	 $hashparam = $_POST["HASH"];
         $merchantpass="gDg1N";  // 3D guvenlik sifresi
         $paramsval="";
         $index1=0;
	 $index2=0;

	 while($index1 < strlen($hashparams))
	 {
   		$index2 = strpos($hashparams,":",$index1);
		$vl = $_POST[substr($hashparams,$index1,$index2- $index1)];
		if($vl == null)
		$vl = "";
 		$paramsval = $paramsval . $vl;
		$index1 = $index2 + 1;
	}
	$merchantpass = "gDg1N";      // 3D guvenlik sifresi
	$hashval = $paramsval.$merchantpass;




	$hash = base64_encode(pack('H*',sha1($hashval)));

	if($paramsval != $hashparamsval || $hashparam != $hash)
		echo "<h4>Güvenlik Uyarisi. Sayisal Imza Geçerli Degil</h4>";











	$Status = $_POST["3DStatus"];
	$ErrMsg = $_POST["ErrorMessage"];
	if($Status == 1 || $Status == 2 || $Status == 3 || $Status == 4)
	{
		echo "<h5>3D Islemi basarili</h5><br/>";

?>

		<h3> Ödeme Sonucu</h3>
                <table border="1">
                    <tr>
                        <td><b>Parametre Ismi</b></td>
                        <td><b>Parameter Degeri</b></td>
                    </tr>
<?php

		for($i=0;$i<6;$i++)
		{
			$param = $odemeparametreleri[$i];
			echo "<tr><td>".$param."</td><td>".$_POST[$param]."</td></tr>";

		}
?>
	</table>

<?php

		$response = $_POST["ProcReturnCode"];
		if($response == "00")
		{
			echo "Ödeme Islemi Basarili";
		}
		else
		{
			echo "Ödeme Islemi Basarisiz.";
		}

	}
	else
	{
		echo "<h5>3D Islemi basarisiz</h5>";
	}



?>

</body>
</html>