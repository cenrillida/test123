<?php
global $link;
$visitor_ip = $_SERVER['REMOTE_ADDR'];
$date = date("Y-m-d");


$res = $link->query("SELECT id FROM magazine_visits WHERE date='".$date."' AND magazine='energyeconomics'");


$deleted = false;
$inserted = false;
if ($res->num_rows == 0)
{
    $link->query("DELETE FROM magazine_ip_visits WHERE magazine='energyeconomics'");
    $link->query("INSERT INTO magazine_ip_visits (address,magazine) VALUES('".$visitor_ip."', 'energyeconomics')");
    $deleted = true;
	//echo '<a style="display: none;" href="counter">'.$DB->error.'</a>';
    $link->query("INSERT INTO magazine_visits SET date='".$date."', hosts=1, views=1, magazine='energyeconomics'");
}
else
{
    $current = $link->query("SELECT id FROM magazine_ip_visits WHERE address='".$visitor_ip."' AND magazine='energyeconomics'");
    if ($current->num_rows == 1)
    {
        $link->query("UPDATE magazine_visits SET `views`=`views`+1 WHERE date='".$date."' AND magazine='energyeconomics'");
    }
    else
    {
        $link->query("INSERT INTO magazine_ip_visits SET address='".$visitor_ip."', magazine='energyeconomics'");
        $inserted = true;
        $link->query("UPDATE magazine_visits SET `hosts`=`hosts`+1,`views`=`views`+1 WHERE date='".$date."' AND magazine='energyeconomics'");
    }
}

$year = date("Y");
$month = date("m");

        $res = $link->query("SELECT id FROM magazine_visits_month WHERE `year`='".$year."' AND `month`='".$month."' AND magazine='energyeconomics'");
        if ($res->num_rows == 0)
        {
            if(!$deleted) {
                $link->query("DELETE FROM magazine_ip_visits WHERE magazine='energyeconomics'");
                $link->query("INSERT INTO magazine_ip_visits (address,magazine) VALUES('".$visitor_ip."', 'energyeconomics')");
                $deleted = true;
            }

            $link->query("INSERT INTO magazine_visits_month SET `year`='".$year."', `month`='".$month."', hosts=1, views=1, magazine='energyeconomics'");
        }
        else
        {
            $current = $link->query("SELECT id FROM magazine_ip_visits WHERE address='".$visitor_ip."' AND magazine='energyeconomics'");
            if ($current->num_rows == 1)
            {
                if($inserted) {
                    $link->query("UPDATE magazine_visits_month SET `hosts`=`hosts`+1,`views`=`views`+1 WHERE `year`='".$year."' AND `month`='".$month."' AND magazine='energyeconomics'");
                } else {
                    $link->query("UPDATE magazine_visits_month SET `views`=`views`+1 WHERE `year`='".$year."' AND `month`='".$month."' AND magazine='energyeconomics'");
                }
            }
            else {
                $link->query("INSERT INTO magazine_ip_visits SET address='".$visitor_ip."', magazine='energyeconomics'");
                $inserted = true;
                $link->query("UPDATE magazine_visits_month SET `hosts`=`hosts`+1,`views`=`views`+1 WHERE `year`='".$year."' AND `month`='".$month."' AND magazine='energyeconomics'");
            }
        }

$m = new MongoClient();
$visitsDb = $m->imemon;
$collection = $visitsDb->visits;

$res = $collection->count(array("year" => $year, "month" => $month, "magazine" => 'energyeconomics'));

if($res == 0) {
    if(!$deleted) {
        $link->query("DELETE FROM magazine_ip_visits WHERE magazine='energyeconomics'");
        $link->query("INSERT INTO magazine_ip_visits (address,magazine) VALUES('".$visitor_ip."', 'energyeconomics')");
        $deleted = true;
    }

    $collection->insert(array("year" => $year, "month" => $month, "magazine" => 'energyeconomics', "hosts" => 1, "views" => 1));
} else {
    $current = $link->query("SELECT id FROM magazine_ip_visits WHERE address='".$visitor_ip."' AND magazine='energyeconomics'");
    $resArr = $collection->findOne(array("year" => $year, "month" => $month, "magazine" => 'energyeconomics'));

    if(!empty($resArr)) {
        if ($current->num_rows == 1) {
            if ($inserted) {
                $collection->update(array("_id" => $resArr['_id']),array("year" => $year, "month" => $month, "magazine" => 'energyeconomics', "hosts" => (int)$resArr['hosts']+1, "views" => (int)$resArr['views']+1));
            } else {
                $collection->update(array("_id" => $resArr['_id']),array("year" => $year, "month" => $month, "magazine" => 'energyeconomics', "hosts" => (int)$resArr['hosts'], "views" => (int)$resArr['views']+1));
            }
        } else {
            $link->query("INSERT INTO magazine_ip_visits SET address='".$visitor_ip."', magazine='energyeconomics'");
            $collection->update(array("_id" => $resArr['_id']),array("year" => $year, "month" => $month, "magazine" => 'energyeconomics', "hosts" => (int)$resArr['hosts']+1, "views" => (int)$resArr['views']+1));
        }
    }
}

?>