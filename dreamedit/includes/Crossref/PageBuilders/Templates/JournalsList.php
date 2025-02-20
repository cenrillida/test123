<?php

namespace Crossref\PageBuilders\Templates;

use Crossref\Crossref;
use Crossref\PageBuilders\PageBuilder;

class JournalsList implements PageBuilder {

    /** @var Crossref */
    private $crossref;
    /** @var \Pages */
    private $pages;

    /**
     * JournalsList constructor.
     * @param Crossref $crossref
     * @param \Pages $pages
     */
    public function __construct(Crossref $crossref, $pages)
    {
        $this->crossref = $crossref;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$DB_AFJOURNAL,$_CONFIG,$site_templater;



        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->crossref->getAuthorizationService()->isAuthorized()):
            $this->crossref->getPageBuilderManager()->setPageBuilder("top");
            $this->crossref->getPageBuilder()->build(array("main_back" => true));

            $numbers = $DB->select("SELECT aa.*,cs.id AS sent_id,cs.checked AS sent_checked FROM adm_article AS aa
                                    LEFT JOIN crossref_sent AS cs ON cs.element_id=aa.page_id AND cs.module='journal'
                                    LEFT JOIN adm_pages_content AS abr ON abr.page_id=aa.journal_new AND abr.cv_name='CROSSREF_ABBREV'
                                    INNER JOIN adm_article_content AS c ON c.page_id=aa.page_id AND c.cv_name='date_public'
                                    WHERE aa.page_template='jnumber' AND abr.cv_text IS NOT NULL AND abr.cv_text<>'' AND aa.page_status=1 AND c.cv_text<>''
                                    ORDER BY aa.page_id DESC");



                $numbersAfjournal = $DB_AFJOURNAL->select(
                    "SELECT 'Анализ и прогноз' AS j_name,y.page_name AS 'year','1' AS 'ap',ap.*,CONCAT(SUBSTR(ap.date_created,1,4),SUBSTR(ap.date_created,6,2),SUBSTR(ap.date_created,9,2)) AS 'date' 
                      FROM `adm_pages` AS ap 
                      INNER JOIN adm_pages AS y ON y.page_id=ap.page_parent
                      WHERE ap.page_template='number' AND ap.page_status=1");

                $sentAfJournal = $DB->select("SELECT cs.element_id AS ARRAY_KEY,cs.*,cs.checked AS sent_checked FROM crossref_sent AS cs WHERE cs.`module`='afjournal'");

                foreach ($numbersAfjournal as $k=>$v) {
                    if(!empty($sentAfJournal[$v['page_id']])) {
                        $numbersAfjournal[$k]['sent_id'] = $sentAfJournal[$v['page_id']]['id'];
                        $numbersAfjournal[$k]['sent_checked'] = $sentAfJournal[$v['page_id']]['sent_checked'];
                    }
                }

                if(!empty($numbersAfjournal)) {
                    $numbersMerged = array_merge(array_values($numbers),array_values($numbersAfjournal));

                    uasort($numbersMerged, function ($a,$b) {
                        if ($a['date'] == $b['date']) {
                            return 0;
                        }
                        return ($a['date'] < $b['date']) ? 1 : -1;
                    });
                    $numbersMerged = array_values($numbersMerged);
                } else {
                    $numbersMerged = array_values($numbers);
                }

            ?>

            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Журнал</th>
                                    <th class="text-center" scope="col" style="width: 400px;">Номер</th>
                                    <th class="text-center" scope="col" style="width: 50px;">Год</th>
                                    <th class="text-center" scope="col" style="width: 200px;">Ранее отправлялся</th>
                                    <th class="text-center" scope="col" style="width: 50px;">Проверить</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($numbersMerged as $number):

                                    ?>
                                    <tr>
                                        <th scope="row"><?=$number['j_name']?></th>
                                        <td class="text-center"><?=$number['page_name']?></td>
                                        <td class="text-center"><?=$number['year']?></td>
                                        <td class="text-center">
                                            <?php if(!empty($number['sent_id'])):

                                                switch ($number['sent_checked']) {
                                                    case 0:
                                                        $icon = '<div class="spinner-border crossref-sent-loader" data-sent_id="'.$number['sent_id'].'" role="status" style="width: 16px; height: 16px">
        <span class="sr-only">Loading...</span>
    </div>';
                                                        $icon = '<i class="fas fa-question"></i>';

                                                        break;
                                                    case 1:
                                                        $icon = '<i class="fas fa-check text-success"></i>';
                                                        break;
                                                    case 2:
                                                        $icon = '<i class="fas fa-exclamation text-warning"></i>';
                                                        break;
                                                    case -1:
                                                        $icon = '<i class="fas fa-times text-danger"></i>';
                                                        break;
                                                    default:
                                                        $icon = '<i class="fas fa-question"></i>';
                                                }
                                                ?>
                                    <a class="text-info" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=numberCheckUpload&id=<?=$number['page_id']?><?php if($number['ap']==1) echo "&ap=1";?>"
                                                                   role="button"><?=$icon?></a>
                                    <?php endif;?>
                                    </td>
                                        <td class="text-center"><a class="text-info" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=numberCheck&id=<?=$number['page_id']?><?php if($number['ap']==1) echo "&ap=1";?>"
                                                                   role="button"><i class="fas fa-search"></i></a></td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;?>
        <?php

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}