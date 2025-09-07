<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
error_reporting(-1);
ini_set('display_errors', 'On');
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
