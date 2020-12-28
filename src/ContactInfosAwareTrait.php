<?php

declare(strict_types=1);

namespace Pollen\ContactInfos;

use Exception;
use Pollen\ContactInfos\Contracts\ContactInfosContract;

trait ContactInfosAwareTrait
{
    /**
     * Instance de l'application.
     * @var ContactInfosContract|null
     */
    private $cinfos;

    /**
     * Récupération de l'instance de l'application.
     *
     * @return ContactInfosContract|null
     */
    public function cinfos(): ?ContactInfosContract
    {
        if (is_null($this->cinfos)) {
            try {
                $this->cinfos = ContactInfos::instance();
            } catch (Exception $e) {
                $this->cinfos;
            }
        }

        return $this->cinfos;
    }

    /**
     * Définition de l'application.
     *
     * @param ContactInfosContract $cinfos
     *
     * @return static
     */
    public function setContactInfos(ContactInfosContract $cinfos): self
    {
        $this->cinfos = $cinfos;

        return $this;
    }
}