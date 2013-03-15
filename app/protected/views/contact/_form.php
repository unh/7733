<?php
/* @var $this ContactController */
/* @var $model Contact */
/* @var $form CActiveForm */
?>

<div class="form">
    <? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'verticalForm',
        'htmlOptions'=>array('class'=>'well'),
    )); ?>

    <?php echo $form->textFieldRow($model, 'name', array('class'=>'span3')); ?>
    <?php echo $form->textFieldRow($model, 'second_name', array('class'=>'span3')); ?>
    <?php echo $form->textFieldRow($model, 'last_name', array('class'=>'span3')); ?>
    <?php echo $form->dateField($model, 'birthday', array('class'=>'span3')); ?>
    <?php echo $form->dropDownList(
        $model, 'street_id',
        CHtml::listData(City::model()->findAll(), 'id', 'name'),
        array('class'=>'span3')
    ); ?>

    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array('buttonType'=>'submit', 'label'=> $model->isNewRecord ? 'Create' : 'Save')
    ); ?>


<?php $this->endWidget(); ?>

</div><!-- form -->