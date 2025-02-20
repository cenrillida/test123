<?php
//
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//
//include_once dirname(__FILE__)."/_include.php";
//
//global $DB;
//
//$jourId = 1668;
//
//$jourPrefix = "electronic-resources/oprme";
//
//$mainMenu = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en) VALUES (0,'Главное меню',?,1,1)",$jourId);
//
//$aboutJour = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en,page_name_en,page_position,addmenuleft,addmenusize,noactivemenulink,page_urlname) VALUES (0,'О журнале',?,1,1,'Journal Information',0,1,400,1,?)",$mainMenu,$jourPrefix."/about");
////$aboutJour = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en,page_name_en,page_position) VALUES (0,'Об издании',?,1,1,'Publication Information',0)",$mainMenu);
//$aboutJourInfo = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en,page_name_en,page_position,page_urlname) VALUES (0,'Информация об издании',?,1,1,'Publication Information',0,?)",$aboutJour,$jourPrefix."/about/info");
//$aboutJourRedCol = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en,page_name_en,page_position,page_urlname) VALUES (0,'Редколлегия',?,1,1,'Editorial Board',1,?)",$aboutJour,$jourPrefix."/about/editorial-board");
//
//$archive = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en,page_name_en,page_position,page_urlname) VALUES ('mag_archive','Архив',?,1,1,'Archive',3,?)",$mainMenu,$jourPrefix."/archive");
//$currentNumber = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en,page_name_en,page_position) VALUES ('mag_current_number','Текущий номер',?,1,1,'Current Issue',2)",$mainMenu);
//$authorsIndex = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en,page_name_en,page_position,page_urlname) VALUES ('mag_authors_index','Авторский указатель',?,1,1,'Authors index',4,?)",$mainMenu,$jourPrefix."/authors-index");
//
//$grayMenu = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en) VALUES (0,'Серое меню',?,1,1)",$jourId);
//
//$DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en,page_name_en,page_link,page_link_en) VALUES (0,'Официальный сайт ИМЭМО РАН',?,1,1,'Official Site of IMEMO','/','/en')",$grayMenu);
//$DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en,page_name_en,page_link,page_link_en) VALUES (0,'Периодические издания',?,1,1,'Editions','/index.php?page_id=1613','/en/index.php?page_id=1613')",$grayMenu);
//
//$addPages = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en) VALUES (0,'Дополнительные страницы',?,0,0)",$jourId);
//
//$authorsByYear = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en,page_name_en,page_position,page_urlname) VALUES ('mag_spisok_year','Авторы за год',?,1,1,'Authors by year',4,?)",$addPages,$jourPrefix."/authors-by-year");
//$articlesByAuthor = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en,page_name_en,page_position,page_urlname) VALUES ('mag_author','Все статьи автора',?,1,1,'Articles by author',4,?)",$addPages,$jourPrefix."/articles-by-author");
//$rubricIndex = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en,page_name_en,page_position,page_urlname) VALUES ('mag_rubric_all','Индекс рубрик',?,1,1,'Rubric Index',4,?)",$addPages,$jourPrefix."/rubric-index");
//$rubric = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en,page_name_en,page_position,page_urlname) VALUES ('mag_rubric','Рубрика',?,1,1,'Rubric',4,?)",$rubricIndex,$jourPrefix."/rubric-index/rubric");
//$articlesByYear = $DB->query("INSERT INTO adm_pages(page_template,page_name,page_parent,page_status,page_status_en,page_name_en,page_position,page_urlname) VALUES ('mag_rubric_all','Статьи за год',?,1,1,'Articles by year',4,?)",$addPages,$jourPrefix."/articles-by-year");
//
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'TITLE','Архив')",$archive);
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'TITLE_EN','Archive')",$archive);
//
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'TITLE','Авторский указатель')",$authorsIndex);
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'TITLE_EN','Authors index')",$authorsIndex);
//
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'TITLE','Авторы за год')",$authorsByYear);
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'TITLE_EN','Authors by year')",$authorsByYear);
//
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'TITLE','Все статьи автора')",$articlesByAuthor);
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'TITLE_EN','Articles by author')",$articlesByAuthor);
//
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'TITLE','Индекс рубрик')",$rubricIndex);
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'TITLE_EN','Rubric Index')",$rubricIndex);
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'SHORT_LIST','1')",$rubricIndex);
//
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'TITLE','Рубрика')",$rubric);
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'TITLE_EN','Rubric')",$rubric);
//
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'TITLE','Статьи за год')",$articlesByYear);
//$DB->query("INSERT INTO adm_pages_content(page_id,cv_name,cv_text) VALUES (?,'TITLE_EN','Articles by year')",$articlesByYear);
//
//
//$DB->query("UPDATE adm_pages_content SET cv_text=? WHERE page_id=? AND cv_name='ARCHIVE_ID'",$archive,$jourId);
//$DB->query("UPDATE adm_pages_content SET cv_text=? WHERE page_id=? AND cv_name='MAIN_MENU_ID'",$mainMenu,$jourId);
//$DB->query("UPDATE adm_pages_content SET cv_text=? WHERE page_id=? AND cv_name='GRAY_MENU_ID'",$grayMenu,$jourId);
//$DB->query("UPDATE adm_pages_content SET cv_text=? WHERE page_id=? AND cv_name='SUMMARY_ID'",$currentNumber,$jourId);
//$DB->query("UPDATE adm_pages_content SET cv_text=? WHERE page_id=? AND cv_name='MAIN_JOUR_ID'",$jourId,$jourId);
//$DB->query("UPDATE adm_pages_content SET cv_text=? WHERE page_id=? AND cv_name='AUTHORS_ID'",$authorsIndex,$jourId);
//$DB->query("UPDATE adm_pages_content SET cv_text=? WHERE page_id=? AND cv_name='AUTHORS_YEARS_ID'",$authorsByYear,$jourId);
//$DB->query("UPDATE adm_pages_content SET cv_text=? WHERE page_id=? AND cv_name='AUTHOR_ID'",$articlesByAuthor,$jourId);
//$DB->query("UPDATE adm_pages_content SET cv_text=? WHERE page_id=? AND cv_name='RUBRICS_ID'",$rubricIndex,$jourId);
//$DB->query("UPDATE adm_pages_content SET cv_text=? WHERE page_id=? AND cv_name='RUBRIC_ID'",$rubric,$jourId);
//$DB->query("UPDATE adm_pages_content SET cv_text=? WHERE page_id=? AND cv_name='YEARS_ID'",$articlesByYear,$jourId);