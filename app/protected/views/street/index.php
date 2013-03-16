<?php
$this->breadcrumbs=array(
	'Streets',
);

$this->menu=array(
	array('label'=>'Create Street','url'=>array('create')),
	array('label'=>'Manage Street','url'=>array('admin')),
);
?>

<h1>Streets</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
