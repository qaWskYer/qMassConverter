<?php

namespace MassConverter\validators;

interface ValidatorInterface
{
    public function validate(string $filepath): bool;
}
