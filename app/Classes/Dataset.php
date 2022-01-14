<?php


namespace App\Classes;


class Dataset
{
    public string $label;
    public array $data;
    public bool $fill = false;
    public $borderColor;
    public $backgroundColor;
    public float $tension = 0.1;
    public int $hoverOffset = 4;
}
