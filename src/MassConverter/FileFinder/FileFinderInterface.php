<?php

namespace MassConverter\FileFinder;

use MassConverter\validators\ValidatorInterface;

interface FileFinderInterface
{
    public function __construct(ValidatorInterface $validator, FilterInterface $filter);
    public function find(string $path): array;
}
