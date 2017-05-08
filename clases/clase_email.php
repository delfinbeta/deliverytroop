<?php
class Email {
  public function enviar_contrasena($correo, $contrasena, $nombre, $apellido) {
    $arrhtml_mail = file($GLOBALS['app_root'].'/plantillas/email_contrasena.html');
		
  	$html_mail = '';
    for($i = 0; $i < count($arrhtml_mail); $i++) {
      $html_mail .= $arrhtml_mail[$i];
    }
    
    $html_mail = str_replace("#NOMBRE#",$nombre,$html_mail);
    $html_mail = str_replace("#APELLIDO#",$apellido,$html_mail);
    $html_mail = str_replace("#CONTRASENA#",$contrasena,$html_mail);
    
    $contenido = $html_mail;
    $asunto = "Delivery Troop - Password";
    
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: Delivery Troop <hello@deliverytroop.com>\r\n";
    mail($correo, $asunto, $contenido, $headers); #ENVIO DEL EMAIL CON LOS DATOS#
  }

  public function enviar_comentario($nombre, $email, $comentario) {
    $arrhtml_mail = file($GLOBALS['app_root'].'/plantillas/email_comentario.html');
        
    $html_mail = '';
    for($i = 0; $i < count($arrhtml_mail); $i++) {
      $html_mail .= $arrhtml_mail[$i];
    }
    
    $html_mail = str_replace("#NOMBRE#",$nombre,$html_mail);
    $html_mail = str_replace("#EMAIL#",$email,$html_mail);
    $html_mail = str_replace("#COMENTARIO#",$comentario,$html_mail);
    
    $contenido = $html_mail;
    $asunto = "Delivery Troop - Comment";
    
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: Delivery Troop <hello@deliverytroop.com>\r\n";
    mail('deliverytroop@gmail.com', $asunto, $contenido, $headers); #ENVIO DEL EMAIL CON LOS DATOS#
  }

  public function enviar_respuesta_comentario($email, $usuario, $respuesta) {
    $arrhtml_mail = file($GLOBALS['app_root'].'/plantillas/email_respuesta_comentario.html');
        
    $html_mail = '';
    for($i = 0; $i < count($arrhtml_mail); $i++) {
      $html_mail .= $arrhtml_mail[$i];
    }
    
    $html_mail = str_replace("#USUARIO#",$usuario,$html_mail);
    $html_mail = str_replace("#RESPUESTA#",$respuesta,$html_mail);
    
    $contenido = $html_mail;
    $asunto = "Delivery Troop - Comment";
    
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: Delivery Troop <hello@deliverytroop.com>\r\n";
    mail($email, $asunto, $contenido, $headers); #ENVIO DEL EMAIL CON LOS DATOS#
  }
  
  public function enviar_orden($id_orden, $nombre, $email, $telefono, $direccion, $zipcode, $ciudad, $hotel_id, $hotel_nombre, $hotel_habitacion, $instrucciones, $html_carrito) {
    $arrhtml_mail = file($GLOBALS['app_root'].'/plantillas/email_orden.html');
        
    $html_mail = '';
    for($i = 0; $i < count($arrhtml_mail); $i++) {
      $html_mail .= $arrhtml_mail[$i];
    }
    
    $html_mail = str_replace("#ORDEN_ID#",$id_orden,$html_mail);
    $html_mail = str_replace("#NOMBRE#",$nombre,$html_mail);
    $html_mail = str_replace("#EMAIL#",$email,$html_mail);
    $html_mail = str_replace("#TELEFONO#",$telefono,$html_mail);
    $html_mail = str_replace("#DIRECCION#",$direccion,$html_mail);
    $html_mail = str_replace("#ZIPCODE#",$zipcode,$html_mail);
    $html_mail = str_replace("#CIUDAD#",$ciudad,$html_mail);

    $hotel = '';
    if($hotel_id > 0) {
      $hotel .= '<tr>';
      $hotel .= '<td style="padding: 4px; width: 50%; border-bottom: 1px solid #FFBE00;">Hotel: <strong>'.$hotel_nombre.'</strong></td>';
      $hotel .= '<td style="padding: 4px; width: 50%; border-bottom: 1px solid #FFBE00;">Room: <strong>'.$hotel_habitacion.'</strong></td>';
      $hotel .= '</tr>';
    }

    $html_mail = str_replace("#HOTEL#",$hotel,$html_mail);
    $html_mail = str_replace("#INSTRUCCIONES#",$instrucciones,$html_mail);
    $html_mail = str_replace("#HTML_CARRITO#",$html_carrito,$html_mail);
    
    $contenido = $html_mail;
    $asunto = "Delivery Troop - Order Code:".$id_orden;
    
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: Delivery Troop <hello@deliverytroop.com>\r\n";
    mail('deliverytroop@gmail.com', $asunto, $contenido, $headers); #ENVIO DEL EMAIL CON LOS DATOS#
    mail($email, $asunto, $contenido, $headers);
  }
}
?>