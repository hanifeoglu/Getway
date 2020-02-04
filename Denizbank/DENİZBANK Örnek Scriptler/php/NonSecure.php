<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
    <title>Non Secure Payment</title>
</head>
<html>
<body>
<?php

	if($_POST){

		$DATA = "ShopCode=".$_POST["ShopCode"]."&".
				"PurchAmount=".$_POST["Amount"]."&".
				"Currency=".$_POST["Currency"]."&".
				"OrderId=".$_POST["OrderId"]."&".
				"InstallmentCount=".$_POST["InstallmentCount"]."&".
				"TxnType=".$_POST["TxnType"]."&".
				"orgOrderId=".$_POST["orgOrderId"]."&".
				"UserCode=".$_POST["UserCode"]."&".
				"UserPass=".$_POST["UserPass"]."&".
				"SecureType=NonSecure&".
				"Pan=".$_POST["Pan"]."&".
				"Expiry=".$_POST["Expiry"]."&".
				"Cvv2=".$_POST["Cvv2"]."&".
				"BonusAmount=".$_POST["BonusAmount"]."&".
				"CardType=".$_POST["CardType"]."&".
				"Lang=TR&".
				"MOTO=".$_POST["MOTO"];
				/*Eðer 3D doðrulamasý yapýlmýþ ise aþaðýdaki alanlar da gönderilmelidir							/*
				"PayerAuthenticationCode=3D dönen cavv deðeri";
				"Eci=3D den dönen eci deðeri";//Visa - 05,06 MasterCard 01,02 olabilir
				"PayerTxnId=3D den dönen xid deðeri.";
				*/

		$url = "https://sanaltest.denizbank.com/mpi/Default.aspx";  //TEST

		$ch = curl_init();    // initialize curl handle

		curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($ch, CURLOPT_SSLVERSION, 3);

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
		echo "<table>";
		foreach($resultValues as $result)
		{
			$keyValue = explode("=", $result);
			foreach($keyValue as $key => $value ){
				echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
			}

			echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
		}
		echo "</table>";

	}

?>


<center>
		<form method="post">
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
					<td>Tutar:</td>
					<td><input type="text" name="Amount" value="9.95"/></td>
				</tr>
				<tr>
					<td>Kur secimi</td>
					<td><select name="Currency">
						<option value="949">TL</option>
						<option value="840">USD</option>
						<option value="978">EUR</option>
					</select>
					</td>
				</tr>
				<tr>
					<td>Bonus:</td>
					<td><input type="text" name="BonusAmount" value=""/></td>
				</tr>
				<tr>
					<td>Taksit Sayisi:</td>
					<td><input type="text" name="InstallmentCount" value=""/></td>
				</tr>
				<tr>
					<td>Visa/MC secimi</td>
					<td><select name="CardType">
						<option value="0">Visa</option>
						<option value="1">MasterCard</option>
					</select>
					</td>
				</tr>
				<tr>
					<td>Order No</td>
					<td><input type="text" name="OrderId" value=""/></td>
				</tr>
			        <tr>
					<td>Ýþlem Tipi</td>
					<td><select name="TxnType">
						<option value="Auth">Auth</option>
						<option value="PreAuth">PreAuth</option>
						<option value="PostAuth">PostAuth</option>
						<option value="Refund">Refund</option>
						<option value="Void">Void</option>
						<option value="StatusHistory">StatusHistory</option>
					</select>
					</td>
				</tr>
				<tr>
					<td>Orijinal Ýþlem Order No</td>
					<td><input type="text" name="orgOrderId" value=""/></td>
				</tr>
				<tr>
					<td>Shop Code</td>
					<td><input type="text" name="ShopCode" size="20" value="3123"/></td>
				</tr>
				<tr>
					<td>Kullanici Kodu</td>
					<td><input type="text" name="UserCode" size="20" value="InterTestApi"/></td>
				</tr>
				<tr>
					<td>Kullanici Sifre</td>
					<td><input type="text" name="UserPass" size="20" value="3"/></td>
				</tr>
				<tr>
					<td>MOTO (1-MOTO, 0 veya "" - Ecommerce)</td>
					<td><input type="text" name="MOTO" size="20" value="0"/></td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<input type="submit" value="Ödemeyi Tamamla"/>
					</td>
				</tr>
			</table>
		</form>
   </center>
</body>
</html>



