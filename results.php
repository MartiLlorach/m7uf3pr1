<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
   		body{
   		}
   		table,td {
   			border: 1px solid black;
   			border-spacing: 0px;
   		}
   	</style>
  </head>
  <body>
    <?php

      # (1.1) Connectem a MySQL (host,usuari,contrassenya)
      $conn = mysqli_connect('localhost','marti','');

      # (1.2) Triem la base de dades amb la que treballarem
      mysqli_select_db($conn, 'world');

      if (isset($_POST['country'])){
   		# (2.1) creem el string de la consulta (query)
     		$consulta =  "SELECT c.Name as cityName, p.Name as countryName, c.CountryCode, c.District, c.Population
                      FROM city c
                      INNER JOIN country p ON c.CountryCode = p.Code
                      WHERE c.CountryCode = 'BRA';";


     		# (2.2) enviem la query al SGBD per obtenir el resultat
     		$resultat = mysqli_query($conn, $consulta);

     		# (2.3) si no hi ha resultat (0 files o bé hi ha algun error a la sintaxi)
     		#     posem un missatge d'error i acabem (die) l'execució de la pàgina web
     		if (!$resultat) {
         			$message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
         			$message .= 'Consulta realitzada: ' . $consulta;
         			die($message);
     		}
   	?>

   	<!-- (3.1) aquí va la taula HTML que omplirem amb dades de la BBDD -->
   	<table>
   	<!-- la capçalera de la taula l'hem de fer nosaltres -->
   	<thead><td colspan="4" align="center" bgcolor="cyan">Llistat de ciutats</td></thead>
   	<?php
   		# (3.2) Bucle while
   		while( $registre = mysqli_fetch_assoc($resultat) )
   		{
   			# els \t (tabulador) i els \n (salt de línia) son perquè el codi font quedi llegible

   			# (3.3) obrim fila de la taula HTML amb <tr>
   			echo "\t<tr>\n";

   			# (3.4) cadascuna de les columnes ha d'anar precedida d'un <td>
   			#	després concatenar el contingut del camp del registre
   			#	i tancar amb un </td>
   			echo "\t\t<td>".$registre["cityName"]."</td>\n";
   			echo "\t\t<td>".$registre['countryName']."</td>\n";
   			echo "\t\t<td>".$registre["District"]."</td>\n";
   			echo "\t\t<td>".$registre['Population']."</td>\n";

   			# (3.5) tanquem la fila
   			echo "\t</tr>\n";
   		}
   	?>
    	<!-- (3.6) tanquem la taula -->
   	</table>
    <?php } ?>
  </body>
</html>
