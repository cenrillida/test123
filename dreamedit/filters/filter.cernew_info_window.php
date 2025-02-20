<?php
global $DB;

$result2 = $DB->selectRow("SELECT `table` COLLATE utf8_general_ci AS `table` FROM cer_infowindow");

$result2['table'] = mb_convert_encoding($result2['table'],"utf-8","cp1251");
$data_info = unserialize($result2['table']);
$line = false;

?>
<div class="col-12 pb-3">
    <div class="shadow border bg-white p-3 h-100">
        <div class="row">
            <div class="col-12">
                <table class="table text-center">

                    <?
                    $first = true;
                    foreach($data_info as $row_info):
                    if($first) {
                        ?>
                        <thead class="thead-dark">
                    <?php
                    }
                    $emptyRow = true;
                        foreach($row_info as $node) {
                            if(!empty($node)) {
                                $emptyRow = false;
                            }
                        }
                        if($emptyRow && !$first) {
                            continue;
                        }
                        echo '<tr>';
                        $count_info=count($row_info);
                        foreach($row_info as $node):
                            if($node=="-") {
                                $line=true;
                                break;
                            }
                            $count_info--;
                            if ($count_info!=0):?>
                                <<?php if($first) echo 'th'; else echo 'td';?> class="align-middle p-1<?php if($first) echo ' bg-color-imemo';?>"<? if($line){
                                    echo ' style="border-top: 1px solid black;';
                                    if(strpos($node,"&#8593")!==FALSE) echo ' color: green;';
                                    if(strpos($node,"&#8595")!==FALSE) echo ' color: red;';
                                    echo '"';
                                }
                                else { if(strpos($node,"&#8593")!==FALSE) echo ' style="color: green;"'; if(strpos($node,"&#8595")!==FALSE) echo ' style="color: red;"';}?>><?=mb_convert_encoding($node,'cp1251','utf-8')?></<?php if($first) echo 'th'; else echo 'td';?>>
                            <?
                            else:
                                $line=false;
                            endif;
                        endforeach;?>
                        </tr>
                    <?
                    if($first) {
                        echo '</thead>';
                        $first = false;
                    }
                    endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>