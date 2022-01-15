# GhostMailer

Es un sitioweb creado por Alan MOR con la finalidad de enviar emails de manera masiva, creando bucles programables para realizar pausas entre cada email enviado.

Esta escrito en PHP y solo es necesario pegar la carpeta en el directorio raiz de cualquier servidor web, por ejemplo Apache

El sitio web cuenta con dos partes.

1. El enviador: Donde podemos configurar los parametros para envío en cualqueir servidor SMTP, por ejemplo, para hacer un envío con el servidor SMTP de Gmail, los parametros a configurar son los siguientes

Servidor SMTP: smtp.gmail.com
Usuario: tucorreo@gmail.com
Password: tuPasswordGmail
Puerto: 465
Cifrado: SSL


Adicional a esto hay que mencionar que existe una segunda petición de contraseña la cual es simplemente la palabra "internet"

recordemos que todos los emails son escritos en codigo HTML, por lo que GhostMailer solicita dos tipos de información, el código en HTML del email a enviar,  y la version en texto plano, ambas son requeridas para enviar correctamente el email.


Las bases de datos deben estar en formato TXT para poder ser enviadas por el GhostMailer

2. La segunda parte es un verificador de email, en el que nuevamente nos pide la BD en formado TXT y la contraseña "internet"

La funcion de este apartado es verificar la fiabilidad del email, verificando la sintaxis, el formato, y la valiidación de los registros MX para el dominio en cuestion.


Cualquier duda adicional de montaje o uso pueden escribirme a alanosoriouni@gmail.com para mayor información
