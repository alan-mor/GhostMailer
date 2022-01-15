<html><head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
<link rel="shortcut icon" href="img/gst.ico" />
<title> Analizando... </title></head>
<body bgcolor="#000000" text="#40FF00">
<font face="Segoe UI">

<?php

date_default_timezone_set('America/Mexico_City'); //Establecemos la zona horaria

	ini_set('post_max_size','100M');
	ini_set('upload_max_filesize','100M');
	ini_set('max_execution_time','1000000000000000000000000000');
	ini_set('max_input_time','1000000000000000000000000');


	$pss1 = $_POST["pss"]; //leemos el pass del formulario
	$pss = md5($pss1); //transformamos el pass en MD5

	//Damos valores vacios a algunas variables para no marcar errores
	$cont = "0"; 
	$contmal = "0";
	$contbn = "0";
	$nlog = "";
	$nlogb = "";



if ($pss == "c3581516868fb3b71746931cac66390e") {


	$basefile = $_FILES["base"]["tmp_name"]; //Lee el archivo de la base
	$basece = $_FILES["base"]["name"]; //separar el nombre de la base
	$base = substr($basece, 0, strrpos($basece, ".")); 
	$file = fopen($basefile, "r") or exit("Error abriendo fichero!"); //intentar abrir o fallar

//Lee línea a línea y escribela hasta el fin de fichero



	$hora=  date ("H:i:s"); //registrar hora inicial
	$fecha= date ("j/M/Y"); //registrar fecha inicial
	$cont = 0; //asignar el valor 0 al contador para evitar variables no declaradas
	$contmal = 0; //asignar el valor 0 al contador para evitar variables no declaradas


//FUNCION PARA VERIFICAR SINTAXIS DEL EMAIL
function vemail($dompa)

{

  $matches = null;

  return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $dompa, $matches));

}


//INICIA EL PROCESO DEL BUCLE
while($mail = fgets($file)) {

   // if (feof($file)) break;

	$dompa = trim($mail); //le quito los espacios en blanco
	$dompa2 = substr($dompa, strpos($dompa,'@')); //eimino el usuario y dejo el dominio con arroba
	$dominio = str_replace("@", "", $dompa2); //eliminio el arroba


//extraer usuario para verificar
//$vusr = $vmail[0]; // Imprime "usuario"
//echo $vmail[1]; // Imprime "email.dom"
//$vmail = explode("@",$dompa); //esto separa en dos strings un email, lo que este antes del arrona y lo que este despues del arroba



// CREAR FUNCION PARA VALIDAD USUARIO


// CREAR FUNCION PARA VALIDAD USUARIO

	if (!vemail($dompa) == true){ 


		 $nlog="bd/".$base."_MALOS".date("dmy").".csv"; //nombra el log segun el dia
		 $linlog =$mail.","; //Se escribe la linea del log con la información
		 $ffile=fopen($nlog,"a+"); //Agrega los permisos para escritura del archivo 
		 fwrite($ffile,$linlog);  //Escribe
		 fclose($ffile); //cierra el archivo

		 $contmal = $contmal + 1;


	 } 

	else 
	{
		if (!dns_check_record($dominio)) { 


		 $nlog="bd/".$base."_MALOS".date("dmy").".csv"; //nombra el log segun el dia
		 $linlog =$mail.","; //Se escribe la linea del log con la información
		 $ffile=fopen($nlog,"a+"); //Agrega los permisos para escritura del archivo 
		 fwrite($ffile,$linlog);  //Escribe
		 fclose($ffile); //cierra el archivo

		 $contmal = $contmal + 1;

		 }
				 else 
		 	{
		 	 $nlogb="bd/".$base."_BUENOS".date("dmy").".csv"; //nombra el log segun el dia
			 $linlog =$mail.","; //Se escribe la linea del log con la información
			 $ffile=fopen($nlogb,"a+"); //Agrega los permisos para escritura del archivo 
			 fwrite($ffile,$linlog);  //Escribe
			 fclose($ffile); //cierra el archivo
			 $contbn = $contbn + 1;
		 	}
	 }
$cont = $cont + 1; //Contrador de los emails procesados




} // AQUI CIERRA EL WILD

} // Termina el IF del password

else { echo "ERROR PASSWORD"; } 



$hora2 =  date ("H:i:s"); //registra hora final del analisis
$fecha2 = date ("j/M/Y"); //registra fecha final del analisis

if($cont == "") {$cont = "0";} //Si las variables estan vacias asigna el valor 0 para poder imprimir algo
if($contmal == "") {$contmal = "0";} //Si las variables estan vacias asigna el valor 0 para poder imprimir algo
if($contbn == "") {$contbn = "0";} //Si las variables estan vacias asigna el valor 0 para poder imprimir algo
if($nlog == "") {$nlog = "#";} //Si las variables estan vacias asigna el valor # para poder imprimir algo
if($nlogb == "") {$nlogb = "#";} //Si las variables estan vacias asigna el valor # para poder imprimir algo


//ESCRIBIMOS EL REPORTE DEL ANALISIS
echo "<br>
<center><img src='img/gm.png' width='500' align='center'><br>

<br><br><FONT face='Segoe UI' color='#F0FF00' size='+3'><b>$cont </b></font><font color='#12EBEB' size='+3'> Emails Analizados.</font><br>

<b>Inicio del analisis:  </b><font color='#ffffff'>  $hora  </font> del <font color='#ffffff'>  $fecha  </font>. <b>Fin del analisis:</b> <font color='#ffffff'> $hora2 </font> del <font color='#ffffff'>  $fecha2  </font><br><br>

<font color='#12EBEB' size='+3'> Resultado del Analisis de la BD</font><FONT face='Segoe UI' color='#F0FF00' size='+3'><b> $base</b></font><br><br>

</center>





<table width='400' border='0' align='center'>
  <tr>
    <td width='150'><FONT face='Segoe UI' color='#F0FF00'><b>$contbn </b></font><font color='#12EBEB'> Emails buenos encontrados.</font></td>
    <td><a href='$nlogb' download='$nlogb'  style='color:#fff';>Descargar</a></td>
  </tr>
  <tr>
    <td><FONT face='Segoe UI' color='#F0FF00'><b>$contmal </b></font><font color='#12EBEB'> Emails invalidos encontrados.</font></td>
    <td><a href='$nlog' download='$nlog'  style='color:#fff';>Descargar</a></td>
  </tr>
</table>

";

?>



</body>

</html>