<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;


class DataClass {
    #[Assert\NotBlank]
    public int $uninitialisedInteger;

    #[Assert\NotBlank]
    public int $integer = 1;
}
