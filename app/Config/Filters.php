<?php

namespace Config;

use App\Filters\AdminFilter;
use App\Filters\AsnFilter;
use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'secureheaders' => SecureHeaders::class,
        'admin'         => AdminFilter::class,
        'asn'           => AsnFilter::class,
    ];

    public array $required = [
        'before' => [],
        'after'  => [],
    ];

    public array $globals = [
        'before' => [],
        'after'  => [
            'secureheaders',
        ],
    ];

    public array $methods = [];

    public array $filters = [];
}
