<?php

namespace Contest\Services;

use Contest\Contest;
use Contest\Models\Department;

/**
 * Class DepartmentService
 * @package Contest\Services
 */
class DepartmentService {

    /**
     * @var Contest
     */
    private $contest;
    /**
     * DepartmentService constructor.
     * @param Contest $contest
     */
    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    /**
     * @param mixed[] $row
     * @return Department
     */
    public function mapToDepartment($row) {
        $department = new Department(
            $row['id'],
            $row['title'],
            $row['title_r'],
            $row['title_t']
        );
        return $department;
    }

    /**
     * @param Department $department
     * @return mixed[]
     */
    public function mapToArray($department) {
        $row = array(
            "id" => $department->getId(),
            "title" => $department->getTitle(),
            "title_r" => $department->getTitleR(),
            "title_t" => $department->getTitleT()
        );
        return $row;
    }

    /**
     * @param int $id
     * @return string
     */
    private function getFullPathTitle($id) {
        global $DB;
        $departmentArr = $DB->selectRow(
            "SELECT p.page_id AS id,p.page_parent AS parent_id,t.cv_text AS title, tr.cv_text AS title_r,tt.cv_text AS title_t,ni.cv_text AS not_include, p.page_template 
              FROM adm_pages AS p
              LEFT JOIN adm_pages_content AS t ON t.page_id=p.page_id AND t.cv_name='TITLE'
              LEFT JOIN adm_pages_content AS tr ON tr.page_id=p.page_id AND tr.cv_name='TITLE_R'
              LEFT JOIN adm_pages_content AS tt ON tt.page_id=p.page_id AND tt.cv_name='TITLE_T'
              LEFT JOIN adm_pages_content AS ni ON ni.page_id=p.page_id AND ni.cv_name='CONTEST_NO_INCLUDE'
              WHERE p.page_id=?d",
            $id
        );
        if(!empty($departmentArr)) {
            if($departmentArr['parent_id']!=0) {
                if (!empty($departmentArr['title_r']) && $departmentArr['page_template']=='podr' && $departmentArr['not_include']!=1) {
                    return " " . $departmentArr['title_r'] . $this->getFullPathTitle($departmentArr['parent_id']);
                } else {
                    return $this->getFullPathTitle($departmentArr['parent_id']);
                }
            } else {
                if (!empty($departmentArr['title_r']) && $departmentArr['page_template']=='podr') {
                    if($departmentArr['not_include']!=1) {
                        return " " . $departmentArr['title_r'];
                    } else {
                        return "";
                    }
                }
            }
        }
        return "";
    }

    /**
     * @param int $id
     * @return Department
     */
    public function getFullPathDepartment($id) {
        global $DB;

        $departmentArr = $DB->selectRow(
            "SELECT p.page_id AS id,p.page_parent AS parent_id,t.cv_text AS title, tr.cv_text AS title_r,tt.cv_text AS title_t 
              FROM adm_pages AS p
              INNER JOIN adm_pages_content AS t ON t.page_id=p.page_id AND t.cv_name='TITLE'
              INNER JOIN adm_pages_content AS tr ON tr.page_id=p.page_id AND tr.cv_name='TITLE_R'
              INNER JOIN adm_pages_content AS tt ON tt.page_id=p.page_id AND tt.cv_name='TITLE_T'
              WHERE p.page_id=?d AND p.page_template='podr'",
            $id
        );

        if(!empty($departmentArr)) {
            if($departmentArr['parent_id']!=0) {
                $fullTitle = $this->getFullPathTitle($departmentArr['parent_id']);
                $departmentArr['title'] .= $fullTitle;
                $departmentArr['title_r'] .= $fullTitle;
                $departmentArr['title_t'] .= $fullTitle;
            }

            $department = $this->mapToDepartment($departmentArr);
            return $department;
        }
        return null;
    }

    /**
     * @param int $id
     * @return Department
     */
    public function getDepartmentById($id) {
        global $DB;

        $departmentArr = $DB->selectRow(
            "SELECT p.page_id AS id,t.cv_text AS title, tr.cv_text AS title_r,tt.cv_text AS title_t 
              FROM adm_pages AS p
              INNER JOIN adm_pages_content AS t ON t.page_id=p.page_id AND t.cv_name='TITLE'
              INNER JOIN adm_pages_content AS tr ON tr.page_id=p.page_id AND tr.cv_name='TITLE_R'
              INNER JOIN adm_pages_content AS tt ON tt.page_id=p.page_id AND tt.cv_name='TITLE_T'
              WHERE p.page_id=?d AND p.page_template='podr'",
            $id
        );

        if(!empty($departmentArr)) {
            $department = $this->mapToDepartment($departmentArr);
            return $department;
        }
        return null;
    }

    /**
     * @return Department[]
     */
    public function getAllDepartments($sortField="title",$sortType="ASC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }
        if($sortField=="title") {
            $sortField = "t.cv_text";
        }

        $departmentArr = $DB->select(
            "SELECT p.page_id AS id,t.cv_text AS title, tr.cv_text AS title_r,tt.cv_text AS title_t 
              FROM adm_pages AS p
              INNER JOIN adm_pages_content AS t ON t.page_id=p.page_id AND t.cv_name='TITLE'
              INNER JOIN adm_pages_content AS tr ON tr.page_id=p.page_id AND tr.cv_name='TITLE_R'
              INNER JOIN adm_pages_content AS tt ON tt.page_id=p.page_id AND tt.cv_name='TITLE_T'
              WHERE p.page_template='podr'
              ORDER BY ".$sortField." ".$sortType
        );

        $departments = array();
        foreach ($departmentArr as $item) {
            $departments[] = $this->mapToDepartment($item);
        }
        return $departments;
    }

}