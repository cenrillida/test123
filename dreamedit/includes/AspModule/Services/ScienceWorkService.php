<?php

namespace AspModule\Services;

/**
 *
 */
class ScienceWorkService
{
    /**
     * @var string[]
     */
    private $scienceWorkTypes = array(
        0 => '���������� (� �.�. ������������� �������������� ����������), ����� � �����������, �������',
        1 => '������ � ������������� ������� ��������',
        2 => '�������� (������������� ��������������), ������ � ���������',
        3 => '�������� � ������� �������',
        4 => '���������� � ���������� ������������������ ����������� �������� (��������, ���, ������)',
        5 =>'������ ���������� �� �������� ���������������� ������������ (� �.�.  �����������, ������������ �����������)'
    );

    /**
     * @return string[]
     */
    public function getScienceWorkTypes()
    {
        return $this->scienceWorkTypes;
    }

    public function getScienceWorkByTypeId($typeId) {
        if(!empty($this->scienceWorkTypes[$typeId])) {
            return $this->scienceWorkTypes[$typeId];
        }
        return "";
    }

}