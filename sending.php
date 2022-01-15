﻿    
﻿<html><head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
<link rel="shortcut icon" href="img/gst.ico" />
<title> Enviando... </title></head>
<body bgcolor="#000000" text="#40FF00" font="Segoe UI">
<center><img src="img/gm.png" width="400" align="center"></center><br>
<br>

<div align="center" width="75%">
<script language="JavaScript" type="text/javascript"> alert("El Envío se ha iniciado, no cierres esta ventana hasta que te avise.");   </script>

<div id="tudiv" align="left" style=" background : #03075F;  padding : 10px; width : 710px; height : 300px; overflow : auto;">



<?php

//$respondera = "email@dominio.com"; Aquí se puede configurar para responder a un email diferente al emisor


//#######   DECLARACIÓN DE VARIABLES NECESARIAS   #########//



	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/Exception.php';
	require 'phpmailer/PHPMailer.php';
	require 'phpmailer/SMTP.php';
	
	
	
	ini_set('post_max_size','100M');
	ini_set('upload_max_filesize','100M');
	ini_set('max_execution_time','1000000000000000000000000000');
	ini_set('max_input_time','1000000000000000000000000');
	// script de upload
	
	
	$svr_smtp = $_POST["svr_smtp"]; //servidor SMTP
	$usr_smtp = $_POST["usr_smtp"]; //Usuario SMTP
	$pss_smtp = $_POST["pss_smtp"]; //Passwords SMTP
	$port_smtp = $_POST["port_smtp"]; //Puerto SMTP
	$enc = $_REQUEST['enc']; //Valor de encriptación


	date_default_timezone_set('America/Mexico_City'); // se establece la zona horaria e idioma
	$pss1 = $_POST["pss"]; //leemos el pass del formulario
	$pss = md5($pss1); //transformamos el pass en MD5
	$cont = 0; // Establecemos el contador de emails en 0
	$hora=  date ("H:i:s"); //Capturamos la hora de inicio 
	$fecha= date ("j/M/Y"); //Capturamos la fecha de inicio
	echo "<FONT face='Segoe UI'>"; //Mantenemos un FONT abierto para darle formato a todo el documento

	$cont = "0"; //Declaramos contador de buenos en 0 para evitarvariables indefinidas
	$contf = "0"; //Declaramos contador de fallidos en 0 para evitarvariables indefinidas
	$ndis = "";


