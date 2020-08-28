<?php

namespace ALttP;

use ALttP\Item;

/**
 * A rule is a setting that can apply changes to the game.
 */
abstract class Rule
{
    /**
     * The basic rule set
     */

    abstract public function canBeatBoss($world, $bossName, $items);

    abstract public function initWorld(&$config);

    abstract public function prepareWorld($world, &$advancement_items, &$nice_items_swords, &$nice_items);

    abstract public function canEnter($regionName, $items);
}
