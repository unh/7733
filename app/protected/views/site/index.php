<?php
/* @var $this SiteController
 * @var $form TbActiveForm
 */

$this->pageTitle=Yii::app()->name;
?>

<div class="form">
<? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'verticalForm',
    'inlineErrors' => false,
    'method' => 'get',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<?php
    echo CHtml::label('Name', 'fio');
    echo CHtml::textField('Contact[fio]', $model->fio, array('class'=>'span6'));

    echo CHtml::label('Phone', 'phone');
    echo CHtml::textField('Contact[phone]', $model->phone, array('class'=>'span3'));

    echo $form->dropDownListRow($model, 'city_id_search', CHtml::listData(City::model()->findAll(), 'id', 'name'), array('class'=>'span3'));
?>

<?php //echo $form->textFieldRow($model, 'phone', array('class'=>'span3')); ?>

    <div class="form-actions">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            array('buttonType'=>'submit', 'label'=> 'Search')
        ); ?>
    </div>


<?php $this->endWidget(); ?>
</div>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'contact-grid',
    'dataProvider'=>$model->searchFio(),
    'columns'=>array(
        'name',
        'second_name',
        'last_name',
        'birthday',
        array('name' => 'street_search', 'value' => '$data->street->name'),
        array('name' => 'city_search', 'value' => '$data->street->city->name' ),
        'phone',
    ),
)); ?>