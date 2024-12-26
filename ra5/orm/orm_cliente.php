<?php
    require_once("util/Autocarga.php");

    use orm\util\Html;
    use orm\util\Autocarga;

    Autocarga::registro_autocarga();
    Html::inicio("ORM en PHP", ['../../styles/general.css', '../../styles/tablas.css']);
    echo "<header>ORM en PHP</header>";
    Html::fin();
?>