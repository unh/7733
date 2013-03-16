<?php
$this->breadcrumbs=array(
	'Streets'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Street','url'=>array('index')),
	array('label'=>'Create Street','url'=>array('create')),
	array('label'=>'Update Street','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Street','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Street','url'=>array('admin')),
);
?>

<h1>View Street #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        array(
            'label'=>$model->getAttributeLabel('city_id'),
            'value'=>$model->city->name,
        ),
        'name',
	),
)); ?>
