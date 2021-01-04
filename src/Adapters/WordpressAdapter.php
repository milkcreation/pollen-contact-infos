<?php

declare(strict_types=1);

namespace Pollen\ContactInfos\Adapters;

use Pollen\ContactInfos\Contracts\ContactInfosContract;

class WordpressAdapter extends AbstractContactInfosAdapter
{
    /**
     * @param ContactInfosContract $cinfosManager
     */
    public function __construct(ContactInfosContract $cinfosManager)
    {
        parent::__construct($cinfosManager);

        add_action(
            'init',
            function () {
                if ($config = config('contact-infos', true)) {
                    $defaults = [
                        'admin' => false,
                    ];

                    config(
                        [
                            'contact-infos' => is_array($config) ? array_merge($defaults, $config) : $defaults,
                        ]
                    );

                    if ($admin = config('contact-infos.admin')) {
                        $defaults = ['params' => []];

                        if ($fields = config('contact-infos.fields', [])) {
                            $defaults['params']['fields'] = $fields;
                        }

                        if ($groups = config('contact-infos.groups', [])) {
                            $defaults['params']['groups'] = $groups;
                        }

                        $attrs = is_array($admin) ? array_merge($defaults, $admin) : $defaults;
                        $attrs['driver'] = 'contact-infos';

                        $this->cinfos()->metaboxManager()->add(
                            md5('ContactInfosMetabox'),
                            array_merge(
                                $attrs,
                                [
                                    'driver' => 'contact-infos',
                                ]
                            ),
                            'tify_options@options',
                            'tab'
                        );
                    }
                }
            }
        );
    }
}
