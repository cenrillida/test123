<body style="font-size:14px;width:600px;">
<?
global $DB,$_CONFIG, $site_templater;
$ps = new Persons();
$rows=$ps->getPersonsById($_REQUEST[id]);
//print_r($rows);
//$site_templater->appendValues(array("DESCRIPTION" => "��������� ����� ��� ".strip_tags($rows[0][fio])));
//$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

$pg = new Pages();

$id = addslashes($_REQUEST['id']);
global $_CONFIG;
$ps = new Persons();

//��������� ������� ����������
$row=$ps->getPersonsByIdFull($id);
//print_r($row);
$row2=$DB->select("SELECT * FROM persona_user WHERE id_persona=".(int)$_REQUEST[id]);


echo "<h2> ".$row[0][fio]."</h2>";
echo "".$_TPL_REPLACMENT[CONTENT];
echo "<hr /><span style='color:red;font-size:18px;'>������������ �� �����:</span><br /><br />";
//echo $row[0][ForSite]."<br /><br />";

if (!empty($row[0][regalii0]) || !empty($row[0][regalii0]))
	echo $row[0][regalii0]."<br />".$row[0][regalii];
echo $row[0][dolj]."<br />".$row[0][otdel];
echo "<br />";
  if (!empty($row[0][contact]) && $row[0][contact]!='<a href="mailto:"></a>')
	  echo "<br /><b>���������� ����������</b>";
   echo "<br>".$row[0][contact];
   echo "<br />";



echo $row[0][about];




echo "<br />";
echo "<hr /><span style='color:red;font-size:18px;'>����� ��������:</span><br /><br />";
echo "<br /><br /><b>��� �� ����������: </b>".$row2[0][fio_en];
echo "<br /><br /><b>���������� ����������: </b>".$row2[0][email]." | ".$row2[tel];
echo "<br /><br /><b>���������� ����������: </b>".$row2[0][publs];
echo "<br /><br /><b>�����������: </b>".$row2[0][disser];
echo "<br /><br /><b>������� ������� ���������: </b>".$row2[0][�����];
echo "<br /><br /><b>� ����: </b>".$row2[0][about]."<br />".$row2[0][about_en];
//$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>



