<?php

declare(strict_types=1);

namespace Pollen\ContactInfos;

use Pollen\ContactInfos\Adapters\WordpressAdapter;
use Pollen\ContactInfos\Contracts\ContactInfosContract;
use Pollen\ContactInfos\Metabox\ContactInfosMetabox;
use tiFy\Container\ServiceProvider;
use tiFy\Metabox\Contracts\MetaboxContract;

class ContactInfosServiceProvider extends ServiceProvider
{
    /**
     * Liste des noms de qualification des services fournis.
     * @internal requis. Tous les noms de qualification de services à traiter doivent être renseignés.
     * @var string[]
     */
    protected $provides = [
        ContactInfosContract::class,
        ContactInfosMetabox::class,
        WordpressAdapter::class
    ];

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        events()->listen('wp.booted', function () {
            /** @var ContactInfosContract $cinfos */
            $cinfos = $this->getContainer()->get(ContactInfosContract::class);

            if ($options = get_option('contact_infos') ?: null) {
                $cinfos->config($options);
            }
            $cinfos->setAdapter($this->getContainer()->get(WordpressAdapter::class))->boot();
        });
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->getContainer()->share(ContactInfosContract::class, function () {
            return new ContactInfos(config('contact-infos', []), $this->getContainer());
        });

        $this->registerAdapters();
        $this->registerMetaboxDrivers();
    }

    /**
     * Déclaration des adapteurs.
     *
     * @return void
     */
    public function registerAdapters(): void
    {
        $this->getContainer()->share(WordpressAdapter::class, function () {
            return new WordpressAdapter($this->getContainer()->get(ContactInfosContract::class));
        });
    }

    /**
     * Déclaration des metaboxes.
     *
     * @return void
     */
    public function registerMetaboxDrivers(): void
    {
        $this->getContainer()->add(ContactInfosMetabox::class, function () {
            return new ContactInfosMetabox(
                $this->getContainer()->get(ContactInfosContract::class),
                $this->getContainer()->get(MetaboxContract::class)
            );
        });
    }
}