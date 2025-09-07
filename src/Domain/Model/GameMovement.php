<?php
namespace App\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\DocumentEmbedded(collection="games")
 */
class GameMovement
{
    protected string $user;
    protected string $coord;
}
