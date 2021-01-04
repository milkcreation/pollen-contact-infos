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

<?php echo field('media-image', [
    'name'    => $field->getName(),
    'value'   => $field->getValue(),
    'width'   => 640,
    'height'  => 640
]);