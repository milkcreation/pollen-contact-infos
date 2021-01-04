<?php
/**
 * @var tiFy\Metabox\MetaboxViewInterface $this
 * @var Pollen\ContactInfos\Metabox\ContactInfosFieldBag $field
 */
?>
<?php $this->layout('layout-field'); ?>

<?php $this->start('label'); ?>
<?php echo $field->getTitle(); ?>
<?php $this->end(); ?>

<?php echo field('text', [
    'attrs' => [
        'class' => '%s widefat',
    ],
    'name'  => $field->getName(),
    'value' => $field->getValue(),
]);