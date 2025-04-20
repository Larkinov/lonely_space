<?php

namespace Larkbu\LonelySpace\Model\Universe;

use Larkbu\LonelySpace\Exception\CoordinatesException;

class CoordinatesHome extends ICoordinates
{
    public function fly(string $direction, int $step = 1): void
    {

        switch ($direction) {
            case 'forward':
                $this->flyAxis('x', true, $step);
                break;
            case 'back':
                $this->flyAxis('x', false, $step);
                break;
            case 'up':
                $this->flyAxis('y', true, $step);
                break;
            case 'down':
                $this->flyAxis('y', false, $step);
                break;
            case 'right':
                $this->flyAxis('z', true, $step);
                break;
            case 'left':
                $this->flyAxis('z', false, $step);
                break;
            default:
                throw new CoordinatesException('Неизвестная координата - ' . $direction);
        }
    }

    private function flyAxis(string $axis, bool $isForward, int $step = 1): void
    {
        if ($isForward) {
            $this->axis[$axis] += $step;
        } else {
            $this->axis[$axis] -= $step;
        }
    }
}
