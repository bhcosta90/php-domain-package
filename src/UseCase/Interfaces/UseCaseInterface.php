<?php

namespace Costa\DomainPackage\UseCase\Interfaces;

interface UseCaseInterface
{
    public function execute(object $input): OutputInterface;
}
