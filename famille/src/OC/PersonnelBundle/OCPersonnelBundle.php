<?php

namespace OC\PersonnelBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OCPersonnelBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
