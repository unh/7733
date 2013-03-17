<?php
/* @var $this ContactController */
/* @var $data Contact */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('second_name')); ?>:</b>
	<?php echo CHtml::encode($data->second_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->street->getAttributeLabel('city_id')); ?>:</b>
	<?php echo CHtml::encode($data->street->city->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('street_id')); ?>:</b>
	<?php echo CHtml::encode($data->street->name); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
    <?php echo CHtml::encode($data->phone); ?>
    <br />


</div>