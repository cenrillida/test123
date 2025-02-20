<?php

class MagazineRelocator {

    public function __construct()
    {
    }

    public function checkAndRelocateWithPageAttr($pageId, $attr) {

        if(substr($attr['page_template'],0,8)=="magazine") {
            $pg = new Pages();


            if(empty($_SERVER["REDIRECT_URL"]) || (
                substr($_SERVER["REDIRECT_URL"],0,6) != '/jour/' &&
                substr($_SERVER["REDIRECT_URL"],0,9) != '/en/jour/' &&
                $_SESSION["jour"]!="/jour")) {
                $magPage = $pg->getFirstParentWithTemplate($pageId, "magazine");
                if(!empty($magPage)) {
                    $magContent = $pg->getContentByPageId($magPage['page_id']);

                    if(!empty($magContent['ITYPE_JOUR'])) {
                        $mz = new Magazine();
                        $mag = $mz->getPageById($magContent['ITYPE_JOUR']);
                        if(!empty($mag['page_journame'])) {
                            $_SERVER["REDIRECT_URL"] = $_SESSION['lang']."/jour/".$mag['page_journame']."/";
                        } else {
                            Dreamedit::sendHeaderByCode(404);
                            exit;
                        }
                    } else {
                        Dreamedit::sendHeaderByCode(404);
                        exit;
                    }
                } else {
                    Dreamedit::sendHeaderByCode(404);
                    exit;
                }
            }
        }


        if(substr($_SERVER["REDIRECT_URL"],0,6) == '/jour/' || substr($_SERVER["REDIRECT_URL"],0,9) == '/en/jour/' || $_SESSION["jour"]=="/jour") {

            $mz = new Magazine();
            $magazines = $mz->getMagazinesUrls();

            if ($attr['page_template']=="magazine_page" || $attr['page_template']=="magazine_article") {
                foreach ($magazines as $magazine) {

                    if (substr($_SERVER['REDIRECT_URL'], 0, strlen($_SESSION["lang"] . "/jour/" . $magazine['page_journame'] . "/")) == $_SESSION["lang"] . "/jour/" . $magazine['page_journame'] . "/") {
                        $mzNew = new MagazineNew();
                        $newMagazine = $mzNew->getPageIdByMagazineOldId($magazine['page_id']);
                        $magazineOptions = $pg->getContentByPageId($newMagazine['page_id']);


                        $articleId = "";
                        if($attr['page_template']=="magazine_page" ) {
                            if (empty($_GET['jid'])) {
                                $redirectPage = $magazineOptions['SUMMARY_ID'];
                            } else {
                                $articleId = "&article_id=" . $_GET['jid'];
                                $redirectPage = $magazineOptions['ARCHIVE_ID'];
                            }
                        }
                        if($attr['page_template']=="magazine_article" ) {
                            $articleId = "&article_id=".$_GET['id'];
                            $redirectPage = $magazineOptions['ARCHIVE_ID'];
                        }

                        Dreamedit::sendHeaderByCode(301);

                        if ($_SESSION["lang"] == "/en")
                            Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . "/en/index.php?page_id=" . $redirectPage.$articleId);
                        else
                            Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . "/index.php?page_id=" . $redirectPage.$articleId);
                        exit;
                    }
                }

            }



            $foundMagazineId = "";

            foreach ($magazines as $magazine) {

                if (mb_strtolower($_SERVER["REDIRECT_URL"]) == $_SESSION["lang"] . "/jour/" . mb_strtolower($magazine['page_journame'])) {
                    $mzNew = new MagazineNew();
                    $newMagazine = $mzNew->getPageIdByMagazineOldId($magazine['page_id']);


                    $foundMagazineId = $newMagazine['page_id'];

                }

                if (mb_strtolower(substr($_SERVER['REDIRECT_URL'], 0, strlen($_SESSION["lang"] . "/jour/" . $magazine['page_journame'] . "/"))) == $_SESSION["lang"] . "/jour/" . mb_strtolower($magazine['page_journame']) . "/") {
                    $mzNew = new MagazineNew();
                    $newMagazine = $mzNew->getPageIdByMagazineOldId($magazine['page_id']);
                    $foundMagazineId = $newMagazine['page_id'];

                }


            }

            if (!empty($foundMagazineId)) {
                Dreamedit::sendHeaderByCode(301);


                if ($_SESSION["lang"] == "/en")
                    Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . "/en/index.php?page_id=" . $foundMagazineId);
                else
                    Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . "/index.php?page_id=" . $foundMagazineId);

                exit;
            } else {
                Dreamedit::sendHeaderByCode(301);
                if ($_SESSION["lang"] == "/en")
                    Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . "/en/index.php?page_id=1592");
                else
                    Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . "/index.php?page_id=1592");
                exit;
            }
        }
    }
}