if ($pss == "c3581516868fb3b71746931cac66390e") {
	
//#######  APERTURA DE ARCHIVOS DE BASES #########//	

//	$base =$_POST["base"]; //se lee el nombre de la base
	$basefile = $_FILES["base"]["tmp_name"]; //lee el archivo temporal
	$basece = $_FILES["base"]["name"]; //obtiene el nombre de la base con extencion
	$base = substr($basece, 0, strrpos($basece, ".")); // elimina la extencion del nombre de la base
	
	
	//$base= "bd/". $base . ".txt"; // se le agrega la duta y extencion
	$file = fopen($basefile, "r") or exit("Error abriendo fichero!"); //abre el archivo 
	while($mail = fgets($file)) { //Lee línea a línea y escribela hasta el fin de fichero y pongo el valor en la variable mail
	//   if (feof($file)) break;
	usleep(75000); // Esto puede agregar una pausa entre cada email, 1 millon = 1 segundo
	
//#######  PREPARANDO INFORMACIÓN DE ENVÍO #########//
	
		$destino = $mail; // el valor de mail lo paso a destino
		//$nremitente = utf8_decode($_POST["nremitente"]);// Jala el valor del nombre del remitente a la variable nremitente
		$nremitente = $_POST["nremitente"];
		$remitente = $_POST["remitente"]; // Jala el valor del email del remitente a la variable remitente
		$asunto = $_POST["asunto"];
		//$asunto = utf8_decode($_POST["asunto"]); //Jala el valor del asunto a la varuable asunto 

// EXTRAIGO EL DOMINIO PARA CREAR EL ID

		$dompa = trim($mail); //le quito los espacios en blanco
		$dompa2 = substr($dompa, strpos($dompa,'@')); //eimino el usuario y dejo el dominio con arroba
		$dominio = str_replace("@", "", $dompa2); //eliminio el arroba

        $msgid=md5(uniqid(time())) . "@" . $dominio; //creo el ID del email segun la norma ISO
		//$msgid=md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME']; //creo el ID del email segun la norma ISO
		$boundary= uniqid('np'); //Empieza la frontera del email


//ESTA SECCIÓN DIVIDE EL USUARIO DEL DOMINIO


//$email = explode("@", $destino ); //manifiesta el divisor
//$nremitente = $email[0]; // Imprime "nombre" //Usa el usuario del email como remitente
//echo $email[1]; // Imprime "correo.com"  //sin uso 





		
//#######  PREPARANDO INFORMACIÓN DE HEADERS #########//
		
		$header = "From: " .$nremitente. "<" . $remitente . ">\r\n"; //pone el FROM con nombre y email a los headers
		//$header.= "BCC:<".$copiar.">\r\n";  //Esto agrega una copia oculta a una direccion 
		$header .= "X-Sender: GhostMailer <".$remitente.">\r\n"; // Nombre del Software remitente
		$header .= "X-Mailer: PHP/" . phpversion()."\r\n"; // Nombre y Version de PHP
		$header .= "Return-Path:<".$remitente.">\r\n"; // Return path para enviar errores y rebotes a esta direccion
		$header .= "Reply-To:<".$remitente.">\r\n"; // Se respondera a esta direccion
		//$header .=  "List-Unsubscribe:<mailto:".$remitente.">\r\n"; // para agregar el desuscribir, pero daña la version de solo texto
		$header.= "MIME-Version: 1.0\r\n"; // Version de MIME
		$header.= "X-Priority: 1\r\n";  //Se establece la prioridad del email, 0 normal, 1 importante
		$header.= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n"; //Establece que el email tiene version multiple, texto y html
		//$header.= "Content-Transfer-Encoding: quoted-printable\r\n";  //esta madre jode la version de solo texto
		$header.= "Message-ID:<" . $msgid .">\r\n"; //Agrego el ID a los headers

//#######  PREPARANDO VARIABLES DE CONTENIDO #########//

		$formatohtml= $_POST["contenido"]; // Agrego a la variable formatohtml el contenido HTML del form
		$formatoplano = $_POST["contenidotp"]; //Agrego a la variable formatoplano el contenido de Texto Plano del form
		$contenido = "This is a MIME encoded message."; //Establece que se codifica con MIME
		
//#######  PREPARANDO ENVÍO EN TXT #########//
		
		$contenido .= "\r\n\r\n--" . $boundary . "\r\n"; //Inicia la frontera txt
		$contenido .= "Content-Type: text/plain; charset=utf-8\r\n\r\n";// establece el inicio del texto plano con UTF-8
		//$contenido .= "Content-Type: text/plain; charset=ISO-8859-1\r\n\r\n"; // establece el inicio del texto plano con ISO 8859
		$contenido .= $formatoplano; // Agrego a la variable contenido el valor del mensaje en texto plano
		$contenido .= "\r\n\r\n--" . $boundary . "\r\n"; //Cierra la frontera del texto plano


//#######  PREPARANDO ENVÍO EN HTML #########//

		$contenido .= "Content-type: text/html; charset=utf-8\r\n\r\n"; // Establece el inicio del mensaje en HTML
		$contenido .= $formatohtml; // Agrega a la variable contenido el valor del mensaje en texto HTML
		$contenido .= "\r\n\r\n--" . $boundary . "--"; // cierra el mensaje en HTML
		//$header .= rtrim(chunk_split(base64_encode($contenido)));  //codigica en base64

//#######  INICIA EL PROCESO DE ENVÍO  #########//		
		
		
		
		
		
		
		
		
		



// Instantiation and passing `true` enables exceptions
$smail = new PHPMailer(true);

try {


//Server settings


    $smail->SMTPDebug = 0;                      // Enable verbose debug output
    $smail->Debugoutput = 'html';                    //formato html
    $smail->isSMTP();                                            // Send using SMTP
    $smail->Host       = $svr_smtp;            // Set the SMTP server to send through
    $smail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $smail->Username   = $usr_smtp;           // SMTP username
    $smail->Password   = $pss_smtp;           // SMTP password
    $smail->SMTPSecure = $enc;             // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $smail->Port       = $port_smtp;          // TCP port to connect to
	$smail->CharSet = 'UTF-8';


    //Recipients
    $smail->setFrom($remitente, $nremitente); //asigna datos de remitente
    $smail->addAddress($destino);     // Add a recipient
 //   $smail->addAddress('ellen@example.com');               // Name is optional
 //   $smail->addReplyTo('info@example.com', 'Information');
 //   $smail->addCC('cc@example.com');
 //   $smail->addBCC('bcc@example.com');

    // Attachments
	$adjunto = $_FILES["adjunto"]; //asigna nombre a la variable adjunto
	//$smail->AddAttachment($adjunto['tmp_name'], $adjunto['name']); //adjunta el archivo
	
	//                  trim($adjunto) !== false
	if ($adjunto['name'] != "") //Si el adjunto tiene nombre, envia el adjunto
	{ 
		$smail->AddAttachment($adjunto['tmp_name'], $adjunto['name']); //adjunta el archivo
	} 
	

	
	
	
	
 //   $smail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
 //   $smail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content	
	
    $smail->Subject = $asunto;
    $smail->Body    = $formatohtml;
    $smail->AltBody = $formatoplano;

    $smail->send();
echo '<table width="700"><tbody><tr><td width="600"><FONT face="Segoe UI"> Enviado a:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><FONT face="Segoe UI" color="#F2FF81">'.$mail.'</font><FONT face="Segoe UI">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td width="100">OK <br /></td></tr></tbody></table>'; $cont = $cont + 1; 
} catch (Exception $e) {
    echo '<table width="700"><tbody><tr><td width="600"><FONT face="Segoe UI"> Enviado a:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><FONT face="Segoe UI" color="#F2FF81">'.$mail.'</font><FONT face="Segoe UI">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td width="100">FAILED <br /></td></tr></tbody></table>'; $contf = $contf + 1;
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
//#######  INICIA EL PRCESO DE ENVÍO EXPRESS #########//

		//mail ($destino, utf8_decode($asunto), $contenido, $header);	
		//echo '<table width="700"><tbody><tr><td width="600"><FONT face="Segoe UI"> Enviado a:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><FONT face="Segoe UI" color="#F2FF81">'.$mail.'</font><FONT face="Segoe UI">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td width="100">OK <br /></td></tr></tbody></table>';
		//$cont = $cont + 1;
	 
//#######  GUARDAR LOS LOGS DE EMAILS ENVIADOS  #########//
	 
		 $nlog="log/LOG".date("dmy").".csv"; //nombra el log segun el dia
		 $hlog=date("H:i:s"); //variable para la fecha del log
		 $nbase= $base; //variable para el nombre de la base
		 $linlog =$hlog.",".$nbase.",".$msgid.",".$nremitente.",".$remitente.",".$asunto.",".$destino; //Se escribe la linea del log con la información
		 $ffile=fopen($nlog,"a+"); //Agrega los permisos para escritura del archivo 
		 fwrite($ffile,$linlog);  //Escribe
		 fclose($ffile); //cierra el archivo
	 
} //Se cierra el ciclo de envío cuando se terminan los emails de la base

fclose($file);// Cierra el TXT de la  base
echo "<br><a name='ultimo'></a>Fin del envío<br></div>"; // Imprime el mensaje de fin del envío






//#######  SI EL NOMBRE DE LA BASE ES test (minusculas), GUARDA UNA COPIA DEL FOLLETO  #########//

	if ($nbase !== "test")
	{
		$ndis="folletos/F".date("ymd")."H".date("His")."-".$nbase."-".$asunto.".html"; //nombre del folleto segun el dia
		$fffile=fopen($ndis,"w"); // Crea el archivo 
		fwrite($fffile,$formatohtml); //Escribe el contenido en HTML
		fclose($fffile); // Cierra el archivo
	} // Termina el IF para guardar el folleto



} // Termina el IF del password

else { echo "ERROR PASSWORD"; } // En caso de escribir mal el PSS, saca este error


	if($cont == "") {$cont = "0";} //Si el contador esta vacio asignarle el valor 0 para que pueda imprimir algo
	if($contf == "") {$contf = "0";} //Si el contador esta vacio asignarle el valor 0 para que pueda imprimir algo
	if($ndis == "") {$ndis = "#";} //Si las variables estan vacias asigna el valor # para poder imprimir algo



//#######  ESCRIBE EL RESUMEN DEL ENVÍO  #########//
	$contt = $cont + $contf; //Sumatoria de emails fallados y enviados
	echo "<br><font color='#FFFFFF' size='+2'><b>" . $contt . "</b></font><font color='#FFFFFF' size='+2'> Emails Procesados. </font>"; //imprime emails procesados
	echo "<font color='#F0FF00' size='+2'><b>" . $cont . "</b></font><font color='#F0FF00' size='+2'> Enviados, </font>"; //imprime emails enviados
	echo "<font color='#FF2D2D' size='+2'><b>" . $contf . "</b></font><font color='#FF2D2D' size='+2'> Fallidos</font><br><br>"; //imprime emails fallidos


	echo "<b>Inicio del envío: </b><font color='#ffffff'>" . $hora . "</font> del <font color='#ffffff'>" . $fecha . "</font>. ";// imprime inicio del envio
	$hora=  date ("H:i:s"); //Captura la hora de la finalizacion del envio
	$fecha= date ("j/M/Y"); //Captura la fecha de finalizacion del envio
	echo "<b>Fin del envío:</b> <font color='#ffffff'>" . $hora . "</font> del <font color='#ffffff'>" . $fecha . "</font><br /><br />"; // imprime el final del envio



//#######  ESCRIBE EL REPORTE DE LA INFORMACIÓN USADA PARA EL ENVÍO  #########//



echo "

<table width='500' border='0' align='center'>
  <tr>
    <td width='100'><b>Servidor: </b></td>
    <td><font color='#12EBEB'>$svr_smtp</font></td>
  </tr>
  <tr>
    <td><b>BD: </b></td>
    <td><font color='#12EBEB'>$base</font></td>
  </tr>
  <tr>
    <td><b>Asunto: </b></td>
    <td><font color='#12EBEB'>$asunto</font></td>
  </tr>
  <tr>
    <td><b>Nombre: </b></td>
    <td><font color='#12EBEB'>$nremitente</font></td>
  </tr>
  <tr>
    <td><b>Email: </b></td>
    <td><font color='#12EBEB'>$remitente</font></td>
  </tr>
  <tr>
    <td><b>Mensaje: </b></td>
    <td><font color='#12EBEB'><a href='$ndis' target='_blank' style='color:#fff';>Ver</a>&nbsp;&nbsp;&nbsp;     <a href='$ndis' download='$nremitente - $asunto' target='_blank' style='color:#fff';>Descargar</font></font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
";



	

?>

<script language="JavaScript" type="text/javascript"> alert("Ya terminé :) "); </script>
</div>

</body>
<html>
