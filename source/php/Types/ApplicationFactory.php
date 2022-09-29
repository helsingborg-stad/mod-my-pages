<?php
namespace ModMyPages\Types;

interface ApplicationFactory
{
    public function create(array $options, ApplicationServices $services) : Application;
}
