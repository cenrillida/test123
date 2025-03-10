<?php
/*************************
  Coppermine Photo Gallery
  ************************
  Copyright (c) 2003-2014 Coppermine Dev Team
  v1.0 originally written by Gregory Demar

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License version 3
  as published by the Free Software Foundation.

  ********************************************
  Coppermine version: 1.5.28
  $HeadURL: https://svn.code.sf.net/p/coppermine/code/trunk/cpg1.5.x/lang/spanish.php $
  $Revision: 8683 $
**********************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

// info about translators and translated language
$lang_translation_info['lang_name_english'] = 'Spanish';
$lang_translation_info['lang_name_native'] = 'Español';
$lang_translation_info['lang_country_code'] = 'es';
$lang_translation_info['trans_name'] = array('fermunoz', 'Dtc', 'jmatute');
$lang_translation_info['trans_email'] = array('', '', '');
$lang_translation_info['trans_website'] = array('http://forum.coppermine-gallery.net/index.php?action=profile;u=73025', 'http://dtcsrni.co.cc/', 'http://forum.coppermine-gallery.net/index.php?action=profile;u=73633');
$lang_translation_info['trans_date'] = '2010-05-03';
$lang_charset = 'utf-8';
$lang_text_dir = 'ltr'; // ('ltr' for left to right, 'rtl' for right to left)


// shortcuts for Bytes, Kibibytes, Mebibytes, Gibibytes
$lang_byte_units = array('Bytes', 'Kb', 'Mb', 'Gb');
$lang_decimal_separator = array('.', ','); //cpg1.5 // symbol used to separate thousands from hundreds and rounded number from decimal place


// Day of weeks and months
$lang_day_of_week = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'); //Jmatute: Mantén el orden de los campos!
$lang_month = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');



// The various date formats
// See http://www.php.net/manual/en/function.strftime.php to define the variable below
$lang_date['album'] = '%d de %B de %y';
$lang_date['lastcom'] = '%d/%m/%y a las %H:%M';
$lang_date['lastup'] = '%d de %B de %Y';
$lang_date['register'] = '%d de %B de %Y';
$lang_date['lasthit'] = '%d de %B de %Y a las %I:%M %p';
$lang_date['comment'] = '%d de %B de %Y a las %I:%M %p';
$lang_date['log'] = '%B %d, %Y at %I:%M %p';    //jmatute: se mantiene el formato por si hay que enviar a desarrollo
$lang_date['scientific'] = '%Y-%m-%d %H:%M:%S'; //jmatute: se mantiene el formato por si hay que enviar a desarrollo



// For the word censor
$lang_bad_words = array('*joder*', 'pendejo', 'culo', 'culero', 'culera*', 'verga', 'mierda', 'chinga', 'mamada', 'mames*', 'puto', 'puta', 'dego', 'dick*', 'dildo', 'fanculo', 'feces', 'foreskin', 'Fu\(*', 'fuk*', 'honkey', 'hore', 'injun', 'kike', 'lesbo', 'masturbat*', 'motherfucker', 'nigger*', 'nutsack','penis', 'phuck', 'poop', 'pussy', 'scrotum', 'shit', 'slut', 'titties', 'titty', 'twaty', 'wank*', 'whore', 'wop*');

$lang_meta_album_names['random'] = 'Ficheros al azar';
$lang_meta_album_names['lastup'] = 'Últimas subidas';
$lang_meta_album_names['lastalb'] = 'Últimos álbumes actualizados';
$lang_meta_album_names['lastcom'] = 'Últimos comentarios';
$lang_meta_album_names['topn'] = 'Más vistos';
$lang_meta_album_names['toprated'] = 'Más valorados';
$lang_meta_album_names['lasthits'] = 'Últimos archivos vistos';
$lang_meta_album_names['search'] = 'Resultado de la búsqueda de archivos'; //jmatute: pendiente de comprobar
$lang_meta_album_names['album_search'] = 'Resultado de la búsqueda de álbumes';
$lang_meta_album_names['category_search'] = 'Resultado de la búsqueda de categorías';
$lang_meta_album_names['favpics'] = 'Favoritos';
$lang_meta_album_names['datebrowse'] = 'Búsqueda por fecha'; //cpg1.5


$lang_errors['access_denied'] = 'No tienes permiso para acceder a esta página';
$lang_errors['invalid_form_token'] = 'No hay un testigo de formulario (\'form token\') válido - probablemente has tardado demasiado'; //cpg1.5
$lang_errors['perm_denied'] = 'No tienes permiso para realizar esta operación.';
$lang_errors['param_missing'] = 'Llamada al script sin los parámetros requeridos.';
$lang_errors['non_exist_ap'] = '¡El álbum o el fichero no existen!';
$lang_errors['quota_exceeded'] = 'Cuota de disco excedida'; //cpg1.5
$lang_errors['quota_exceeded_details'] = 'Tienes una cuota de disco de [quota]K, tus archivos actualmente ocupan [space]K, y añadiendo este archivo excederías la cuota.'; //cpg1.5
$lang_errors['gd_file_type_err'] = 'Cuando se usa la librería de imagen GD solamente están permitidos los tipos JPEG y PNG.';
$lang_errors['invalid_image'] = 'La imagen que has subido está corrupta o no puede ser tratada por la biblioteca GD';
$lang_errors['resize_failed'] = 'Incapaz de crear miniatura o imagen de tamaño reducido';
$lang_errors['no_img_to_display'] = 'Ningún archivo que enseñar.'; //jmatute: Pendiente de comprobar
$lang_errors['non_exist_cat'] = 'La categoría seleccionada no existe';
$lang_errors['directory_ro'] = 'El directorio \'%s\' no tiene permisos de escritura y no se pueden borrar los archivos.';
$lang_errors['pic_in_invalid_album'] = '¿¡El archivo está en un álbum que no existe (%s)!?';
$lang_errors['banned'] = 'En este momento se te tiene prohibido el uso de este sitio.';
$lang_errors['offline_title'] = 'Desconectad@';
$lang_errors['offline_text'] = 'La galería está temporalmente desactivada, vuelve a comprobar en un rato.';
$lang_errors['ecards_empty'] = 'Actualmente no hay postales que mostrar. O bien se han borrado o bien no has activado "Guardar las postales" en la configuración';
$lang_errors['database_query'] = 'Se produjo un error al procesar una consulta de base de datos';
$lang_errors['non_exist_comment'] = 'El comentario seleccionado no existe';
$lang_errors['captcha_error'] = 'El codigo de confirmación no coincide'; // cpg1.5
$lang_errors['login_needed'] = 'Necesitas estar %sregistrado%s y %svalidado%s para acceder a esta página'; // cpg1.5
$lang_errors['error'] = 'Error'; // cpg1.5
$lang_errors['critical_error'] = 'Error crítico'; // cpg1.5
$lang_errors['access_thumbnail_only'] = 'Sólo se te permite ver miniaturas.'; // cpg1.5
$lang_errors['access_intermediate_only'] = 'No estás autorizado para ver las imágenes de tamaño completo.'; // cpg1.5
$lang_errors['access_none'] = 'No estás autorizado para ver ningún fichero.'; // cpg1.5
$lang_errors['register_globals_title'] = 'Existe la variable register_globals';// cpg1.5 //jmatute: Pendiente de comprobar
$lang_errors['register_globals_warning'] = 'La configuración de PHP register_globals está habilitada en su servidor, que es una mala idea en términos de seguridad. Es muy recomendable que lo deshabilites.'; //cpg1.5
$lang_bbcode_help_title = 'Ayuda de BBCode';
$lang_bbcode_help = 'Los siguientes códigos te pueden ser de utilidad: : <li>[b]Negrita[/b] =&gt; <strong>Negrita</strong></li><li>[i]Itálica[/i] =&gt; <i>Itálica</i></li><li>[url=http://sitioweb.com/]Texto de la Url[/url] =&gt; <a href="http://sitioweb.com">Texto de la Url</a></li><li>[email]usuario@dominio.com[/email] =&gt; <a href="mailto:usuario@dominio.com">usuario@dominio.com</a></li><li>[color=red]Algun texto[/color] =&gt; <span style="color:red">Algun Texto</span></li><li>[img]http://documentation.coppermine-gallery.net/images/browser.png[/img] =&gt; <img src="docs/images/browser.png" border="0" alt="" /></li>';
$lang_common['yes'] = 'Si'; // cpg1.5
$lang_common['no'] = 'No'; // cpg1.5
$lang_common['back'] = 'Atrás'; // cpg1.5
$lang_common['continue'] = 'Continuar'; // cpg1.5
$lang_common['information'] = 'Información'; // cpg1.5
$lang_common['error'] = 'Error'; // cpg1.5
$lang_common['check_uncheck_all'] = 'Marcar/Desmarcar todo'; // cpg1.5
$lang_common['confirm'] = 'Confirmación'; // cpg1.5
$lang_common['captcha_help_title'] = 'Confirmación Visual (captcha)'; // cpg1.5
$lang_common['captcha_help'] = 'Para evitar el spam, tienes que confirmar que eres un humano real y no sólo una secuencia de comandos bot, introduciendo el texto que se muestra. <br /> No distingue mayúsculas/minúsculas'; // cpg1.5
$lang_common['title'] = 'Título'; // cpg1.5
$lang_common['caption'] = 'Leyenda'; // cpg1.5
$lang_common['keywords'] = 'Palabras clave'; // cpg1.5
$lang_common['keywords_insert1'] = 'Palabras clave (separadas por %s)'; // cpg1.5
$lang_common['keywords_insert2'] = 'Elegir desde la lista'; // cpg1.5
$lang_common['keyword_separator'] = 'Separador de palabras clave'; //cpg1.5
$lang_common['keyword_separators'] = array(' '=>'espacio', ','=>'coma', ';'=>'punto y coma'); // cpg1.5
$lang_common['owner_name'] = 'Nombre del Propietario'; // cpg1.5
$lang_common['filename'] = 'Nombre del archivo'; // cpg1.5
$lang_common['filesize'] = 'Tamaño del archivo'; // cpg1.5
$lang_common['album'] = 'Álbum'; // cpg1.5
$lang_common['file'] = 'Archivo'; // cpg1.5
$lang_common['date'] = 'Fecha'; // cpg1.5
$lang_common['help'] = 'Ayuda'; // cpg1.5
$lang_common['close'] = 'Cerrar'; // cpg1.5
$lang_common['go'] = 'Ir'; // cpg1.5
$lang_common['javascript_needed'] = 'Esta página requiere JavaScript para funcionar. Por favor, habilítalo'; // cpg1.5
$lang_common['move_up'] = 'Subir'; // cpg1.5
$lang_common['move_down'] = 'Bajar'; // cpg1.5
$lang_common['move_top'] = 'Mover al principio'; // cpg1.5
$lang_common['move_bottom'] = 'Mover al final'; // cpg1.5
$lang_common['delete'] = 'Borrar'; // cpg1.5
$lang_common['edit'] = 'Editar'; // cpg1.5
$lang_common['username_if_blank'] = 'Desconocido'; // cpg1.5
$lang_common['albums_no_category'] = 'Álbumes sin categoría'; // cpg1.5
$lang_common['personal_albums'] = '* Álbumes personales'; // cpg1.5
$lang_common['select_album'] = 'Álbum seleccionado'; // cpg1.5
$lang_common['ok'] = 'OK'; // cpg1.5
$lang_common['status'] = 'Estado'; // cpg1.5
$lang_common['apply_changes'] = 'Aplicar cambios'; // cpg1.5
$lang_common['done'] = 'Listo'; // cpg1.5
$lang_common['album_properties'] = 'Propiedades del álbum'; // cpg1.5
$lang_common['parent_category'] = 'Categoría padre'; // cpg1.5
$lang_common['edit_files'] = 'Editar archivos'; // cpg1.5
$lang_common['thumbnail_view'] = 'Vista de miniaturas'; // cpg1.5
$lang_common['album_manager'] = 'Administrador de álbumes'; // cpg1.5
$lang_common['more'] = 'Más'; // cpg1.5



// ------------------------------------------------------------------------- //
// File theme.php // Traducida
// ------------------------------------------------------------------------- //
$lang_main_menu['home_title'] = 'Ir a la página principal';
$lang_main_menu['home_lnk'] = 'Principal';
$lang_main_menu['alb_list_title'] = 'Ir a la lista de álbumes';
$lang_main_menu['alb_list_lnk'] = 'Lista de álbumes';
$lang_main_menu['my_gal_title'] = 'Ir a "Mi galería personal"';
$lang_main_menu['my_gal_lnk'] = 'Mi galería';
$lang_main_menu['my_prof_title'] = 'Ir a "Mi perfil personal"';
$lang_main_menu['my_prof_lnk'] = 'Mi perfil';
$lang_main_menu['adm_mode_title'] = 'Mostrar los controles de administración y/o edición.'; // cpg1.5
$lang_main_menu['adm_mode_lnk'] = 'Ver controles de edición y/o admin.'; // cpg1.5
$lang_main_menu['usr_mode_title'] = 'Ocultar controles de administración y/o edición. Similar al \'Modo usuario\' de versiones anteriores'; // cpg1.5 //jmatute: Pendiente de comprobar
$lang_main_menu['usr_mode_lnk'] = 'Ocultar controles de edición y/o admin.'; // cpg1.5 //jmatute: Pendiente de comprobar
$lang_main_menu['upload_pic_title'] = 'Subir un archivo dentro de un álbum'; //jmatute: Pendiente de comprobar
$lang_main_menu['upload_pic_lnk'] = 'Subir archivo';
$lang_main_menu['register_title'] = 'Crear una cuenta de usuario';
$lang_main_menu['register_lnk'] = 'Regístrate';
$lang_main_menu['login_title'] = 'Validarse en el sistema - para usuarios registrados';
$lang_main_menu['login_lnk'] = 'Entrar';
$lang_main_menu['logout_title'] = 'Salir';
$lang_main_menu['logout_lnk'] = 'Salir';
$lang_main_menu['lastup_title'] = 'Mostrar las subidas más recientes';
$lang_main_menu['lastup_lnk'] = 'Últimos archivos';
$lang_main_menu['lastcom_title'] = 'Mostrar los últimos comentarios';
$lang_main_menu['lastcom_lnk'] = 'Últimos comentarios';
$lang_main_menu['topn_title'] = 'Mostrar los archivos más visitados';
$lang_main_menu['topn_lnk'] = 'Más vistos';
$lang_main_menu['toprated_title'] = 'Ver los archivos más valorados/votados';
$lang_main_menu['toprated_lnk'] = 'Más valorados';
$lang_main_menu['search_title'] = 'Buscar una galería'; //jmatute: Pendiente de comprobar
$lang_main_menu['search_lnk'] = 'Buscar';
$lang_main_menu['fav_title'] = 'Ir a mis favoritos';
$lang_main_menu['fav_lnk'] = 'Mis favoritos';
$lang_main_menu['memberlist_title'] = 'Mostrar la lista de usuarios';
$lang_main_menu['memberlist_lnk'] = 'Lista de usuarios';
$lang_main_menu['browse_by_date_lnk'] = 'Por fecha'; // cpg1.5
$lang_main_menu['browse_by_date_title'] = 'Buscar por fecha de subida mediante un calendario'; // cpg1.5
$lang_main_menu['contact_title'] = 'Póngase en contacto con %s'; // cpg1.5
$lang_main_menu['contact_lnk'] = 'Contacto'; // cpg1.5
$lang_main_menu['sidebar_title'] = 'Añadir una barra lateral a tu buscador'; // cpg1.5
$lang_main_menu['sidebar_lnk'] = 'Barra lateral'; // cpg1.5
$lang_gallery_admin_menu['upl_app_title'] = 'Aprobar nuevas subidas de los usuarios';
$lang_gallery_admin_menu['upl_app_lnk'] = 'Aprobar subidas';
$lang_gallery_admin_menu['admin_title'] = 'Ir a la configuración';
$lang_gallery_admin_menu['admin_lnk'] = 'Configurar';
$lang_gallery_admin_menu['albums_title'] = 'Ir a la configuración del álbum';
$lang_gallery_admin_menu['albums_lnk'] = 'Álbumes';
$lang_gallery_admin_menu['categories_title'] = 'Ir a la configuración de categoría';
$lang_gallery_admin_menu['categories_lnk'] = 'Categorías';
$lang_gallery_admin_menu['users_title'] = 'Ir a la configuración de usuario';
$lang_gallery_admin_menu['users_lnk'] = 'Usuarios';
$lang_gallery_admin_menu['groups_title'] = 'Ir a configuración de grupos';
$lang_gallery_admin_menu['groups_lnk'] = 'Grupos';
$lang_gallery_admin_menu['comments_title'] = 'Revisar los últimos comentarios';
$lang_gallery_admin_menu['comments_lnk'] = 'Revisar comentarios';
$lang_gallery_admin_menu['searchnew_title'] = 'Añadir ficheros por lotes (Batch)';
$lang_gallery_admin_menu['searchnew_lnk'] = 'Añadir ficheros (Batch)';
$lang_gallery_admin_menu['util_title'] = 'Ir a las herramientas administrativas';
$lang_gallery_admin_menu['util_lnk'] = 'Herramientas Administrativas';
$lang_gallery_admin_menu['key_lnk'] = 'Diccionario de palabras clave';
$lang_gallery_admin_menu['ban_title'] = 'Ir a los usuarios expulsados';
$lang_gallery_admin_menu['ban_lnk'] = 'Usuarios expulsados';
$lang_gallery_admin_menu['db_ecard_title'] = 'Revisar postales';
$lang_gallery_admin_menu['db_ecard_lnk'] = 'Mostrar postales';
$lang_gallery_admin_menu['pictures_title'] = 'Ordenar mis archivos';
$lang_gallery_admin_menu['pictures_lnk'] = 'Ordenar mis archivos';
$lang_gallery_admin_menu['documentation_lnk'] = 'Documentación';
$lang_gallery_admin_menu['documentation_title'] = 'Manual de Coppermine';
$lang_gallery_admin_menu['phpinfo_lnk'] = 'phpinfo'; // cpg1.5
$lang_gallery_admin_menu['phpinfo_title'] = 'Contiene información técnica sobre su servidor. Se te puede pedir que proporciones esta información cuando solicite ayuda en los foros de soporte.'; // cpg1.5
$lang_gallery_admin_menu['update_database_lnk'] = 'Actualizar base de datos'; // cpg1.5
$lang_gallery_admin_menu['update_database_title'] = 'Si has reemplazado los archivos de Coppermine, agregado una modificación o actualización desde una versión anterior de Coppermine, asegúrate de ejecutar la actualización la base de datos una vez. Esto creará las tablas necesarias y/o valores de configuración en la base de datos de Coppermine.'; // cpg1.5
$lang_gallery_admin_menu['view_log_files_lnk'] = 'Ver archivos de registro (log)'; // cpg1.5
$lang_gallery_admin_menu['view_log_files_title'] = 'Coppermine puede realizar un seguimiento de diversas acciones que realizan los usuarios. Puedes verlo si has habilitado el registro en la configuración de Coppermine.'; // cpg1.5
$lang_gallery_admin_menu['check_versions_lnk'] = 'Verificar versión'; // cpg1.5
$lang_gallery_admin_menu['check_versions_title'] = 'Revisa el archivo de versión y verifica si ha remplazado todos los archivos después de hacer la actualización, o si los archivos fuente de Coppermine han sido actualizados después de la aparición de un paquete.'; // cpg1.5
$lang_gallery_admin_menu['bridgemgr_lnk'] = 'Administrador de enlaces (bridges)'; // cpg1.5
$lang_gallery_admin_menu['bridgemgr_title'] = 'Habilitar / deshabilitar la integración (enlace) de Coppermine con otra aplicación (por ejemplo, su BBS).'; // cpg1.5
$lang_gallery_admin_menu['pluginmgr_lnk'] = 'Administrador de plugins'; // cpg1.5
$lang_gallery_admin_menu['pluginmgr_title'] = 'Administrador de plugins'; // cpg1.5
$lang_gallery_admin_menu['overall_stats_lnk'] = 'Estadísticas totales'; // cpg1.5
$lang_gallery_admin_menu['overall_stats_title'] = 'Ver estadísticas generales por navegador y sistema operativo de los visitantes (si las opciones correspondientes se activan en la configuración).'; // cpg1.5
$lang_gallery_admin_menu['keywordmgr_lnk'] = 'Administrador de palabras clave'; // cpg1.5
$lang_gallery_admin_menu['keywordmgr_title'] = 'Administrar las palabras clave (si la opción correspondiente está activada en la configuración).'; // cpg1.5
$lang_gallery_admin_menu['exifmgr_lnk'] = 'Administrador de datos EXIF'; // cpg1.5
$lang_gallery_admin_menu['exifmgr_title'] = 'Administrar los datos EXIF (si está habilitada la configuración correspondiente).'; // cpg1.5
$lang_gallery_admin_menu['shownews_lnk'] = 'Mostrar novedades'; // cpg1.5
$lang_gallery_admin_menu['shownews_title'] = 'Mostrar las novedades desde coppermine-gallery.net'; // cpg1.5
$lang_user_admin_menu['albmgr_title'] = 'Crear y ordenar mis álbumes';
$lang_user_admin_menu['albmgr_lnk'] = 'Crear/ordenar álbumes';
$lang_user_admin_menu['modifyalb_title'] = 'Editar los álbumes ya creados';
$lang_user_admin_menu['modifyalb_lnk'] = 'Modificar álbumes';
$lang_user_admin_menu['my_prof_title'] = 'Editar tu perfil personal';
$lang_user_admin_menu['my_prof_lnk'] = 'Mi perfil';
$lang_cat_list['category'] = 'Categoría';
$lang_cat_list['albums'] = 'Álbumes';
$lang_cat_list['pictures'] = 'Archivos';
$lang_album_list['album_on_page'] = '%d álbumes en %d página(s)';
$lang_thumb_view['date'] = 'Fecha';

//Sort by filename and title
$lang_thumb_view['name'] = 'Nombre del archivo';
$lang_thumb_view['sort_da'] = 'Ordenar por fecha ascendente';
$lang_thumb_view['sort_dd'] = 'Ordenar por fecha descendente';
$lang_thumb_view['sort_na'] = 'Ordenar por nombre ascendente';
$lang_thumb_view['sort_nd'] = 'Ordenar por nombre descendente';
$lang_thumb_view['sort_ta'] = 'Ordenar por título ascendente';
$lang_thumb_view['sort_td'] = 'Ordenar por título descendente';
$lang_thumb_view['position'] = 'Posición';
$lang_thumb_view['sort_pa'] = 'Ordenar por posición ascendente';
$lang_thumb_view['sort_pd'] = 'Ordenar por posición descendente';
$lang_thumb_view['download_zip'] = 'Descargar como archivo ZIP';
$lang_thumb_view['pic_on_page'] = '%d archivos en %d página(s)';
$lang_thumb_view['user_on_page'] = '%d usuarios en %d página(s)';
$lang_thumb_view['enter_alb_pass'] = 'Introduce la contraseña del álbum';
$lang_thumb_view['invalid_pass'] = 'Contraseña no válida';
$lang_thumb_view['pass'] = 'Contraseña';
$lang_thumb_view['submit'] = 'Enviar';
$lang_thumb_view['zipdownload_copyright'] = 'Por favor, respeta los derechos de autor - utiliza sólo los archivos que hayas descargado en la forma prevista por el propietario de la galería'; // cpg1.5
$lang_thumb_view['zipdownload_username'] = 'Este archivo ZIP contiene, comprimidos, los archivos favoritos de %s'; // cpg1.5
$lang_img_nav_bar['thumb_title'] = 'Regresar a la vista de miniaturas';
$lang_img_nav_bar['pic_info_title'] = 'Mostrar/Ocultar información del archivo';
$lang_img_nav_bar['slideshow_title'] = 'Presentación de diapositivas';
$lang_img_nav_bar['ecard_title'] = 'Enviar este archivo como una postal';
$lang_img_nav_bar['ecard_disabled'] = 'Las postales estan deshabilitadas';
$lang_img_nav_bar['ecard_disabled_msg'] = 'No tienes permiso para enviar postales'; // js-alert
$lang_img_nav_bar['prev_title'] = 'Ver el archivo anterior';
$lang_img_nav_bar['next_title'] = 'Ver el archivo siguiente';
$lang_img_nav_bar['pic_pos'] = 'Archivo %s/%s';
$lang_img_nav_bar['report_title'] = 'Reportar este archivo al administrador';
$lang_img_nav_bar['go_album_end'] = 'Saltar al final';
$lang_img_nav_bar['go_album_start'] = 'Regresar al inicio';
$lang_rate_pic['rate_this_pic'] = 'Vota este archivo';
$lang_rate_pic['no_votes'] = '(No hay votos aún)';
$lang_rate_pic['rating'] = '(Votación actual : %s / %s con %s votos)';
$lang_rate_pic['rubbish'] = 'Basura';
$lang_rate_pic['poor'] = 'Pobre';
$lang_rate_pic['fair'] = 'Razonable';
$lang_rate_pic['good'] = 'Está bien';
$lang_rate_pic['excellent'] = 'Excelente';
$lang_rate_pic['great'] = 'Genial';
$lang_rate_pic['js_warning'] = 'Tienes que habilitar Javascript para poder votar'; // cpg1.5
$lang_rate_pic['already_voted'] = 'Ya has votado este archivo.'; // cpg1.5
$lang_rate_pic['forbidden'] = 'No puedes votar tus propios archivos'; // cpg1.5
$lang_rate_pic['rollover_to_rate'] = 'Mueve el cursor sobre la imagen de las estrellas para votar'; // cpg1.5

// ------------------------------------------------------------------------- //
// File include/functions.inc.php // Traducida
// ------------------------------------------------------------------------- //
$lang_cpg_die['file'] = 'Fichero: ';
$lang_cpg_die['line'] = 'Linea: ';
$lang_display_thumbnails['dimensions'] = 'Dimensiones=';
$lang_display_thumbnails['date_added'] = 'Fecha añadida=';
$lang_get_pic_data['n_comments'] = '%s commentarios';
$lang_get_pic_data['n_views'] = 'vista %s veces';
$lang_get_pic_data['n_votes'] = '(%s votos)';
$lang_cpg_debug_output['debug_info'] = 'Información para depuración';
$lang_cpg_debug_output['debug_output'] = 'Salida de la depuración'; // cpg1.5
$lang_cpg_debug_output['select_all'] = 'Seleccionar todo';
$lang_cpg_debug_output['copy_and_paste_instructions'] = 'Si vas a solicitar ayuda en el foro de Coppermine, copia y pega esta salida de depuración en tu entrada cuando se te solicite, junto con el mensaje de error que recibes (si existe). ¡Añade esta información sólo si te lo piden! Asegúrate de reemplazar las contraseñas de la consulta con *** antes de publicar.'; // cpg1.5
$lang_cpg_debug_output['debug_output_explain'] = 'Nota: Esto es a título informativo y no significa que hay un error en la galería.'; // cpg1.5
$lang_cpg_debug_output['phpinfo'] = 'Mostrar phpinfo';
$lang_cpg_debug_output['notices'] = 'Noticias';
$lang_cpg_debug_output['notices_help_admin'] = 'Las notas aparecen en esta página porque tú (como administrador de la galería) lo permitiste deliberadamente en la configuración de Coppermine. Eso no significa necesariamente que algo está mal con la galería. De hecho, sólo los desarrolladores cualificados deberían activar esta opción para hacer un seguimiento de errores. Si te molestan estos avisos y/o que no tienes idea de lo que quieren decir, quita la opción de depuración en la configuración de Coppermine.'; // cpg1.5
$lang_cpg_debug_output['notices_help_non_admin'] = 'Las notas han sido habilitadas por el administrador adrede. Eso no significa necesariamente que algo está mal por tu parte. Puedes ignorar estas notas.'; // cpg1.5
$lang_cpg_debug_output['show_hide'] = 'mostrar/ocultar'; // cpg1.5
$lang_language_selection['reset_language'] = 'Idioma por defecto';
$lang_language_selection['choose_language'] = 'Elige idioma';
$lang_theme_selection['reset_theme'] = 'Tema por defecto';
$lang_theme_selection['choose_theme'] = 'Elige un tema';
$lang_version_alert['version_alert'] = '¡Versión no soportada!';
$lang_version_alert['no_stable_version'] = 'Estás ejecutando %s (%s), preparada sólo para usuarios muy experimentados - no tiene soporte, y no se garantiza el funcionamiento. ¡Úsala bajo tu responsabilidad, o baja de versión a la última estable si necesitas soporte!';
$lang_version_alert['gallery_offline'] = 'La galería está actualmente desactivada, y solo será visible para tí como administrador. No olvides activarla de nuevo después de terminar el mantenimiento.';
$lang_version_alert['coppermine_news'] = 'Noticias de coppermine-gallery.net'; // cpg1.5
$lang_version_alert['no_iframe'] = 'Tu navegador no puede mostrar frames (marcos)'; // cpg1.5
$lang_version_alert['hide'] = 'Ocultar'; // cpg1.5
$lang_create_tabs['previous'] = 'Previos'; // cpg1.5
$lang_create_tabs['next'] = 'Siguiente'; // cpg1.5
$lang_create_tabs['jump_to_page'] = 'Saltar a la página'; // cpg1.5
$lang_get_remote_file_by_url['no_data_returned'] = 'No hay datos con %s'; // cpg1.5
$lang_get_remote_file_by_url['curl'] = 'CURL'; // cpg1.5
$lang_get_remote_file_by_url['fsockopen'] = 'Coneccion Socket (FSOCKOPEN)'; // cpg1.5
$lang_get_remote_file_by_url['fopen'] = 'fopen'; // cpg1.5
$lang_get_remote_file_by_url['curl_not_available'] = 'Curl no esta disponible en tu servidor'; // cpg1.5
$lang_get_remote_file_by_url['error_number'] = 'Número de error: %s'; // cpg1.5
$lang_get_remote_file_by_url['error_message'] = 'Mensaje de Error: %s'; // cpg1.5



// ------------------------------------------------------------------------- //
// File include/mailer.inc.php // Traducida
// ------------------------------------------------------------------------- //
$lang_mailer['provide_address'] = 'Debes escribir al menos una ';
$lang_mailer['mailer_not_supported'] = ' programa de correo no soportado';
$lang_mailer['execute'] = 'No se puede ejecutar: ';
$lang_mailer['instantiate'] = 'No se puede iniciar la funcion de correo';
$lang_mailer['authenticate'] = 'SMTP Error: No se puede autentificar';
$lang_mailer['from_failed'] = 'Fallaron estas direcciones de remitente: ';
$lang_mailer['recipients_failed'] = 'SMTP Error: Los siguientes ';
$lang_mailer['data_not_accepted'] = 'SMTP Error: Datos no aceptados.';
$lang_mailer['connect_host'] = 'SMTP Error: No se puede conectar con el servidor.';
$lang_mailer['file_access'] = 'No se puede acceder al archivo: ';
$lang_mailer['file_open'] = 'Error de archivo: No se pudo abrir el archivo: ';
$lang_mailer['encoding'] = 'Codificacion desconocida: ';
$lang_mailer['signing'] = 'Firma de error: ';



// ------------------------------------------------------------------------- //
// File include/plugin_api.inc.php // Traducida
// ------------------------------------------------------------------------- //
$lang_plugin_api['error_install'] = 'No se pudo instalar el plugin \'%s\'';
$lang_plugin_api['error_uninstall'] = 'No se pudo desinstalar el plugin \'%s\'';
$lang_plugin_api['error_sleep'] = 'No se pudo deshabilitar el plugin \'%s\''; // cpg1.5



// ------------------------------------------------------------------------- //
// File include/smilies.inc.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('SMILIES_PHP')) {
$lang_smilies_inc_php['Exclamation'] = 'Exclamación';
$lang_smilies_inc_php['Question'] = 'Pregunta';
$lang_smilies_inc_php['Very Happy'] = 'Muy feliz';
$lang_smilies_inc_php['Smile'] = 'Sonrisa';
$lang_smilies_inc_php['Sad'] = 'Triste';
$lang_smilies_inc_php['Surprised'] = 'Sorprendido';
$lang_smilies_inc_php['Shocked'] = 'En shock';
$lang_smilies_inc_php['Confused'] = 'Confundido';
$lang_smilies_inc_php['Cool'] = 'Sensacional!';
$lang_smilies_inc_php['Laughing'] = 'Riendo';
$lang_smilies_inc_php['Mad'] = 'Loco';
$lang_smilies_inc_php['Razz'] = 'Razz';
$lang_smilies_inc_php['Embarrassed'] = 'Avergonzado'; // cpg1.5
$lang_smilies_inc_php['Crying or Very sad'] = 'Llorando o muy triste';
$lang_smilies_inc_php['Evil or Very Mad'] = 'Malo o muy enojado';
$lang_smilies_inc_php['Twisted Evil'] = 'Retorcido';
$lang_smilies_inc_php['Rolling Eyes'] = 'Ojos locos';
$lang_smilies_inc_php['Wink'] = 'Cerrar el ojo';
$lang_smilies_inc_php['Idea'] = 'Idea';
$lang_smilies_inc_php['Arrow'] = 'Flecha';
$lang_smilies_inc_php['Neutral'] = 'Neutral';
$lang_smilies_inc_php['Mr. Green'] = 'Sr. Verde';
};



// ------------------------------------------------------------------------- //
// File albmgr.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('ALBMGR_PHP')) {
$lang_albmgr_php['title'] = 'Administrador de álbum'; // cpg1.5
$lang_albmgr_php['alb_need_name'] = 'Los álbumes necesitan tener un nombre!'; // js-alert
$lang_albmgr_php['confirm_modifs'] = '¿Estas seguro de querer hacer esas modificaciones?'; // js-alert
$lang_albmgr_php['no_change'] = '¡No has hecho ningun cambio!'; // js-alert
$lang_albmgr_php['new_album'] = 'Nuevo álbum';
$lang_albmgr_php['delete_album'] = 'Borrar álbum'; // cpg1.5
$lang_albmgr_php['confirm_delete1'] = '¿Estas seguro de querer borrar este álbum?'; // js-alert
$lang_albmgr_php['confirm_delete2'] = 'Todos los archivos y comentarios que contiene se perderán!'; // js-alert
$lang_albmgr_php['select_first'] = 'Selecciona un álbum primero'; // js-alert
$lang_albmgr_php['my_gallery'] = '* Mi galería *';
$lang_albmgr_php['no_category'] = '* Sin categoría *';
$lang_albmgr_php['select_category'] = 'Seleccionar categoría';
$lang_albmgr_php['category_change'] = 'Si cambias la categoría, tus cambios se perderán!'; // cpg1.5
$lang_albmgr_php['page_change'] = 'Si sigues este enlace, tus cambios se perderán!'; // cpg1.5
$lang_albmgr_php['cancel'] = 'Cancelar'; // cpg1.5
$lang_albmgr_php['submit_reminder'] = 'Los cambios no se guardan hasta que pulses &quot;Aplicar Cambios&quot;.'; // cpg1.5
}


// ------------------------------------------------------------------------- //
// File banning.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('BANNING_PHP')) {
$lang_banning_php['title'] = 'Usuarios expulsados';
$lang_banning_php['user_name'] = 'Nombre de usuario';
$lang_banning_php['user_account'] = 'Cuenta de usuario';
$lang_banning_php['email_address'] = 'Dirección de correo'; // cpg1.5
$lang_banning_php['ip_address'] = 'Dirección IP';
$lang_banning_php['expires'] = 'Expira'; // cpg1.5
$lang_banning_php['expiry_date'] = 'Fecha de expiración'; // cpg1.5
$lang_banning_php['expired'] = 'Expirada'; // cpg1.5
$lang_banning_php['edit_ban'] = 'Guardar cambios';
$lang_banning_php['add_new'] = 'Añadir nuevo';
$lang_banning_php['add_ban'] = 'Añade';
$lang_banning_php['error_user'] = 'No se pudo encontrar al usuario';
$lang_banning_php['error_specify'] = 'Debes especificar un usuario o una dirección IP';
$lang_banning_php['error_ban_id'] = '¡Identificador de expulsión inválido!';
$lang_banning_php['error_admin_ban'] = 'No te puedes expulsar a tí mismo';
$lang_banning_php['error_server_ban'] = '¿Vas a expulsar a tu propio seridor? no, no, no... ¡no lo puedes hacer!';
$lang_banning_php['skipping'] = 'Saltándose esa orden'; // cpg1.5
$lang_banning_php['lookup_ip'] = 'Buscando dirección IP';
$lang_banning_php['select_date'] = 'Selecciona fecha';
$lang_banning_php['delete_comments'] = 'Borrar comentarios'; // cpg1.5
$lang_banning_php['current'] = 'actual'; // cpg1.5
$lang_banning_php['all'] = 'todos'; // cpg1.5
$lang_banning_php['none'] = 'ninguno'; // cpg1.5
$lang_banning_php['view'] = 'ver'; // cpg1.5
$lang_banning_php['ban_id'] = 'Identificador de expulsión'; // cpg1.5
$lang_banning_php['existing_bans'] = 'Expulsiones existentes'; // cpg1.5
$lang_banning_php['no_banning_when_bridged'] = 'Estás usando tu galería integrada en otra aplicación. Usa el mecanismo de expulsión de esa aplicación en lugar del integrado en Coppermine. Los mecanismos de Coppermine no se aplican correctamente si está integrado.'; // cpg1.5
$lang_banning_php['records_on_page'] = '%d registros en %d página(s)'; // cpg1.5
$lang_banning_php['ascending'] = 'ascendente'; // cpg1.5
$lang_banning_php['descending'] = 'descendente'; // cpg1.5
$lang_banning_php['sort_by'] = 'Ordenar por'; // cpg1.5
$lang_banning_php['sorted_by'] = 'ordenado por'; // cpg1.5
$lang_banning_php['ban_record_x_updated'] = 'El registro de expulsión %s ha sido actualizado'; // cpg1.5
$lang_banning_php['ban_record_x_deleted'] = 'El registro de expulsión %s ha sido borrado'; // cpg1.5
$lang_banning_php['new_ban_record_created'] = 'Creado un nuevo registro de expulsión'; // cpg1.5
$lang_banning_php['ban_record_x_already_exists'] = 'El registro de expulsión %s ya existe'; // cpg1.5
$lang_banning_php['comment_deleted'] = '%s comentario hecho por %s ha sido borrado(s)'; // cpg1.5
$lang_banning_php['comments_deleted'] = '%s cometarios hechos por %s han sido borrados'; // cpg1.5
$lang_banning_php['email_field_invalid'] = 'Introduce una direccion de correo válida'; // cpg1.5
$lang_banning_php['ip_address_field_invalid'] = 'Introduce una direccion IP válida (x.x.x.x)'; // cpg1.5
$lang_banning_php['expiry_field_invalid'] = 'Introduce una fecha de expiración válida (YYYY-MM-DD)'; // cpg1.5
$lang_banning_php['form_not_submit'] = 'No se ha enviado el formulario - debes corregir los errores antes'; // cpg1.5
};

// ------------------------------------------------------------------------- //
// File bridgemgr.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('BRIDGEMGR_PHP')) {
$lang_bridgemgr_php['title'] = 'Asistente de Enlaces';
$lang_bridgemgr_php['back'] = 'retroceder';
$lang_bridgemgr_php['next'] = 'siguiente';
$lang_bridgemgr_php['start_wizard'] = 'Iniciando del asistente de enlaces';
$lang_bridgemgr_php['finish'] = 'Terminar';
$lang_bridgemgr_php['no_action_needed'] = 'No se requieren acciones en este paso. Solo presione \'siguiente\' para continuar.';
$lang_bridgemgr_php['reset_to_default'] = 'Restaurar predeterminados';
$lang_bridgemgr_php['choose_bbs_app'] = 'escoja la aplicación para enlazar con Coppermine';
$lang_bridgemgr_php['support_url'] = 'Ir aquí para soporte sobre esta aplicación';
$lang_bridgemgr_php['settings_path'] = 'ruta(s) usadas por su aplicación';
$lang_bridgemgr_php['full_forum_url'] = 'URL de la aplicación enlazada';
$lang_bridgemgr_php['relative_path_of_forum_from_webroot'] = 'Ruta absoluta de la aplicación enlazada';
$lang_bridgemgr_php['relative_path_to_config_file'] = 'Ruta relativa del fichero de configuración de la aplicación enlazada';
$lang_bridgemgr_php['cookie_prefix'] = 'Prefijo de la cookie';
$lang_bridgemgr_php['special_settings'] = 'configuraciones específicas de la aplicación';
$lang_bridgemgr_php['use_post_based_groups'] = '¿Usar los grupos personalizados en la aplicación?';
$lang_bridgemgr_php['use_post_based_groups_yes'] = 'si';
$lang_bridgemgr_php['use_post_based_groups_no'] = 'no';
$lang_bridgemgr_php['error_title'] = 'Tienes que corregir estos errores para continuar. Vuelve a la pantalla anterior.';
$lang_bridgemgr_php['error_specify_bbs'] = 'Tienes que especificar la aplicación con la que quieres enlazar.';
$lang_bridgemgr_php['finalize'] = 'activar/desactivar el enlace';
$lang_bridgemgr_php['finalize_explanation'] = 'Tu configuración se ha guardado en la base de datos, pero no se ha activado el enlace. Puedes activarlo/desactivarlo en cualquier momento. Asegúrate de recordar el usuario y contraseña administrador de tu instalación Coppermine, porque podrías necesitarlo para hacer modificaciones. Si algo no funcionara ve a %s y desactiva los enlaces, mediante tu usuario administrador no relacionado con los enlaces (normalmente, el que configuraste en la instalación de Coppermine).';
$lang_bridgemgr_php['your_bridge_settings'] = 'Tu configuración de enlaces';
$lang_bridgemgr_php['title_enable'] = 'Activar enlace/integración con %s';
$lang_bridgemgr_php['bridge_enable_yes'] = 'activar';
$lang_bridgemgr_php['bridge_enable_no'] = 'desactivar';
$lang_bridgemgr_php['error_must_not_be_empty'] = 'no puede quedar vacío';
$lang_bridgemgr_php['error_either_be'] = 'debe ser %s o %s';
$lang_bridgemgr_php['error_folder_not_exist'] = '%s no existe. Corrige el valor para %s';
$lang_bridgemgr_php['error_cookie_not_readible'] = 'Coppermine no puede leer una cookie de nombre %s. Corrige el valor de %s, o ve al panel de administración de la aplicación enlazada y asegúrate que la ruta a la cookie es accesible por Coppermine.';
$lang_bridgemgr_php['error_mandatory_field_empty'] = 'el campo %s no puede quedar vacío - pon el valor apropiado.';
$lang_bridgemgr_php['error_no_trailing_slash'] = 'No puede haber una barra \'\\\' al final del campo %s.';
$lang_bridgemgr_php['error_trailing_slash'] = 'Debe haber una barra \'\\\' al final del campo %s.';
$lang_bridgemgr_php['error_prefix_and_table'] = '%s y ';
$lang_bridgemgr_php['recovery_title'] = 'Gestor de enlaces: recuperación de emergencia';
$lang_bridgemgr_php['recovery_explanation'] = 'Si quieres administrar los enlaces (bridges) de tu galería Coppermine debes acceder como administrador. Si no puedes acceder porque los enlaces no funcionan correctamente puedes desactivarlos en esta página. Introducir el nombre y contraseña no te dará acceso, pero desactivará los enlaces. Puedes buscar en la documentación si quieres más detalles.';
$lang_bridgemgr_php['username'] = 'Usuario';
$lang_bridgemgr_php['password'] = 'Contraseña';
$lang_bridgemgr_php['disable_submit'] = 'enviar';
$lang_bridgemgr_php['recovery_success_title'] = 'Autorización correcta';
$lang_bridgemgr_php['recovery_success_content'] = 'Se ha desactivado con éxito el enlace de Coppermine con otras aplicaciones. Esta instalación de Coppermine funciona ahora en modo no integrado (standalone).';
$lang_bridgemgr_php['recovery_success_advice_login'] = 'Accede como administrador para editar la configuración y/o activar la integración de nuevo.';
$lang_bridgemgr_php['goto_login'] = 'Ir a la página de acceso';
$lang_bridgemgr_php['goto_bridgemgr'] = 'Ir al gestor de enlaces';
$lang_bridgemgr_php['recovery_failure_title'] = 'Error en la autorización';
$lang_bridgemgr_php['recovery_failure_content'] = 'Error en las credenciales. Tienes que acceder como usuario administrador no relacionado con los enlaces (normalmente, el que configuraste en la instalación de Coppermine)';
$lang_bridgemgr_php['try_again'] = 'probar de nuevo';
$lang_bridgemgr_php['recovery_wait_title'] = 'El tiempo de espera no ha pasado';
$lang_bridgemgr_php['recovery_wait_content'] = 'Por razonde de seguridad no se permiten intentos fallidos muy seguidos (evitar ataques de fuerza bruta), de modo que tendrás que esperar un poco antes de volver a intentarlo.';
$lang_bridgemgr_php['wait'] = 'espera';
$lang_bridgemgr_php['browse'] = 'navega';
}

// ------------------------------------------------------------------------- //
// File calendar.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('CALENDAR_PHP')) {
$lang_calendar_php['title'] = 'Calendario';
$lang_calendar_php['clear_date'] = 'borrar fecha';
$lang_calendar_php['files'] = 'ficheros'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File catmgr.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('CATMGR_PHP')) {
$lang_catmgr_php['miss_param'] = '¡Faltan parametros necesarios para la operación \'%s\'!';
$lang_catmgr_php['unknown_cat'] = 'La categoría seleccionada no existe en la base de datos';
$lang_catmgr_php['usergal_cat_ro'] = '¡No se pueden borrar las galerías de usuarios!';
$lang_catmgr_php['manage_cat'] = 'Administrar categorías';
$lang_catmgr_php['confirm_delete'] = '¿Seguro que quieres BORRRAR esta categoría?'; // js-alert
$lang_catmgr_php['category'] = 'Categorías'; // cpg1.5
$lang_catmgr_php['operations'] = 'Operaciones';
$lang_catmgr_php['move_into'] = 'Pasar a';
$lang_catmgr_php['update_create'] = 'Actualizar/Crear categoría';
$lang_catmgr_php['parent_cat'] = 'categoría principal';
$lang_catmgr_php['cat_title'] = 'Titulo de la Categoría';
$lang_catmgr_php['cat_thumb'] = 'Miniatura de la categoría';
$lang_catmgr_php['cat_desc'] = 'Descripcion de la categoría';
$lang_catmgr_php['categories_alpha_sort'] = 'Ordenar categorías alfabeticamente (en lugar del orden personalizado)';
$lang_catmgr_php['save_cfg'] = 'Guardar configuración';
$lang_catmgr_php['no_category'] = '* Sin categoría *'; // cpg1.5
$lang_catmgr_php['group_create_alb'] = 'En esta categoría se permite crear álbumes a los grupos'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File contact.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('CONTACT_PHP')) {
$lang_contact_php['title'] = 'Contacto'; // cpg1.5
$lang_contact_php['your_name'] = 'Tu nombre'; // cpg1.5
$lang_contact_php['your_email'] = 'Tu correo'; // cpg1.5
$lang_contact_php['subject'] = 'Asunto'; // cpg1.5
$lang_contact_php['your_message'] = 'Tu mensaje'; // cpg1.5
$lang_contact_php['name_field_mandatory'] = 'Por favor, introduce tu nombre'; // cpg1.5 // js-alert
$lang_contact_php['name_field_invalid'] = 'Por favor, introduce un nombre válido'; // cpg1.5 // js-alert
$lang_contact_php['email_field_mandatory'] = 'Por favor, introduce tu correo'; // cpg1.5 // js-alert
$lang_contact_php['email_field_invalid'] = 'Por favor, introduce un correo válido'; // cpg1.5 // js-alert
$lang_contact_php['subject_field_mandatory'] = 'Por favor introduce un asunto significativo (más detallado)'; // cpg1.5 // js-alert
$lang_contact_php['message_field_mandatory'] = 'Por favor, introduce tu mensaje'; // cpg1.5 // js-alert
$lang_contact_php['confirmation'] = 'Confirmación'; // cpg1.5
$lang_contact_php['email_headline'] = 'Este correo electrónico fue enviado a %s utilizando el formulario de contacto en %s desde la dirección IP %s'; // cpg1.5
$lang_contact_php['registered_user'] = 'Usuario registrado'; // cpg1.5
$lang_contact_php['guest'] = 'Anónimo'; // cpg1.5
$lang_contact_php['unknown'] = 'Desconocido'; // cpg1.5
$lang_contact_php['user_info'] = 'El %s llamado %s con la direccion de correo %s dijo:'; // cpg1.5
$lang_contact_php['failed_sending_email'] = 'Fallo al enviar el correo. Por favor, inténtalo de nuevo'; // cpg1.5
$lang_contact_php['email_sent'] = 'Se ha enviado tu correo.'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File admin.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('ADMIN_PHP')) {
$lang_admin_php['title'] = 'Configuración de galería';
$lang_admin_php['general_settings'] = 'Configuración general'; // cpg1.5
$lang_admin_php['language_charset_settings'] = 'Idioma y conjunto de caracteres'; // cpg1.5
$lang_admin_php['themes_settings'] = 'Temas (aspecto)'; // cpg1.5
$lang_admin_php['album_list_view'] = 'Lista de álbumes'; // cpg1.5
$lang_admin_php['thumbnail_view'] = 'Vista de miniaturas'; // cpg1.5
$lang_admin_php['image_view'] = 'Vista de imágenes'; // cpg1.5
$lang_admin_php['comment_settings'] = 'Comentarios'; // cpg1.5
$lang_admin_php['thumbnail_settings'] = 'Miniaturas'; // cpg1.5
$lang_admin_php['file_settings'] = 'Archivos'; // cpg1.5
$lang_admin_php['image_watermarking'] = 'Marcas de agua'; // cpg1.5
$lang_admin_php['registration'] = 'Registro de usuarios'; // cpg1.5
$lang_admin_php['user_settings'] = 'Usuarios'; // cpg1.5
$lang_admin_php['custom_fields_user_profile'] = 'Campos personalizados para perfiles de usuarios (déjalo en blanco si no se usa). Utilice el Perfil 6 para entradas largas, como biografías '; // cpg1.5
$lang_admin_php['custom_fields_image_description'] = 'Campos extra para descripción de imágenes (déjalo en blanco si no se usan) '; // cpg1.5
$lang_admin_php['cookie_settings'] = 'Cookies'; // cpg1.5
$lang_admin_php['email_settings'] = 'Correo (normalmente no requiere cambios, deja los campos en blanco si no esta seguro) '; // cpg1.5
$lang_admin_php['logging_stats'] = 'Registro de sucesos (Log) y estadísticas '; // cpg1.5
$lang_admin_php['maintenance_settings'] = 'Mantenimiento'; // cpg1.5
$lang_admin_php['manage_exif'] = 'Gestión de datos EXIF';
$lang_admin_php['manage_plugins'] = 'Gestión de plugins';
$lang_admin_php['manage_keyword'] = 'Gestión de palabras clave';
$lang_admin_php['restore_cfg'] = 'Restaurar valores de fábrica';
$lang_admin_php['restore_cfg_confirm'] = '¿Realmente quieres volver a los valores de fábrica para todos los parámetros? ¡No se puede deshacer!'; // cpg1.5 // js-alert
$lang_admin_php['save_cfg'] = 'Guardar la nueva configuración';
$lang_admin_php['notes'] = 'Notas';
$lang_admin_php['info'] = 'Información';
$lang_admin_php['upd_success'] = 'La configuración de Coppermine se ha actualizado';
$lang_admin_php['restore_success'] = 'Se ha restaurado la configuración Coppermine a los valores por defecto';
$lang_admin_php['name_a'] = 'Nombre ascendente';
$lang_admin_php['name_d'] = 'Nombre descendente';
$lang_admin_php['title_a'] = 'Título ascendente';
$lang_admin_php['title_d'] = 'Título descendente';
$lang_admin_php['date_a'] = 'Fecha ascendente';
$lang_admin_php['date_d'] = 'Fecha descendente';
$lang_admin_php['pos_a'] = 'Posición ascendente';
$lang_admin_php['pos_d'] = 'Posición descendente';
$lang_admin_php['th_any'] = 'Lado máximo';
$lang_admin_php['th_ht'] = 'Alto';
$lang_admin_php['th_wd'] = 'Ancho';
$lang_admin_php['th_ex'] = 'Exacto'; // cpg1.5
$lang_admin_php['debug_everyone'] = 'todos';
$lang_admin_php['debug_admin'] = 'sólo administrador';
$lang_admin_php['no_logs'] = 'Desactivado';
$lang_admin_php['log_normal'] = 'Normal';
$lang_admin_php['log_all'] = 'Todo';
$lang_admin_php['view_logs'] = 'Ver logs';
$lang_admin_php['click_expand'] = 'pulsa en el nombre de la sección para expandirla';
$lang_admin_php['click_collapse'] = 'pulsa en el nombre de la sección para contraerla'; // cpg1.5
$lang_admin_php['expand_all'] = 'Expandir todo ';
$lang_admin_php['toggle_all'] = 'Cambiar todo'; // cpg1.5
$lang_admin_php['notice1'] = '(*) Estos valores no deben ser cambiados si ya existen archivos en la base de datos.';
$lang_admin_php['notice2'] = '(**) Si se cambian estos valores, solamente afectará a los archivos que se añadan desde este momento, por lo que es recomendable no cambiarlos si ya hay imágenes en la galería. Puedes, sin embargo, hacer los cambios sobre imágenes existentes con la utilidad &quot;<a href="util.php">Cambiar tamaños</a>&quot; del el menú de administración.';
$lang_admin_php['notice3'] = '(***) Los ficheros de log están en inglés.';
$lang_admin_php['bbs_disabled'] = 'La función está descativada cuando se usa integración (bridge)';
$lang_admin_php['auto_resize_everyone'] = 'Todos';
$lang_admin_php['auto_resize_user'] = 'Sólo el usuario';
$lang_admin_php['ascending'] = 'ascendente';
$lang_admin_php['descending'] = 'descendente';
$lang_admin_php['collapse_all'] = 'Contraer todo'; // cpg1.5
$lang_admin_php['separate_page'] = 'en una nueva página'; // cpg1.5
$lang_admin_php['inline'] = 'en la misma página'; // cpg1.5
$lang_admin_php['guests_only'] = 'Sólo invitados'; // cpg1.5
$lang_admin_php['wm_bottomright'] = 'Derecha abajo'; // cpg1.5
$lang_admin_php['wm_bottomleft'] = 'Izquierda abajo'; // cpg1.5
$lang_admin_php['wm_topleft'] = 'Izquierda arriba'; // cpg1.5
$lang_admin_php['wm_topright'] = 'Derecha arriba'; // cpg1.5
$lang_admin_php['wm_center'] = 'Centrado'; // cpg1.5
$lang_admin_php['wm_both'] = 'Ambos'; // cpg1.5
$lang_admin_php['wm_original'] = 'Original'; // cpg1.5
$lang_admin_php['wm_resized'] = 'Tamaño cambiado'; // cpg1.5
$lang_admin_php['gallery_name'] = 'Nombre de la galería'; // cpg1.5
$lang_admin_php['gallery_description'] = 'Descripción de la galería'; // cpg1.5
$lang_admin_php['gallery_admin_email'] = 'Correo del administrador de la galería'; // cpg1.5
$lang_admin_php['ecards_more_pic_target'] = 'URL de la carpeta de la galería'; // cpg1.5
$lang_admin_php['ecards_more_pic_target_detail'] = '(con una barra al final, no con \'index.php\' o similar)'; // cpg1.5
$lang_admin_php['home_target'] = 'URL de la página principal'; // cpg1.5
$lang_admin_php['enable_zipdownload'] = 'Permitir descarga comprimida (ZIP) de los favoritos'; // cpg1.5
$lang_admin_php['enable_zipdownload_no_textfile'] = 'sólo los favoritos'; // cpg1.5
$lang_admin_php['enable_zipdownload_additional_textfile'] = 'favoritos y fichero readme'; // cpg1.5
$lang_admin_php['time_offset'] = 'Zona horaria respecto a GMT'; // cpg1.5
$lang_admin_php['time_offset_detail'] = '(Hora actual: %s)'; // cpg1.5
$lang_admin_php['enable_help'] = 'Habilitar iconos de ayuda'; // cpg1.5
$lang_admin_php['enable_help_description'] = 'ayuda parcialmente en inglés '; // cpg1.5
//$lang_admin_php['clickable_keyword_search'] = 'Mostrar palabras clave \'clickables\' en la búsqueda'; // cpg1.5
$lang_admin_php['clickable_keyword_search'] = 'Mostrar la nube de palabras clave en la página de búsqueda'; // cpg1.5
$lang_admin_php['keyword_separator'] = 'Separador de palabras clave'; // cpg1.5
$lang_admin_php['keyword_convert'] = 'Convertir el separador de palabras clave'; // cpg1.5
$lang_admin_php['enable_plugins'] = 'Activar plugins'; // cpg1.5
$lang_admin_php['purge_expired_bans'] = 'Purgar expulsiones caducadas automáticamente'; // cpg1.5
$lang_admin_php['browse_batch_add'] = 'Interfaz navegable para añadir imágenes por lotes'; // cpg1.5
$lang_admin_php['batch_proc_limit'] = 'Procesos concurrentes para añadir imágenes por lotes'; // cpg1.5
$lang_admin_php['display_thumbs_batch_add'] = 'Mostrar miniaturas cuando se añaden imágenes por lotes'; // cpg1.5
$lang_admin_php['lang'] = 'Idioma por defecto'; // cpg1.5
$lang_admin_php['language_autodetect'] = 'Detectar idioma automáticamente'; // cpg1.5
$lang_admin_php['charset'] = 'Juego de caracteres'; // cpg1.5
$lang_admin_php['previous_next_tab'] = 'Mostrar enlaces siguiente/anterior en las páginas de tablas'; // cpg1.5
$lang_admin_php['theme'] = 'Tema (aspecto)'; // cpg1.5
$lang_admin_php['custom_lnk_name'] = 'Nombre del enlace del menú personalizado '; // cpg1.5
$lang_admin_php['custom_lnk_url'] = 'URL del enlace del menú personalizado '; // cpg1.5
$lang_admin_php['enable_menu_icons'] = 'Mostrar iconos en el menú'; // cpg1.5
$lang_admin_php['show_bbcode_help'] = 'Mostrar la ayuda BBCode'; // cpg1.5
$lang_admin_php['vanity_block'] = 'Mostrar el "Vanity block" en temas que han sido definidos como compilados para XHTML y CSS '; // cpg1.5
$lang_admin_php['highlight_multiple'] = 'Para marcar varias líneas mantenga pulsada la tecla [Ctrl]'; // cpg1.5
$lang_admin_php['custom_header_path'] = 'Ruta de inserción de la cabecera personalizada'; // cpg1.5
$lang_admin_php['custom_footer_path'] = 'Ruta de inserción del pie de página personalizado'; // cpg1.5
$lang_admin_php['browse_by_date'] = 'Permitir la navegación por fecha'; // cpg1.5
$lang_admin_php['display_redirection_page'] = 'Mostrar las páginas redirigidas'; // cpg1.5
$lang_admin_php['display_xp_publish_link'] = 'Promocionar el uso del XP Publisher mostrando un enlace en la página de carga'; // cpg1.5
$lang_admin_php['main_table_width'] = 'Ancho de la tabla principal'; // cpg1.5
$lang_admin_php['pixels_or_percent'] = 'pixels o %'; // cpg1.5
$lang_admin_php['subcat_level'] = 'Número de niveles de categorías a mostrar'; // cpg1.5
$lang_admin_php['albums_per_page'] = 'Número de álbumes a mostrar'; // cpg1.5
$lang_admin_php['album_list_cols'] = 'Número de columnas en la lista de álbumes'; // cpg1.5
$lang_admin_php['alb_list_thumb_size'] = 'Tamaño de las imágenes miniatura en pixels'; // cpg1.5
$lang_admin_php['main_page_layout'] = 'Contenido de la página principal'; // cpg1.5
$lang_admin_php['first_level'] = 'Mostrar miniaturas de los álbumes de primer nivel en categorías'; // cpg1.5
$lang_admin_php['categories_alpha_sort'] = 'Organizar categoría alfabéticamente'; // cpg1.5
$lang_admin_php['categories_alpha_sort_details'] = '(en lugar del orden predefinida)'; // cpg1.5
$lang_admin_php['link_pic_count'] = 'Mostrar numero de archivos enlazados'; // cpg1.5
$lang_admin_php['thumbcols'] = 'Número de columnas en la vista de miniaturas'; // cpg1.5
$lang_admin_php['thumbrows'] = 'Número de filas en la vista de miniaturas'; // cpg1.5
$lang_admin_php['max_tabs'] = 'Máximo número de pestañas (tabs) a mostrar'; // cpg1.5
$lang_admin_php['tabs_dropdown'] = 'Mostrar lista desplegable de páginas junto a las pestañas (tabs)'; // cpg1.5
$lang_admin_php['caption_in_thumbview'] = 'Mostrar la descripción (además del título) debajo de la miniatura'; // cpg1.5
$lang_admin_php['views_in_thumbview'] = 'Mostrar número de veces vista debajo de la miniatura'; // cpg1.5
$lang_admin_php['display_comment_count'] = 'Mostrar número de comentarios debajo de la miniatura'; // cpg1.5
$lang_admin_php['display_uploader'] = 'Mostrar el usuario que añadió el archivo'; // cpg1.5
//$lang_admin_php['display_admin_uploader'] = 'Mostrar el usuario que añadió el archivo'; // cpg1.5
$lang_admin_php['display_filename'] = 'Mostrar nombre de la miniatura'; // cpg1.5
$lang_admin_php['display_thumbnail_rating'] = 'Mostrar valoración debajo de la miniatura'; // cpg1.5
$lang_admin_php['alb_desc_thumb'] = 'Mostrar la descripción del álbum'; // cpg1.5
$lang_admin_php['thumbnail_to_fullsize'] = 'Mostrar la imagen a tamaño completo al pulsar la miniatura'; // cpg1.5
$lang_admin_php['default_sort_order'] = 'Orden por defecto de los ficheros'; // cpg1.5
$lang_admin_php['min_votes_for_rating'] = 'Mínimo número de votos para que un archivo aparezca el la lista de \'Más Valorados\' '; // cpg1.5
$lang_admin_php['picture_table_width'] = 'Ancho de la tabla de ficheros'; // cpg1.5
$lang_admin_php['display_pic_info'] = 'Información del fichero visible por defecto'; // cpg1.5
$lang_admin_php['picinfo_movie_download_link'] = 'Mostrar el enlace de descarga en el área de información'; // cpg1.5
$lang_admin_php['max_img_desc_length'] = 'Longitud máxima de la descripción del archivo'; // cpg1.5
$lang_admin_php['max_com_wlength'] = 'Longitud máxima de una palabra'; // cpg1.5
$lang_admin_php['display_film_strip'] = 'Mostrar tira de película'; // cpg1.5
$lang_admin_php['max_film_strip_items'] = 'Número de objetos en tira de película'; // cpg1.5
$lang_admin_php['slideshow_interval'] = 'Intervalo de tiempo entre imágenes en la presentación en'; // cpg1.5
$lang_admin_php['milliseconds'] = 'milisegundos'; // cpg1.5
$lang_admin_php['slideshow_interval_detail'] = '1 segundo = 1000 milisegundos'; // cpg1.5
$lang_admin_php['slideshow_hits'] = 'Contar las vistas en las presentaciones'; // cpg1.5
$lang_admin_php['ecard_flash'] = 'Permitir Flash en las postales'; // cpg1.5
$lang_admin_php['not_recommended'] = 'no recomendado'; // cpg1.5
$lang_admin_php['recommended'] = 'recomendado'; // cpg1.5
$lang_admin_php['transparent_overlay'] = 'Insertar una capa trasnparente para minimizar el robo de imágenes'; // cpg1.5
$lang_admin_php['old_style_rating'] = 'Usar el antiguo sistema de votaciones'; // cpg1.5 //jmatute
$lang_admin_php['old_style_rating_extra'] = 'Esto deshabilitará la opción \'Número de estrellas que se usarán\''; // cpg1.5
$lang_admin_php['rating_stars_amount'] = 'Número de estrellas que se usarán en la votación'; // cpg1.5
$lang_admin_php['rate_own_files'] = 'Los usuarios pueden votar sus propios ficheros'; // cpg1.5
$lang_admin_php['filter_bad_words'] = 'Filtrar palabras malsonantes en los comentarios'; // cpg1.5
$lang_admin_php['enable_smilies'] = 'Permitir emoticonos en los comentarios'; // cpg1.5
$lang_admin_php['disable_comment_flood_protect'] = 'Permitir varios comentarios consecutivos del mismo usuario en un archivo'; // cpg1.5
$lang_admin_php['disable_comment_flood_protect_details'] = '(deshabilitar protección contra flood)'; // cpg1.5
$lang_admin_php['max_com_lines'] = 'Máximo número de líneas en un comentario'; // cpg1.5
$lang_admin_php['max_com_size'] = 'Máxima longitud de un comentario'; // cpg1.5
$lang_admin_php['email_comment_notification'] = 'Notificar al administrador por correo sobre los comentarios añadidos'; // cpg1.5
$lang_admin_php['comments_sort_descending'] = 'Ordenar los comentarios'; // cpg1.5
$lang_admin_php['comments_per_page'] = 'Comentarios por página'; // cpg1.5
$lang_admin_php['comments_anon_pfx'] = 'Prefijo para autores anónimos'; // cpg1.5
$lang_admin_php['comment_approval'] = 'Aprobación necesaria para los comentarios'; // cpg1.5
$lang_admin_php['display_comment_approval_only'] = 'Mostrar sólo los comentarios pendientes de aprobación en la página &quot;Revisar comentarios&quot;'; // cpg1.5
$lang_admin_php['comment_placeholder'] = 'Mostrar un marcador a los usuarios cuando hay comentarios pendientes de aprobación'; // cpg1.5
$lang_admin_php['comment_user_edit'] = 'Permitir a los usuarios editar sus propios comentarios'; // cpg1.5
$lang_admin_php['comment_captcha'] = 'Mostrar confirmación visual (Captcha) para añadir comentarios'; // cpg1.5
$lang_admin_php['comment_akismet_enable'] = 'Opciones Akismet'; // cpg1.5
$lang_admin_php['comment_akismet_enable_description'] = '¿Qué hacer si Akismet rechaza un comentario como spam?'; // cpg1.5
$lang_admin_php['comment_akismet_applicable_only'] = 'Las opciones sólo aplican si se habilita el API de Akismet con una clave válida'; // cpg1.5
$lang_admin_php['comment_akismet_enable_approval'] = 'Permitir comentarios que no pasan el filtro Akismet, pero marcarlos como no aprobados'; // cpg1.5
$lang_admin_php['comment_akismet_drop_tell'] = 'Borrar el comentario que no se valida e informar al autor que fué rechazado'; // cpg1.5
$lang_admin_php['comment_akismet_drop_lie'] = 'Borrar el comentario que no se valida e informar al autor que fué añadido'; // cpg1.5
$lang_admin_php['comment_akismet_api_key'] = 'Clave API de Akismet'; // cpg1.5
$lang_admin_php['comment_akismet_api_key_description'] = 'Déjelo en blanco para deshabilitar Akismet'; // cpg1.5
$lang_admin_php['comment_akismet_group'] = 'Applicar Akismet a los comentarios de'; // cpg1.5
$lang_admin_php['comment_promote_registration'] = 'Pedir a los usuarios que se registren y accedan para dejar comentarios'; // cpg1.5
$lang_admin_php['thumb_width'] = 'Dimansión mayor de una miniatura (anchura, si usas "Exacta" en "Usar dimensión")'; // cpg1.5
$lang_admin_php['thumb_use'] = 'Usar dimensión'; // cpg1.5
$lang_admin_php['thumb_use_detail'] = '(anchura, altura o la mayor de la miniatura)'; // cpg1.5
$lang_admin_php['thumb_height'] = 'Alto de la miniatura'; // cpg1.5
$lang_admin_php['thumb_height_detail'] = '(sólo aplica si se usa &quot;Exacta&quot; en &quot;Usar dimensión&quot;)'; // cpg1.5
$lang_admin_php['movie_audio_document'] = 'Película, sonido, documento'; // cpg1.5
$lang_admin_php['thumb_pfx'] = 'Prefijo para las miniaturas'; // cpg1.5
$lang_admin_php['enable_unsharp'] = 'Nitidez de las miniaturas: activar \'Unsharp Mask\''; // cpg1.5 //Pendiente
$lang_admin_php['unsharp_amount'] = 'Nitidez de las miniaturas: cantidad'; // cpg1.5 //Pendiente
$lang_admin_php['unsharp_radius'] = 'Nitidez de las miniaturas: radio'; // cpg1.5 //Pendiente
$lang_admin_php['unsharp_threshold'] = 'Nitidez de las miniaturas: umbral'; // cpg1.5 //Pendiente
$lang_admin_php['jpeg_qual'] = 'Calidad de los ficheros JPEG'; // cpg1.5
$lang_admin_php['make_intermediate'] = 'Crear imágenes intermedias'; // cpg1.5
$lang_admin_php['picture_use'] = 'Usar dimensión'; // cpg1.5
$lang_admin_php['picture_use_detail'] = '(ancho, alto o máximo para una imagen intermedia)'; // cpg1.5
$lang_admin_php['picture_use_thumb'] = 'Como la miniatura'; // cpg1.5
$lang_admin_php['picture_width'] = 'Máx. ancho o alto de una imagen intermedia'; // cpg1.5
$lang_admin_php['max_upl_size'] = 'Tamaño máximo de los ficheros cargados'; // cpg1.5
$lang_admin_php['kilobytes'] = 'KB'; // cpg1.5
$lang_admin_php['pixels'] = 'pixels'; // cpg1.5
$lang_admin_php['max_upl_width_height'] = 'Ancho o alto máximos de las imágenes cargadas'; // cpg1.5
$lang_admin_php['auto_resize'] = 'Escalar automáticamente las imágenes mayores que el ancho o alto máximo'; // cpg1.5
$lang_admin_php['fullsize_padding_x'] = 'Relleno horizontal para la ventana emergente de imagen completa'; // cpg1.5 //pendiente
$lang_admin_php['fullsize_padding_y'] = 'Relleno vertical para la ventana emergente de imagen completa'; // cpg1.5 //pendiente
$lang_admin_php['allow_private_albums'] = 'Permitir álbumes privados'; // cpg1.5
$lang_admin_php['allow_private_albums_note'] = '(Nota: Si cambias de  \'Si\' a \'No\' todos los álbumes privados que estén ya definidos serán visibles)'; // cpg1.5
$lang_admin_php['show_private'] = 'Mostrar icono de álbum privado a los usuarios no validados'; // cpg1.5
$lang_admin_php['forbiden_fname_char'] = 'Caracteres prohibidos en los nombres de fichero'; // cpg1.5
$lang_admin_php['silly_safe_mode'] = 'Permitir &quot;silly safe mode&quot;'; // cpg1.5 //pendiente
$lang_admin_php['allowed_img_types'] = 'Tipos de imágenes permitidos'; // cpg1.5
$lang_admin_php['allowed_mov_types'] = 'Tipos de archivos de video admitidos'; // cpg1.5
$lang_admin_php['media_autostart'] = 'Autoinicio de Peliculas'; // cpg1.5
$lang_admin_php['allowed_snd_types'] = 'Tipos de archivos de sonido admitidos'; // cpg1.5
$lang_admin_php['allowed_doc_types'] = 'Tipos de documentos admitidos'; // cpg1.5
$lang_admin_php['thumb_method'] = 'Método para el reescalado de imágenes'; // cpg1.5
$lang_admin_php['impath'] = 'Ruta a la utilidad \'convert\' de ImageMagick'; // cpg1.5
$lang_admin_php['impath_example'] = '(por ejemplo /usr/bin/X11/)'; // cpg1.5
$lang_admin_php['im_options'] = 'Comandos de línea para ImageMagick'; // cpg1.5
$lang_admin_php['read_exif_data'] = 'Leer datos EXIF en los archivos JPEG'; // cpg1.5
$lang_admin_php['read_iptc_data'] = 'Leer datos IPTC en los archivos JPEG'; // cpg1.5
$lang_admin_php['fullpath'] = 'Directorio base de los álbumes'; // cpg1.5
$lang_admin_php['userpics'] = 'Directorio para los archivos de los usuarios'; // cpg1.5
$lang_admin_php['normal_pfx'] = 'Prefijo para las imágenes intermedias'; // cpg1.5
$lang_admin_php['default_dir_mode'] = 'Modo por defecto para los directorios'; // cpg1.5
$lang_admin_php['default_file_mode'] = 'Modo por defecto para los ficheros'; // cpg1.5
$lang_admin_php['enable_watermark'] = 'Imágenes para marca de agua'; // cpg1.5
$lang_admin_php['enable_thumb_watermark'] = 'Miniaturas definidas por el usuario para marca de agua'; // cpg1.5
$lang_admin_php['where_put_watermark'] = 'Lugar en que se pondrá la marca de agua'; // cpg1.5
$lang_admin_php['which_files_to_watermark'] = 'A qué ficheros aplicar la marca de agua'; // cpg1.5
$lang_admin_php['watermark_file'] = 'Qué fichero se usará para marca de agua'; // cpg1.5
$lang_admin_php['watermark_transparency'] = 'Transparencia de la imagen completa'; // cpg1.5
$lang_admin_php['zero_2_hundred'] = '0-100'; // cpg1.5
$lang_admin_php['reduce_watermark'] = 'Reescalar la marca de agua si el ancho de la imagen es menor que el valor introducido. Esa se usará como referencia del 100%. El reescalado de la marca de agua es lineal (0 para deshabilitarla)'; // cpg1.5
$lang_admin_php['watermark_transparency_featherx'] = 'Establecer x para el color transparente'; // cpg1.5
$lang_admin_php['watermark_transparency_feathery'] = 'Establecer y para el color transparente'; // cpg1.5
$lang_admin_php['gd2_only'] = 'Sólo para GD2'; // cpg1.5
$lang_admin_php['allow_user_registration'] = 'Permitir registrarse a nuevos usuarios'; // cpg1.5
$lang_admin_php['global_registration_pw'] = 'Contraseña general al registrarse'; // cpg1.5
$lang_admin_php['user_registration_disclaimer'] = 'Mostrar \'disclaimer\' en el registro de usuario'; // cpg1.5
$lang_admin_php['registration_captcha'] = 'Mostrar confirmación visual (Captcha) en la página de registro'; // cpg1.5
$lang_admin_php['reg_requires_valid_email'] = 'El registro de usuarios requiere verificación de correo'; // cpg1.5
$lang_admin_php['reg_notify_admin_email'] = 'Notificar por email al administrador del registro de nuevos usuarios '; // cpg1.5
$lang_admin_php['admin_activation'] = 'El administrador activa los registros de usuario'; // cpg1.5
$lang_admin_php['personal_album_on_registration'] = 'Crear un álbum de usuario en la galería personal al registrarse'; // cpg1.5
$lang_admin_php['allow_unlogged_access'] = 'Permitir accesos de usuarios no validados (invitados o anónimos) '; // cpg1.5
$lang_admin_php['thumbnail_intermediate_full'] = 'imágenes miniatura, intermedias y a tamaño completo'; // cpg1.5
$lang_admin_php['thumbnail_intermediate'] = 'imágenes miniatura y a tamaño completo'; // cpg1.5
$lang_admin_php['thumbnail_only'] = 'sólo miniatura'; // cpg1.5
$lang_admin_php['upload_mechanism'] = 'Método de carga de imágenes por defecto'; // cpg1.5
$lang_admin_php['upload_swf'] = 'avanzado - múltiples ficheros, usa Flash (recomendado)'; // cpg1.5
$lang_admin_php['upload_single'] = 'simple - un fichero cada vez'; // cpg1.5
$lang_admin_php['allow_user_upload_choice'] = 'Permitir a los usuarios elegir el método de subida'; // cpg1.5
$lang_admin_php['allow_duplicate_emails_addr'] = 'Permitir a dos usuarios tener el mismo correo '; // cpg1.5
$lang_admin_php['upl_notify_admin_email'] = 'Notificar al administrador que hay archivos añadidos esperando autorización'; // cpg1.5
$lang_admin_php['allow_memberlist'] = 'Permitir a los usuarios validados ver la lista completa de usuarios'; // cpg1.5
$lang_admin_php['allow_email_change'] = 'Permitir a los usuarios cambiar su correo en su perfil'; // cpg1.5
$lang_admin_php['allow_user_account_delete'] = 'Permitir a los usuarios borrar su cuenta'; // cpg1.5
$lang_admin_php['users_can_edit_pics'] = 'Permitir a los usuarios tener control sobre sus archivos en galerias publicas'; // cpg1.5
$lang_admin_php['allow_user_move_album'] = 'Permitir a los usuarios mover sus álbumes desde/hasta las categorías permitidas'; // cpg1.5
$lang_admin_php['allow_user_album_keyword'] = 'Permitir a los usuarios asignar palabras clave al álbum'; // cpg1.5
$lang_admin_php['allow_user_edit_after_cat_close'] = 'Permitir a los usuarios editar sus álbumes en categorías bloqueadas'; // cpg1.5
$lang_admin_php['login_method_username'] = 'por nombre de usuario'; // cpg1.5
$lang_admin_php['login_method_email'] = 'por el correo'; // cpg1.5
$lang_admin_php['login_method_both'] = 'por ambos'; // cpg1.5
$lang_admin_php['login_method'] = '¿Cómo se permitirá a los usuarios acceder?'; // cpg1.5
$lang_admin_php['login_threshold'] = 'Numero de intentos fallidos de autentificación antes de proceder a la expulsión'; // cpg1.5
$lang_admin_php['login_threshold_detail'] = '(para evitar ataques de fuerza bruta)'; // cpg1.5
$lang_admin_php['login_expiry'] = 'Duración de la expulsión luego de los intentos fallidos'; // cpg1.5
$lang_admin_php['minutes'] = 'minutos'; // cpg1.5
$lang_admin_php['report_post'] = 'Habilitar reporte al Administrador'; // cpg1.5
$lang_admin_php['user_profile1_name'] = 'Campo 1 en el perfil'; // cpg1.5
$lang_admin_php['user_profile2_name'] = 'Campo 2 en el perfil'; // cpg1.5
$lang_admin_php['user_profile3_name'] = 'Campo 3 en el perfil'; // cpg1.5
$lang_admin_php['user_profile4_name'] = 'Campo 4 en el perfil'; // cpg1.5
$lang_admin_php['user_profile5_name'] = 'Campo 5 en el perfil'; // cpg1.5
$lang_admin_php['user_profile6_name'] = 'Campo 6 en el perfil'; // cpg1.5
$lang_admin_php['user_field1_name'] = 'Campo 1'; // cpg1.5
$lang_admin_php['user_field2_name'] = 'Campo 2'; // cpg1.5
$lang_admin_php['user_field3_name'] = 'Campo 3'; // cpg1.5
$lang_admin_php['user_field4_name'] = 'Campo 4'; // cpg1.5
$lang_admin_php['cookie_name'] = 'Nombre de la cookie usada por el script'; // cpg1.5
$lang_admin_php['cookie_path'] = 'Ruta de la cookie usada por el script'; // cpg1.5
$lang_admin_php['smtp_host'] = 'Servidor SMTP (si se deja en blanco se usará sendmail) '; // cpg1.5
$lang_admin_php['smtp_username'] = 'Usuario SMTP'; // cpg1.5
$lang_admin_php['smtp_password'] = 'Contraseña SMTP'; // cpg1.5
$lang_admin_php['log_mode'] = 'Modo de registro de sucesos'; // cpg1.5
$lang_admin_php['log_mode_details'] = 'Todos los registros se escriben en inglés.'; // cpg1.5
$lang_admin_php['log_ecards'] = 'Registrar los sucesos de postales'; // cpg1.5
$lang_admin_php['log_ecards_detail'] = 'Nota: Guardar esta información puede tener consecuencias legales en algunos países (en España aplica la LOPD). Debes informar al usuario cuando se registre que se está guardando la información de las postales. También se recomienda crear una página separada con la política de privacidad.'; // cpg1.5
$lang_admin_php['vote_details'] = 'Mantener estadísticas detalladas de los votos'; // cpg1.5
$lang_admin_php['hit_details'] = 'Mantener estadísticas detalladas de los hits'; // cpg1.5
$lang_admin_php['display_stats_on_index'] = 'Mostrar estadísticas en la página índice'; // cpg1.5
$lang_admin_php['count_file_hits'] = 'Contar visitas a ficheros'; // cpg1.5
$lang_admin_php['count_album_hits'] = 'Contar visitas a los álbumes'; // cpg1.5
$lang_admin_php['count_admin_hits'] = 'Contar las visitas del administrador'; // cpg1.5
$lang_admin_php['debug_mode'] = 'Habilitar depuración'; // cpg1.5
$lang_admin_php['debug_notice'] = 'Mostrar notas en el modo de depuración'; // cpg1.5
$lang_admin_php['offline'] = 'Desactivar la galería (no olvides activarla después de terminar)'; // cpg1.5
$lang_admin_php['display_coppermine_news'] = 'Mostrar noticias de coppermine-gallery.net'; // cpg1.5
$lang_admin_php['display_coppermine_detail'] = 'Sólo se mostrarán al administrador'; // cpg1.5
$lang_admin_php['config_setting_invalid'] = 'El valor establecido en &laquo;%s&raquo; no es válido, revísalo por favor.'; // cpg1.5
$lang_admin_php['config_setting_ok'] = 'Se ha guardado el valor de &laquo;%s&raquo;.'; // cpg1.5
$lang_admin_php['contact_form_settings'] = 'Formulario de contacto'; // cpg1.5
$lang_admin_php['contact_form_guest_enable'] = 'Mostrar el formulario de contacto para usuarios anónimos (invitados)'; // cpg1.5
$lang_admin_php['contact_form_registered_enable'] = 'Mostrar el formulario de contacto para usuarios registrados'; // cpg1.5
$lang_admin_php['with_captcha'] = 'con confirmación visual (captcha)'; // cpg1.5
$lang_admin_php['without_captcha'] = 'sin confirmación visual (captcha)'; // cpg1.5
$lang_admin_php['optional'] = 'opcional'; // cpg1.5
$lang_admin_php['mandatory'] = 'obligatorio'; // cpg1.5
$lang_admin_php['contact_form_guest_name_field'] = 'Mostrar el nombre del remitente a los invitados'; // cpg1.5
$lang_admin_php['contact_form_guest_email_field'] = 'Mostrar el correo del remitente a los invitados'; // cpg1.5
$lang_admin_php['contact_form_subject_field'] = 'Mostrar asunto'; // cpg1.5
$lang_admin_php['contact_form_subject_content'] = 'Asunto de los correos generados en el formulario de contacto'; // cpg1.5
$lang_admin_php['contact_form_sender_email'] = 'Usar el correo del remitente en el campo &quot;De&quot;'; // cpg1.5
$lang_admin_php['allow_no_link'] = 'permitir, pero no mostrar enlace'; // cpg1.5
$lang_admin_php['allow_show_link'] = 'permitir, y promocionar el uso mostrando un enlace'; // cpg1.5
$lang_admin_php['display_sidebar_user'] = 'Barra lateral para usuarios registrados'; // cpg1.5
$lang_admin_php['display_sidebar_guest'] = 'Barra lateral para invitados'; // cpg1.5
$lang_admin_php['do_not_change'] = '¡No lo cambies a menos que REALMENTE sepas lo que haces!'; // cpg1.5
$lang_admin_php['reset_to_default'] = 'Poner valores por defecto'; // cpg1.5
$lang_admin_php['no_change_needed'] = 'No ha habido cambios, la opción está en el valor por defecto'; // cpg1.5
$lang_admin_php['enabled'] = 'activado'; // cpg1.5
$lang_admin_php['disabled'] = 'desactivado'; // cpg1.5
$lang_admin_php['none'] = 'ninguno'; // cpg1.5
$lang_admin_php['warning_change'] = 'Este cambio sólo afectará a los ficheros que añadas de ahora en adelante, por lo que es preferible no cambiarlo si ya tienes ficheros en la galería. Puedes también aplicar los cambios a los ficheros ya existentes con la opción "Reescalar imágenes" del manú de utilidades.'; // cpg1.5
$lang_admin_php['warning_exist'] = 'No deberías cambiar estos ajustes si ya tienes ficheros en la base de datos.'; // cpg1.5
$lang_admin_php['warning_dont_submit'] = 'Si no estás seguro del impacto que tendrá cambiar ese valor no envíes el formulario y revisa la documentación antes.'; // cpg1.5 // js-alert
$lang_admin_php['menu_only'] = 'sólo en el menú'; // cpg1.5
$lang_admin_php['everywhere'] = 'en todas partes'; // cpg1.5
$lang_admin_php['manage_languages'] = 'Gestionar idiomas'; // cpg1.5
$lang_admin_php['form_token_lifetime'] = 'Caducidad del testigo de formulario (\'form token\')'; // cpg1.5
$lang_admin_php['seconds'] = 'Segundos'; // cpg1.5
$lang_admin_php['display_reset_boxes_in_config'] = 'Mostrar cajas de \'Reestablecer\' en la configuración'; // cpg1.5
$lang_admin_php['upd_not_needed'] = 'No se necesita actualizar.'; // cpg 1.5
}

// ------------------------------------------------------------------------- //
// File db_ecard.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('DB_ECARD_PHP')) {
$lang_db_ecard_php['title'] = 'Enviar postales';
$lang_db_ecard_php['ecard_sender'] = 'Remitente';
$lang_db_ecard_php['ecard_recipient'] = 'Destinatario';
$lang_db_ecard_php['ecard_date'] = 'Fecha';
$lang_db_ecard_php['ecard_display'] = 'Mostrar postales';
$lang_db_ecard_php['ecard_name'] = 'Nombre';
$lang_db_ecard_php['ecard_email'] = 'Correo';
$lang_db_ecard_php['ecard_ip'] = 'Dirección IP';
$lang_db_ecard_php['ecard_ascending'] = 'Ascendente';
$lang_db_ecard_php['ecard_descending'] = 'Descendente';
$lang_db_ecard_php['ecard_sorted'] = 'Ordenadas';
$lang_db_ecard_php['ecard_by_date'] = 'por fecha';
$lang_db_ecard_php['ecard_by_sender_name'] = 'por nombre del remitente';
$lang_db_ecard_php['ecard_by_sender_email'] = 'por correo(s) del remitente';
$lang_db_ecard_php['ecard_by_sender_ip'] = 'por la direccion IP del remitente';
$lang_db_ecard_php['ecard_by_recipient_name'] = 'por nombre del destinatario';
$lang_db_ecard_php['ecard_by_recipient_email'] = 'por correo(s) del destinatario';
$lang_db_ecard_php['ecard_number'] = 'Mostrando los registros %s a %s de %s';
$lang_db_ecard_php['ecard_goto_page'] = 'ir a la página';
$lang_db_ecard_php['ecard_records_per_page'] = 'Registros por página';
$lang_db_ecard_php['check_all'] = 'Marcar todas';
$lang_db_ecard_php['uncheck_all'] = 'Desmarcar todas';
$lang_db_ecard_php['ecards_delete_selected'] = 'Borrar postales seleccionadas';
$lang_db_ecard_php['ecards_delete_confirm'] = '¿Estas seguro de que quieres borrar los registros? Marca la casilla de verificacion!';
$lang_db_ecard_php['ecards_delete_sure'] = 'Estoy seguro';
$lang_db_ecard_php['invalid_data'] = 'Los datos de la postal a la que está intentando acceder han sido corrompidos por su cliente de correo. Compruebe que la conexión se ha completado.';
}

// ------------------------------------------------------------------------- //
// File db_input.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('DB_INPUT_PHP')) {
$lang_db_input_php['empty_name_or_com'] = 'Es necesario que escribas tu nombre y un comentario';
$lang_db_input_php['com_added'] = 'Comentario añadido'; // cpg1.5
$lang_db_input_php['alb_need_title'] = 'Tienes que proporcionar un título para el álbum!';
$lang_db_input_php['no_udp_needed'] = 'No necesita actualizacion.';
$lang_db_input_php['alb_updated'] = 'El álbum fue actualizado';
$lang_db_input_php['unknown_album'] = 'El álbum seleccionado no existe o no tienes permiso para verlo';
$lang_db_input_php['no_pic_uploaded'] = 'Ningun archivo cargado!<br />Si realmente has seleccionado un archivo para subir, revisa si el servidor acepta la subida de archivos ...';
$lang_db_input_php['err_mkdir'] = 'Fallo en la creación del directorio %s!';
$lang_db_input_php['dest_dir_ro'] = 'El directorio destino %s no es modificable por el script!';
$lang_db_input_php['err_move'] = 'Imposible mover %s a %s!';
$lang_db_input_php['err_fsize_too_large'] = 'El archivo que has subido es muy grande (maximo permitido es %s x %s)!';
$lang_db_input_php['err_imgsize_too_large'] = 'El archivo que has subido ocupa mucho (maximo permitido es %s KB)!';
$lang_db_input_php['err_invalid_img'] = 'El archivo que quieres subir no es una imagen válida!';
$lang_db_input_php['allowed_img_types'] = 'Puedes subir %s archivos.';
$lang_db_input_php['err_insert_pic'] = 'No se puede insertar el archivo \'%s\' en el álbum';
$lang_db_input_php['upload_success'] = 'Tu archivo se ha cargado satisfactoriamente.<br />Será visible despues de que el administrador lo apruebe.';
$lang_db_input_php['notify_admin_email_subject'] = '%s - Notificación de subida';
$lang_db_input_php['notify_admin_email_body'] = '%s ha cargado un archivo y necesita aprobación. Visita %s';
$lang_db_input_php['info'] = 'Información';
$lang_db_input_php['com_added'] = 'Comentario añadido';
$lang_db_input_php['com_updated'] = 'Comentario actualizado'; // cpg1.5
$lang_db_input_php['alb_updated'] = 'Álbum actualizado';
$lang_db_input_php['err_comment_empty'] = 'Tu comentario esta vacio!';
$lang_db_input_php['err_invalid_fext'] = 'Sólo se aceptan archivos con las siguientes extensiones:'; // js-alert
$lang_db_input_php['no_flood'] = 'Lo siento, pero eres el autor del último comentario publicado para este archivo<br />Edita el comentario que has escrito si quieres modificarlo';
$lang_db_input_php['redirect_msg'] = 'Estás siendo redireccionado.<br /><br />Pulsa \'Continuar\' si la página no se actualiza automaticamente';
$lang_db_input_php['upl_success'] = 'Archivo cargado satisfactoriamente';
$lang_db_input_php['email_comment_subject'] = 'Comentario escrito en la galería Coppermine';
$lang_db_input_php['email_comment_body'] = 'Han dejado un comentario en la galería. Miralo en';
$lang_db_input_php['album_not_selected'] = 'Álbum no seleccionado';
$lang_db_input_php['com_author_error'] = 'Un usuario registrado está usando este nick. Elige otro o valídate si eres tú';
}

// ------------------------------------------------------------------------- //
// File delete.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('DELETE_PHP')) {
$lang_delete_php['orig_pic'] = 'Imagen original'; // cpg1.5
$lang_delete_php['fs_pic'] = 'Imagen a tamaño completo';
$lang_delete_php['del_success'] = 'Borrado satisfactoriamente!';
$lang_delete_php['ns_pic'] = 'Imagen de tamaño normal';
$lang_delete_php['err_del'] = 'No puede ser borrado';
$lang_delete_php['thumb_pic'] = 'Miniatura';
$lang_delete_php['comment'] = 'Comentario';
$lang_delete_php['im_in_alb'] = 'Imagen en álbum';
$lang_delete_php['alb_del_success'] = 'Álbum &laquo;%s&raquo; borrado';
$lang_delete_php['alb_mgr'] = 'Administrador de álbumes';
$lang_delete_php['err_invalid_data'] = 'Datos no válidos recibidos en \'%s\'';
$lang_delete_php['create_alb'] = 'Creando álbum \'%s\'';
$lang_delete_php['update_alb'] = 'Actualizando álbum \'%s\' con el título \'%s\' e índice \'%s\'';
$lang_delete_php['del_pic'] = 'Borrar archivo';
$lang_delete_php['del_alb'] = 'Borrar álbum';
$lang_delete_php['del_user'] = 'Borrar usuario';
$lang_delete_php['err_unknown_user'] = 'El usuario seleccionado no existe!';
$lang_delete_php['err_empty_groups'] = 'No existe la tabla de grupos, o la tabla está vacía!';
$lang_delete_php['comment_deleted'] = 'Comentario borrado';
$lang_delete_php['npic'] = 'Imagen';
$lang_delete_php['pic_mgr'] = 'Gestor de imágenes';
$lang_delete_php['update_pic'] = 'Actualizando la imagen \'%s\' con nombre de fichero \'%s\' e índice \'%s\'';
$lang_delete_php['username'] = 'Usuario';
$lang_delete_php['anonymized_comments'] = '%s comentarios(s) pasados a anónimos';
$lang_delete_php['anonymized_uploads'] = '%s subida(s) pública(s) pasados a anónimos';
$lang_delete_php['deleted_comments'] = '%s comentario(s) borrados';
$lang_delete_php['deleted_uploads'] = '%s subida(s) pública(s) borradas';
$lang_delete_php['user_deleted'] = 'usuario %s borrado';
$lang_delete_php['activate_user'] = 'Activar usuario';
$lang_delete_php['user_already_active'] = 'La cuenta ya está activa';
$lang_delete_php['activated'] = 'Activado';
$lang_delete_php['deactivate_user'] = 'Desactivar usuario';
$lang_delete_php['user_already_inactive'] = 'La cuenta ya está inactiva';
$lang_delete_php['deactivated'] = 'Desactivada';
$lang_delete_php['reset_password'] = 'Reestablecer la(s) contraseña(s)';
$lang_delete_php['password_reset'] = 'Contraseña reestablecida a %s';
$lang_delete_php['change_group'] = 'Cambiar grupo principal';
$lang_delete_php['change_group_to_group'] = 'Cambiando de %s a %s';
$lang_delete_php['add_group'] = 'Añadir otro grupo';
$lang_delete_php['add_group_to_group'] = 'Añadiendo el usuario %s al grupo %s. Ahora es miembro de %s como principal y de %s como secundario.';
$lang_delete_php['status'] = 'Estado';
$lang_delete_php['updating_album'] = 'Actualizando álbum '; // cpg1.5
$lang_delete_php['moved_picture_to_position'] = 'Archivo %s movido a la posición %s'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File displayimage.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('DISPLAYIMAGE_PHP'))
{
$lang_display_image_php['confirm_del'] = 'Estas seguro de querer BORRAR este archivo?\\nTambién se borrarán comentarios.'; // js-alert
$lang_display_image_php['del_pic'] = 'Borrar este archivo';
$lang_display_image_php['size'] = '%s x %s pixels';
$lang_display_image_php['views'] = '%s visitas';
$lang_display_image_php['slideshow'] = 'Presentacion de diapositivas';
$lang_display_image_php['stop_slideshow'] = 'Detener presentacion de diapositivas';
$lang_display_image_php['view_fs'] = 'Pulsa para ver la imagen a tamaño completo';
$lang_display_image_php['edit_pic'] = 'Editar la informacion del archivo';
$lang_display_image_php['crop_pic'] = 'Cortar y girar';
$lang_display_image_php['set_player'] = 'Cambiar el reproductor';
$lang_picinfo['title'] = 'Informacion de archivo';
$lang_picinfo['Album name'] = 'Nombre de álbum';
$lang_picinfo['Rating'] = 'Votado (%s votos)';
$lang_picinfo['Date Added'] = 'Fecha añadida';
$lang_picinfo['Dimensions'] = 'Dimensiones';
$lang_picinfo['Displayed'] = 'Visto';
$lang_picinfo['URL'] = 'URL';
$lang_picinfo['Make'] = 'Hecho';
$lang_picinfo['Model'] = 'Modelo';
$lang_picinfo['DateTime'] = 'Fecha y hora';
$lang_picinfo['ISOSpeedRatings'] = 'ISO';
$lang_picinfo['MaxApertureValue'] = 'Maxima apertura';
$lang_picinfo['FocalLength'] = 'Longitud focal';
$lang_picinfo['Comment'] = 'Comentario';
$lang_picinfo['addFav'] = 'Añadir a favoritos';
$lang_picinfo['addFavPhrase'] = 'Favoritos';
$lang_picinfo['remFav'] = 'Quitar de favoritos';
$lang_picinfo['iptcTitle'] = 'Título IPTC';
$lang_picinfo['iptcCopyright'] = 'Copyright IPTC';
$lang_picinfo['iptcKeywords'] = 'Palabras clave IPTC';
$lang_picinfo['iptcCategory'] = 'Categoría IPTC';
$lang_picinfo['iptcSubCategories'] = 'Subcategorías IPTC';
$lang_picinfo['ColorSpace'] = 'Espacio de color';
$lang_picinfo['ExposureProgram'] = 'Programa de exposición';
$lang_picinfo['Flash'] = 'Flash';
$lang_picinfo['MeteringMode'] = 'Modo de medición';
$lang_picinfo['ExposureTime'] = 'Tiempo de exposición';
$lang_picinfo['ExposureBiasValue'] = 'Compensación de la exposición';
$lang_picinfo['ImageDescription'] = 'Descripción';
$lang_picinfo['Orientation'] = 'Orientación';
$lang_picinfo['xResolution'] = 'Resolución X';
$lang_picinfo['yResolution'] = 'Resolución Y';
$lang_picinfo['ResolutionUnit'] = 'Unidades de resolución';
$lang_picinfo['Software'] = 'Software';
$lang_picinfo['YCbCrPositioning'] = 'Posición YCbCr';
$lang_picinfo['ExifOffset'] = 'Offset EXIF';
$lang_picinfo['IFD1Offset'] = 'IFD1 Offset';
$lang_picinfo['FNumber'] = 'Número F';
$lang_picinfo['ExifVersion'] = 'Versión EXIF';
$lang_picinfo['DateTimeOriginal'] = 'Fecha y hora originales';
$lang_picinfo['DateTimedigitized'] = 'Fecha y hora de modificación';
$lang_picinfo['ComponentsConfiguration'] = 'Configuración por componentes';
$lang_picinfo['CompressedBitsPerPixel'] = 'Bits Por Pixel (compresión)';
$lang_picinfo['LightSource'] = 'Fuente de luz';
$lang_picinfo['ISOSetting'] = 'Ajuste ISO';
$lang_picinfo['ColorMode'] = 'Modo de color';
$lang_picinfo['Quality'] = 'Calidad';
$lang_picinfo['ImageSharpening'] = 'Enfoque de la imagen (sharpening)';
$lang_picinfo['FocusMode'] = 'Modo de enfoque';
$lang_picinfo['FlashSetting'] = 'Ajustes de flash';
$lang_picinfo['ISOSelection'] = 'Selección ISO';
$lang_picinfo['ImageAdjustment'] = 'Ajustes de imagen';
$lang_picinfo['Adapter'] = 'Adaptador';
$lang_picinfo['ManualFocusDistance'] = 'Distancia de enfoque manual';
$lang_picinfo['DigitalZoom'] = 'Zoom digital';
$lang_picinfo['AFFocusPosition'] = 'Posición de autofoco';
$lang_picinfo['Saturation'] = 'Saturación';
$lang_picinfo['NoiseReduction'] = 'Reducción de ruido';
$lang_picinfo['FlashPixVersion'] = 'Versión de FlashPix';
$lang_picinfo['ExifimageWidth'] = 'Ancho de imagen EXIF';
$lang_picinfo['ExifimageHeight'] = 'Alto de imagen EXIF';
$lang_picinfo['ExifinteroperabilityOffset'] = 'EXIF Interoperability Offset';
$lang_picinfo['FileSource'] = 'Origen del fichero';
$lang_picinfo['SceneType'] = 'Tipo de escena';
$lang_picinfo['CustomerRender'] = 'Customer Render'; //jmatute: pendiente
$lang_picinfo['ExposureMode'] = 'Modo de exposición';
$lang_picinfo['WhiteBalance'] = 'Balance de blancos';
$lang_picinfo['DigitalZoomRatio'] = 'Zoom digital';
$lang_picinfo['SceneCaptureMode'] = 'Modo de captura de escenas';
$lang_picinfo['GainControl'] = 'Control de ganancia';
$lang_picinfo['Contrast'] = 'Contraste';
$lang_picinfo['Sharpness'] = 'Nitidez';
$lang_picinfo['ManageExifDisplay'] = 'Gestionar la visualización de datos EXIF';
$lang_picinfo['success'] = 'Información actualizada.';
$lang_picinfo['show_details'] = 'Mostrar detalles'; // cpg1.5
$lang_picinfo['hide_details'] = 'Ocultar detalles'; // cpg1.5
$lang_picinfo['download_URL'] = 'Enlace directo';
$lang_picinfo['movie_player'] = 'Reproducir el fichero en tu aplicación estándar';
$lang_display_comments['comment_x_to_y_of_z'] = '%d a %d de %d'; // cpg1.5
$lang_display_comments['page'] = 'Página'; // cpg1.5
$lang_display_comments['edit_title'] = 'Editar este comentario';
$lang_display_comments['delete_title'] = 'Borrar este comentario'; // cpg1.5
$lang_display_comments['confirm_delete'] = '¿Estás seguro de querer borrar este comentario?'; // js-alert
$lang_display_comments['add_your_comment'] = 'Añade tu comentario';
$lang_display_comments['name'] = 'Nombre';
$lang_display_comments['comment'] = 'Comentario';
$lang_display_comments['your_name'] = 'Anónimo';
$lang_display_comments['report_comment_title'] = 'Informar al administrador sobre este comentario';
$lang_display_comments['pending_approval'] = 'El comentario será visible tras la aprobación del administrador'; // cpg1.5
$lang_display_comments['unapproved_comment'] = 'Comentario rechazado'; // cpg1.5
$lang_display_comments['pending_approval_message'] = 'Alguien ha escrito un comentario. Será visible tras la aprobación del administrador.'; // cpg1.5
$lang_display_comments['approve'] = 'Aprobar comentario'; // cpg1.5
$lang_display_comments['disapprove'] = 'Marcar como rechazado'; // cpg1.5
$lang_display_comments['log_in_to_comment'] = 'No se permiten comentarios anónimos. %sAccede%s para comentar'; // cpg1.5 // do not translate the %s placeholders - they will be used as wrappers for the link (<a>)
$lang_display_comments['default_username_message'] = 'Por favor, pon tu nombre para comentar'; // cpg1.5
$lang_display_comments['comment_rejected'] = 'Se ha rechazado tu comentario'; // cpg1.5
$lang_fullsize_popup['click_to_close'] = 'Pulsa en la imagen para cerrar la ventana';
$lang_fullsize_popup['close_window'] = 'Cerrar ventana'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File ecard.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('ECARDS_PHP')) {
$lang_ecard_php['title'] = 'Enviar una postal';
$lang_ecard_php['invalid_email'] = 'Aviso: dirección de correo no válida:'; // cpg1.5
$lang_ecard_php['ecard_title'] = '%s te ha enviado una postal';
$lang_ecard_php['error_not_image'] = 'Sólo se pueden enviar imágenes en las postales.'; // cpg1.5
$lang_ecard_php['error_not_image_flash'] = 'Sólo se pueden enviar imágenes y archivos Flash en las postales.'; // cpg1.5
$lang_ecard_php['view_ecard'] = 'Si la imagen no se ve correctamente, pulsa en este enlace';
$lang_ecard_php['view_ecard_plaintext'] = 'Para ver la postal copia este enlace y pégalo en tu navegador:';
$lang_ecard_php['view_more_pics'] = 'Ver más imágenes!';
$lang_ecard_php['send_success'] = 'Postal enviada';
$lang_ecard_php['send_failed'] = 'Lo siento, pero el servidor no puede enviar tu postal...';
$lang_ecard_php['from'] = 'De';
$lang_ecard_php['your_name'] = 'Tu nombre';
$lang_ecard_php['your_email'] = 'Tu dirección de correo';
$lang_ecard_php['to'] = 'Para';
$lang_ecard_php['rcpt_name'] = 'Destinatario';
$lang_ecard_php['rcpt_email'] = 'Dirección de correo';
$lang_ecard_php['greetings'] = 'Título';
$lang_ecard_php['message'] = 'Mensaje';
$lang_ecard_php['ecards_footer'] = 'Enviada por %s desde la IP %s a las %s (hora de la galería)';
$lang_ecard_php['preview'] = 'Vista previa de la postal';
$lang_ecard_php['preview_button'] = 'Vista previa';
$lang_ecard_php['submit_button'] = 'Enviar postal';
$lang_ecard_php['preview_view_ecard'] = 'Este será el enlace alternativo a la postal una vez que se genere. No funciona en la vista previa.';
}

// ------------------------------------------------------------------------- //
// File report_file.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('REPORT_FILE_PHP')) {
$lang_report_php['title'] = 'Informar al administrador';
$lang_report_php['invalid_email'] = '<strong>Aviso</strong>: ¡dirección de correo no válida!';
$lang_report_php['report_subject'] = 'Informe de %s sobre %s en una galería';
$lang_report_php['view_report'] = 'Si el informe no se ve correctamente pulsa en este enlace';
$lang_report_php['view_report_plaintext'] = 'Para ver el informe copia este enlace y pégalo en tu navegador:';
$lang_report_php['view_more_pics'] = 'Galería';
$lang_report_php['send_success'] = 'Se ha enviado tu informe';
$lang_report_php['send_failed'] = 'Lo siento, pero el servidor no puede enviar tu informe...';
$lang_report_php['from'] = 'De';
$lang_report_php['your_name'] = 'Tu nombre';
$lang_report_php['your_email'] = 'Tu dirección de correo';
$lang_report_php['to'] = 'Para';
$lang_report_php['administrator'] = 'Administrador/Moderador';
$lang_report_php['subject'] = 'Asunto';
$lang_report_php['comment_field_name'] = 'Informe de un comentario por "%s"';
$lang_report_php['reason'] = 'Motivo';
$lang_report_php['message'] = 'Mensaje';
$lang_report_php['report_footer'] = 'Enviado por %s desde la IP %s a las %s (hora de la galería)';
$lang_report_php['obscene'] = 'obsceno';
$lang_report_php['offensive'] = 'ofensivo';
$lang_report_php['misplaced'] = 'Fuera de lugar/tópico';
$lang_report_php['missing'] = 'perdido';
$lang_report_php['issue'] = 'error/no se puede ver';
$lang_report_php['other'] = 'otro';
$lang_report_php['refers_to'] = 'El informe de fichero se refiere a';
$lang_report_php['reasons_list_heading'] = 'razón(es) para informar:';
$lang_report_php['no_reason_given'] = 'no se da razón alguna';
$lang_report_php['go_comment'] = 'Ir al comentario';
$lang_report_php['view_comment'] = 'Ver el informe completo con el comentario';
$lang_report_php['type_file'] = 'fichero';
$lang_report_php['type_comment'] = 'comentario';
$lang_report_php['invalid_data'] = 'Los datos del informe a los que intentas acceder se han corrompido por tu aplicación de correo. Comprueba si el enlace está correcto.';
}

// ------------------------------------------------------------------------- //
// File editpics.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('EDITPICS_PHP')) {
$lang_editpics_php['pic_info'] = 'Información del archivo';
$lang_editpics_php['desc'] = 'Descripción';
$lang_editpics_php['approval'] = 'Aprobación'; //cpg 1.5 //jmatute: pendiente de comprobar
$lang_editpics_php['approved'] = 'Aprobada'; // cpg 1.5
$lang_editpics_php['unapproved'] = 'No aprobada'; // cpg 1.5
$lang_editpics_php['new_keyword'] = 'Nueva palabra clave';
$lang_editpics_php['new_keywords'] = 'No se han encontrado palabras clave';
$lang_editpics_php['existing_keyword'] = 'Palabra clave ya existente';
$lang_editpics_php['pic_info_str'] = '%sx%s - %s KB - %s visitas - %s votos';
$lang_editpics_php['approve'] = 'Aprobar fichero';
$lang_editpics_php['postpone_app'] = 'Posponer aprobación';
$lang_editpics_php['del_pic'] = 'Borrar fichero';
$lang_editpics_php['del_all'] = 'Borrar todos los ficheros';
$lang_editpics_php['read_exif'] = 'Releer datos EXIF';
$lang_editpics_php['reset_view_count'] = 'Poner a cero el contador de visitas';
$lang_editpics_php['reset_all_view_count'] = 'Poner a cero TODOS los contadores de visitas';
$lang_editpics_php['reset_votes'] = 'Poner a cero los votos';
$lang_editpics_php['reset_all_votes'] = 'Poner a cero TODOS los votos';
$lang_editpics_php['del_comm'] = 'Borrar comentarios';
$lang_editpics_php['del_all_comm'] = 'Borrar TODOS los comentarios';
$lang_editpics_php['upl_approval'] = 'Aprobación de la subida';
$lang_editpics_php['edit_pics'] = 'Editar imágenes';
$lang_editpics_php['edit_pic'] = 'Editar imagen'; // cpg 1.5
$lang_editpics_php['see_next'] = 'Ver los ficheros siguientes';
$lang_editpics_php['see_prev'] = 'Ver los ficheros anteriores';
$lang_editpics_php['n_pic'] = '%s imágenes';
$lang_editpics_php['n_of_pic_to_disp'] = 'Número de imágenes que se mostrarán';
$lang_editpics_php['crop_title'] = 'Coppermine Picture Editor';
$lang_editpics_php['preview'] = 'Vista previa';
$lang_editpics_php['save'] = 'Guardar imagen';
$lang_editpics_php['save_thumb'] = 'Guardar como miniatura';
$lang_editpics_php['gallery_icon'] = 'Poner esta imagen como mi icono';
$lang_editpics_php['sel_on_img'] = '¡La selección ha de estar completamente dentro de la imagen!'; // js-alert
$lang_editpics_php['album_properties'] = 'Propiedades del álbum';
$lang_editpics_php['parent_category'] = 'Categoría padre';
$lang_editpics_php['thumbnail_view'] = 'Vista de miniaturas';
$lang_editpics_php['select_unselect'] = 'Seleccionar/quitar selección a todas';
$lang_editpics_php['file_exists'] = 'Ya existe el fichero destino \'%s\'.';
$lang_editpics_php['rename_failed'] = 'Error al renombrar \'%s\' a \'%s\'.';
$lang_editpics_php['src_file_missing'] = 'El fichero origen \'%s\' no existe.';
$lang_editpics_php['mime_conv'] = 'No se puede convertir \'%s\' a \'%s\'';
$lang_editpics_php['forb_ext'] = 'Extensión del fichero no permitida.';
$lang_editpics_php['error_editor_class'] = 'La clase para tu método de reescalado no está implementada'; // cpg 1.5 // Pendiente
$lang_editpics_php['error_document_size'] = 'El documento no tiene ancho o alto'; // cpg 1.5 // js-alert
$lang_editpics_php['success_picture'] = 'Imagen guardada - ahora puedes %scerrar%s esta ventana'; // cpg1.5 // do not translate "%s" here
$lang_editpics_php['success_thumb'] = 'Miniatura guardada - ahora puedes %scerrar%s esta ventana'; // cpg1.5 // do not translate "%s" here
$lang_editpics_php['rotate'] = 'Rotar'; // cpg 1.5
$lang_editpics_php['mirror'] = 'Voltear'; // cpg 1.5
$lang_editpics_php['scale'] = 'Expandir/contraer'; // cpg 1.5
$lang_editpics_php['new_width'] = 'Nuevo ancho'; // cpg 1.5
$lang_editpics_php['new_height'] = 'Nuevo alto'; // cpg 1.5
$lang_editpics_php['enable_clipping'] = 'Habilitar cortar, aplicar para recortar'; // cpg 1.5 //Pendiente
$lang_editpics_php['jpeg_quality'] = 'Calidad de salida JPEG'; // cpg 1.5
$lang_editpics_php['or'] = 'O'; // cpg 1.5
$lang_editpics_php['approve_pic'] = 'Aprobar fichero'; // cpg 1.5
$lang_editpics_php['approve_all'] = 'Aprobar TODOS los ficheros'; // cpg 1.5
$lang_editpics_php['error_empty'] = 'El álbum está vacío'; // cpg1.5
$lang_editpics_php['error_approval_empty'] = 'No hay imágenes por aprobar'; // cpg1.5
$lang_editpics_php['error_linked_only'] = 'El álbum sólo tiene enlaces a ficheros, que no se pueden editar desde aquí'; // cpg1.5
$lang_editpics_php['note_approve_public'] = 'Los ficheros que se han movido a un álbum publico debes ser aprobados por un administrador.'; // cpg1.5
$lang_editpics_php['note_approve_private'] = 'Los ficheros que se han movido a un álbum en una galería privada deben ser aprobados por un administrador.' ; // cpg1.5
$lang_editpics_php['note_edit_control'] = 'No se puede editar los ficheros que se han movido a un álbum publico.'; // cpg1.5
$lang_editpics_php['confirm_move'] = '¿Estás seguro de querer mover este fichero?'; // cpg1.5 //js-alert
$lang_editpics_php['success_changes'] = 'Cambios guardados'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File forgot_passwd.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('FORGOT_PASSWD_PHP')) {
$lang_forgot_passwd_php['forgot_passwd'] = 'Recuperación de contraseña';
$lang_forgot_passwd_php['err_already_logged_in'] = '¡Ya estás validado como usuario!';
$lang_forgot_passwd_php['enter_email'] = 'Introduce dirección de correo';
$lang_forgot_passwd_php['submit'] = 'ir';
$lang_forgot_passwd_php['illegal_session'] = 'Sesión de \'Olvide mi contraseña\' invalida o ha expirado.';
$lang_forgot_passwd_php['failed_sending_email'] = '¡El email con la contraseña no ha podido ser enviado!';
$lang_forgot_passwd_php['email_sent'] = 'Un email con su Usuario y su nueva contraseña ha sido enviado a %s';
$lang_forgot_passwd_php['verify_email_sent'] = 'Se ha enviado un email a %s. Por favor verifique su email para completar el proceso.';
$lang_forgot_passwd_php['err_unk_user'] = '¡El usuario seleccionado no existe!';
$lang_forgot_passwd_php['account_verify_subject'] = '%s - Recuperación de Contraseña';
$lang_forgot_passwd_php['passwd_reset_subject'] = '%s - Su nueva contraseña';
$lang_forgot_passwd_php['account_verify_email'] = <<< EOT
Ha solicitado la recuperación de contraseña. Si desea proseguir con el proceso y recibirla, haga click en el siguiente enlace:
  	
<a href="{VERIFY_LINK}">{VERIFY_LINK}</a>


Saludos,

Los administradores de {SITE_NAME}

EOT;

$lang_forgot_passwd_php['reset_email'] = <<< EOT
Aquí esta la contraseña que solicitó:

Usuario   : {USER_NAME}
Contraseña: {PASSWORD}

Vaya a <a href="{SITE_LINK}">{SITE_LINK}</a> para acceder.


Saludos,

Los administradores de {SITE_NAME}

EOT;
}

// ------------------------------------------------------------------------- //
// File groupmgr.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('GROUPMGR_PHP')) {
$lang_groupmgr_php['group_manager'] = 'Configuración de grupos'; // cpg1.5.x
$lang_groupmgr_php['group_name'] = 'Grupos';
$lang_groupmgr_php['permissions'] = 'Permisos';
$lang_groupmgr_php['public_albums'] = 'Añadir ficheros a álbumes públicos';
$lang_groupmgr_php['personal_gallery'] = 'Galería personal';
$lang_groupmgr_php['disk_quota'] = 'Cuota de disco';
$lang_groupmgr_php['rating'] = 'Valoración';
$lang_groupmgr_php['ecards'] = 'Postales';
$lang_groupmgr_php['comments'] = 'Comentarios';
$lang_groupmgr_php['allowed'] = 'Permitido';
$lang_groupmgr_php['approval'] = 'Aprobación';
$lang_groupmgr_php['create_new_group'] = 'Crear nuevo grupo';
$lang_groupmgr_php['del_groups'] = 'Borrar el/los grupo(s) seleccionado(s)';
$lang_groupmgr_php['confirm_del'] = '¡Atención, cuando borras un grupo, los usuarios que pertenecen a ese grupo serán transferidos al grupo \'Registered\'!\n\n¿Deseas continuar?'; // js-alert
$lang_groupmgr_php['title'] = 'Configurar grupos de usuarios';
$lang_groupmgr_php['reset_to_default'] = 'Regresar al nombre predeterminado (%s) - ¡recomendado!';
$lang_groupmgr_php['error_group_empty'] = '¡Tabla del grupo vacia!<br /><br />Grupos predeterminados creados, porfavor recargue esta página';
$lang_groupmgr_php['explain_greyed_out_title'] = '¿Porque esta fila está deshabilitada?';
$lang_groupmgr_php['explain_guests_greyed_out_text'] = 'No puedes cambiar las propiedades de este grupo porque su nivel de acceso es NINGUNA. Todos los usuarios que no se validen (miembros del grupo %s) no pueden hacer otra cosa que entrar; de modo que los ajustes de grupos no aplican en su caso. Cambia el nivel de acceso aquí o en la página de configuración de la galería en el apartado "Configuración de usuarios" -> "Permitir accesos de usuarios no validados".';
$lang_groupmgr_php['group_assigned_album'] = 'álbum(s) asignados';
$lang_groupmgr_php['access_level'] = 'Nivel de acceso'; // cpg1.5
$lang_groupmgr_php['thumbnail_intermediate_full'] = 'miniaturas, intermedias y tamaño completo'; // cpg1.5
$lang_groupmgr_php['thumbnail_intermediate'] = 'miniaturas e intermedias'; // cpg1.5
$lang_groupmgr_php['thumbnail_only'] = 'sólo miniaturas'; // cpg1.5
$lang_groupmgr_php['none'] = 'ningún archivo'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File index.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('INDEX_PHP'))
{
$lang_index_php['welcome'] = '¡Bienvenido!';
$lang_album_admin_menu['confirm_delete'] = '¿Estás seguro de querer BORRAR este album ? \\nSe borrarán también todos los archivos y comentarios.'; // js-alert
$lang_album_admin_menu['delete'] = 'Borrar';
$lang_album_admin_menu['modify'] = 'Propiedades';
$lang_album_admin_menu['edit_pics'] = 'Editar archivos';
$lang_album_admin_menu['cat_locked'] = 'Álbum bloqueado para modificar'; // cpg1.5.x
$lang_list_categories['home'] = 'Inicio';
$lang_list_categories['stat1'] = '[pictures] archivos en [albums] álbums y [cat] categorías con [comments] comentarios vistos [views] veces'; // do not translate the stuff in square brackets
$lang_list_categories['stat2'] = '[pictures] archivos en [albums] álbums vistos [views] veces'; // do not translate the stuff in square brackets
$lang_list_categories['xx_s_gallery'] = 'Galería de %s';
$lang_list_categories['stat3'] = '[pictures] archivos en[albums] álbums com [comments] comentarios vistos [views] veces'; // do not translate the stuff in square brackets
$lang_list_users['user_list'] = 'Lista de usuarios';
$lang_list_users['no_user_gal'] = 'No hay galerías de usuarios';
$lang_list_users['n_albums'] = '%s álbum(es)';
$lang_list_users['n_pics'] = '%s archivo(s)';
$lang_list_albums['n_pictures'] = '%s archivo(s)';
$lang_list_albums['last_added'] = ', último añadido el %s';
$lang_list_albums['n_link_pictures'] = '%s archivo(s) enlazado(s)';
$lang_list_albums['total_pictures'] = '%s archivo(s) en total';
$lang_list_albums['alb_hits'] = 'álbum visto %s veces'; // cpg1.5
$lang_list_albums['from_category'] = ' - desde la categoría: '; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File install.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('INSTALL_PHP')) {
$lang_install['already_succ'] = 'La instalación se ha ejecutado con éxito y ahora está bloqueada.';
$lang_install['already_succ_explain'] = 'Si quieres ejecutar de nuevo, primero debes borrar el fichero \'include/config.inc.php\' que se ha creado en el directorio de Coppermine. Puedes hacerlo con cualquier programa de FTP';
$lang_install['cant_read_tmp_conf'] = 'El instalador no puede leer el fichero temporal de configuración %s.';
$lang_install['cant_write_tmp_conf'] = 'El instalador no puede escribir el fichero temporal de configuración %s.';
$lang_install['review_permissions'] = 'Por favor revisa los permisos del directorio.';
$lang_install['change_lang'] = 'Cambiar idioma';
$lang_install['check_path'] = 'Comprueba la ruta';
$lang_install['continue'] = 'Siguiente paso';
$lang_install['conv_said'] = 'El programa de conversión dijo:';
$lang_install['license_info'] = 'Coppermine es un paquete de galería de imágenes y multimedia desarrollado bajo la licencia GNU GPL v3. Al instalarlo consientes los términos de licencia de Coppermine:';
$lang_install['cpg_info_frames'] = 'Tu navegador no es capaz de mostrar frames (marcos). Puedes revisar los términos de la licencia en el directorio de documentación dentro del paquete de Coppermine.';
$lang_install['license'] = 'Acuerdo de licencia de Coppermine';
$lang_install['create_table'] = 'Creando la tabla \'%s\'';
$lang_install['db_populating'] = 'Intentando insertar en la base de datos.';
$lang_install['db_alr_populated'] = 'Los datos necesarios ya están cargados en la base de datos.';
$lang_install['dir_ok'] = 'Directorio encontrado';
$lang_install['directory'] = 'Directorio';
$lang_install['email'] = 'Dirección de correo';
$lang_install['email_no_match'] = 'La direcciones de correo no son iguales o son no válidas.';
$lang_install['email_verif'] = 'Comprueba la dirección de correo';
$lang_install['err_cpgnuke'] = '<h1>ERROR</h1>Parece que estás intentando instalar en tu portal Nuke esta galería Coppermine que debe correr aislada (standalone).<br />¡Esta versión debe correr aislada (standalone)!<br />Algunas configuraciones de servidores muestran este aviso aunque no haya un portal Nuke instalado - si este es tu caso, <a href="%s?continue_anyway=1">continúa</a> con la instalación. Si estás usando un portal Nuke, quizá quieras echar un ojo a <a href=\"http://www.cpgnuke.com/\">CpgNuke</a> o usar una de los paquetes no soportados en <a href=\"http://sourceforge.net/project/showfiles.php?group_id=89658&amp;package_id=95984\">Coppermine ports</a> - ¡No continúes con esta instalación si es el caso!';
$lang_install['error'] = 'ERROR';
$lang_install['error_need_corr'] = 'Debes corregir antes los siguientes errores :';
$lang_install['finish'] = 'Terminar instalación';
$lang_install['gd_note'] = '<strong>Importante :</strong> las versiones antiguas de la librería gráfica GD soportan sólo imágenes JPEG y PNG. Si este es tu caso esta galería no podrá crear miniaturas para los ficheros GIF.';
$lang_install['go_to_main'] = 'Ir a la página principal';
$lang_install['im_no_convert_ex'] = 'La instalación encontró la utilidad \'convert\' de ImageMagick en \'%s\', pero no se puede ejecutar.<br />Deberías usar GD en lugar de ImageMagick.';
$lang_install['im_not_found'] = 'La instalación intentó encontrar ImageMagick, pero no se ha encontrado o ha habido un error. <br />Coppermine puede usar la utilidad \'convert\' de <a href="http://www.imagemagick.org/">ImageMagick</a> para crear las miniaturas. La calidad de las imágenes generadas por ImageMagick es superior a las de GD1 aunque equivelentes alas producidas por GD2.<br />Si ImageMagick está instalado en tu sistema y quieres usarlo<br />necesitas dar la ruta completa a la utilidad \'convert\'. <br />En Windows la ruta tendrá una forma parecida a \'c:/ImageMagick/\' y no debe tener espacios; en Unix será parecida a \'/usr/bin/\'.<br />Si no sabes si ImageMagick está instalado o no en el sistema deja este valor en blanco - la instalación intentará usar GD2 por defecto (que es lo que tiene la mayor parte de los usuarios). <br />También se puede cambiar más adelante (en la pantalla de configuración de Coppermine), así que no te preocupes si no sabes qué escribir en este campo - déjalo en blanco.';
$lang_install['im_packages'] = 'Tu sistema soporta el/los siguiente(s) paquete(s) gráficos';
$lang_install['im_path'] = 'Ruta de ImageMagick:';
$lang_install['im_path_space'] = 'La ruta de ImageMagick (\'%s\') tiene al menos un espacio. Esto causará problemas en el script.<br />Debes mover ImageMagick a otro directorio.';
$lang_install['installation'] = 'installación';
$lang_install['installer_locked'] = 'El instalador está bloqueado';
$lang_install['installer_selected'] = 'El instalador seleccionó';
$lang_install['inv_im_path'] = 'El instalador no encuentra el directorio \'%s\' que has puesto para ImageMagick o no tiene permisos de acceso a él. Comprueba que la ruta es correcta y/o que hay permisos de acceso al directorio.';
$lang_install['lets_go'] = '¡Adelante!';
$lang_install['mysql_create_btn'] = 'Crear';
$lang_install['mysql_create_db'] = 'Crear una base de datos MySQL nueva';
$lang_install['mysql_db_name'] = 'Nombre de la base de datos MySQL';
$lang_install['mysql_error'] = 'Error MySQL: ';
$lang_install['mysql_host'] = 'Servidor MySQL<br />(localhost normalmente)';
$lang_install['mysql_username'] = 'Usuario MySQL'; // cpg1.5
$lang_install['mysql_password'] = 'Contraseña MySQL'; // cpg1.5
$lang_install['mysql_no_create_db'] = 'No se pudo crear la base de datos MySQL.';
$lang_install['mysql_no_sel_dbs'] = 'No se ha podido sacar la lista de bases de datos MySQL disponibles';
$lang_install['mysql_succ'] = 'Conexión correcta con la base de datos';
$lang_install['mysql_tbl_pref'] = 'Prefijo de las tablas MySQL';
$lang_install['mysql_test_connection'] = 'Comprobar conexión';
$lang_install['mysql_wrong_db'] = 'MySQL no ha podido encontrar una base de datos llamada \'%s\'. Por favor, comprueba el nombre';
$lang_install['n_a'] = 'N/A';
$lang_install['no_admin_email'] = 'Debes introducir el correo de un administrador';
$lang_install['no_admin_password'] = 'Debes introducir la contraseña de un administrador';
$lang_install['no_admin_username'] = 'Debes introducir el nombre de un administrador';
$lang_install['no_dir'] = 'El directorio no está disponible';
$lang_install['no_gd'] = 'Tu instalación de PHP no parece tener la librería gráfica \'GD\' y no has indicado que quieras usar ImageMagick. Se ha configurado Coppermine para que use GD2 porque a veces falla la detección automática de GD. Si la librería GD está instalada todo debería funcionar, y en caso contrario necesitarás instalar ImageMagick.';
$lang_install['no_mysql_conn'] = 'No se ha podido crear una conexión a MySQL. Por favor, revisa los parámetros que indicaste';
$lang_install['no_mysql_support'] = 'PHP no está activado para usar MySQL.';
$lang_install['no_thumb_method'] = 'Debes elegir una aplicación de gestión de imágenes (GD/IM)';
$lang_install['nok'] = 'No correcto';
$lang_install['not_here_yet'] = 'No hay nada aquí aún, por favor pulsa %saquí%s para volver.';
$lang_install['ok'] = 'OK';
$lang_install['on_q'] = 'on query'; //jmatute : preguntar
$lang_install['or'] = 'o';
$lang_install['pass_err'] = 'Las contraseñas no son iguales, usaste caracteres no permitidos o nestá en blanco.';
$lang_install['password'] = 'Contraseña';
$lang_install['password_verif'] = 'Verificar contraseña';
$lang_install['perm_error'] = 'Los permisos de \'%s\' están establecidos para %s, por favor cámbialos a';
$lang_install['perm_ok'] = 'Los permisos de los directorios parecen estar correctos.<br />Continúa con el siguiente paso.';
$lang_install['perm_not_ok'] = 'Los permisos de los directorios no están bien.<br />Por favor cambia los permisos de los directorios con la etiqueta "No correcto".'; // cpg1.5
$lang_install['please_go_back'] = 'Por favor %spulsa aquí%s para volver y arreglar el problema antes de seguir.';
$lang_install['populate_db'] = 'Cargar la base de datos';
$lang_install['ready_to_roll'] = '<a href="index.php">Coppermine</a> está configurado y preparado para su uso..<br /><a href="login.php">Accede</a> con las credenciales que proporcionaste para administrar.';
$lang_install['sect_create_adm'] = 'Esta sección necesita información para crear la cuenta de administrador de Coppermine. Usa caracteres alfanuméricos únicamente. ¡Escribe con cuidado!';
$lang_install['sect_mysql_info'] = 'Esta sección necesita información sobre cómo acceder a la base de datos MySQL.<br />Si no conoces los detalles consulta con el soporte de tu servidor web.';
$lang_install['sect_mysql_sel_db'] = 'Tienes que elegir qué base de datos usar para Coppermine.<br />Puedes crear una base de datos nueva durente el proceso de instalación si tu cuenta MySQL tiene los privilegios necesarios, o puedes usar una que ya exista. Si no te gusta ninguna de las opciones, tendrás que crear una base de datos desde fuera del instalador de Coppermine, y después volver aquí para seleccionar esa nueva base de datos de la lista más abajo. También puedes cambier el prefijo de las tablas (no uses puntos en él), pero se recomienda mantener el de por defecto.';
$lang_install['select_lang'] = 'Selecciona el idioma por defecto: ';
$lang_install['sql_file_not_found'] = 'No se ha encontrado el fichero \'%s\'. Comprueba que has subido todos los ficheros de Coppermine al servidor.';
$lang_install['status'] = 'Estado';
$lang_install['subdir_called'] = 'El subdirectorio \'%s\' debería estar dentro del directorio en el que has subido Coppermine.<br />El instalador no puede encontrarlo. Comprueba que has subido todos los ficheros de Coppermine al servidor.';
$lang_install['title_admin'] = 'Crear la cuenta de administración de Coppermine';
$lang_install['title_dir_check'] = 'Comprobando los permisos de los directorios';
$lang_install['title_file_check'] = 'Comprobando los ficheros de la instalación';
$lang_install['title_finished'] = 'Instalación terminada';
$lang_install['title_imp'] = 'Selección del paquete de imágenes';
$lang_install['title_imp_test'] = 'Comprobando la librería de imágenes';
$lang_install['title_mysql_db_sel'] = 'Selección de la base de datos MySQL';
$lang_install['title_mysql_pop'] = 'Creando la estructura de la base de datos';
$lang_install['title_mysql_user'] = 'Verificación de usuario MySQL';
$lang_install['title_welcome'] = 'Bienvenido a la instalación de Coppermine';
$lang_install['tmp_conf_error'] = 'No se ha podido escribir el fichero temporal de configuración - comprueba que el directorio \'include\' tiene los permisos de escritura adecuados.';
$lang_install['tmp_conf_ser_err'] = 'Ha ocurrido un error grave durante la instalación. Intenta recargar la página o volver al principio de la instalación borrando el fichero \'include/config.tmp\'.';
$lang_install['try_again'] = '¡Inténtalo otra vez!';
$lang_install['unable_write_config'] = 'No se ha podido escribir el fichero de configuración';
$lang_install['user_err'] = 'El nombre del usuario administrador no puede estar vacío y sólo puede tener caracteres alfanuméricos.';
$lang_install['username'] = 'Usuario';
$lang_install['your_admin_account'] = 'Tu cuenta de administrador';
$lang_install['no_cookie'] = 'Tu navegador no acepta cookies. Es recomendable aceptarlas.';
$lang_install['no_javascript'] = 'Tu navegador parece tener Javascript desactivado - Es muy recomendable activarlo.';
$lang_install['register_globals_detected'] = 'Parece que tu configuración de PHP tiene la opción \'register_globals\' activada - deberías desactivarla por razonde de seguridad.';
$lang_install['more'] = 'más';
$lang_install['version_undetected'] = 'No se ha podido determinar qué versión de %s hay en tu servidor. Asegúrate de que es al menos la versión %s.';
$lang_install['version_incompatible'] = 'El script ha encontrado la versión (%s) de %s en tu servidor, que es incompatible.<br />¡Asegúrate de usar una versión compatible (%s o más nueva) antes de seguir!';
$lang_install['read_gif'] = 'Leer/escribir ficheros .gif';
$lang_install['read_png'] = 'Leer/escribir ficheros .png';
$lang_install['read_jpg'] = 'Leer/escribir ficheros .jpg';
$lang_install['write_error'] = 'No se ha podido guardar la imagen generada en el disco.';
$lang_install['read_error'] = 'No se ha podido leer la imagen de origen.';
$lang_install['combine_error'] = 'No se han podido combinar las imágenes de origen';
$lang_install['text_error'] = 'No se ha podido añadir texto a la imagen de origen';
$lang_install['scale_error'] = 'No se ha podido reescalar la imagen de origen';
$lang_install['pixels'] = 'pixels';
$lang_install['combine'] = 'Combinar dos imágenes';
$lang_install['text'] = 'Escribir texto en una imágen';
$lang_install['scale'] = 'Reescalar una imagen';
$lang_install['generated_image'] = 'Imagen generada';
$lang_install['reference_image'] = 'Imagen de referencia';
$lang_install['imp_test_error'] = 'Hay errores en una o más comprobaciones. ¡Asegúrate que has elegido la librería de proceso de imágenes apropiada y que está configurada correctamente!';
$lang_install['writable'] = 'Se puede escribir';
$lang_install['not_writable'] = 'No se puede escribir';
$lang_install['not_exist'] = 'No existe';
$lang_install['old_install'] = 'Este es el nuevo asistente de instalación. %sPulsa aquí%s si prefieres la pantalla de instalación clásica.'; //cpg1.5
}

// ------------------------------------------------------------------------- //
// File keywordmgr.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('KEYWORDMGR_PHP')) {
$lang_keywordmgr_php['title'] = 'Gestionar palabras clave';
$lang_keywordmgr_php['search'] = 'Buscar';
$lang_keywordmgr_php['keyword_test_search'] = 'Buscar %s en una ventana nueva';
$lang_keywordmgr_php['keyword_del'] = 'Borrar la palabra clave %s';
$lang_keywordmgr_php['confirm_delete'] = 'Estás seguro de querer borrar la palabra clave %s de TODA la galería?'; // js-alert
$lang_keywordmgr_php['change_keyword'] = 'Cambiar palabra clave';
}

// ------------------------------------------------------------------------- //
// File langmgr.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('LANGMGR_PHP')) {
$lang_langmgr_php['title'] = 'Gestor de idiomas';
$lang_langmgr_php['english_language_name'] = 'Inglés';
$lang_langmgr_php['native_language_name'] = 'Nativo';
$lang_langmgr_php['custom_language_name'] = 'Modificado';
$lang_langmgr_php['language_name'] = 'Nombre del idioma';
$lang_langmgr_php['language_file'] = 'Fichero del idioma';
$lang_langmgr_php['flag'] = 'Bandera';
$lang_langmgr_php['file_available'] = 'Disponible';
$lang_langmgr_php['enabled'] = 'Activo';
$lang_langmgr_php['complete'] = 'Completo';
$lang_langmgr_php['default'] = 'Por defecto';
$lang_langmgr_php['missing'] = 'no encontrado';
$lang_langmgr_php['broken'] = 'parece estar roto o inaccesible';
$lang_langmgr_php['exists_in_db_and_file'] = 'existe en la base de datos y en fichero';
$lang_langmgr_php['exists_as_file_only'] = 'sólo existe como fichero';
$lang_langmgr_php['pick_a_flag'] = 'Elige uno';
$lang_langmgr_php['replace_x_with_y'] = 'Reemplazar %s por %s';
$lang_langmgr_php['tanslator_information'] = 'Información del traductor';
$lang_langmgr_php['cpg_version'] = 'Versión Coppermine';
$lang_langmgr_php['hide_details'] = 'Ocultar detalles';
$lang_langmgr_php['show_details'] = 'Mostrar detalles';
$lang_langmgr_php['loading'] = 'Cargando';
$lang_langmgr_php['english_missing'] = 'El fichero de idioma inglés no está accesible aunque no se debe borrar nunca. Es necesario reponerlo inmediatamente.';
$lang_langmgr_php['enable_at_least_one'] = 'Necesitas habilitar al menos un idioma para que funcione la galería';
$lang_langmgr_php['enable_default'] = 'Has elegido un idioma que no está habilitado. ¡Elige otro idioma por defecto o habilita el idioma que has elegido por defecto!';
$lang_langmgr_php['available_default'] = 'Has elegido un idioma que ni siquiera está disponible. ¡Elige otro idioma por defecto!';
$lang_langmgr_php['version_does_not_match'] = 'La versión de este fichero no corresponde con la de Coppermine. Úsalo con cuidado y pruébalo exhaustivamente!';
$lang_langmgr_php['no_version'] = 'No se pudo recuperar infomación de versión. Es muy posible que este fichero de lenguaje no funcione o que no sea un fichero de lenguaje.';
$lang_langmgr_php['filesize'] = 'El tamaño del fichero (%s) es inverosímil';
$lang_langmgr_php['content_missing'] = 'No parece que el fichero contenga la información necesaria, así que probablemente no sea válido.';
$lang_langmgr_php['status'] = 'Estado';
$lang_langmgr_php['default_language'] = '%s elegido como idioma por defecto';
}

// ------------------------------------------------------------------------- //
// File login.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('LOGIN_PHP')) {
$lang_login_php['login'] = 'Acceder';
$lang_login_php['enter_login_pswd'] = 'Introduce tu usuario y contraseña para acceder';
$lang_login_php['username'] = 'Usuario';
$lang_login_php['email'] = 'Correo'; // cpg1.5
$lang_login_php['both'] = 'Usuario / Correo'; // cpg1.5
$lang_login_php['password'] = 'Contraseña';
$lang_login_php['remember_me'] = 'Recordarme';
$lang_login_php['welcome'] = 'Bienvenido %s ...';
$lang_login_php['err_login'] = 'Acceso fallido. Inténtalo de nuevo.';
$lang_login_php['err_already_logged_in'] = '¡Ya estaba validado en el sistema!';
$lang_login_php['forgot_password_link'] = 'Olvidé mi contraseña';
$lang_login_php['cookie_warning'] = 'Aviso: tu navegador no acepta las cookies';
$lang_login_php['send_activation_link'] = '¿Perdiste el enlace de la activación?';
$lang_login_php['force_login'] = 'Debes acceder para ver esta página'; // cpg1.5
$lang_login_php['force_login_title'] = 'Accede para continuar'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File logout.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('LOGOUT_PHP')) {
$lang_logout_php['logout'] = 'Salir';
$lang_logout_php['bye'] = 'Hasta luego, %s ...';
$lang_logout_php['err_not_logged_in'] = '¡No está validado en el sistema!'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File minibrowser.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('MINIBROWSER_PHP')) {
$lang_minibrowser_php['up'] = 'Arriba un nivel';
$lang_minibrowser_php['current_path'] = 'ruta actual';
$lang_minibrowser_php['select_directory'] = 'Elige un directorio, por favor';
$lang_minibrowser_php['click_to_close'] = 'Pulsa en una imagen para cerrar esta ventana';
$lang_minibrowser_php['folder'] = 'Carpeta'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File mode.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('MODE_PHP')) {
$lang_mode_php[0] = 'Ocultando los controles de administración...'; // cpg1.5
$lang_mode_php[1] = 'Mostrando los controles de administración...'; // cpg1.5
$lang_mode_php['news_hide'] = 'Ocultando novedades...'; // cpg1.5
$lang_mode_php['news_show'] = 'Mostrando novedades...'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File modifyalb.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('MODIFYALB_PHP')) {
$lang_modifyalb_php['upd_alb_n'] = 'Actualizar el álbum %s';
$lang_modifyalb_php['related_tasks'] = 'Otras acciones relacionadas'; // cpg1.5
$lang_modifyalb_php['choose_album'] = 'Escoge el álbum'; // cpg1.5
$lang_modifyalb_php['general_settings'] = 'Configuración general';
$lang_modifyalb_php['alb_title'] = 'Título del álbum';
$lang_modifyalb_php['alb_cat'] = 'Categoría del álbum';
$lang_modifyalb_php['alb_desc'] = 'Descripción del álbum';
$lang_modifyalb_php['alb_keyword'] = 'Palabras clave del álbum';
$lang_modifyalb_php['alb_thumb'] = 'Miniatura del álbum';
$lang_modifyalb_php['alb_perm'] = 'Permisos para este álbum';
$lang_modifyalb_php['can_view'] = 'Este álbum puede ser visto por';
$lang_modifyalb_php['can_upload'] = 'Los visitantes pueden añadir archivos';
$lang_modifyalb_php['can_post_comments'] = 'Los visitantes pueden añadir comentarios';
$lang_modifyalb_php['can_rate'] = 'Los visitantes pueden valorar los archivos';
$lang_modifyalb_php['user_gal'] = 'Galería del usuario';
$lang_modifyalb_php['my_gal'] = '* Mi galería *'; // cpg 1.5
$lang_modifyalb_php['no_cat'] = '* Sin categoría *';
$lang_modifyalb_php['alb_empty'] = 'El álbum está vacío';
$lang_modifyalb_php['last_uploaded'] = 'Últimos subidos';
$lang_modifyalb_php['public_alb'] = 'Todo el mundo (álbum púbilco)';
$lang_modifyalb_php['me_only'] = 'Sólo yo';
$lang_modifyalb_php['owner_only'] = 'Sólo el dueño del álbum (%s)';
$lang_modifyalb_php['group_only'] = 'Miembros del grupo \'%s\'';
$lang_modifyalb_php['err_no_alb_to_modify'] = 'No puedes modificar álbumes.';
$lang_modifyalb_php['update'] = 'Actualizar el álbum';
$lang_modifyalb_php['reset_album'] = 'Resetear el álbum';
$lang_modifyalb_php['reset_views'] = 'Poner los contadores a &quot;0&quot; en %s';
$lang_modifyalb_php['reset_rating'] = 'Poner a cero las votaciones de todos los ficheros en %s';
$lang_modifyalb_php['delete_comments'] = 'Borrar todos los comentaios en %s';
$lang_modifyalb_php['delete_files'] = '%sIrreversible:%s Borrar todos los ficheros de %s';
$lang_modifyalb_php['views'] = 'vistas';
$lang_modifyalb_php['votes'] = 'votos';
$lang_modifyalb_php['comments'] = 'comentarios';
$lang_modifyalb_php['files'] = 'archivos';
$lang_modifyalb_php['submit_reset'] = 'Grabar cambios';
$lang_modifyalb_php['reset_views_confirm'] = 'Estoy seguro';
$lang_modifyalb_php['notice1'] = '(*) dependiendo de la configuración de %sgrupos%s'; // do not translate the %s placeholders
$lang_modifyalb_php['can_moderate'] = 'El álbum podrá ser moderado por'; // cpg 1.5
$lang_modifyalb_php['admins_only'] = 'sólo los administradores'; // cpg 1.5
$lang_modifyalb_php['alb_password'] = 'Contraseña del álbum (Nueva)';
$lang_modifyalb_php['alb_password_hint'] = 'Recordatorio de contraseña del álbum';
$lang_modifyalb_php['edit_files'] = 'Editar ficheros';
$lang_modifyalb_php['parent_category'] = 'Categoría padre';
$lang_modifyalb_php['thumbnail_view'] = 'Vista de miniaturas';
$lang_modifyalb_php['random_image'] = 'Imagen al azar'; // cpg 1.5
$lang_modifyalb_php['password_protect'] = 'Proteger este álbum con contraseña (marcar para \'si\')'; //cpg1.5
}

// ------------------------------------------------------------------------- //
// File phpinfo.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('PHPINFO_PHP')) {
$lang_phpinfo_php['php_info'] = 'PHP info';
$lang_phpinfo_php['explanation'] = 'Esto es lo que la función <a href="http://www.php.net/phpinfo">phpinfo()</a> muestra, utilizando Coppermine.';
$lang_phpinfo_php['no_link'] = 'Que otros puedan ver tu información de PHP es un riesgo de seguridad, por eso esta pagina solo es visible si has iniciado sesión como administrador. No puedes publicar un link a esta pagina para los demás, ellos tendrán un acceso denegado.';
}

// ------------------------------------------------------------------------- //
// File picmgr.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('PICMGR_PHP')) {
$lang_picmgr_php['pic_mgr'] = 'Administrador de imágenes';
$lang_picmgr_php['confirm_modifs'] = '¿Estás seguro que deseas aplicar las modificaciones a la imagen?'; // cpg1.5 // js-alert
$lang_picmgr_php['no_change'] = '¡No has hecho ningún cambio!';
$lang_picmgr_php['no_album'] = '* No álbum *';
$lang_picmgr_php['explanation_header'] = 'El Ordenamiento personalizado que puede especificar en esta pagina solo será tomado en cuenta si ';
$lang_picmgr_php['explanation1'] = 'el administrador ha marcado la opción "Orden predeterminado de archivos" en la configuración a "Descendente" or "Ascendente" (configuración global para todos los usuarios que no han escogido otra opción)';
$lang_picmgr_php['explanation2'] = 'el usuario ha escogido "Descendente" or "Ascendente" en la pagina de vistas en miniatura (por configuración de usuario)';
$lang_picmgr_php['change_album'] = '¡Si cambias el álbum se perderán los cambios!'; // cpg1.5 // js-alert
$lang_picmgr_php['submit_reminder'] = 'Los cambios en la ordenación no se guardan hasta que no pulsas &quot;Aplicar cambios&quot;.'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File pluginmgr.php // Traducida 20100503
// ------------------------------------------------------------------------- //
if (defined('PLUGINMGR_PHP'))
{
$lang_pluginmgr_php['confirm_uninstall'] = '¿Estás seguro de querer DESINSTALAR este plugin?';
$lang_pluginmgr_php['confirm_remove'] = 'NOTA: el API de Plugins está desactivado. ¿Quieres QUTAR MANUALMENTE este plugin, ignorando las posibles acciones de limpieza posteriores?'; // cpg1.5
$lang_pluginmgr_php['confirm_delete'] = '¿Estás seguro de querer BORRAR este plugin?';
$lang_pluginmgr_php['pmgr'] = 'Gestor de Plugin';
$lang_pluginmgr_php['explanation'] = 'Instalar / desinstalar / gestionar plugins con esta página.'; // cpg1.5
$lang_pluginmgr_php['plugin_enabled'] = 'API de Plugins activado'; // cpg1.5
$lang_pluginmgr_php['name'] = 'Nombre';
$lang_pluginmgr_php['author'] = 'Autor';
$lang_pluginmgr_php['desc'] = 'Descripción';
$lang_pluginmgr_php['vers'] = 'v';
$lang_pluginmgr_php['i_plugins'] = 'Plugins instalados';
$lang_pluginmgr_php['n_plugins'] = 'Plugins no instalados';
$lang_pluginmgr_php['none_installed'] = 'Ninguno está instalado';
$lang_pluginmgr_php['operation'] = 'Operación';
$lang_pluginmgr_php['not_plugin_package'] = 'El fichero que has subido no es un paquete de plugins.';
$lang_pluginmgr_php['copy_error'] = 'Se ha producido un error al copiar el paquete al directorio de plugins.';
$lang_pluginmgr_php['upload'] = 'Subir';
$lang_pluginmgr_php['configure_plugin'] = 'Configurar el plugin';
$lang_pluginmgr_php['cleanup_plugin'] = 'Limpiar el plugin';
$lang_pluginmgr_php['extra'] = 'Extra'; // cpg1.5
$lang_pluginmgr_php['install_info'] = 'Información de instalación'; // cpg1.5
$lang_pluginmgr_php['plugin_disabled_note'] = 'El API de Plugins está desactivado, así que no se permite esa operación.'; // cpg1.5
$lang_pluginmgr_php['install'] = 'instalar'; // cpg1.5
$lang_pluginmgr_php['uninstall'] = 'desinstalar'; // cpg1.5
$lang_pluginmgr_php['minimum_requirements_not_met'] = 'No se cumplen los requisitos mínimos'; // cpg1.5
$lang_pluginmgr_php['confirm_version'] = 'No se han podido determinar los requisitos de versión para este plugin. Normalmente eso indica que el plugin no se diseñó para esta versión de Coppermine y por tanto podría estropear tu galería. ¿Seguir de todos modos (no recomendable)?'; // cpg1.5 // js-alert
}

// ------------------------------------------------------------------------- //
// File ratepic.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('RATEPIC_PHP')) {
$lang_rate_pic_php['already_rated'] = 'Lo iento, pero ya has votado este fichero';
$lang_rate_pic_php['rate_ok'] = 'Voto aceptado';
$lang_rate_pic_php['forbidden'] = 'No puedes votar tus propios ficheros.';
}

// ------------------------------------------------------------------------- //
// File register.php & profile.php
// ------------------------------------------------------------------------- //
if (defined('REGISTER_PHP') || defined('PROFILE_PHP')) {
$lang_register_php['disclamer'] = <<< EOT
Si bien los administradores de {SITE_NAME} intentarán quitar o editar el material susceptible de no ser apropiado tan rápido como sea posible, es casi imposible revisar cada entrada. Por tanto reconoces que las entradas en este sitio expresan el punto de vista del autor y no del administrador o webmaster (excepto las entradas que hagan en su propio nombre) y por tanto no son responsables de su contenido.<br />
<br />
Usted acuerda no añadir ningún material abusivo, obsceno, vulgar, escandaloso, odioso, amenazador, de orientación sexual, o ningún otro que pueda violar cualquier ley aplicable. Usted está de acuerdo con que el webmaster, el administrador, los moderadores y los asesores de {SITE_NAME} tienen el derecho de quitar o de corregir cualquier contenido en cualquier momento si lo consideran necesario. Como usuario, accede a que cualquier información añadida será almacenada en una base de datos. Asi mismo, esta informaciÃ³n no serÃ¡ divulgada a terceros sin su consentimiento. El webmaster y el administrador no se pueden hacer responsables de ningún intento de destrucción de la base de datos que pueda conducir a la pérdida de la misma.<br />
<br />
Este sitio utiliza cookies para almacenar la información en su ordenador. Estas cookies sirven para mejorar la navegación en este sitio. La dirección de email se utiliza solamente para confirmar sus detalles y contraseña del registro.<br />
<br />
Pulsando 'estoy de acuerdo' expresas tu conformidad con estas condiciones.
EOT;
$lang_register_php['page_title'] = 'Registro de nuevo usuario';
$lang_register_php['term_cond'] = 'Términos y condiciones';
$lang_register_php['i_agree'] = 'estoy de acuerdo';
$lang_register_php['submit'] = 'Enviar solicitud de registro';
$lang_register_php['err_user_exists'] = 'El nombre de usuario elegido ya existe. Por favor elige otro diferente';
$lang_register_php['err_global_pw'] = 'Contraseña global no válida'; // cpg1.5
$lang_register_php['err_global_pass_same'] = 'La contraseña debría ser ferente de la global'; // cpg1.5
$lang_register_php['err_duplicate_email'] = 'Otro usuario se ha registrado anteriormente con esa dirección de correo';
$lang_register_php['err_disclaimer'] = 'Tienes que aceptar las condiciones de renuncia de responsabilidad (disclaimer) antes'; // cpg1.5
$lang_register_php['enter_info'] = 'Entrada de información de registro';
$lang_register_php['required_info'] = 'Información necesaria';
$lang_register_php['optional_info'] = 'Información opcional';
$lang_register_php['username'] = 'Usuario';
$lang_register_php['password'] = 'Contraseña';
$lang_register_php['password_again'] = 'Repite la contraseña';
$lang_register_php['global_registration_pw'] = 'Contraseña global'; // cpg1.5
$lang_register_php['email'] = 'Correo';
$lang_register_php['location'] = 'Ubicación';
$lang_register_php['interests'] = 'Intereses';
$lang_register_php['website'] = 'Página web';
$lang_register_php['occupation'] = 'Ocupación';
$lang_register_php['error'] = 'ERROR';
$lang_register_php['confirm_email_subject'] = '%s - ';
$lang_register_php['information'] = 'Información';
$lang_register_php['failed_sending_email'] = '¡No se ha podido enviar el correo de confirmación de registro!';
$lang_register_php['thank_you'] = 'Gracias por registrarse.<br />Te hemos enviado un correo con la información para activar tu cuenta a la dirección que has proporcionado.';
$lang_register_php['acct_created'] = 'Hemos creado tu cuenta y ahora puedes validarte con tu usuario y tu contraseña';
$lang_register_php['acct_active'] = 'Hemos activado tu cuenta y ya puedes validarte con tu usuario y tu contraseña';
$lang_register_php['acct_already_act'] = '¡La cuenta ya estaba activa!';
$lang_register_php['acct_act_failed'] = '¡No se puede activar esta cuenta!';
$lang_register_php['err_unk_user'] = '¡No existe el usuario seleccionado!';
$lang_register_php['x_s_profile'] = 'Perfil de %s';
$lang_register_php['group'] = 'Grupo';
$lang_register_php['reg_date'] = 'Registrado en ';
$lang_register_php['disk_usage'] = 'Uso de disco';
$lang_register_php['change_pass'] = 'Cambiar contraseña';
$lang_register_php['current_pass'] = 'Contraseña actual';
$lang_register_php['new_pass'] = 'Contraseña nueva';
$lang_register_php['new_pass_again'] = 'Reescribir la contraseña nueva';
$lang_register_php['err_curr_pass'] = 'La contraseña actual es incorrecta';
$lang_register_php['change_pass'] = 'Cambiar mi contraseña';
$lang_register_php['update_success'] = 'El perfil se ha actualizado';
$lang_register_php['pass_chg_success'] = 'Se ha cambiado la contraseña';
$lang_register_php['pass_chg_error'] = 'No se ha cambiado la contraseña';
$lang_register_php['notify_admin_email_subject'] = '%s - Notificación de registro';
$lang_register_php['last_uploads'] = 'Último fichero subido'; // cpg1.5
$lang_register_php['last_uploads_detail'] = 'Pulsa para ver todos los ficheros subidos por %s'; // cpg1.5
$lang_register_php['last_comments'] = 'Último comentario'; // cpg1.5
$lang_register_php['you'] = 'tí'; // cpg1.5
$lang_register_php['last_comments_detail'] = 'Pulsa para ver todos los comentarios hechos por %s'; // cpg1.5
$lang_register_php['notify_admin_email_body'] = 'Se ha registrado un nuevo usuario con el nombre "%s" en tu galería';
$lang_register_php['pic_count'] = 'ficheros subidos';
$lang_register_php['notify_admin_request_email_subject'] = '%s - Solicitud de registro';
$lang_register_php['thank_you_admin_activation'] = 'Gracias.<br />Tu solicitud de activación de la cuenta se ha enviado al administrador. Recibirás un correo cuand se apruebe.';
$lang_register_php['acct_active_admin_activation'] = 'La cuenta está activa y se ha enviado un correo al usuario.';
$lang_register_php['notify_user_email_subject'] = '%s - Notificación de activación';
$lang_register_php['delete_my_account'] = 'Borrar mi cuenta de usuario'; // cpg1.5
$lang_register_php['warning_delete'] = 'Aviso: No se puede deshacer el borrado de la cuenta. Los %sficheros que cargaste%s en los álbumes públicos y %stus comentarios%s no se eliminan al borrar la cuenta. Sin embargo sí se borrarán los ficheros que cargaste en tu galería personal.'; // cpg1.5 // The %s-placeholders mustn't be removed, they will later be replaced by the wrappers for the links
$lang_register_php['i_am_sure'] = 'Estoy seguro de quere borrar mi cuenta de usuario'; // cpg1.5
$lang_register_php['really_delete'] = '¿Realmente quieres borrar tu cuenta?'; // cpg1.5 // js-alert
$lang_register_php['edit_xs_profile'] = 'Editrar el perfil de %s'; // cpg1.5
$lang_register_php['edit_my_profile'] = 'Editar mi perfil'; // cpg1.5
$lang_register_php['none'] = 'ninguno'; // cpg1.5
$lang_register_php['user_name_banned'] = 'El usuario seleccionado no tiene permisos o está expulsado. Escoge otro nombre de usuario'; // cpg1.5
$lang_register_php['email_address_banned'] = 'Estás expulsado de la galería, y no se te permite volver a registrarte. ¡Largo!'; // cpg1.5
$lang_register_php['email_warning1'] = '¡El campo del correo no puede quedar vacío!'; // cpg1.5
$lang_register_php['email_warning2'] = 'Dirección de correo no válida. Revísala'; // cpg1.5
$lang_register_php['username_warning1'] = '¡El nombre de usuario no puede quedar vacío!'; // cpg1.5
$lang_register_php['username_warning2'] = '¡El nombre de usuario debe tener al menos dos caracteres!'; // cpg1.5
$lang_register_php['password_warning1'] = '¡La contraseña debe tener al menos dos caracteres!'; // cpg1.5
$lang_register_php['password_warning2'] = '¡El nombre de usuario y la contraseña han de ser diferentes!'; // cpg1.5
$lang_register_php['password_verification_warning1'] = 'Las dos contraseñas no son iguales. Tecléalas de nuevo'; // cpg1.5
$lang_register_php['form_not_submit'] = 'No se ha enviado la solicitud - hay errores que corregir'; // cpg1.5
$lang_register_php['banned'] = '¡Expulsado!'; // cpg1.5


$lang_register_php['confirm_email'] = <<< EOT
Gracias por registrarte en {SITE_NAME}

Tu nombre de usuario es: "{USER_NAME}"

Para terminar de activar tu cuenta, debes pulsar sobre el enlace que aparece debajo, o copialo y pégalo en tu navegador de InterNet.

<a href="{ACT_LINK}">{ACT_LINK}</a>

Saludos.

Los administradores de {SITE_NAME}

EOT;

$lang_register_approve_email = <<< EOT
Se ha registrado un nuevo usuario de nombre "{USER_NAME}" en tu galería.
Para terminar de activar la cuenta, debes pulsar sobre el enlace que aparece debajo, o copialo y pégalo en tu navegador de InterNet.

<a href="{ACT_LINK}">{ACT_LINK}</a>

EOT;

$lang_register_php['activated_email'] = <<< EOT
Se ha aprobado y activado tu cuenta.

Ya te puedes validar en <a href="{SITE_LINK}">{SITE_LINK}</a> como el usuario "{USER_NAME}"


Saludos.

Los administradores de {SITE_NAME}

EOT;
}

// ------------------------------------------------------------------------- //
// File reviewcom.php  // Traducida 20100503
// ------------------------------------------------------------------------- //
if (defined('REVIEWCOM_PHP')) {
$lang_reviewcom_php['title'] = 'Revisar comentarios';
$lang_reviewcom_php['no_comment'] = 'No hay comentarios que revisar';
$lang_reviewcom_php['n_comm_del'] = '%s comentario(s) borrado(s)';
$lang_reviewcom_php['n_comm_disp'] = 'Número de comentarios a mostrar';
$lang_reviewcom_php['see_prev'] = 'Ver el anterior';
$lang_reviewcom_php['see_next'] = 'Ver el siguiente';
$lang_reviewcom_php['del_comm'] = 'Borrar los comentarios seleccionados';
$lang_reviewcom_php['user_name'] = 'Nombre';
$lang_reviewcom_php['date'] = 'Fecha';
$lang_reviewcom_php['comment'] = 'Comentario';
$lang_reviewcom_php['file'] = 'Archivo';
$lang_reviewcom_php['name_a'] = 'Nombre de usuario ascendente';
$lang_reviewcom_php['name_d'] = 'Nombre de usuario descendente';
$lang_reviewcom_php['date_a'] = 'Fecha ascendente';
$lang_reviewcom_php['date_d'] = 'Fecha descendente';
$lang_reviewcom_php['comment_a'] = 'Comentario ascendente';
$lang_reviewcom_php['comment_d'] = 'Comentario descendente';
$lang_reviewcom_php['file_a'] = 'Archivo ascendente';
$lang_reviewcom_php['file_d'] = 'Archivo descendente';
$lang_reviewcom_php['approval_a'] = 'Aprobación ascendente'; // cpg1.5
$lang_reviewcom_php['approval_d'] = 'Aprobación descendente'; // cpg1.5
$lang_reviewcom_php['ip_a'] = 'Dirección IP ascendente'; // cpg1.5
$lang_reviewcom_php['ip_d'] = 'Dirección IP descendente'; // cpg1.5
$lang_reviewcom_php['akismet_a'] = 'Valoración Akismet (comentarios válidos al final)'; // cpg1.5
$lang_reviewcom_php['akismet_d'] = 'Valoración Akismet (comentarios válidos al principio)'; // cpg1.5
$lang_reviewcom_php['n_comm_appr'] = '%s comentario(s) aprobado(s)'; // cpg1.5
$lang_reviewcom_php['n_comm_unappr'] = '%s comentario(s) no aprobado(s)'; // cpg1.5
$lang_reviewcom_php['configuration_changed'] = 'Cambiada la configuración de aprobaciones'; // cpg1.5
$lang_reviewcom_php['only_approval'] = 'mostrando sólo los comentarios pendientes de aprobación'; // cpg1.5
$lang_reviewcom_php['approval'] = 'Aprobado'; // cpg1.5
$lang_reviewcom_php['save_changes'] = 'Guardar cambios'; // cpg1.5
$lang_reviewcom_php['n_confirm_delete'] = '¿De verdad quieres borrar los comentarios(s) seleccionado(s)?'; // cpg1.5
$lang_reviewcom_php['with_selected'] = 'Acción en los seleccionados:'; // cpg1.5
$lang_reviewcom_php['delete'] = 'borrar'; // cpg1.5
$lang_reviewcom_php['approve'] = 'aprobar'; // cpg1.5
$lang_reviewcom_php['disapprove'] = 'desaprobar'; // cpg1.5
$lang_reviewcom_php['do_nothing'] = 'no hacer nada'; // cpg1.5
$lang_reviewcom_php['comment_approved'] = 'Comentario aprobado'; // cpg1.5
$lang_reviewcom_php['comment_unapproved'] = 'Comentario no aprobado'; // cpg1.5
$lang_reviewcom_php['ban_and_delete'] = 'Expulsar al usuario y borrar comentario'; // cpg1.5
$lang_reviewcom_php['akismet_status'] = 'Akismet dijo'; // cpg1.5
$lang_reviewcom_php['is_spam'] = 'es spam'; // cpg1.5
$lang_reviewcom_php['is_not_spam'] = 'no es spam'; // cpg1.5
$lang_reviewcom_php['akismet'] = 'Akismet'; // cpg1.5
$lang_reviewcom_php['akismet_count'] = 'Akismet ha encontrado %s mensajes de spam por ahora'; // cpg1.5
$lang_reviewcom_php['akismet_test_result'] = 'Resultado de la clave Akismet API %s'; // cpg1.5
$lang_reviewcom_php['invalid'] = 'inválido'; // cpg1.5
$lang_reviewcom_php['missing_gallery_url'] = 'Debes proporcionar la URL de una gallería en la configuración de Coppermine'; // cpg1.5
$lang_reviewcom_php['unable_to_connect'] = 'Incapaz de conectar con akismet.com'; // cpg1.5
$lang_reviewcom_php['not_found'] = 'No se encuentra la URL de destino. Puede que haya cambiado la estructura del sitio de akismet.com.'; // cpg1.5
$lang_reviewcom_php['unknown_error'] = 'Error desconocido'; // cpg1.5
$lang_reviewcom_php['error_message'] = 'El mensaje de error devuelto es'; // cpg1.5
$lang_reviewcom_php['ip_address'] = 'Dirección IP'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File sidebar.php // Traducida 20100503
// ------------------------------------------------------------------------- //
if (defined('SIDEBAR_PHP')) {
$lang_sidebar_php['sidebar'] = 'Barra lateral'; // cpg1.5
$lang_sidebar_php['install'] = 'instalar'; // cpg1.5
$lang_sidebar_php['install_explain'] = 'Entre los varios métodos inteligentes de acceder rápidamente al contenido del sitio hay barras laterales para los navegadores más populares sobre varios sistemas operativos para llegar a las páginas más rápidamente. Aquí tiene la información necesaria para instalar (y desinstalar) para los navegadores soportados.'; // cpg1.5
$lang_sidebar_php['os_browser_detect'] = 'Detectando el sistema operativo y el navegador'; // cpg1.5
$lang_sidebar_php['os_browser_detect_explain'] = 'Estamos intentando detectar automáticamente el sistema operativo y el navegador que usas - un momento, por favor. Si falla la autodetección a lo mejor quieres %smostrar%s todas las opciones manuales.'; // cpg1.5
$lang_sidebar_php['mozilla'] = 'Mozilla, Firefox, Netscape 6+, Konqueror 3.2+'; // cpg1.5
$lang_sidebar_php['mozilla_explain'] = 'Si usas Mozilla 0.9.4 o superior puedes %sañadir nuestra barra lateral%s a las que ya tienes. Podrás desinstalarla con la opción "Presonalizar barra lateral"/"Customize Sidebar".'; // cpg1.5
$lang_sidebar_php['ie_mac'] = 'Internet Explorer 5 o superior sobre Mac OS'; // cpg1.5
$lang_sidebar_php['ie_mac_explain'] = 'Si usas Internet Explorer 5 or above on MacOS, %sabre nuestra barra lateral%s en una ventana separada. En esa ventana abre la pestaña "Page Holder" de la izquierda. Pulsa "Añadir". Si la quieres mantener para uso futuro, pulsa en "Favoritos" y selecciona "Add to Page Holder Favorites"/"Añadir a favoritos".'; // cpg1.5
$lang_sidebar_php['ie_win'] = 'Internet Explorer 5 o superior sobre Windows'; // cpg1.5
$lang_sidebar_php['ie_win_explain'] = 'Si usas Internet Explorer 5 o superior en Windows, puedes añadir la barra lateral a tu barra de herramientas "Vínculos"; o puedes añadirla a tus favoritos, y al pulsar sobre ella aparecerá en lugar de la ventana de búsqueda - pulsa %saquí%s y seleccionar "Añadir a favoritos" en el menú desplegable. Este enlace no instala nuestra barra como tu barra por defecto, así que no se hacen modificaciones en tu sistema.'; // cpg1.5
$lang_sidebar_php['ie7_win'] = 'Internet Explorer 7 o superior sobre XP/Vista'; // cpg1.5
$lang_sidebar_php['ie7_win_explain'] = 'Si usas Internet Explorer 7 en Windows, puedes añadir una ventana emergente de navegación a tu barra de herramientas de "Vínculos"; o puedes añadirla a tus favoritos, y al pulsar sobre ella aparecerá de nuevo como ventana emergente al pulsar %saquí%s y seleccionar "Añadir a favoritos" en el menú desplegable. En versiones anteriores de Internet Explorer era posible añadir una barra lateral real, pero en IE7 no se puede hacer sin aplicar parcheos del registro un tanto complicados. Si quieres una barra lateral de verdad te recomendamos que uses otro navegador.'; // cpg1.5
$lang_sidebar_php['opera'] = 'Opera 6 y superior'; // cpg1.5
$lang_sidebar_php['opera_explain'] = 'Si usas Opera, puedes %spulsar este enlace%s para añadir nuestra barra lateral a tus conjuntos. Después marca "Mostrar en panel"/"Show in panel". Puedes desinstalarla pulsando el botón derecho sobre su pestaña y eligiendo "Borrar"/"Delete" del menú desplegable.'; // cpg1.5
$lang_sidebar_php['additional_options'] = 'Opciones adicionales'; // cpg1.5
$lang_sidebar_php['additional_options_explain'] = 'Si tienes otro navegador distinto de los mencionados, pulsa %saquí%s para mostrar las opciones posibles.'; // cpg1.5
$lang_sidebar_php['cannot_add_sidebar'] = '¡No se puede añadir la barra lateral! ¡Tu navegador no la soporta!'; // cpg1.5 // js-alert
$lang_sidebar_php['search'] = 'Buscar'; // cpg1.5
$lang_sidebar_php['reload'] = 'Recargar'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File search.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('SEARCH_PHP'))
{
$lang_search_php['title'] = 'Buscar';
$lang_search_php['submit_search'] = 'buscar';
$lang_search_php['keyword_list_title'] = 'Lista de palabras clave';
$lang_search_php['keyword_msg'] = 'La lista previa puede no estar completa. No incluye las palabras de los títulos o descripciones. Prueba la búsqueda completa.';
$lang_search_php['edit_keywords'] = 'Editar palabras clave';
$lang_search_php['search in'] = 'Buscar en:';
$lang_search_php['ip_address'] = 'Direcciones IP';
$lang_search_php['imgfields'] = 'Buscar en ficheros';
$lang_search_php['albcatfields'] = 'Buscar en álbumes y categorías';
$lang_search_php['age'] = 'Período';
$lang_search_php['newer_than'] = 'Menos de ';
$lang_search_php['older_than'] = 'Más de';
$lang_search_php['days'] = 'días';
$lang_search_php['all_words'] = 'Encontrar todas las palabras (AND)';
$lang_search_php['any_words'] = 'Encontrar cualquier palabra (OR)';
$lang_search_php['regex'] = 'Expresiones regulares';
$lang_search_php['album_title'] = 'Títulos de álbumes';
$lang_search_php['category_title'] = 'Títulos de categorías';
}

// ------------------------------------------------------------------------- //
// File searchnew.php // Traducida 20100503
// ------------------------------------------------------------------------- //
if (defined('SEARCHNEW_PHP')) {
$lang_search_new_php['page_title'] = 'Buscar nuevos ficheros';
$lang_search_new_php['select_dir'] = 'Selecciona directorio';
$lang_search_new_php['select_dir_msg'] = 'Esta función te permite añadir de forma automática los ficheros que hayas subido a tu servidor mediante FTP.<br /><br />Selecciona el directorio donde has subido tus ficheros.';
$lang_search_new_php['no_pic_to_add'] = 'No hay ningún fichero que añadir';
$lang_search_new_php['need_one_album'] = 'Necesitas al menos un álbum para utilizar esta función';
$lang_search_new_php['warning'] = 'Atención';
$lang_search_new_php['change_perm'] = 'El script no puede escribir en este directorio. ¡Necesitas cambiar sus permisos a modo 755 o 777 antes de intentarlo de nuevo!';
$lang_search_new_php['target_album'] = '<strong>Colocar los ficheros del directorio &quot;</strong>%s<strong>&quot; en el álbum </strong>%s';
$lang_search_new_php['folder'] = 'Carpeta';
$lang_search_new_php['image'] = 'imagen';
$lang_search_new_php['result'] = 'Resultado';
$lang_search_new_php['dir_ro'] = 'No se puede escribir. ';
$lang_search_new_php['dir_cant_read'] = 'No se puede leer. ';
$lang_search_new_php['insert'] = 'Añadiendo nuevos ficheros a la galería';
$lang_search_new_php['list_new_pic'] = 'Listado de nuevos ficheros';
$lang_search_new_php['insert_selected'] = 'Añadir los ficheros seleccionados';
$lang_search_new_php['no_pic_found'] = 'No se encontró ningún fichero nuevo';
$lang_search_new_php['be_patient'] = 'Por favor sé paciente, el script necesita tiempo para añadir los ficheros';
$lang_search_new_php['no_album'] = 'ningún album seleccionado';
$lang_search_new_php['result_icon'] = 'Pulsa para los detalles o para recargar';
$lang_search_new_php['notes'] = <<< EOT
    <ul>
        <li>%s: fichero añadido sin problemas</li>
        <li>%s: es un duplicado y ya existe en la base de datos</li>
        <li>%s: no se puede añadir, por favor comprueba la configuración y los permisos de los directorios donde están los ficheros</li>
        <li>%s: no has seleccionado un album al que añadir los ficheros</li>
        <li>%s: Archivo erróneo, corrupto o inaccesible</li>
        <li>%s: fichero de tipo desconocido</li>
        <li>%s: el fichero es una imagen GIF</li>
        <li>Si los iconos no aparecen, pulsa sobre el icono de archivo no cargado para ver el error producido por PHP</li>
        <li>Si el navegador produce un timeout, pulsa el icono de Actualizar</li>
    </ul>
EOT;
// Translator note: Do not translate the %s placeholders - they are being replaced with icons
$lang_search_new_php['check_all'] = 'Marcar todos';
$lang_search_new_php['uncheck_all'] = 'Desmarcar todos';
$lang_search_new_php['no_folders'] = 'Aún no hay carpetas dentro del dicrectorio "albums". Crea al menos una carpeta personalizada en ella y carga por ftp los ficheros allí. No debes cargar en la carpetas "userpics" ni "edit", porque están reservadas para subidas por http y para uso interno.';
$lang_search_new_php['browse_batch_add'] = 'Interfaz navegable'; // cpg1.5
$lang_search_new_php['display_thumbs_batch_add'] = 'Mostrar miniaturas en la vista previa'; // cpg1.5
$lang_search_new_php['edit_pics'] = 'Editar ficheros';
$lang_search_new_php['edit_properties'] = 'Propiedades del álbum';
$lang_search_new_php['view_thumbs'] = 'Vista de miniaturas';
$lang_search_new_php['add_more_folder'] = 'Añadir por lotes más ficheros de la carpeta %s'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File send_activation.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('SEND_ACTIVATION_PHP')) {
$lang_send_activation_php['err_already_logged_in'] = '¡Ya estaba validado en el sistema!'; // cpg1.5
$lang_send_activation_php['activation_not_required'] = 'Este sitio web no necesita activación por correo'; // cpg1.5
$lang_send_activation_php['err_unk_user'] = '¡El usuario seleccionado no existe!'; // cpg1.5
$lang_send_activation_php['resend_act_link'] = 'Reenviar el enlace de activación de cuenta'; // cpg1.5
$lang_send_activation_php['enter_email'] = 'Introduce tu dirección de correo'; // cpg1.5
$lang_send_activation_php['submit'] = 'Enviar'; // cpg1.5
$lang_send_activation_php['failed_sending_email'] = 'Fallo al enviar el correo con el enlace de activación de cuenta'; // cpg1.5
$lang_send_activation_php['activation_email_sent'] = 'Se ha enviado un correo a %s con el enlace de activación. Revisa tu correo para completar el proceso'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File stat_details.php // Traducida 20100502
// ------------------------------------------------------------------------- //
if (defined('STAT_DETAILS_PHP')) {
$lang_stat_details_php['show_hide'] = 'mostrar/ocultar esta columna';
$lang_stat_details_php['title'] = 'Estadísticas detalladas'; // cpg1.5
$lang_stat_details_php['vote'] = 'Detalles de votos';
$lang_stat_details_php['hits'] = 'Detalles de veces que se vió la imagen';
$lang_stat_details_php['stats'] = 'Estadísticas de votos';
$lang_stat_details_php['users'] = 'Estadísticas de usuarios';
$lang_stat_details_php['sdate'] = 'Fecha';
$lang_stat_details_php['rating'] = 'Valoración';
$lang_stat_details_php['search_phrase'] = 'Buscar frase';
$lang_stat_details_php['referer'] = 'URL de origen (Referrer)';
$lang_stat_details_php['browser'] = 'Navegador';
$lang_stat_details_php['os'] = 'Sistema operativo';
$lang_stat_details_php['ip'] = 'Dirección IP';
$lang_stat_details_php['uid'] = 'Usuario'; // cpg1.5
$lang_stat_details_php['sort_by_xxx'] = 'Ordenar por %s';
$lang_stat_details_php['ascending'] = 'ascendente';
$lang_stat_details_php['descending'] = 'descendente';
$lang_stat_details_php['internal'] = 'int';
$lang_stat_details_php['close'] = 'cerrar';
$lang_stat_details_php['hide_internal_referers'] = 'ocultar las URL de origen interno';
$lang_stat_details_php['date_display'] = 'Date display'; //jmatute: pendiente
$lang_stat_details_php['records_per_page'] = 'registros por página';
$lang_stat_details_php['submit'] = 'enviar/refrescar';
$lang_stat_details_php['overall_stats'] = 'Estadísticas generales'; // cpg1.5
$lang_stat_details_php['stats_by_os'] = 'Estadísticas por sistema operativo'; // cpg1.5
$lang_stat_details_php['number_of_hits'] = 'Número de veces vista'; // cpg1.5
$lang_stat_details_php['total'] = 'Total'; // cpg1.5
$lang_stat_details_php['stats_by_browser'] = 'Estadísticas por navegador'; // cpg1.5
$lang_stat_details_php['overall_stats_config'] = 'Configuración de estadísticas generales'; // cpg1.5
$lang_stat_details_php['hit_details'] = 'Guardar información detallada del uso'; // cpg1.5
$lang_stat_details_php['hit_details_explanation'] = 'Guardar información detallada para estadísticas de archivos vistos por los usuarios'; // cpg1.5
$lang_stat_details_php['vote_details'] = 'Guardar información detallada de los votos'; // cpg1.5
$lang_stat_details_php['vote_details_explanation'] = 'Guardar información detallada para estadísticas de cada voto de los usuarios'; // cpg1.5
$lang_stat_details_php['empty_hits_table'] = 'Borrar las estadísticas de acciones'; // cpg1.5
$lang_stat_details_php['empty_hits_table_confirm'] = '¿Estás absolutamente seguro de quere borrar TODAS las estadísticas de acceso a las imágenes para TODA la galería? ¡No se podrá deshacer!'; // cpg1.5 // js-alert
$lang_stat_details_php['empty_votes_table'] = 'Borrar las estadísticas de votos'; // cpg1.5
$lang_stat_details_php['empty_votes_table_confirm'] = '¿Estás absolutamente seguro de quere borrar TODAS las estadísticas de votos para TODA la galería? ¡No se podrá deshacer!'; // cpg1.5 // js-alert
$lang_stat_details_php['submit'] = 'Enviar'; // cpg1.5
$lang_stat_details_php['upd_success'] = 'Se ha actualizado la configuración de Coppermine'; // cpg1.5
$lang_stat_details_php['votes'] = 'votos'; // cpg1.5
$lang_stat_details_php['reset_votes_individual'] = 'Poner a cero el/los voto(s) seleccionado(s)'; // cpg1.5
$lang_stat_details_php['reset_votes_individual_confirm'] = '¿Estás seguro de querer borrar los votos seleccionados? ¡No se podrá deshacer!'; // cpg1.5
$lang_stat_details_php['back_to_intermediate'] = 'Regresar a la vista de fichero intermedio'; // cpg1.5
$lang_stat_details_php['records_on_page'] = '%s registros en %s página(s)'; // cpg1.5
$lang_stat_details_php['guest'] = 'Invitado'; // cpg1.5
$lang_stat_details_php['not_implemented'] = 'Aún en construcción'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File upload.php // Traducida 20100503
// ------------------------------------------------------------------------- //
if (defined('UPLOAD_PHP')) {
$lang_upload_php['title'] = 'Cargar fichero';
$lang_upload_php['restrictions'] = 'Restricciones'; // cpg1.5
$lang_upload_php['choose_method'] = 'Elige método de carga'; // cpg1.5
$lang_upload_php['upload_swf'] = 'Múltiples ficheros - usa Flash (recomendado)'; // cpg1.5
$lang_upload_php['upload_single'] = 'Simple - un fichero cada vez'; // cpg1.5
$lang_upload_php['up_instr_1'] = 'Selecciona un álbum de la lista desplegable';
$lang_upload_php['up_instr_2'] = 'Pulsa el botón "Explorar" y busca el/los fichero(s) que quieres subir. Puedes seleccionar varios de una vez pulsando Ctrl+Click.';
$lang_upload_php['up_instr_3'] = 'Selecciona más ficheros para cargar usando el paso 2';
$lang_upload_php['up_instr_4'] = 'Pulsa el botón "Continuar" después de que los ficheros se hayan cargado (el botón aparecrá cuando se haya cargado al menos un fichero).';
$lang_upload_php['up_instr_5'] = 'Pasarás a una pantalla en la que puedes introducir detalles de los ficheros que hayas subido. Después de rellenar los datos, envía el formulario con el botón "Aplicar cambios" al final del formulario.';
$lang_upload_php['restriction_zip'] = 'Los ficheros ZIP que hayas cargado permanecerán comprimidos y no se descomprimirán en el servidor.';
$lang_upload_php['restriction_filesize'] = 'Cada fichero que cargues debe ser menor que %s.';
$lang_upload_php['reg_instr_1'] = 'Acción no válida al crear el formulario.';
$lang_upload_php['no_name'] = 'Nombre de fichero no disponible'; // cpg 1.5
$lang_upload_php['no_tmp_name'] = 'Incapaz de cargar'; // cpg 1.5
$lang_upload_php['no_post'] = 'Fichero no cargado por POST.';
$lang_upload_php['forb_ext'] = 'Extensión no válida.';
$lang_upload_php['exc_php_ini'] = 'Se supera el tamaño de fichero indicado en php.ini.';
$lang_upload_php['exc_file_size'] = 'Se supera el tamaño de fichero permitido por Coppermine.';
$lang_upload_php['partial_upload'] = 'Sólo se ha hecho una carga parcial.';
$lang_upload_php['no_upload'] = 'No ha habido carga.';
$lang_upload_php['unknown_code'] = 'Error PHP desconocido.';
$lang_upload_php['impossible'] = 'Imposible mover.';
$lang_upload_php['not_image'] = 'No es una imagen/está corrupta';
$lang_upload_php['not_GD'] = 'No es una extensión GD.';
$lang_upload_php['pixel_allowance'] = 'El alto y/o ancho de la imagen cargada es mayor que el permitodi por la configuración de la galería.';
$lang_upload_php['failure'] = 'Fallo en la carga';
$lang_upload_php['no_place'] = 'No se pudo ubicar el fichero anterior.';
$lang_upload_php['max_fsize'] = 'Tamaño máximo de fichero permitido %s';
$lang_upload_php['picture'] = 'Imagen';
$lang_upload_php['pic_title'] = 'Título';
$lang_upload_php['description'] = 'Descripción';
$lang_upload_php['keywords_sel'] = 'Elige una palabra clave';
$lang_upload_php['err_no_alb_uploadables'] = 'Lo siento, pero no se te permite subir imágenes a ningún álbum';
$lang_upload_php['close'] = 'Cerrar';
$lang_upload_php['no_keywords'] = 'Lo siento, ¡no hay palabras clave disponibles!';
$lang_upload_php['regenerate_dictionary'] = 'Regenerar diccionario';
$lang_upload_php['allowed_types'] = 'Se te permite subir ficheros con estas extensiones:'; // cpg1.5
$lang_upload_php['allowed_img_types'] = 'Extensiones de imagen: %s'; // cpg1.5
$lang_upload_php['allowed_mov_types'] = 'Extensiones de vídeo : %s'; // cpg1.5
$lang_upload_php['allowed_doc_types'] = 'Extensiones de documentos: %s'; // cpg1.5
$lang_upload_php['allowed_snd_types'] = 'Extensions de audio: %s'; // cpg1.5
$lang_upload_php['please_wait'] = 'Espera, por favor, mientras se suben los ficheros - podría tardar un rato'; // cpg1.5
$lang_upload_php['alternative_upload'] = 'Método de subida alternativo'; // cpg1.5
$lang_upload_php['xp_publish_promote'] = 'Si estás en Windows XP/Vista, puedes usar el Asistente de carga de Windows XP también para subir ficheros, que te proporciona una interfaz más sencilla directamente en tu máquina.'; // cpg1.5
$lang_upload_php['err_js_disabled'] = 'La interfaz Flash de subida no ha podido cargarse. Debes tener activado JavaScript para usar Flash.'; // cpg1.5
$lang_upload_php['err_flash_disabled'] = 'La interfaz de carga está tardando mucho o la carga ha fallado. Asegúrate que tienes activos los plugins de Flash y que tienes instalado un reproductor de Flash, por favor.'; // cpg1.5
$lang_upload_php['err_alternate_method'] = 'Como alternativa puedes <a href="upload.php?single=1">usar el método simple</a> para cargar los ficheros de uno en uno.'; // cpg1.5
$lang_upload_php['err_flash_version'] = 'No se ha podido cargar la interfaz de carga. Puede que debas instalar o actualizar el reproductor de Flash. Visita el <a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash">sitio web de Adobe</a> para instalar el Reproductor de Flash.'; // cpg1.5
$lang_upload_php['flash_loading'] = 'Cargando la interfaz de carga. Espera un momento, por favor...'; // cpg1.5
$lang_upload_swf_php['browse'] = 'Explorar...'; //cpg1.5
$lang_upload_swf_php['cancel_all'] = 'Cancelar todas las subidas'; //cpg1.5
$lang_upload_swf_php['upload_queue'] = 'Cola de subida'; //cpg1.5
$lang_upload_swf_php['files_uploaded'] = 'ficheros cargados'; //cpg1.5
$lang_upload_swf_php['all_files'] = 'Todos los ficheros'; //cpg1.5
$lang_upload_swf_php['status_pending'] = 'Pendiente...'; //cpg1.5
$lang_upload_swf_php['status_uploading'] = 'Cargando...'; //cpg1.5
$lang_upload_swf_php['status_complete'] = 'Completo.'; //cpg1.5
$lang_upload_swf_php['status_cancelled'] = 'Cancelado.'; //cpg1.5
$lang_upload_swf_php['status_stopped'] = 'Detenido.'; //cpg1.5
$lang_upload_swf_php['status_failed'] = 'Fallo en la carga.'; //cpg1.5
$lang_upload_swf_php['status_too_big'] = 'Fichero demasiado grande.'; //cpg1.5
$lang_upload_swf_php['status_zero_byte'] = 'No se pueden subir ficheros de longitud cero.'; //cpg1.5
$lang_upload_swf_php['status_invalid_type'] = 'Tipo de fichero no válido.'; //cpg1.5
$lang_upload_swf_php['status_unhandled'] = 'Error no tratable'; //cpg1.5
$lang_upload_swf_php['status_upload_error'] = 'Error en la carga: '; //cpg1.5
$lang_upload_swf_php['status_server_error'] = 'Error del servidor (IO) '; //cpg1.5
$lang_upload_swf_php['status_security_error'] = 'Error de securidad'; //cpg1.5
$lang_upload_swf_php['status_upload_limit'] = 'Excedido el límite de carga.'; //cpg1.5
$lang_upload_swf_php['status_validation_failed'] = 'Fallo en la validación. Carga omitida.'; //cpg1.5
$lang_upload_swf_php['queue_limit'] = 'Has intentado encolar muchos ficheros.'; //cpg1.5
$lang_upload_swf_php['upload_limit_1'] = 'Has alcanzado el límite de carga.'; //cpg1.5
$lang_upload_swf_php['upload_limit_2'] = 'Puedes seleccionar hasta %s fichero(s)'; //cpg1.5
}

// ------------------------------------------------------------------------- //
// File usermgr.php //Traducida
// ------------------------------------------------------------------------- //
if (defined('USERMGR_PHP')) {
$lang_usermgr_php['memberlist'] = 'Miembros';
$lang_usermgr_php['user_manager'] = 'Gestor de usuarios';
$lang_usermgr_php['title'] = 'Gestionar usuarios';
$lang_usermgr_php['name_a'] = 'Nombre ascendente';
$lang_usermgr_php['name_d'] = 'Nombre descendente';
$lang_usermgr_php['group_a'] = 'Grupos ascendente';
$lang_usermgr_php['group_d'] = 'Grupos descendente';
$lang_usermgr_php['reg_a'] = 'Fecha de registro ascendente';
$lang_usermgr_php['reg_d'] = 'Fecha de registro descendente';
$lang_usermgr_php['pic_a'] = 'Número de ficheros ascendente';
$lang_usermgr_php['pic_d'] = 'Número de ficheros descendente';
$lang_usermgr_php['disku_a'] = 'Uso de disco ascendente';
$lang_usermgr_php['disku_d'] = 'Uso de disco descendente';
$lang_usermgr_php['lv_a'] = 'Última visita ascendente';
$lang_usermgr_php['lv_d'] = 'Última visita descendente';
$lang_usermgr_php['sort_by'] = 'Ordenar usuarios por';
$lang_usermgr_php['err_no_users'] = 'La tabla de usuarios está vacía!';
$lang_usermgr_php['err_edit_self'] = 'No puedes editar aquí tu propio perfil. Usa el enlace \'Mi perfil\'';
$lang_usermgr_php['with_selected'] = 'Actuar en los usuarios marcados:';
$lang_usermgr_php['delete_files_no'] = 'Mantener los ficheros públicos (pero anónimos)';
$lang_usermgr_php['delete_files_yes'] = 'borrar también los ficheros públicos';
$lang_usermgr_php['delete_comments_no'] = 'Mantener los comentarios (pero ponerlos anónimos)';
$lang_usermgr_php['delete_comments_yes'] = 'borrar los comentarios también';
$lang_usermgr_php['activate'] = 'Activar';
$lang_usermgr_php['deactivate'] = 'Desactivar';
$lang_usermgr_php['reset_password'] = 'Cambiar contraseña';
$lang_usermgr_php['change_primary_membergroup'] = 'Cambiar el grupo primario';
$lang_usermgr_php['add_secondary_membergroup'] = 'Añadir grupo secundario';
$lang_usermgr_php['name'] = 'Nombre';
$lang_usermgr_php['group'] = 'Grupo';
$lang_usermgr_php['inactive'] = 'Inactivo';
$lang_usermgr_php['operations'] = 'Operaciones';
$lang_usermgr_php['pictures'] = 'Archivos';
$lang_usermgr_php['disk_space_used'] = 'Espacio usado';
$lang_usermgr_php['disk_space_quota'] = 'Cuota'; // cpg1.5
$lang_usermgr_php['registered_on'] = 'Registro';
$lang_usermgr_php['last_visit'] = 'Última visita';
$lang_usermgr_php['u_user_on_p_pages'] = '%d usuarios en %d página(s)';
$lang_usermgr_php['confirm_del'] = '¿Estas seguro de BORRAR a éste ususario?\\nTodos sus álbumes y ficheros se borrarán también.'; // js-alert
$lang_usermgr_php['mail'] = 'CORREO';
$lang_usermgr_php['err_unknown_user'] = '¡El usuario seleccionado no existe!';
$lang_usermgr_php['modify_user'] = 'Modificar usuario';
$lang_usermgr_php['notes'] = 'Notas';
$lang_usermgr_php['note_list'] = 'Si no quieres cambiar la contraseña deja en blanco el campo "contraseña"';
$lang_usermgr_php['password'] = 'Contraseña';
$lang_usermgr_php['user_active'] = 'Activo';
$lang_usermgr_php['user_group'] = 'Grupo';
$lang_usermgr_php['user_email'] = 'Correo';
$lang_usermgr_php['user_web_site'] = 'Sitio Web';
$lang_usermgr_php['create_new_user'] = 'Crear usuario';
$lang_usermgr_php['user_location'] = 'Localización';
$lang_usermgr_php['user_interests'] = 'Intereses';
$lang_usermgr_php['user_occupation'] = 'Ocupación';
$lang_usermgr_php['user_profile1'] = '$user_profile1';
$lang_usermgr_php['user_profile2'] = '$user_profile2';
$lang_usermgr_php['user_profile3'] = '$user_profile3';
$lang_usermgr_php['user_profile4'] = '$user_profile4';
$lang_usermgr_php['user_profile5'] = '$user_profile5';
$lang_usermgr_php['user_profile6'] = '$user_profile6';
$lang_usermgr_php['latest_upload'] = 'Subidas recientes';
$lang_usermgr_php['no_latest_upload'] = 'No ha subido ficheros'; // cpg1.5
$lang_usermgr_php['last_comments'] = 'Últimos comentarios'; // cpg1.5
$lang_usermgr_php['no_last_comments'] = 'No ha hecho comentarios'; // cpg1.5
$lang_usermgr_php['comments'] = 'Comentarios'; // cpg1.5
$lang_usermgr_php['never'] = 'nunca';
$lang_usermgr_php['search'] = 'Búsqueda de usuarios';
$lang_usermgr_php['submit'] = 'Enviar';
$lang_usermgr_php['search_submit'] = 'Buscar';
$lang_usermgr_php['search_result'] = 'Resultados de la búsqueda de: ';
$lang_usermgr_php['alert_no_selection'] = '¡Debes seleccionar al menos un usuario antes!'; // js-alert
$lang_usermgr_php['select_group'] = 'Seleccionar grupo';
$lang_usermgr_php['groups_alb_access'] = 'Permisos del álbum por grupo';
$lang_usermgr_php['category'] = 'Categoría';
$lang_usermgr_php['modify'] = 'Modificar?';
$lang_usermgr_php['group_no_access'] = 'Este grupo no tiene acceso especial';
$lang_usermgr_php['notice'] = 'Ten en cuenta';
$lang_usermgr_php['group_can_access'] = 'Álbum(es) a los que sólo "%s" puede acceder';
$lang_usermgr_php['send_login_data'] = 'Enviar información de acceso al usuario (la contraseña irá por correo)'; // cpg1.5
$lang_usermgr_php['send_login_email_subject'] = 'La información de tu cuenta nueva'; // cpg1.5
$lang_usermgr_php['failed_sending_email'] = 'N¡o se ha podido enviar el correo con los datos de acceso!'; // cpg1.5
$lang_usermgr_php['view_profile'] = 'Ver perfil'; // cpg1.5
$lang_usermgr_php['edit_profile'] = 'Editar perfil'; // cpg1.5
$lang_usermgr_php['ban_user'] = 'Expulsar user'; // cpg1.5
$lang_usermgr_php['user_is_banned'] = 'Usuario expulsado'; // cpg1.5
$lang_usermgr_php['status'] = 'Estado'; // cpg1.5
$lang_usermgr_php['status_active'] = 'activo'; // cpg1.5
$lang_usermgr_php['status_inactive'] = 'inactivo'; // cpg1.5
$lang_usermgr_php['total'] = 'Total'; // cpg1.5
$lang_usermgr_php['send_login_data_email'] = <<< EOT
Se ha creado una cuenta en {SITE_NAME} para tí.

Puedes acceder en <a href="{SITE_LINK}">{SITE_LINK}</a> con el usuario "{USER_NAME}" y contraseña "{USER_PASS}"


Saludos,

Los gestores de {SITE_NAME}

EOT;
}

// ------------------------------------------------------------------------- //
// File update.php // Traducida 20100502
// ------------------------------------------------------------------------- //
if (defined('UPDATE_PHP')) {
$lang_update_php['title'] = 'Actualización'; // cpg1.5
$lang_update_php['welcome_updater'] = 'Bienvenido a la actualización de Coppermine'; // cpg1.5
$lang_update_php['could_not_authenticate'] = 'No se te ha podido verificar la identidad'; // cpg1.5
$lang_update_php['provide_admin_account'] = 'Proporciona las credenciales de tu cuenta de administrador de Coppermine o los datos de tu cuenta MySQL'; // cpg1.5
$lang_update_php['try_again'] = 'Inténtalo otra vez'; // cpg1.5
$lang_update_php['mysql_connect_error'] = 'No se ha podido crear una conexión a MySQL'; // cpg1.5
$lang_update_php['mysql_database_error'] = 'MySQL no ha encontrado una base de datos llamada %s'; // cpg1.5
$lang_update_php['mysql_said'] = 'MySQL dijo'; // cpg1.5
$lang_update_php['check_config_file'] = 'Por favor, comprueba los detalles de  MySQL en %s'; // cpg1.5
$lang_update_php['performing_database_updates'] = 'Efectuando las actualizaciones de base de datos'; // cpg1.5
$lang_update_php['performing_file_updates'] = 'Efectuando las actualizaciones de ficheros'; // cpg1.5
$lang_update_php['already_done'] = 'Ya estaba hecho'; // cpg1.5
$lang_update_php['password_encryption'] = 'Encriptación de contraseñas'; // cpg1.5
$lang_update_php['alb_password_encryption'] = 'Encriptación de contraseñas de álbum'; // cpg1.5
$lang_update_php['category_tree'] = 'Árbol de categorías'; // cpg1.5
$lang_update_php['authentication_needed'] = 'Se necesita identificación'; // cpg1.5
$lang_update_php['username'] = 'Usuario'; // cpg1.5
$lang_update_php['password'] = 'Contraseña'; // cpg1.5
$lang_update_php['update_completed'] = 'Se ha terminado la actualización'; // cpg1.5
$lang_update_php['check_versions'] = 'Se recomienda %scomprobar las versiones de los ficheros%s si has actualizado desde una versión anterior de Coppermine'; // cpg1.5 // Leave the %s untouched when translating - it wraps the link
$lang_update_php['start_page'] = 'Si no es el caso (o no quieres hacerlo), puedes ir a la %spágina de inicio de tu galería%s'; // cpg1.5 // Leave the %s untouched when translating - it wraps the link
$lang_update_php['errors_encountered'] = 'Se han encontrado estos errores, que hay que corregir antes'; // cpg1.5
$lang_update_php['delete_file'] = 'Borrar %s'; // cpg1.5
$lang_update_php['could_not_delete'] = 'No se pudo borrar por falta de permisos. Borra el fichero a mano'; // cpg1.5
$lang_update_php['rename_file'] = 'Renombrar %s a %s'; // cpg1.5
$lang_update_php['could_not_rename'] = 'No se pudo cambiar el nombre por falta de permisos. Renombra el fichero a mano'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File util.php //Traducida
// ------------------------------------------------------------------------- //
if (defined('UTIL_PHP')) {
$lang_util_php['title'] = 'Herramientas administrativas'; // cpg1.5
$lang_util_php['file'] = 'Fichero';
$lang_util_php['problem'] = 'Problema';
$lang_util_php['status'] = 'Estado';
$lang_util_php['title_set_to'] = 'título cambiaso a';
$lang_util_php['submit_form'] = 'enviar';
$lang_util_php['titles_updated'] = '%s títulos cambiados.'; // cpg1.5
$lang_util_php['updated_successfully'] = 'cambiado con éxito'; // cpg1.5
$lang_util_php['error_create'] = 'ERROR creando';
$lang_util_php['continue'] = 'Procesar más ficheros'; // cpg1.5
$lang_util_php['main_success'] = 'El fichero %s se usó con éxito como fichero principal';
$lang_util_php['error_rename'] = 'Error al renombrar  %s a %s';
$lang_util_php['error_not_found'] = 'No se ha podido encontrar el fichero %s';
$lang_util_php['back'] = 'volver al inicio de Herramientas administrativas'; // cpg1.5
$lang_util_php['thumbs_wait'] = 'Actualizando miniaturas y/o reescalando imágenes, espera...';
$lang_util_php['thumbs_continue_wait'] = 'Continuar actualizando miniaturas y/o reesclando imágenes, espera...';
$lang_util_php['titles_wait'] = 'Actualizando títulos, espera por favor...';
$lang_util_php['delete_wait'] = 'Borrando títulos, espera por favor...';
$lang_util_php['replace_wait'] = 'Borrando originales y reemplazándolos con las imágenes reescaladas, espera por favor..';
$lang_util_php['update'] = 'Actualizar miniaturas y/o reescalar imágenes';
$lang_util_php['update_what'] = 'Qué se debería actualizar';
$lang_util_php['update_thumb'] = 'Sólo miniaturas';
$lang_util_php['update_pic'] = 'Sólo imágenes reescaladas';
$lang_util_php['update_both'] = 'Miniaturas e imágenes reescaladas';
$lang_util_php['update_number'] = 'Número de imágenes procesadas en bloque';
$lang_util_php['update_option'] = '(Prueba a poner un número menor si experimentas problemas de timeout)';
$lang_util_php['update_missing'] = 'Actualizar sólo los ficheros perdidos'; // cpg1.5
$lang_util_php['filename_title'] = 'Fichero &rArr; Título del fichero';
$lang_util_php['filename_how'] = 'Cómo se debe modificar el nombre de fichero';
$lang_util_php['filename_remove'] = 'Quitar la extensión (.jpg o la que tenga) y reemplazar _ (guión bajo) con espacios'; // cpg1.5
$lang_util_php['filename_euro'] = 'Cambiar 2003_11_23_13_20_20.jpg a 23/11/2003 13:20';
$lang_util_php['filename_us'] = 'Cambiar 2003_11_23_13_20_20.jpg a 11/23/2003 13:20';
$lang_util_php['filename_time'] = 'Cambiar 2003_11_23_13_20_20.jpg a 13:20';
$lang_util_php['notitle'] = 'Aplicar a los ficheros con título vacío solamente'; // cpg1.5
$lang_util_php['delete_title'] = 'Borrar los títulos';
$lang_util_php['delete_title_explanation'] = 'Esto borrará todos los títulos de archivo del álbum que selecciones.';
$lang_util_php['delete_original'] = 'Borrar las imágenes de tamaño original';
$lang_util_php['delete_original_explanation'] = 'Borrará las imagenes de tamaño completo y dejará las de tamaño intermedio.';
$lang_util_php['delete_intermediate'] = 'Borrar las imágenes intermedias';
$lang_util_php['delete_intermediate_explanation1'] = 'Borrará las imagenes de tamaño intermedio (normal).'; // cpg1.5
$lang_util_php['delete_intermediate_explanation2'] = 'Usa esta opción para liberar espacio en disco si has deshabilitado \'Crear imágenes intermedias\' en la configuración después de que tuvieras ya imágenes.'; // cpg1.5
$lang_util_php['delete_intermediate_check'] = 'La opción de configuración \'Crear imágenes intermedias\' está establecia a %s.'; // cpg1.5
$lang_util_php['no_image'] = 'Me he saltado %s porque no es una imagen.'; // cpg1.5
$lang_util_php['enabled'] = 'activado'; // cpg1.5
$lang_util_php['disabled'] = 'desactivado'; // cpg1.5
$lang_util_php['delete_replace'] = 'Borrar todas las imágenes reemplazándolas con los archivos reescalados';
$lang_util_php['titles_deleted'] = 'Borrados todos los títulos del álbum especificado';
$lang_util_php['deleting_intermediates'] = 'Borrando imágenes intermedias. Espera, por favor...';
$lang_util_php['searching_orphans'] = 'Buscando huérfanos. Espera, por favor...';
$lang_util_php['delete_orphans'] = 'Borrar comentarios huérfanos';
$lang_util_php['delete_orphans_explanation'] = 'Buscará y preparará para borrar los comentarios asociados a ficheros que ya no existen en la galería.<br />Comprueba todos los álbumes.';
$lang_util_php['update_full_normal_thumb'] = 'Todo: tamaño completo, reescaladas (intermedias) y miniaturas'; // cpg1.5
$lang_util_php['update_full_normal'] = 'Tanto las intermedias como las de tamaño completo (si el original está disponible)'; // cpg1.5
$lang_util_php['update_full'] = 'Sólo las de tamaño completo (si el original está disponible)'; // cpg1.5
$lang_util_php['delete_back'] = 'Borrar originales de las imágenes con marca de agua'; // cpg1.5
$lang_util_php['delete_back_explanation'] = 'Esto borrará la copia de seguridad. Libera algo de espacio pero ¡no podrás deshacer la marca de agua!. Después de eso la marca de agua será permanente.'; // cpg1.5
$lang_util_php['finished'] = '<br />¡Terminada la actualización de miniaturas /imágenes!<br />'; // cpg1.5
$lang_util_php['autorefresh'] = 'Refresco automático (no habrá necesidad de pulsar botones en el proceso)'; // cpg1.5
$lang_util_php['refresh_db'] = 'Recargar la información de dimensiones y tamaño';
$lang_util_php['refresh_db_explanation'] = 'Volver a leer los tamaños y dimensiones de los ficheros. Usalo cuando la cuotas de disco no sea correctas y/o cambies a mano algún fichero manualmente.';
$lang_util_php['reset_views'] = 'Poner a cero los contadores de visitas';
$lang_util_php['reset_views_explanation'] = 'Pone a cero los contadores de visitas de todas las imágenes del el álbum seleccionado.';
$lang_util_php['reset_success'] = 'Puesta a cero '; // cpg1.5
$lang_util_php['orphan_comment'] = 'comentarios huérfanos encontrados';
$lang_util_php['delete_all'] = 'Borrar todos';
$lang_util_php['delete_all_orphans'] = 'Borrar todos los huérfanos?';
$lang_util_php['comment'] = 'Comentario: ';
$lang_util_php['nonexist'] = 'asociado a un fichero inexistente # ';
$lang_util_php['delete_old'] = 'Borrar archivos más antiguos que un número dado de días'; // cpg1.5
$lang_util_php['delete_old_explanation'] = 'Borrará los ficheros anteriores al número de días que especifiques (tamaño completo, intermedios y miniaturas). Se puede usar para liberar espacio quitando los más antiguos.'; // cpg1.5
$lang_util_php['delete_old_warning'] = 'Aviso: ¡Este es el último aviso! ¡los ficheros pasarán a mejor vida sin preguntarte más!'; // cpg1.5
$lang_util_php['deleting_old'] = 'Borrando ficheros antiguos. Espere, por favor...'; // cpg1.5
$lang_util_php['older_than'] = 'Borrar ficheros con más de %s dias de antigüedad'; // cpg1.5
$lang_util_php['del_orig'] = 'Fichero original %s borrado con éxito'; // cpg1.5
$lang_util_php['del_intermediate'] = 'Imagen intermedia %s borrada con éxito'; // cpg1.5
$lang_util_php['del_thumb'] = 'Miniatura %s borrada con éxito'; // cpg1.5
$lang_util_php['del_error'] = 'Error al borrar %s!'; // cpg1.5
$lang_util_php['affected_records'] = '%s registros afectados.'; // cpg1.5
$lang_util_php['all_albums'] = 'Todos los álbumes'; // cpg1.5
$lang_util_php['update_result'] = 'Resultado de la actualización'; // cpg1.5
$lang_util_php['incorrect_filesize'] = 'Tamaño total de los ficheros incorrecto'; // cpg1.5
$lang_util_php['database'] = 'Base de datos: '; // cpg1.5
$lang_util_php['bytes'] = ' bytes'; // cpg1.5
$lang_util_php['actual'] = 'Actual: '; // cpg1.5
$lang_util_php['updated'] = 'Actualizado'; // cpg1.5
$lang_util_php['filesize_error'] = 'No puede leer el tamaño del fichero (pudiera ser incorrecto); saltando....'; // cpg1.5
$lang_util_php['skipped'] = 'Saltado'; // cpg1.5
$lang_util_php['incorrect_dimension'] = 'Dimensiones incorrectas'; // cpg1.5
$lang_util_php['dimension_error'] = 'No pude leer las dimensiones de la imagen; saltando....'; // cpg1.5
$lang_util_php['cannot_fix'] = 'No se ha podido arreglar'; // cpg1.5
$lang_util_php['fullpic_error'] = '¡No existe el fichero %s!'; // cpg1.5
$lang_util_php['no_prob_detect'] = 'No se han detectado problemas'; // cpg1.5
$lang_util_php['no_prob_found'] = 'No se han encontrado problemas.'; // cpg1.5
$lang_util_php['keyword_convert'] = 'Convertir el separador de palabras clave'; // cpg1.5
$lang_util_php['keyword_from_to'] = 'Convertir el separdor de %s a %s'; // cpg1.5
$lang_util_php['keyword_set'] = 'Poner el separador de palabras clave al nuevo valor'; // cpg1.5
$lang_util_php['keyword_replace_before'] = 'Antes de convertir cambia %s con %s'; // cpg1.5
$lang_util_php['keyword_replace_after'] = 'Después de convertir cambia %s con %s'; // cpg1.5
$lang_util_php['keyword_replace_values'] = array('_'=>'guión bajo', '-'=>'guión', '~'=>'tilde'); // cpg1.5
$lang_util_php['keyword_explanation'] = 'Esto cambiará el carácter que hace de palabra clave de un valor a otro en todos tus ficheros. Lee la documentación para entrar en detalle.'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File versioncheck.php //traducida 20100503
// ------------------------------------------------------------------------- //
if (defined('VERSIONCHECK_PHP')) {
$lang_versioncheck_php['title'] = 'Comprobar versiones';
$lang_versioncheck_php['versioncheck_output'] = 'Salida de la comprobación';
$lang_versioncheck_php['file'] = 'archivo';
$lang_versioncheck_php['folder'] = 'carpeta';
$lang_versioncheck_php['outdated'] = 'más antiguo que %s';
$lang_versioncheck_php['newer'] = 'más nuevo que %s';
$lang_versioncheck_php['modified'] = 'modificado';
$lang_versioncheck_php['not_modified'] = 'sin modificar'; // cpg1.5
$lang_versioncheck_php['needs_change'] = 'necesita cambio';
$lang_versioncheck_php['review_permissions'] = 'Comprueba los permisos';
$lang_versioncheck_php['inaccessible'] = 'No se puede acceder al fichero';
$lang_versioncheck_php['review_version'] = 'Tu fichero está caducado';
$lang_versioncheck_php['review_dev_version'] = 'Tu fichero es más nuevo de lo esperado';
$lang_versioncheck_php['review_modified'] = 'El fichero está corrupto (o lo has editado deliberadamente)';
$lang_versioncheck_php['review_missing'] = '%s no existe o está inaccesible';
$lang_versioncheck_php['existing'] = 'existe';
$lang_versioncheck_php['review_removed_existing'] = 'Se debe borrar el fichero por razondes de seguridad';
$lang_versioncheck_php['counter'] = 'Contador';
$lang_versioncheck_php['type'] = 'Tipo';
$lang_versioncheck_php['path'] = 'Ruta';
$lang_versioncheck_php['missing'] = 'no existe';
$lang_versioncheck_php['permissions'] = 'Permisos';
$lang_versioncheck_php['version'] = 'Versión';
$lang_versioncheck_php['revision'] = 'Revisión';
$lang_versioncheck_php['modified'] = 'Modificado';
$lang_versioncheck_php['comment'] = 'Comentario';
$lang_versioncheck_php['help'] = 'Ayuda';
$lang_versioncheck_php['repository_link'] = 'Enlace al repositorio';
$lang_versioncheck_php['browse_corresponding_page_subversion'] = 'Abrir en el navegador la página correpondiente a este fichero en el repositorio de la sub-versión';
$lang_versioncheck_php['mandatory'] = 'obligatorio';
$lang_versioncheck_php['mandatory_missing'] = 'Fichero obligatorio no existe'; // cpg1.5
$lang_versioncheck_php['optional'] = 'opcional';
$lang_versioncheck_php['removed'] = 'borrar'; // cpg1.5
$lang_versioncheck_php['options'] = 'Opciones';
$lang_versioncheck_php['display_output'] = 'Salida';
$lang_versioncheck_php['on_screen'] = 'Salida completa';
$lang_versioncheck_php['text_only'] = 'Sólo texto';
$lang_versioncheck_php['errors_only'] = 'Mostrar sólo los posibles errores';
$lang_versioncheck_php['hide_images'] = 'No comprobar imágenes'; // cpg1.5
$lang_versioncheck_php['no_modification_check'] = 'No comprobar los ficheros modificados'; // cpg1.5
$lang_versioncheck_php['do_not_connect_to_online_repository'] = 'No conectar al repositorio';
$lang_versioncheck_php['online_repository_explain'] = 'sólo recomendable si la conexión falla';
$lang_versioncheck_php['submit'] = 'enviar / refrescar';
$lang_versioncheck_php['select_all'] = 'Seleccionar todo'; // js-alert
$lang_versioncheck_php['files_folder_processed'] = 'Mostrando %s entradas de %s carpetas/ficheros procesados con %s posibles problemas';
$lang_versioncheck_php['read'] = 'Leer'; // cpg1.5
$lang_versioncheck_php['write'] = 'Escribir'; // cpg1.5
$lang_versioncheck_php['warning'] = 'Aviso'; // cpg1.5
$lang_versioncheck_php['not_applicable'] = 'n/a'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File view_log.php // Traducida
// ------------------------------------------------------------------------- //
if (defined('VIEWLOG_PHP')) {
$lang_viewlog_php['delete_all'] = 'Borrar todos los registros';
$lang_viewlog_php['delete_this'] = 'Borrar este registro';
$lang_viewlog_php['view_logs'] = 'Ver registros';
$lang_viewlog_php['no_logs'] = 'No hay registros.';
$lang_viewlog_php['last_updated'] = 'modificado por última vez'; // cpg1.5
}

// ------------------------------------------------------------------------- //
// File xp_publish.php // Traducida 20100503
// ------------------------------------------------------------------------- //
if (defined('XP_PUBLISH_PHP')) {
$lang_xp_publish_php['title'] = 'Asistente de publicación en Web para XP';
$lang_xp_publish_php['client_header'] = 'Cliente del asistente de publicación en Web para XP'; // cpg1.5
$lang_xp_publish_php['requirements'] = 'Requisitos'; // cpg1.5
$lang_xp_publish_php['windows_xp'] = 'Windows XP / Vista'; // cpg1.5
$lang_xp_publish_php['no_windows_xp'] = 'Parece que estás ejecutando otro sistema operaftivo que no está soportado'; // cpg1.5
$lang_xp_publish_php['no_os_detect'] = 'No se ha podido determinar el sistema operativo que usas'; // cpg1.5
$lang_xp_publish_php['requirement_http_upload'] = 'Una instalación de Coppermine funcionando en la que la función de subida de http funcione correctamente'; // cpg1.5
$lang_xp_publish_php['requirement_ie'] = 'Microsoft Internet Explorer'; // cpg1.5
$lang_xp_publish_php['requirement_permissions'] = 'El administrador de la galería debe haberte dado permisos de subida de ficheros'; // cpg1.5
$lang_xp_publish_php['requirement_login'] = 'Necesitas estar validado para subir ficheros'; // cpg1.5
$lang_xp_publish_php['no_ie'] = 'Parece que estás usando un navegador no soportado'; // cpg1.5
$lang_xp_publish_php['no_browser_detect'] = 'No se pudo identificar tu navegador'; // cpg1.5
$lang_xp_publish_php['no_gallery_name'] = 'Necesitas especificar el nombre de una galería en la configuración'; // cpg1.5
$lang_xp_publish_php['no_gallery_description'] = 'Necesitas especificar la descripción de una galería en la configuración'; // cpg1.5
$lang_xp_publish_php['howto_install'] = 'Cómo instalar'; // cpg1.5
$lang_xp_publish_php['install_right_click'] = 'Pulsa el botón derecho sobre %seste enlace%s y selecciona &quot;Guardar destino como...&quot;'; // cpg1.5 // translator note: don't replace the %s - that placeholder token needs to go untranslated
$lang_xp_publish_php['install_save'] = 'Guarda el fichero en tu máquina. Asegúrate de que el nombre de fichero es de la forma <tt>cpg_###.reg</tt> (los caracteres ### representan un código de tiempo). Si no e así cámbialo para que tenga esa forma (deja los números)'; // cpg1.5
$lang_xp_publish_php['install_execute'] = 'Después de la descarga, ejecuta el fichero haciendo doble click sobre él para registrar tu servidor en el asistente de publicación Web de Windows'; // cpg1.5
$lang_xp_publish_php['usage'] = 'Uso'; // cpg1.5
$lang_xp_publish_php['select_files'] = 'En el explorador de Windows selecciona los ficheros que quieres subir'; // cpg1.5
$lang_xp_publish_php['display_tasks'] = 'Asegúrate de que la lista de carpetas no está en la izquierda de la ventana, pulsando "Carpetas" en el menú de botones. Si no está el botón de carpetas haz click con el botón derecho sobre el menú y elige que se muestre el menú "Botones estándar"'; // cpg1.5
$lang_xp_publish_php['publish_on_the_web'] = 'Pulsa sobre &quot;Publicar este archivo en web&quot; o &quot;Publica en el web los elementos seleccionados&quot; en el panel de la izquierda'; // cpg1.5
$lang_xp_publish_php['confirm_selection'] = 'Confirma la selección de ficheros que has hecho'; // cpg1.5
$lang_xp_publish_php['select_service'] = 'En la lista de servicios que aparecerá selecciona el correspondiente a tu galería (tiene el nombre de la galería)'; // cpg1.5
$lang_xp_publish_php['enter_login'] = 'Introduce tu información de acceso si es necesario'; // cpg1.5
$lang_xp_publish_php['select_album'] = 'Selecciona el álbum en que quieres guardar los archivos, o crea uno nuevo'; // cpg1.5
$lang_xp_publish_php['next'] = 'Pulsa en &quot;siguiente&quot;'; // cpg1.5
$lang_xp_publish_php['upload_starts'] = 'Debería comenzar a carga de tus archivos'; // cpg1.5
$lang_xp_publish_php['upload_completed'] = 'Cuando termine, comprueba tu galería para ver si se han cargado correctamente'; // cpg1.5
$lang_xp_publish_php['welcome'] = 'Bienvenid@, <strong>%s</strong>,';
$lang_xp_publish_php['need_login'] = 'Necesitas validarte en la galería mediante Internet Explorer antes de usar este asistente.<p/><p>Al validarte no olvides seleccionar la opción &quot;Recordarme&quot; si está presente.';
$lang_xp_publish_php['no_alb'] = 'Lo siento, pero no hay ningún álbum en el que tengas permiso para subir imágenes con este asistente.';
$lang_xp_publish_php['upload'] = 'Cargar tus imágenes en un álbum anterior';
$lang_xp_publish_php['create_new'] = 'Crear un nuevo álbum para tus imágenes';
$lang_xp_publish_php['category'] = 'Categoría';
$lang_xp_publish_php['new_alb_created'] = 'Se ha creado el álbum &quot;<strong>%s</strong>&quot;.';
$lang_xp_publish_php['continue'] = 'Pulsa &quot;Siguiente&quot; para cargar tus imágenes';
$lang_xp_publish_php['link'] = '';
}

// ------------------------------------------------------------------------- //
// Core plugins // Traducida 20100503
// ------------------------------------------------------------------------- //
if (defined('CORE_PLUGIN')) {
$lang_plugin_php['usergal_alphatabs_config_name'] = 'Pestañas alfabéticas de galerías de usuarios'; // cpg1.5
$lang_plugin_php['usergal_alphatabs_config_description'] = 'Qué hace: muestra pestañas de la A a la Z sobre las galerías de usuario en las que pulsar y saltar a una página que muestra las galerías de los usuarios cuyo nombre empieza por esa letra. Recomendado sólo si tienes muchas galerías de usuario.'; // cpg1.5
$lang_plugin_php['usergal_alphatabs_jump_by_username'] = 'Saltar por nombre de usuario'; // cpg1.5
$lang_plugin_php['sample_config_name'] = 'Plugin de ejemplo'; // cpg1.5
$lang_plugin_php['sample_config_description'] = 'Plugin de ejemplo. No hace nada particularmente útil - pensado para mostrar qué pueden hacer los plugins y cómo programarlos. Al activarlo mostrará un texto de ejemplo en rojo.'; // cpg1.5
$lang_plugin_php['sample_plugin_documentation'] = 'Documentación del plugin'; // cpg1.5
$lang_plugin_php['sample_plugin_support'] = 'Soporte del plugin'; // cpg1.5
$lang_plugin_php['sample_install_explain'] = 'Introduce el nombre de usuario (\'foo\') y contraseña (\'bar\') para instalarlo'; // cpg1.5
$lang_plugin_php['sample_install_username'] = 'Usuario'; // cpg1.5
$lang_plugin_php['sample_install_password'] = 'Contraseña'; // cpg1.5
$lang_plugin_php['sample_output'] = 'Este es el texto devuelto por el plugin de ejmplo'; // cpg1.5
$lang_plugin_php['opensearch_config_name'] = 'OpenSearch'; // cpg1.5
$lang_plugin_php['opensearch_config_description'] = 'Una implementación de <a href="http://www.opensearch.org/" rel="external" class="external">OpenSearch</a> para Coppermine.<br />Cuando se activa, los usuarios pueden añadir tu galería a la barra de búsquedas de su navegador.'; // cpg1.5
$lang_plugin_php['opensearch_search'] = 'Buscar %s'; // cpg1.5
$lang_plugin_php['opensearch_extra'] = 'Quizá quieras añadir un texto a yu galería o a tu sitio web que explique qué hace este plugin'; // cpg1.5
$lang_plugin_php['opensearch_failed_to_open_file'] = 'Error al abrir el fichero %s - comprueba los permisos'; // cpg1.5
$lang_plugin_php['opensearch_failed_to_write_file'] = 'Error al escribir en el fichero %s - comprueba los permisos'; // cpg1.5
$lang_plugin_php['opensearch_form_header'] = 'Introduce los detalles que irán en el fichero de descripción'; // cpg1.5
$lang_plugin_php['opensearch_gallery_url'] = 'URL de la galería (asegúrate de que es correcta)'; // cpg1.5
$lang_plugin_php['opensearch_display_name'] = 'Nombre como se muestra en el navegador'; // cpg1.5
$lang_plugin_php['opensearch_description'] = 'Descripción'; // cpg1.5
$lang_plugin_php['opensearch_character_limit'] = 'límite de caracteres de %s'; // cpg1.5
$lang_plugin_php['onlinestats_description'] = 'Muestra un bloque de texto en cada página mostrando cuántos usuarios y visitantes hay conectados en ese momento.';
$lang_plugin_php['onlinestats_name'] = '¿Quién está conectado?';
$lang_plugin_php['onlinestats_config_extra'] = 'Para habilitar el plugin (hacer que muestre el bloque de estadísticas online), se ha añadido la cadena "onlinestats" (separada con una barra invertida) al "contenido de la página principal" en la <a href="admin.php">configuración de Coppermine</a>, sección "Vista de la lista de álbumes". Este parámetro será algo parecido a "breadcrumb/catlist/alblist/onlinestats". Para cambiar la posición del bloque de texto, mueve la cadena "onlinestats" en el campo, y ten cuidado con las barras invertidas.';
$lang_plugin_php['onlinestats_config_install'] = 'El plugin ejecuta consultas adicionales en la base de datos para cada página, consumiendo recursos y ciclos de CPU. Si tu galería coppermine es lenta o tiene muchos usuarios no deberías usarlo.';
$lang_plugin_php['onlinestats_we_have_reg_member'] = 'Hay %s usuario registrado';
$lang_plugin_php['onlinestats_we_have_reg_members'] = 'Hay %s usuarios registrados';
$lang_plugin_php['onlinestats_most_recent'] = 'El último usuario registrado es %s';
$lang_plugin_php['onlinestats_is'] = 'En total hay %s visitante conectados';
$lang_plugin_php['onlinestats_are'] = 'En total hay %s visitantes conectados';
$lang_plugin_php['onlinestats_and'] = 'y';
$lang_plugin_php['onlinestats_reg_member'] = '%s usuario registrado';
$lang_plugin_php['onlinestats_reg_members'] = '%s usuarios registrados';
$lang_plugin_php['onlinestats_guest'] = '%s invitado';
$lang_plugin_php['onlinestats_guests'] = '%s invitados';
$lang_plugin_php['onlinestats_record'] = 'Máximos usuarios conectados: %s en %s';
$lang_plugin_php['onlinestats_since'] = 'Usuarios registrados conectados en los últimos %s minutos: %s';
$lang_plugin_php['onlinestats_config_text'] = '¿Cuánto tiempo debe pasar antes de considerar que un usuario se ha ido?';
$lang_plugin_php['onlinestats_minute'] = 'minutos';
$lang_plugin_php['onlinestats_remove'] = '¿Borrar la tabla usada para las estadísticas online?';
$lang_plugin_php['link_target_name'] = 'Destino del enlace';
$lang_plugin_php['link_target_description'] = 'Cambia la manera de abrir de los enlaces: cuando se habilita, los encaes con el atributo rel="external" se abrirán en ventana nueva (en lugar de ser la misma ventana).';
$lang_plugin_php['link_target_extra'] = 'Sobre todo tendrá impacto en los enlaces "Powered by Coppermine" en la parte baja de la página de la galería.';
$lang_plugin_php['link_target_recommendation'] = 'No es recomendable usar el plugin para evitar controlar a tus usuarios: abrir enlaces en nuevas ventanas es una forma de mangonear a los visitantes.';
}

?>
