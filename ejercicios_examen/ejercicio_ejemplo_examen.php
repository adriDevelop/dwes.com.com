<?php

// Crear un script para recoger los datos del viaje y generar una respuesta con todos los
// detalles elegidos, su coste desglosado y el total.

// Importamos el archivo funciones que incluye incihio_html() y fin_html();
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/funciones.php');

ini_set("upload_max_filesize", 500*1024);

$array_destinos = [
  'paris' => Array('nombre' => 'Paris', 'precio' => 100,),
  'londres' => Array('nombre' => 'Londres', 'precio' => 120),
  'estocolmo' => Array('nombre' => 'Estocolmo', 'precio' => 200),
  'edimburgo' => Array('nombre' => 'Edimburgo', 'precio' => 175),
  'praga' => Array('nombre' => 'Praga', 'precio' => 125),
  'viena' => Array('nombre' => 'Viena', 'precio' => 150)
];

$array_compania = [

  'miair' => Array('nombre' => 'MiAir', 'precio' => 0,),
  'airfly' => Array('nombre' => 'AirFly', 'precio' => 50),
  'vuelaconmigo' => Array('nombre' => 'VuelaConmigo', 'precio' => 75),
  'apedalesair' => Array('nombre' => 'ApedalesAir', 'precio' => 150)
];

$array_hotel = [

  'miair' => Array('nombre' => 'MiAir', 'precio' => 0,),
  'airfly' => Array('nombre' => 'AirFly', 'precio' => 50),
  'vuelaconmigo' => Array('nombre' => 'VuelaConmigo', 'precio' => 75),
  'apedalesair' => Array('nombre' => 'ApedalesAir', 'precio' => 150)
];

$extras = ['vg' => 200,
           'bt' => 30,
           '2m' => 20,
           'sv' => 30
          ];

// Llamamos al incio_html() pasandole los
inicio_html("Actividad 05", ['./styles/general.css', './styles/formulario.css']);

if ( $_SERVER['REQUEST_METHOD'] == "GET"){
  // Poner el formulario si no es sticky form.
  // Si es Sticky form, inicializamos los valores de los controles 
  // del fomrulario con valores por defecto.


}

if ( $_SERVER['REQUEST_METHOD'] == "POST"){
  // Procesa el formulario.
  // Si hay Sticky form, se inicializan las variables con los datos del formulario
  // para inicializar los valores de los controles del formulario.

  $responsable = filter_input(INPUT_POST, 'resonsable', FILTER_SANITIZE_SPECIAL_CHARS);

  $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_NUMBER_INT);
  $telefono = preg_match("/[0-9]{9}/", $telefono) == 0? "" : $telefono;

  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $email = filter_validate($email, FILTER_VALIDATE_EMAIL);

  $destino = filter_input(INPUT_POST, 'destino', FILTER_SANITIZE_SPECIAL_CHARS);
  $destino = array_key_exists($destino, $array_destinos) ? $destino : False;

  $compania = filter_input(INPUT_POST, 'compania', FILTER_SANITIZE_SPECIAL_CHARS);
  $compania = array_key_exists($compania, $array_compania) ? $compania : False;

  $hotel = filter_input(INPUT_POST, 'hotel', FILTER_SANITIZE_INT);
  $hotel = filter_var($hotel, FILTER_VALIDATE_INT, Array('min_range' => 3,
                                                       'max_range' => 5,
                                                       'default' => 3));
  
  $hotel = $hotel >= 3 && $hotel <=5 ? $hotel : 3;

  $desayuno = isset($_POST['desayuno']) && $_POST['desayuno'] == "On";

  $num_personas = filter_input(INPUT_POST, 'personas', FILTER_SANITIZE_INT);
  $num_personas = filter_var($num_personas, FILTER_VALIDATE_INT, Array('min_range' => 5,
                                                       'max_range' => 10,
                                                       'default' => 5));
  
  $dias = filter_input(INPUT_POST, 'dias', FILTER_SANITIZE_NUMBER_INT);
  $dias = $dias == 5 || $dias == 10 || $dias == 15 ? $dias : False;
  
  $extras_recibido = filter_input(INPUT_POST, 'extras[]', FILTER_SANITIZE_SPECIAL_CHARS,
                          FILTER_REQUIRE_ARRAY);
  $extras_ok = True;
  foreach ($extras_recibido as $clave => $valor){
    if( !array_key_exists($clave, $extras)){
      $extras_ok = False;
      break;
    }
  }

  // Los datos se han recibido, saneado y validado.
  // Se genera el presupuesto.

  $total = 0;
  if ( $destino ){
    
  }
  
  // Esto nos lo podriamos ahorrar ya que saneandolo $telefono = filter_var($telefono, FILTER_VALIDATE_INT);
}

// Si es Sticky form el formulario viene aquí.
?>
<header>Propuestas de viaje</header>
<form method="POST" action="<?=$_SERVER['PHP_SELF']?>" exctype="multipart/form-data">
  <input type="hidden" name="MAX_FILE_SIZE" value="<?=500*1024?>">
  <fieldset>
    <legend>Datos a enviar</legend>
    <label for="responsable">Responsable del grupo</label>
    <input type="text" name="responsable" id="responsable" size='40'>

    <label for="telefono">Teléfono</label>
    <input type="text" name="telefono" id="telefono" size='10'>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" size='30'>

    <label for="destino">Destino</label>
    <select name="destino">
    <?php
    foreach( $array_destinos as $clave => $valor){
      echo "<option value='$clave'>{$valor['nombre']}</option>";
    }
    ?>
    </select>

    <label for="compania">Compañia aerea</label>
    <select name="compania">
    <?php
    foreach( $array_compania as $clave => $valor){
      echo "<option value='$clave'>{$valor['nombre']}</option>";
    }
    ?>
    </select>

    <label for="hotel">Hotel</label>
    <select name="hotel">
    <?php
    foreach( $array_hotel as $clave => $valor){
      echo "<option value='$clave'>{$valor['nombre']}</option>";
    }
    ?>
    </select>

    <label for="desayuno">Desayuno incluido</label>
    <input type="checkbox" name="desayuno" id="desayuno">

    <label for="personas">Numero de personas</label>
    <input type="number" min="5" max="10" value="5" name="personas" id="personas">

    <label for="dias">Dias</label>
    <div>
      <input type="radio" name="dias" id="dias_5" value="5">5
      <input type="radio" name="dias" id="dias_10" value="10">10
      <input type="radio" name="dias" id="dias_15" value="15">15
    </div>
    
    <label for="extras[]">Extras</label>
    <div>
      <input type="checkbox" name="extras['vg']" id="extras_1">Visita guiada
      <input type="checkbox" name="extras['bt']" id="extras_2">Bus turistico
      <input type="checkbox" name="extras['2m']" id="extras_3">Segunda maleta facturada
      <input type="checkbox" name="extras['sv']" id="extras_4">Seguro de viajes
    </div>

    <label for="">Copia del libro de familia</label>
    <input type="file" name="libro" id="libro">

  </fieldset>
</form>

<?php
fin_html();
?>