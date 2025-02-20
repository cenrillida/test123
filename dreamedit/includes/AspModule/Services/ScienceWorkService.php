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
        0 => 'Монографии (в т.ч. ответственное редактирование монографий), главы в монографиях, брошюры',
        1 => 'Статьи в рецензируемых научных журналах',
        2 => 'Сборники (ответственное редактирование), статьи в сборниках',
        3 => 'Учебники и учебные пособия',
        4 => 'Публикации в официально зарегистрированных электронных изданиях (журналах, СМИ, сайтах)',
        5 =>'Другие публикации по вопросам профессиональной деятельности (в т.ч.  диссертации, авторефераты диссертаций)'
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