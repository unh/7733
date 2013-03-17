<?php
/* @var $this ContactController */
/* @var $model Contact */

$this->breadcrumbs=array(
    'Contacts'=>array('index'),
    $model->name,
);

$this->menu=array(
    array('label'=>'List Contact','url'=>array('index')),
    array('label'=>'Create Contact','url'=>array('create')),
    array('label'=>'Update Contact','url'=>array('update','id'=>$model->id)),
    array('label'=>'Delete Contact','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage Contact','url'=>array('admin')),
);
?>

<h1>View Contact #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'name',
        'second_name',
        'last_name',
        'birthday',
        array(
            'label'=>$model->street->getAttributeLabel('city_id'),
            'value'=>$model->street->city->name,
        ),
        array(
            'label'=>$model->getAttributeLabel('street_id'),
            'value'=>$model->street->name,
        ),
        'phone'
    ),
)); ?>
