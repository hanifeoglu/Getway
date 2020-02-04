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

	foreach($_POST as $key => $value)
{
	echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
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
        $merchantpass="gDg1N";
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
	$merchantpass = "gDg1N";
	$hashval = $paramsval.$merchantpass;

	$hash = base64_encode(pack('H*',sha1($hashval)));

	if($paramsval != $hashparamsval || $hashparam != $hash)
		echo "<h4>GÃ¼venlik Uyarisi. Sayisal Imza GeÃ§erli Degil</h4>";


	$Status = $_POST["3DStatus"];
	if($Status == 1 || $Status == 2 || $Status == 3 || $Status == 4)
	{
		echo "<h5>3D Islemi basarili</h5><br/>";

		$DATA = "ShopCode=".$_POST["ShopCode"]."&".
				"PurchAmount=".$_POST["PurchAmount"]."&".
				"Currency=".$_POST["Currency"]."&".
				"OrderId=".$_POST["OrderId"]."&".
				"TxnType=Auth&".
				"UserCode=InterTestApi&".
				"UserPass=3&".
				"SecureType=NonSecure&".
                "InstallmentCount=&".
				"MD=".$_POST["MD"]."&".
				"Lang=TR&".
				"PayerAuthenticationCode=".$_POST["PayerAuthenticationCode"]."&".
				"Eci=".$_POST["Eci"]."&".//Visa - 05,06 MasterCard 01,02 olabilir
				"PayerTxnId=".$_POST["PayerTxnId"]."&".
				"MOTO=0";

		$url = "http://sanaltest.denizbank.com/mpi/Default.aspx"; //Test ortam linkidir gercek ortam linki dokumanda yer almaktadir

		$ch = curl_init();    // initialize curl handle

		curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
		curl_setopt($ch, CURLOPT_SSLVERSION, 2);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
		curl_setopt($ch, CURLOPT_TIMEOUT, 90); // times out after 90s
		curl_setopt($ch, CURLOPT_POSTFIELDS, $DATA); // add POST fields


		$result = curl_exec($ch);

		echo "<br>";

		if (curl_errno($ch)) {
			print curl_error($ch);
		} else {
           curl_close($ch);
		}

		$resultValues = explode(";;", $result);
		$response="test";
		echo "<table>";
		foreach($resultValues as $result)
		{
			if(strpos($result,"ProcReturnCode")>-1)
				{
				$response = substr($result, -2, 2);
				}
			$keyValue = explode("=", $result);
			foreach($keyValue as $key => $value )
			{
				echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
			}
			echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
		}
		echo "</table>";

		if($response == "00")
		{
			echo "Ödeme Islemi Basarili";
		}
		else
		{
			echo "Ödeme Islemi Basarisiz";
		}
	}
	else
	{
		echo "3D islemi onay almadi";
	}

?>
</body>
</html>
