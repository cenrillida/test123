<script type="text/javascript">
    var word_list = [
        <?php global $DB;

        $rows = $DB->select("");
        $numRows = count($rows);
        $i = 0;

        $tmp = trim(str_replace("\n", ";", trim($keyword)));
        if (count($tmp)==1)
            $tmp = trim(str_replace("<br>", ";", trim($keyword)));
        $tmp = explode (";", $tmp);
        for ($i=0; $i<count($tmp); $i++)
            echo "<a href=/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID']."&key=".str_replace(' ', '_', $tmp[$i]).">".$tmp[$i]."</a> | ";

        foreach ($rows as $row) {
            $weight='1';
            switch ($count) {
                case 0:
                    $weight='13';
                    break;
                case 1:
                    $weight='10.5';
                    break;
                case 2:
                    $weight='9.4';
                    break;
                case 3:
                    $weight='8';
                    break;
                case 4:
                    $weight='6.2';
                    break;
                case 5:
                case 6:
                case 7:
                case 8:
                    $weight='5';
                    break;
                case 9:
                case 10:
                    $weight='4';
                    break;
                case 11:
                case 12:
                case 13:
                case 14:
                    $weight='3';
                    break;
                case 15:
                case 16:
                case 17:
                case 18:
                case 19:
                case 20:
                case 21:
                case 22:
                case 23:
                case 24:
                    $weight='2';
                    break;
            }

            ?>
        {text: "Lorem", weight: <?=$weight?>, link: "https://github.com/DukeLeNoir/jQCloud"}
            <?
        if(++$i !== $numRows) {
            echo ',';
        }
        }


        ?>
        {text: "Lorem", weight: 13, link: "https://github.com/DukeLeNoir/jQCloud"},
        {text: "Ipsum", weight: 10.5, html: {title: "My Title", "class": "custom-class"}, link: {href: "http://jquery.com/", target: "_blank"}},
        {text: "Dolor", weight: 9.4},
        {text: "Sit", weight: 8},
        {text: "Amet", weight: 6.2},
        {text: "Consectetur", weight: 5},
        {text: "Adipiscing", weight: 5},
        {text: "Elit", weight: 5},
        {text: "Nam et", weight: 5},
        {text: "Leo", weight: 4},
        {text: "Sapien", weight: 4},
        {text: "Pellentesque", weight: 3},
        {text: "habitant", weight: 3},
        {text: "morbi", weight: 3},
        {text: "tristisque", weight: 3},
        {text: "senectus", weight: 3},
        {text: "et netus", weight: 3},
        {text: "et malesuada", weight: 3},
        {text: "fames", weight: 2},
        {text: "ac turpis", weight: 2},
        {text: "egestas", weight: 2},
        {text: "Aenean", weight: 2},
        {text: "vestibulum", weight: 2},
        {text: "elit", weight: 2},
        {text: "sit amet", weight: 2},
        {text: "metus", weight: 2},
        {text: "adipiscing", weight: 2},
        {text: "ut ultrices", weight: 2},
        {text: "justo", weight: 1},
        {text: "dictum", weight: 1},
        {text: "Ut et leo", weight: 1},
        {text: "metus", weight: 1},
        {text: "at molestie", weight: 1},
        {text: "purus", weight: 1},
        {text: "Curabitur", weight: 1},
        {text: "diam", weight: 1},
        {text: "dui", weight: 1},
        {text: "ullamcorper", weight: 1},
        {text: "id vuluptate ut", weight: 1},
        {text: "mattis", weight: 1},
        {text: "et nulla", weight: 1},
        {text: "Sed", weight: 1}
    ];
    jQuery(function() {
        jQuery("#tag_cloud").jQCloud(word_list);
    });
</script>
<div id="tag_cloud" style="width: 100%; height: 350px; border: 1px solid #ccc;"></div>