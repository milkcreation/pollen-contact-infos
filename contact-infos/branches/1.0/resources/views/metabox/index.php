<?php
/**
 * @var tiFy\Metabox\MetaboxViewInterface $this
 * @var Pollen\ContactInfos\Metabox\ContactInfosFieldBag $field
 * @var Pollen\ContactInfos\Metabox\ContactInfosGroupBag $group
 */
?>
<div <?php $this->htmlAttrs(); ?>>
    <div class="ContactInfosMetabox-groups">
        <?php $this->insert('groups', $this->all()); ?>
    </div>
</div>
