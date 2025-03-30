<?php

namespace MassConverter\FileFinder;

interface FilterInterface
{
    public function getFiles(string $path);
}
