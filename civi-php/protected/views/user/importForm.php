<?php
 
return array(
    'attributes' => array(
        'enctype' => 'multipart/form-data',
    ),
 
    'elements' => array(
        'csvfile' => array(
            'type' => 'file',
        	'label'=> Yii::t('app', 'user.csvselectfile.label'),
        ),
    ),
 
    'buttons' => array(
        'reset' => array(
            'type' => 'reset',
            'label' => 'Reset',
        	'class' => CiviGlobals::$buttonClass['class'],
        ),
        'submit' => array(
            'type' => 'submit',
            'label' => 'Upload',
        	'class' => CiviGlobals::$buttonClass['class'],
        ),
    ),
);