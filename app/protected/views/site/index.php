<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

    <div class="search-form">
        <?php
        $model = Contact::model();
        $this->renderPartial('/contact/_search',array(
            'model' => $model,
        )); ?>
    </div><!-- search-form -->

<?php //$this->widget('bootstrap.widgets.TbGridView',array(
//    'id'=>'street-grid',
//    'dataProvider'=>$model->search(),
//    'columns'=>array(
//        'id',
//        array('name' => 'city_search', 'value' => '$data->city->name' ),
//        array('name' => 'name', 'value' => '$data->name' ),
//        array(
//            'class'=>'bootstrap.widgets.TbButtonColumn',
//        ),
//    ),
//)); ?>