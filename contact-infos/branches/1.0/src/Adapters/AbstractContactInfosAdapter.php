<?php

declare(strict_types=1);

namespace Pollen\ContactInfos\Adapters;

use Pollen\ContactInfos\ContactInfosAwareTrait;
use Pollen\ContactInfos\Contracts\ContactInfosContract;

abstract class AbstractContactInfosAdapter implements AdapterInterface
{
    use ContactInfosAwareTrait;

    /**
     * @param ContactInfosContract $cinfosManager
     */
    public function __construct(ContactInfosContract $cinfosManager)
    {
        $this->setContactInfos($cinfosManager);
    }
}
