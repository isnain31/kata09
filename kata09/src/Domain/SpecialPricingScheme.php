<?php

namespace App\Domain;

abstract class SpecialPricingScheme
{
    public int $priority;

    public abstract  function setPriority(int $priority): void;
    public abstract  function getPriority():int;
}