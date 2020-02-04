<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
    <title>Non Secure Payment</title>
</head>
<html>
<body>
<?php

	if($_POST){

		$DATA = "ShopCode=3123&".
				"PurchAmount=".$_POST["Amount"]."&".
				"Currency=".$_POST["Currency"]."&".
				"OrderId=&".
				"TxnType=".$_POST["TxnType"]."&".
				"orgOrderId=".$_POST["orgOrderId"]."&".
				"UserCode=InterTestApi&".
				"UserPass=3&".
				"SecureType=NonSecure&".
				"Lang=TR&".
				"MOTO=0";

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
                <td>
                    Kur secimi
                </td>
                <td>
                    <select name="Currency">
                        <option value="949">TL</option>
                        <option value="840">USD</option>
                        <option value="978">EUR</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Islem Tipi
                </td>
                <td>
                    <select name="TxnType">
                        <option value="Void" selected="selected">Void</option>
                        <option value="Refund">Refund</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Tutar:
                </td>
                <td>
                    <input type="text" name="Amount" value="0.01" />
                </td>
            </tr>
            <tr>
                <td>
                    Orijinal Islem Order No
                </td>
                <td>
                    <input type="text" name="orgOrderId" value="" />
                </td>
            </tr>
            <tr>
                <td align="center" colspan="2">
                    <input type="submit" value="Tamam" />
                </td>
            </tr>
        </table>
		</form>
   </center>
</body>
</html>



