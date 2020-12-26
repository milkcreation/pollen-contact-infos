<?php declare(strict_types=1);

namespace Pollen\ContactInfos;

use tiFy\Container\ServiceProvider;
use Pollen\ContactInfos\Adapters\WordpressAdapter;
use Pollen\ContactInfos\Contracts\ContactInfosContract;

class ContactInfosServiceProvider extends ServiceProvider
{
    /**
     * Liste des noms de qualification des services fournis.
     * @internal requis. Tous les noms de qualification de services à traiter doivent être renseignés.
     * @var string[]
     */
    protected $provides = [
        ContactInfosContract::class,
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
}