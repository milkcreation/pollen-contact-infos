<?php

declare(strict_types=1);

namespace Pollen\ContactInfos\Metabox;

class ContactInfosFieldBag extends AbstractContactInfosBag
{
    /**
     * Récupération de la clé d'indice de qualification de la valeur en base.
     *
     * @return string
     */
    public function getName(): string
    {
        $name = $this->get('name') ? : $this->getAlias();
        $group = $this->get('group');

        return $this->metabox->getName() . '[datas]' . ($group ? "[{$group}]" : '') . "[{$name}]";
    }

    /**
     * Récupération de la valeur enregistrée en base.
     *
     * @param mixed $default
     *
     * @return mixed
     */
    public function getValue($default = null)
    {
        $name = $this->get('name') ? : $this->getAlias();
        $group = $this->get('group');

        return $this->metabox->getValue('datas.' . ($group ? "{$group}." : '') . $name, $default);
    }

    /**
     * Récupération de l'intitulé de qualification.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return (string)$this->get('title') ? : $this->getAlias();
    }

    /**
     * Récupération de l'intitulé de qualification.
     *
     * @return string
     */
    public function render(): string
    {
        $tmpl = "field-{$this->getAlias()}";

        if (!$this->metabox->view()->exists($tmpl)) {
            $tmpl = 'tmpl-field';
        }

        return $this->metabox->view($tmpl, ['field' => $this]);
    }
}
