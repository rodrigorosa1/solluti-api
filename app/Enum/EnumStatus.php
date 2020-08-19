<?php
/**
 * Created by PhpStorm.
 * User: rodrigo
 * Date: 18/08/20
 * Time: 22:08
 */

namespace App\Enum;


abstract class EnumStatus
{
    const ACTIVE    = 1;
    const INACTIVE = 0;

    const STATUS = [
        self::ACTIVE => 'Ativo',
        self::INACTIVE => 'Inativo',
    ];

}
