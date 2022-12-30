<?php

namespace Costa\DomainPackage\UseCase\Interfaces;

interface UseCaseInterface
{
    public function execute(UseCase\InputInterface $input): UseCase\OutputInterface;
}
