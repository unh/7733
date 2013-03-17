<?php
/* @var $this ContactController */
/* @var $model Contact */
/* @var $form TbActiveForm */
?>

<div class="form">
    <? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'verticalForm',
        'inlineErrors' => false,
        'htmlOptions'=>array('class'=>'well'),
    )); ?>

    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->textFieldRow($model, 'name', array('class'=>'span3')); ?>
    <?php echo $form->textFieldRow($model, 'second_name', array('class'=>'span3')); ?>
    <?php echo $form->textFieldRow($model, 'last_name', array('class'=>'span3')); ?>
    <?php
        echo $form->labelEx($model, 'birthday');
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name'      => 'date_start',
            'attribute' => 'birthday',
            'model'     => $model,
            'options'   => array(
                'dateFormat'  => 'dd.mm.yy',
                'changeMonth' => true,
                'changeYear'  => true,
                'minDate'     =>  "-100Y",
                'maxDate'     => date('d.m.Y')
            ),
            'htmlOptions' => array('class'=>'span3'),
        ));
        //echo $form->dateField($model, 'birthday', array('class'=>'span2'));

    ?>
    <?php ?>
    <?php
        echo CHtml::label('City', 'city');
        echo CHtml::dropDownList('city', '', CHtml::listData(City::model()->findAll(), 'id', 'name'));
    ?>

    <?php
        echo $form->labelEx($model, 'street_id');
        echo CHtml::textField('street', $model->street->name, array('class'=>'span3'));
        echo $form->hiddenField($model, 'street_id', array('class'=>'span3'));
    ?>

    <?php echo $form->textFieldRow($model, 'phone', array('class'=>'span3')); ?>
    <div class="form-actions">
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array('buttonType'=>'submit', 'label'=> $model->isNewRecord ? 'Create' : 'Save')
    ); ?>
    </div>


<?php $this->endWidget(); ?>

<?php
    Yii::app()->clientScript->registerScript('contact-form', <<<JS
        var map = {};
        $('#street').attr("autocomplete", "off")
                    .typeahead({
            source: function (query, process) {
                return $.get('/street/typeahead', { city: $('#city').val(), query: query }, function (data) {
                    var options = [];
                    map = [];
                    $('#Contact_street_id').val('');
                    $.each(data.options, function(i, object) {
                        map[object.name] = object;
                        options.push(object.name);
                    });
                    return process(options);
                });
            },

            updater: function(item) {
                $('#Contact_street_id').val(map[item].value);
                return item;
            }
        });

        $('#city').change(function() {
            $('#street').val('');
            $('#Contact_street_id').val('');
        });
JS
        , CClientScript::POS_READY);
?>


</div><!-- form -->