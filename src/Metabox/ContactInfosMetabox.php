<?php

declare(strict_types=1);

namespace Pollen\ContactInfos\Metabox;

use Illuminate\Support\Collection;
use Pollen\ContactInfos\Contracts\ContactInfosContract;
use Pollen\ContactInfos\ContactInfosAwareTrait;
use tiFy\Metabox\Contracts\MetaboxContract;
use tiFy\Metabox\MetaboxDriver;
use tiFy\Metabox\MetaboxDriverInterface;

class ContactInfosMetabox extends MetaboxDriver
{
    use ContactInfosAwareTrait;

    /**
     * Liste des instances de champs déclarés.
     * @var ContactInfosFieldBag[]|array
     */
    protected $fields = [];

    /**
     * Liste des instances de groupe de champs déclarés.
     * @var ContactInfosGroupBag[]|array
     */
    protected $groups = [];

    /**
     * @inheritDoc
     */
    protected $name = 'contact_infos';

    /**
     * @param ContactInfosContract $contactInfos
     * @param MetaboxContract $metaboxManager
     */
    public function __construct(ContactInfosContract $contactInfos, MetaboxContract $metaboxManager)
    {
        $this->setContactInfos($contactInfos);

        parent::__construct($metaboxManager);
    }

    /**
     * Déclaration d'un champ.
     *
     * @param string $alias
     * @param array|ContactInfosFieldBag $args
     *
     * @return $this
     */
    public function addField(string $alias, $args = []): self
    {
        $field = $args instanceof ContactInfosFieldBag ? $args : (new ContactInfosFieldBag())->set($args);

        $this->fields[$alias] = $field->setMetabox($this)->setAlias($alias);

        return $this;
    }

    /**
     * Déclaration d'un groupe de champ.
     *
     * @param string $alias
     * @param array|ContactInfosGroupBag $args
     *
     * @return $this
     */
    public function addGroup(string $alias, $args = []): self
    {
        $group = $args instanceof ContactInfosGroupBag ? $args : (new ContactInfosGroupBag())->set($args);

        $this->groups[$alias] = $group->setMetabox($this)->setAlias($alias);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function boot(): MetaboxDriverInterface
    {
        parent::boot();

        $fields = [
            'address1' => [
                'group' => 'contact',
                'title' => __('Adresse Postale', 'tify'),
            ],
            'address2' => [
                'group' => 'contact',
                'title' => __('Adresse complémentaire', 'tify'),
            ],
            'address3' => [
                'group' => 'contact',
                'title' => __('Informations supplémentaires concernant l\'adresse', 'tify'),
            ],
            'city'     => [
                'group' => 'contact',
                'title' => __('Ville', 'tify'),
            ],
            'postcode' => [
                'group' => 'contact',
                'title' => __('Code postal', 'tify'),
            ],
            'country'  => [
                'group' => 'contact',
                'title' => __('Pays', 'tify'),
            ],
            'phone'    => [
                'group' => 'contact',
                'title' => __('Numéro de téléphone', 'tify'),
            ],
            'fax'      => [
                'group' => 'contact',
                'title' => __('Numéro de fax', 'tify'),
            ],
            'email'    => [
                'group' => 'contact',
                'title' => __('Adresse de messagerie', 'tify'),
            ],
            'website'  => [
                'group' => 'contact',
                'title' => __('Site internet', 'tify'),
            ],
            'map'      => [
                'group' => 'contact',
                'title' => __('Carte', 'theme'),
            ],
            'maplink'  => [
                'group' => 'contact',
                'title' => __('Lien vers la carte interactive', 'theme'),
            ],
            'name'     => [
                'group' => 'company',
                'title' => __('Nom de la société', 'tify'),
            ],
            'form'     => [
                'group' => 'company',
                'title' => __('Forme juridique', 'tify'),
            ],
            'siren'    => [
                'group' => 'company',
                'title' => __('Numéro de SIREN', 'tify'),
            ],
            'siret'    => [
                'group' => 'company',
                'title' => __('Numéro de SIRET', 'tify'),
            ],
            'tva'      => [
                'group' => 'company',
                'title' => __('N° de TVA Intracommunautaire', 'tify'),
            ],
            'ape'      => [
                'group' => 'company',
                'title' => __('Activité (Code NAF ou APE)', 'tify'),
            ],
            'cnil'     => [
                'group' => 'company',
                'title' => __('Déclaration CNIL', 'tify'),
            ],
            'opening'  => [
                'group' => 'company',
                'title' => __('Horaires d\'ouverture', 'theme'),
            ],
        ];

        foreach ($fields as $alias => $field) {
            $this->addField($alias, $field);
        }

        $groups = [
            'contact' => [
                'title' => __('Informations de contact', 'theme'),
            ],
            'company' => [
                'title' => __('Informations sur la société', 'theme'),
            ],
        ];

        foreach ($groups as $alias => $group) {
            $this->addGroup($alias, $group);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(
            parent::defaultParams(),
            [
                'fields' => ['address1', 'address2', 'city', 'postcode', 'phone', 'email'],
                'groups' => ['contact'],
            ]
        );
    }

    /**
     * Récupération de la liste des champs associé à un groupe.
     *
     * @param string $group Alias de qualification du groupe.
     *
     * @return ContactInfosFieldBag[]|array
     */
    public function getFields(string $group): array
    {
        $exists = $this->get('fields', []);
        $fields = [];

        foreach ($exists as $alias) {
            if (isset($this->fields[$alias])) {
                $fields[$alias] = $this->fields[$alias]->build();
            }
        }

        return (new Collection($fields))->filter(
            function ($field) use ($group) {
                return $field->group === $group;
            }
        )->sortBy('position')->all();
    }

    /**
     * Récupération de la liste des groupes de champs.
     *
     * @return ContactInfosGroupBag[]|array
     */
    public function getGroups(): array
    {
        $aliases = $this->get('groups', []);
        $groups = [];

        foreach ($aliases as $alias) {
            if (isset($this->groups[$alias])) {
                $groups[$alias] = $this->groups[$alias]->build();
            }
        }

        return (new Collection($groups))->sortBy('position')->all();
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->title ?? __('Informations de contact', 'tify');
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $this->set('groups', $this->getGroups());

        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->cinfos()->resources('/views/metabox/');
    }
}
