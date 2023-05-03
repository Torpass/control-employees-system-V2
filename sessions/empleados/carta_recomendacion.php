<?php include '../../dbConnections/db.php'?>
<?php include '../../dbConnections/dbEmployees.php'?> 



<?php 
$connect = new EmployeeCrud();
$tbl_employees = $connect->getEmployees();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de Recomendacion</title>
</head>
<body>
    <h1>Carta de recomendacion laboral</h1>     
    <p>Barquisimeto Lara, Venezuela a  <strong><?php echo date('d-M-Y')?></strong></p>
    <p>Estimado/a <strong>[Nombre del destinatario]</strong>,</p>
    <p>Me complace recomendar con entusiasmo a <strong><?php echo $employee['firstName'].' '.$employee['lastName']?></strong> para cualquier oportunidad laboral que pueda estar buscando. <strong><?php echo $employee['firstName']?></strong> ha sido un/a miembro/a valioso/a de nuestro equipo desde su fecha de inicio en <strong>Grows company</strong> en <strong><?php echo $employee['startedAt']?></strong>. Durante su tiempo con nosotros, ha ocupado el puesto de <strong><?php echo $employee['job']?></strong>.</p>
    <p>Durante su tiempo en <strong>Grows company</strong>, <strong><?php echo $employee['firstName']?></strong> demostró una gran habilidad para llevar a cabo sus tareas de manera efectiva y eficiente, y siempre ha cumplido con los objetivos y metas asignados. Además, ha demostrado ser una persona altamente confiable, responsable y comprometida con su trabajo.</p>
    <p><strong><?php echo $employee['firstName']?></strong> también ha demostrado ser un/a gran colaborador/a y compañero/a de trabajo. Es un/a comunicador/a eficaz, capaz de interactuar con personas de todos los niveles de la organización y de trabajar en equipo para alcanzar objetivos comunes.</p>
    <p>Por todas estas razones, estoy seguro/a de que <strong><?php echo $employee['firstName']?></strong> sería un/a gran activo para cualquier organización que tenga la suerte de tenerlo/a en su equipo. Si necesita más información, no dude en ponerse en contacto conmigo.</p> <br><br><br><br><br>
    _______________________________________________________
    <p>Atentamente,</p>
    <p><strong>Pastor Jiménez</strong></p>
    <p><strong>C.E.O</strong></p>
    <p><strong>Grows Company</strong></p> <br>
    _______________________________________________________

</body>
</html>



<?php 
    require_once('../../libs/dompdf/autoload.inc.php');
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();
    $options = $dompdf->getOptions();
    $options->set('isRemoteEnabled', TRUE);
    $dompdf->setOptions($options);
    
    $dompdf->loadHtml(ob_get_clean()); 
    $dompdf->setPaper('letter');
    $dompdf->render();
    $dompdf->stream('Carta de Recomendacion.pdf', array('Attachment' => 0));
?>
