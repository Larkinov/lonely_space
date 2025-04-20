<?php

namespace Larkbu\LonelySpace\Model\Universe;

use Larkbu\LonelySpace\Model\Space\SpaceObject;
use Larkbu\LonelySpace\Model\Space\Star;

final class Universe
{
    const SIZE_X = 5;
    const SIZE_Y = 5;
    const SIZE_Z = 5;

    const DEFAULT_STARS =  [
        [
            'name' => 'Сириус',
            'description' => 'Самая яркая звезда на ночном небе, известная как "Собачья звезда", находится в созвездии Большого пса.'
        ],
        [
            'name' => 'Проксима Центавра',
            'description' => 'Ближайшая к Земле звезда, находящаяся в системе Альфа Центавра, известная своей планетой в зоне обитаемости.'
        ],
        [
            'name' => 'Бетельгейзе',
            'description' => 'Красный гигант в созвездии Ориона, который может стать суперновой в будущем.'
        ],
        [
            'name' => 'Вега',
            'description' => 'Яркая звезда в созвездии Лиры, одна из ближайших звезд к Земле, и часть треугольника летом.'
        ],
        [
            'name' => 'Антарес',
            'description' => 'Красный супергигант в созвездии Скорпиона, известный своим ярким оранжево-красным цветом.'
        ],
        [
            'name' => 'Альдебаран',
            'description' => 'Яркая звезда в созвездии Тельца, которая является главной звездой этого созвездия.'
        ],
        [
            'name' => 'Капелла',
            'description' => 'Яркая двойная звезда в созвездии Возничего, состоящая из двух желтых гигантов.'
        ],
        [
            'name' => 'Плэйядос',
            'description' => 'Сквозь общий свет выступает в виде туманности; это звезды, которые можно увидеть невооруженным глазом в созвездии Тельца.'
        ],
        [
            'name' => 'Спика',
            'description' => 'Основная звезда в созвездии Девы и одна из самых ярких звезд на ночном небе.'
        ],
        [
            'name' => 'Денеб',
            'description' => 'Яркая звезда в созвездии Лебедя, которая является частью Летнего треугольника.'
        ]
    ];

    public static function create() {}

    public static function setTableStars()
    {
        for ($i = 0; $i < count(Universe::DEFAULT_STARS); $i++) {

            $star = Star::create(
                [
                    'name' => Universe::DEFAULT_STARS[$i]['name'],
                    'description' => Universe::DEFAULT_STARS[$i]['description'],
                ]
            );

            $star->save();
        }
    }

    public static function createSpaceObjects()
    {

        $stars = Star::getAll();

        $procentGenerated = 33;

        for ($x = 0; $x <= self::SIZE_X; $x++) {
            for ($y = 0; $y <= self::SIZE_Y; $y++) {
                for ($z = 0; $z <= self::SIZE_Z; $z++) {
                    if ($procentGenerated > random_int(0, 100)) {
                        $randStar = random_int(0, count($stars) - 1);
                        $spaceObject = SpaceObject::create(
                            [
                                'type' => $stars[$randStar]->getType(),
                                'objectId' => $stars[$randStar]->getId(),
                                'coordinates' => 'x' . strval($x + 1) . 'y' . strval($y + 1) . 'z' . strval($z + 1),
                            ]
                        );
                    } else {
                        $spaceObject =  SpaceObject::create(
                            [
                                'type' => 'star',
                                'objectId' => '-1',
                                'coordinates' => 'x' . strval($x + 1) . 'y' . strval($y + 1) . 'z' . strval($z + 1),
                            ]
                        );
                    }
                    $spaceObject->save();
                }
            }
        }
    }
}
