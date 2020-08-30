<?php

use ALttP\Support\ItemCollection;
use ALttP\Item;
use ALttP\World;
use ALttP\Boss;

class BossTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->world = World::factory();
        $this->collected->setChecksForWorld($this->world->id);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->collection);
        unset($this->world);
    }

    public function agahnimDataProvider()
    {
        return [
            [[], null, False],
            [['L1Sword'], null, True],
            [['L2Sword'], null, True],
            [['BugCatchingNet'], null, True],
            [['Hammer'], null, True],
            [['FireRod'], null, False],
            [['Boomerang'], null, False],
        ];
    }

    /**
     * @dataProvider agahnimDataProvider
     */
    public function testAgahnim($items, $settings, $expectedToBeat)
    {
        $this->bossCheck("Agahnim", $items, $settings, $expectedToBeat);
        $this->bossCheck("Agahnim2", $items, $settings, $expectedToBeat);
    }

    public function armosDataProvider()
    {
        return [
            [[], null, False],
            [['L1Sword'], null, True],
            [['Hammer'], null, True],
            [['Bow'], null, True],
            [['Boomerang'], null, True],
            [['RedBoomerang'], null, True],
            [['HalfMagic', 'FireRod'], null, False],
            [['Bottle', 'HalfMagic', 'FireRod'], null, True],
            [['Bottle', 'HalfMagic', 'FireRod'], ['item.functionality' => 'hard'], False],
            [['Bottle', 'HalfMagic', 'IceRod'], null, True],
            [['Bottle', 'Bottle', 'FireRod'], null, False],
            [['CaneOfByrna'], null, False],
            [['CaneOfSomaria'], null, False],
            [['Bottle', 'CaneOfByrna'], null, True],
            [['Bottle', 'CaneOfSomaria'], null, True],
        ];
    }

    /**
     * @dataProvider armosDataProvider
     */
    public function testArmos($items, $settings, $expectedToBeat)
    {
        $this->bossCheck("Armos Knights", $items, $settings, $expectedToBeat);
    }

    public function lanmolasDataProvider()
    {
        return [
            [[], null, False],
            [['RedBoomerang'], null, False],
            [['L1Sword'], null, True],
            [['Hammer'], null, True],
            [['Bow'], null, True],
            [['FireRod'], null, True],
            [['IceRod'], null, True],
            [['CaneOfByrna'], null, True],
            [['CaneOfSomaria'], null, True],
        ];
    }

    /**
     * @dataProvider lanmolasDataProvider
     */
    public function testLanmolas($items, $settings, $expectedToBeat)
    {
        $this->bossCheck("Lanmolas", $items, $settings, $expectedToBeat);
    }

    public function moldormDataProvider()
    {
        return [
            [[], null, False],
            [['RedBoomerang'], null, False],
            [['L1Sword'], null, True],
            [['Hammer'], null, True],
            [['Bow'], null, False],
            [['FireRod'], null, False],
            [['IceRod'], null, False],
            [['CaneOfByrna'], null, False],
            [['CaneOfSomaria'], null, False],
        ];
    }

    /**
     * @dataProvider molDormDataProvider
     */
    public function testMoldorm($items, $settings, $expectedToBeat)
    {
        $this->bossCheck("Moldorm", $items, $settings, $expectedToBeat);
    }

    public function helmasaurDataProvider()
    {
        return [
            [[], null, False],
            [['RedBoomerang'], null, False],
            [['L1Sword'], null, True],
            [['Hammer'], null, False],
            [['Hammer', 'L1Sword'], ['itemPlacement' => 'basic'], False],
            [['Hammer', 'L2Sword' ], ['itemPlacement' => 'basic'], True],
            [['Hammer', 'Bow' ], ['itemPlacement' => 'basic'], True],
            [['L1Sword', 'Hammer'], null, True],
        ];
    }

    /**
     * @dataProvider helmasaurDataProvider
     */
    public function testHelmasaur($items, $settings, $expectedToBeat)
    {
        $this->bossCheck("Helmasaur King", $items, $settings, $expectedToBeat);
    }

    public function arrghusDataProvider()
    {
        return [
            [[], null, False],
            [['L1Sword'], null, False],
            [['L2Sword'], null, False],
            [['L1Sword', 'Hookshot'], null, True],
            [['L1Sword', 'Hookshot'], ['itemPlacement' => 'basic'], False],
            [['L2Sword', 'Hookshot'], ['itemPlacement' => 'basic'], True],
            [['Hookshot'], ['itemPlacement' => 'basic', 'mode.weapons' => 'swordless'], False],
            [['Hookshot', 'Hammer'], ['itemPlacement' => 'basic', 'mode.weapons' => 'swordless'], True],
            [['Hookshot', 'FireRod'], null, False],
            [['Hookshot', 'Bow'], null, False],
            [['Hookshot', 'Bow', 'FireRod'], null, True],
            [['Hookshot', 'FireRod', 'Bottle'], null, True],
            [['Hookshot', 'FireRod', 'HalfMagic'], null, True],
            [['Hookshot', 'IceRod', 'Bottle'], null, True],
        ];
    }

    /**
     * @dataProvider arrghusDataProvider
     */
    public function testArrghus($items, $settings, $expectedToBeat)
    {
        $this->bossCheck("Arrghus", $items, $settings, $expectedToBeat);
    }

    public function mothulaDataProvider()
    {
        return [
            [[], null, False],
            [['L1Sword'], null, True],
            [['FireRod', 'Bottle'], null, True],
            [['FireRod', 'HalfMagic'], null, True],
            [['CaneOfSomaria', 'Bottle'], null, True],
            [['CaneOfByrna', 'Bottle'], null, True],
            [['Hammer'], null, True],
            [['Hammer'], ['itemPlacement' => 'basic'], False],
            [['L1Sword'], ['itemPlacement' => 'basic'], False],
            [['L2Sword'], ['itemPlacement' => 'basic'], True],
            [['FireRod'], ['itemPlacement' => 'basic'], False],
            [['FireRod', 'Bottle'], ['itemPlacement' => 'basic'], True],
            [['Bottle', 'BugCatchingNet', 'PegasusBoots', 'Quake'], null, True], # Good bee
            [['Bottle', 'BugCatchingNet', 'PegasusBoots', 'Quake'], ['itemPlacement' => 'basic'], False], # Good bee
        ];
    }

    /**
     * @dataProvider mothulaDataProvider
     */
    public function testMothua($items, $settings, $expectedToBeat)
    {
        $this->bossCheck("Mothula", $items, $settings, $expectedToBeat);
    }

    public function blindDataProvider()
    {
        return [
            [[], null, False],
            [['L1Sword'], null, True],
            [['L1Sword'], ['itemPlacement' => 'basic'], False],
            [['L1Sword', 'Cape'], ['itemPlacement' => 'basic'], True],
            [['Hammer'], null, True],
            [['Hammer'], ['itemPlacement' => 'basic', 'mode.weapons' => 'swordless'], True],
            [['CaneOfSomaria'], null, True],
            [['CaneOfByrna'], null, True],
            [['CaneOfSomaria'], ['itemPlacement' => 'basic', 'mode.weapons' => 'swordless'], True],
            [['CaneOfByrna'], ['itemPlacement' => 'basic', 'mode.weapons' => 'swordless'], True],
        ];
    }

    /**
     * @dataProvider blindDataProvider
     */
    public function testBlind($items, $settings, $expectedToBeat)
    {
        $this->bossCheck("Blind", $items, $settings, $expectedToBeat);
    }

    public function kholdstareDataProvider()
    {
        return [
            [[], null, False],
            [['L1Sword'], null, False],
            [['L2Sword'], null, False],
            [['L1Sword', 'FireRod'], null, True],
            [['L1Sword', 'Bombos'], null, True],
            [['L1Sword', 'Bombos'], ['itemPlacement' => 'basic'], False],
            [['L1Sword', 'FireRod'], ['itemPlacement' => 'basic'], False],
            [['L1Sword', 'Bombos', 'Bottle'], ['itemPlacement' => 'basic'], False],
            [['Bombos', 'FireRod', 'Bottle'], ['itemPlacement' => 'basic'], False],
            [['Bombos', 'FireRod', 'Bottle'], ['mode.weapons' => 'swordless', 'itemPlacement' => 'basic'], True],
            [['L1Sword', 'Bombos', 'FireRod', 'Bottle'], ['itemPlacement' => 'basic'], True],
            [['FireRod', 'Bombos', 'Bottle'], null, False],
            [['FireRod', 'Bombos', 'Bottle', 'Bottle'], null, True],
            [['Hammer'], ['itemPlacement' => 'basic', 'mode.weapons' => 'swordless'], False],
            [['Hammer', 'FireRod'], ['itemPlacement' => 'basic', 'mode.weapons' => 'swordless'], False],
            [['FireRod', 'Bottle'], ['mode.weapons' => 'swordless'], False],
            [['FireRod', 'Bottle', 'Bottle'], ['mode.weapons' => 'swordless'], True],
            [['FireRod', 'Bottle', 'HalfMagic'], ['mode.weapons' => 'swordless'], True],
            [['FireRod', 'Bombos', 'Bottle'], ['mode.weapons' => 'swordless'], True],
        ];
    }

    /**
     * @dataProvider kholdstareDataProvider
     */
    public function testKholdstare($items, $settings, $expectedToBeat)
    {
        $this->bossCheck("Kholdstare", $items, $settings, $expectedToBeat);
    }

    public function vitreousDataProvider()
    {
        return [
            [[], null, False],
            [['L1Sword'], null, True],
            [['Hammer'], null, True],
            [['Bow'], null, True],
            [['L1Sword'], ['itemPlacement' => 'basic'], False],
            [['L2Sword'], ['itemPlacement' => 'basic'], True],
            [['L1Sword', 'Bow'], ['itemPlacement' => 'basic'], True],
            [['Bow'], ['itemPlacement' => 'basic'], True],
            [['Hammer'], ['itemPlacement' => 'basic'], False],
        ];
    }

    /**
     * @dataProvider vitreousDataProvider
     */
    public function testVitreous($items, $settings, $expectedToBeat)
    {
        $this->bossCheck("Vitreous", $items, $settings, $expectedToBeat);
    }

    public function trinexxDataProvider()
    {
        return [
            [[], null, False],
            [['L1Sword'], null, False],
            [['L4Sword'], null, False],
            [['FireRod'], null, False],
            [['IceRod'], null, False],
            [['FireRod', 'IceRod'], null, False],
            [['FireRod', 'IceRod', 'Hammer'], null, True],
            [['FireRod', 'IceRod', 'L1Sword'], null, False],
            [['FireRod', 'IceRod', 'L2Sword'], null, False],
            [['FireRod', 'IceRod', 'L3Sword'], null, True],
            [['FireRod', 'IceRod', 'L2Sword', 'Bottle'], null, True],
            [['FireRod', 'IceRod', 'L1Sword', 'Bottle'], null, False],
            [['FireRod', 'IceRod', 'L1Sword', 'Bottle', 'Bottle'], null, False],
            [['L2Sword', 'FireRod', 'IceRod'], ['itemPlacement' => 'basic'], False],
            [['L2Sword', 'FireRod', 'IceRod', 'Bottle', 'Bottle'], ['itemPlacement' => 'basic'], True],
            [['L1Sword', 'FireRod', 'IceRod', 'Bottle', 'Bottle', 'HalfMagic'], null, True],
            [['FireRod', 'IceRod', 'Bottle', 'Bottle'], ['mode.weapons' => 'swordless', 'itemPlacement' => 'basic'], False],
            [['FireRod', 'IceRod', 'Hammer'], ['mode.weapons' => 'swordless', 'itemPlacement' => 'basic'], True],
        ];
    }

    /**
     * @dataProvider trinexxDataProvider
     */
    public function testTrinexx($items, $settings, $expectedToBeat)
    {
        $this->bossCheck("Trinexx", $items, $settings, $expectedToBeat);
    }

    private function bossCheck($bossName, $items, $settings, $expectedToBeat)
    {
        if ($settings !== null)
        {
            $this->world = World::factory('standard', $settings);
            $this->collected->setChecksForWorld($this->world->id);
        }

        $this->addCollected($items);

        $allBosses = Boss::all($this->world);


        $boss = $allBosses[$bossName];
        
        $this->assertEquals($boss->getName(), $bossName);
        $this->assertEquals($expectedToBeat, $boss->canBeat($this->collected));
    }
}