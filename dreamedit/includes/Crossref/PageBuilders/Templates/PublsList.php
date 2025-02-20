<?php

namespace Crossref\PageBuilders\Templates;

use Crossref\Crossref;
use Crossref\PageBuilders\PageBuilder;

class PublsList implements PageBuilder {

    /** @var Crossref */
    private $crossref;
    /** @var \Pages */
    private $pages;

    /**
     * PublsList constructor.
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
        global $DB,$_CONFIG,$site_templater;



        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->crossref->getAuthorizationService()->isAuthorized()):
            $this->crossref->getPageBuilderManager()->setPageBuilder("top");
            $this->crossref->getPageBuilder()->build(array("main_back" => true));

            $numbers = $DB->select("SELECT p.*,cs.id AS sent_id,cs.checked AS sent_checked FROM publ AS p
                                    LEFT JOIN crossref_sent AS cs ON cs.element_id=p.id AND cs.module='publ'
                                    WHERE tip=441 AND doi<>'' AND status=1 AND vid<>446
                                    ORDER BY p.id DESC");
            ?>

            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Публикация</th>
                                    <th class="text-center" scope="col" style="width: 50px;">Год</th>
                                    <th class="text-center" scope="col" style="width: 200px;">Ранее отправлялась</th>
                                    <th class="text-center" scope="col" style="width: 50px;">Проверить</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($numbers as $number):
                                    if(empty($number['name_title'])) {
                                        $number['name_title'] = $number['name'];
                                    }
                                    ?>
                                    <tr>
                                        <th scope="row"><?=$number['name_title']?></th>
                                        <td class="text-center"><?=$number['year']?></td>
                                        <td class="text-center">
                                            <?php if(!empty($number['sent_id'])) {
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
                                                echo '<a class="text-info" href="/index.php?page_id=' . $_REQUEST['page_id'] . '&mode=publCheckUpload&id=' . $number['id'] . '"
                                                                   role="button">'.$icon.'</a>';
                                            }?>
                                        </td>
                                        <td class="text-center"><a class="text-info" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=publCheck&id=<?=$number['id']?>"
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