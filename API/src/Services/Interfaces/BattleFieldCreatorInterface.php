<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 01.10.2018
 * Time: 20:30
 */

namespace App\Services\Interfaces;

use App\Entity\BattleField;
use App\Entity\Board;

interface BattleFieldCreatorInterface
{
    public function generateBattleField(Board $board): BattleField;
}
