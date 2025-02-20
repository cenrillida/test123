<?php
global $link,$p_id;

$result2 = $link->query("SELECT * FROM cer_infowindow");

$data_info = mysqli_fetch_row($result2);

if($_GET[debug]==1) {
    var_dump($data_info[1]);
}
$data_info = unserialize($data_info[1]);
$line = false;

?>
<div class="infowindow">
    <table>
        <? foreach($data_info as $row_info):
            echo '<tr>';
            $count_info=count($row_info);
            foreach($row_info as $node):
                if($node=="-") {
                    $line=true;
                    break;
                }
                $count_info--;
                if ($count_info!=0):?>
                <td<? if($line){
                echo ' style="border-top: 1px solid black;';
                if(strpos($node,"&#8593")!==FALSE) echo ' color: green;';
                if(strpos($node,"&#8595")!==FALSE) echo ' color: red;';
                echo '"';
                }
                else { if(strpos($node,"&#8593")!==FALSE) echo ' style="color: green;"'; if(strpos($node,"&#8595")!==FALSE) echo ' style="color: red;"';}?>><?=$node?></td>
            <?
                else:
                $line=false;
                endif;
            endforeach;?>
        </tr>
        <? endforeach; ?>
    </table>
</div>