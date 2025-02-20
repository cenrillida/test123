<?php

/**
 * Class NotificationService
 */
class NotificationService {

    /**
     * @param int $iLineId
     * @return array
     */
    function getUserUnreadNotifications($iLineId = null) {
        global $DBH;

        $queryIlineId = "1=1";
        if(!empty($iLineId)) {
            $queryIlineId = "ae.itype_id=:itype_id";
        }

        $STH = $DBH->prepare("
            SELECT 
                   ae.el_id AS 'id',
                   d.icont_text AS 'date',
                   ne.icont_text AS 'notification_end',
                   s.icont_text AS 'status',
                   c.icont_text AS 'content',
                   ae.itype_id AS iline_id
            FROM adm_ilines_element AS ae
            INNER JOIN adm_ilines_content AS d ON ae.el_id=d.el_id AND d.icont_var='date'
            INNER JOIN adm_ilines_content AS ne ON ae.el_id=ne.el_id AND ne.icont_var='notification_end'
            INNER JOIN adm_ilines_content AS s ON ae.el_id=s.el_id AND s.icont_var='status'
            LEFT JOIN adm_ilines_content AS c ON ae.el_id=c.el_id AND c.icont_var='content'
            WHERE $queryIlineId AND s.icont_text=1 AND STR_TO_DATE( ne.icont_text, '%Y.%m.%d %H:%i' )>=NOW()
            ");

        if(!empty($iLineId)) {
            $STH->bindParam(":itype_id",$iLineId,PDO::PARAM_INT);
        }

        $STH->execute();
        $rows = $STH->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }
}