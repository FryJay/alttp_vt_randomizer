<?php

namespace ALttP\Rule\Boss;

use ALttP\Rule\Boss;

class BasicPlacement extends Boss
{
    /**
     * This Rule changes the game to allow swords.
     */

    public function canBeatBoss($world, $bossName, $items)
    {
        switch ($bossName)
        {
            case 'Arrghus':
                return $items->hasSword(2);
            case 'Mothula':
                return $items->hasAny(["Sword2", "FireRod2"]);
            case 'Blind':
                return $items->hasSword() && $items->hasAny(['Cape', 'CaneOfByrna']);
            case 'Kholdstare':
                return $items->hasAny(["Sword2", "FireRod3"]) || 
                    $items->hasAll(['Bombos2', 'FireRod2', 'Sword']);
            case 'Vitreous':
                return $items->hasAny(['Sword2', 'Bow']);
            case 'Trinexx':
                return $items->hasSword(3) || 
                    ($items->canExtendMagic($world, 2) && $items->hasSword(2));
            default:
                return parent::canBeatBoss($world, $bossName, $items);
        }
    }

    public function initWorld(&$config) { 
        $config['region.forceSkullWoodsKey'] = true;
    }

    public function canEnter($world, $regionName, $items) {

        $parentResult = parent::canEnter($world, $regionName, $items);
        $basicPlacementResult = True;

        switch ($regionName)
        {
            case 'Ganons Tower':
                $basicPlacementResult = 
                    (($this->world->config('mode.weapons') === 'swordless' || $items->hasSword(2)) && 
                    $items->hasHealth(12) && 
                    ($items->hasBottle(2) || $items->hasArmor()));
                break;
            default:
                break;
        }
        return $parentResult && $basicPlacementResult;
    }
}