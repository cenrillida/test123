<?php

ini_set('memory_limit', '2048M');
include_once dirname(__FILE__)."/_include.php";

function echoPublsTable($rows) {
    $publs = new Publications();
    ?>
    <table>
        <?php foreach ($rows as $row): $authors = $publs->getAuthors($row['people']);?>
        <tr>
            <td><a href="https://www.imemo.ru/dreamedit/index.php?mod=articls&action=edit&id=<?=$row['page_id']?>" target="_blank">Админка</a></td>
            <td><?=$row['affiliation']?></td>
            <td><?=$authors[0]?></td>
        </tr>
        <?php endforeach;?>
    </table>
    <?php
}

$publsAffiliation = $DB->select("
SELECT * FROM adm_article
WHERE 
    (page_template = 'jarticle' OR page_template = 'jarticle_2021') AND
    (affiliation LIKE '%Примаков%' OR affiliation LIKE '%ИМЭМО%' OR people_affiliation_en LIKE '%IMEMO%')
");


$personsWorking = $DB->select("
SELECT * FROM persons 
         WHERE 
             (otdel<>1240 AND otdel2<>1240 AND otdel3<>1240) AND
             (otdel<>561 AND otdel2<>561 AND otdel3<>561) AND
             (dolj<>100 AND dolj2<>100 AND dolj3<>100)


 ");

$sqlText = "1=0";
$sqlTextAfjourn = "1=0";
$sqlWithoutText = "1=1";

foreach (array_map(function ($el) { return $el['id'];},$personsWorking) as $value) {
    $sqlText.= " OR people LIKE '$value<%' OR people LIKE '%>$value<%' OR people LIKE '%>$value'";
    $sqlTextAfjourn.= " OR p.cv_text LIKE '$value<%' OR p.cv_text LIKE '%>$value<%' OR p.cv_text LIKE '%>$value'";
    $sqlWithoutText.= " AND people NOT LIKE '$value<%' AND people NOT LIKE '%>$value<%' AND people NOT LIKE '%>$value'";
}

$publsPeople = $DB->select("
SELECT * FROM adm_article
WHERE
    (page_template = 'jarticle' OR page_template = 'jarticle_2021') AND
    (".$sqlText.")
");

//foreach ($publsPeople as $publ) {
//    $DB->query("UPDATE adm_article SET to_publs_list=1 WHERE page_id=?d", $publ['page_id']);
//}

$publsPeopleAfjournal = $DB->select("
SELECT aa.* FROM afjourn.adm_pages AS aa
INNER JOIN afjourn.adm_pages_content AS p ON aa.page_id=p.page_id AND p.cv_name='PEOPLE'
WHERE aa.page_template='article' AND
      (".$sqlTextAfjourn.")

");

$publsAffiliationAfjournal = $DB->select("
SELECT aa.* FROM afjourn.adm_pages AS aa
INNER JOIN afjourn.adm_pages_content AS affiliation ON aa.page_id=affiliation.page_id AND affiliation.cv_name='AFFILIATION'
LEFT JOIN afjourn.adm_pages_content AS to_publs_list ON aa.page_id=to_publs_list.page_id AND to_publs_list.cv_name='TO_PUBLS_LIST'
WHERE aa.page_template='article' AND
      ((affiliation.cv_text LIKE '%Примаков%' OR affiliation.cv_text LIKE '%ИМЭМО%' OR aa.people_affiliation_en LIKE '%IMEMO%') OR to_publs_list.cv_text=1)

");

if($_GET['debug']==345) {
//    foreach ($publsPeopleAfjournal as $publ) {
//        $DB->query("INSERT INTO afjourn.adm_pages_content(page_id,cv_name,cv_text) VALUES (?d,'TO_PUBLS_LIST','1')", $publ['page_id']);
//    }
    var_dump(count($publsAffiliationAfjournal));
}


$publsAffiliationPeople = $DB->select("
SELECT * FROM adm_article
WHERE 
    (page_template = 'jarticle' OR page_template = 'jarticle_2021') AND
    ((affiliation LIKE '%Примаков%' OR affiliation LIKE '%ИМЭМО%' OR people_affiliation_en LIKE '%IMEMO%') OR
    (".$sqlText."))
");



$publsAffiliationWithoutPeople = $DB->select("
SELECT * FROM adm_article
WHERE 
    (page_template = 'jarticle' OR page_template = 'jarticle_2021') AND
    ((affiliation LIKE '%Примаков%' OR affiliation LIKE '%ИМЭМО%' OR people_affiliation_en LIKE '%IMEMO%') AND
    (".$sqlWithoutText."))
");

$publsPeopleWithoutAffiliation = $DB->select("
SELECT * FROM adm_article
WHERE 
    (page_template = 'jarticle' OR page_template = 'jarticle_2021') AND
    (((affiliation NOT LIKE '%Примаков%' AND affiliation NOT LIKE '%ИМЭМО%') OR affiliation IS NULL) AND
    ((people_affiliation_en NOT LIKE '%IMEMO%') OR people_affiliation_en IS NULL) AND
    (".$sqlText."))
");


?>
<html lang="ru">
<head>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div><a href="https://imemo.ru/dreamedit/publs_test.php?type=affiliation">Количество статей по аффилиации учитывая совпадения "ИМЭМО" и "Примаков"</a>: <?=count($publsAffiliation)?></div>
    <div><a href="https://imemo.ru/dreamedit/publs_test.php?type=people">Количество статей по персоналиям(кроме должности "сотрудник другой организации", отделов "уволен" и "партнеры)</a>: <?=count($publsPeople)?></div>
    <div><a href="https://imemo.ru/dreamedit/publs_test.php?type=affiliationWithPeople">Количество статей по аффилиации и персоналиям</a>: <?=count($publsAffiliationPeople)?></div>
    <div><a href="https://imemo.ru/dreamedit/publs_test.php?type=affiliationWithoutPeople">Количество статей по аффилиации выключая совпадения по персоналиям</a>: <?=count($publsAffiliationWithoutPeople)?></div>
    <div><a href="https://imemo.ru/dreamedit/publs_test.php?type=peopleWithoutAffiliation">Количество статей по персоналиям выключая совпадения по аффилиации</a>: <?=count($publsPeopleWithoutAffiliation)?></div>


<?php

switch($_GET['type']) {
    case 'affiliation':
        echoPublsTable($publsAffiliation);
        break;
    case 'people':
        echoPublsTable($publsPeople);
        break;
    case 'affiliationWithPeople':
        echoPublsTable($publsAffiliationPeople);
        break;
    case 'affiliationWithoutPeople':
        echoPublsTable($publsAffiliationWithoutPeople);
        break;
    case 'peopleWithoutAffiliation':
        echoPublsTable($publsPeopleWithoutAffiliation);
        break;
    default:

}

if($_GET['year']==2023) {

    $publsPeople = $DB->select("
    SELECT * FROM adm_article
    WHERE
    (page_template = 'jarticle' OR page_template = 'jarticle_2021') AND
    ((affiliation LIKE '%Примаков%' OR affiliation LIKE '%ИМЭМО%') AND
    (".$sqlWithoutText.")) AND year=2023
    ");

    var_dump($publsPeople);
}
?>

</body>
</html>
