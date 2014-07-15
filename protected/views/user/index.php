

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'user-grid',
    'dataProvider'=>$userModel->search(),
    'filter'=>$userModel,
    'template'=>'{summary} {pager} {items} {pager}',
    'columns'=>array(
        'Name',
        'LastName',
        'Email',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
        )
    ),
)); ?>