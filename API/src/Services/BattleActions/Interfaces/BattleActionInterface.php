<?php
/**
 * Created by PhpStorm.
 * User: anghel
 * Date: 07.10.2018
 * Time: 13:31
 */

namespace App\Services\BattleActions\Interfaces;

use App\Entity\BattleField;
use App\Entity\GameAction;
use App\Entity\User;

interface BattleActionInterface
{
    public function handle(User $user, BattleField $battleField): GameAction;
    public function support(User $user, BattleField $battleField): bool ;
    public function getPriority(): int;
    public function getName(): string;
}