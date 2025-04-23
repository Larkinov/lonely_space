<?php

namespace Larkbu\LonelySpace\Model\Universe;

use Larkbu\LonelySpace\Exception\CoordinatesException;

abstract class ICoordinates
{

    private string $coordinates;
    protected array $axis = ['x' => 0, 'y' => 0, 'z' => 0];

    public function __construct(string $coordinates)
    {
        $this->coordinates = $coordinates;
        $this->prepare();
    }

    private function prepare(): void
    {
        preg_match('/x([-+]?\d+)y([-+]?\d+)z([-+]?\d+)/', $this->coordinates, $matches);

        if (count($matches) === 4) {
            $this->axis['x'] = (int)$matches[1];
            $this->axis['y'] = (int)$matches[2];
            $this->axis['z'] = (int)$matches[3];
        } else {
            throw new CoordinatesException('Количество полученных координат не равно трем');
        }
    }

    public function getAxis(): array
    {
        return $this->axis;
    }

    public function fly(string $direction, int $step = 1): void
    {

        switch ($direction) {
            case 'forward':
                $this->flyAxis('x', true, Universe::SIZE_X, $step);
                break;
            case 'back':
                $this->flyAxis('x', false, Universe::SIZE_X, $step);
                break;
            case 'up':
                $this->flyAxis('y', true, Universe::SIZE_Y, $step);
                break;
            case 'down':
                $this->flyAxis('y', false, Universe::SIZE_Y, $step);
                break;
            case 'right':
                $this->flyAxis('z', true, Universe::SIZE_Z, $step);
                break;
            case 'left':
                $this->flyAxis('z', false, Universe::SIZE_Z, $step);
                break;
            default:
                throw new CoordinatesException('Неизвестная координата - ' . $direction);
        }
    }

    private function flyAxis(string $axis, bool $isForward, int $max, int $step = 1): void
    {
        if ($isForward) {
            if ($this->axis[$axis] + $step <= $max)
                $this->axis[$axis] += $step;
            else
                $this->axis[$axis] = 0;
        } else {
            if ($this->axis[$axis] - $step >= 0)
                $this->axis[$axis] -= $step;
            else
                $this->axis[$axis] = $max;
        }
    }

    public function get()
    {
        return "x" . strval($this->axis['x']) . "y" . strval($this->axis['y']) . "z" . strval($this->axis['z']);
    }
}
