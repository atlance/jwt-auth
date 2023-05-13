<?php

declare(strict_types=1);

use Atlance\JwtAuth\AtlanceJwtAuthBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;

return [
    FrameworkBundle::class => ['all' => true],
    SecurityBundle::class => ['all' => true],
    SensioFrameworkExtraBundle::class => ['all' => true],
    AtlanceJwtAuthBundle::class => ['all' => true],
];
