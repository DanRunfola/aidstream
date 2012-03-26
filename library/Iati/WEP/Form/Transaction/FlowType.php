<?php

class Iati_WEP_Form_Transaction_FlowType extends Iati_Form
{
    public function init()
    {
        $model = new Model_Wep();
        
        $this->setAttrib('class' , 'first-child')
            ->setMethod('post')
            ->setIsArray(true);
            
        $form = array();
        
        $form['id'] = new Zend_Form_Element_Hidden('id');
        
        $codes = $model->getCodeArray('FlowType', null, '1' , true);
        $form['code'] = new Zend_Form_Element_Select('code');
        $form['code']->setLabel('Code')
            ->setAttrib('class' , 'form-select')
            ->setMultioptions($codes);
                    
        $form['text'] = new Zend_Form_Element_Textarea('text');
        $form['text']->setLabel('Text')
            ->setAttribs(array('rows'=>'3' , 'cols'=> '20'));
        
        $lang = $model->getCodeArray('Language', null, '1' , true);
        $form['lang'] = new Zend_Form_Element_Select('lang');
        $form['lang']->setLabel('Language')
            ->setAttrib('class' , 'form-select')
            ->setMultioptions($lang);
        
        $this->addElements($form);
    }
}