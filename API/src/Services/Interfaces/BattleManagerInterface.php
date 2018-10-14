<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 07.10.2018
 * Time: 13:26
 */

namespace App\Services\Interfaces;

use App\Entity\BattleField;
use App\Entity\GameAction;

interface BattleManagerInterface
{
    public function makeTurn(BattleField $battleField): GameAction;
}