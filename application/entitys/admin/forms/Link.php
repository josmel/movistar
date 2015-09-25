<?php

class Admin_Form_Link extends Core_Form_Form {

    public function init() {
        $obj = new Application_Model_DbTable_Link();
        $primaryKey = $obj->getPrimaryKey();
        $this->setMethod('post');
        $this->setEnctype('multipart/form-data');
        $this->setAttrib('idlink', $primaryKey);
        $this->setAction('/link/index');
        $e = new Zend_Form_Element_Hidden($primaryKey);
        $this->addElement($e);
        $e = new Zend_Form_Element_Checkbox('chkEstado[]');
        $e->setValue(true);
        $this->addElement($e);
        $e = new Zend_Form_Element_Text('txtTitulo[]');
        $this->addElement($e);
        $e = new Zend_Form_Element_Text('txtLink[]');
        $this->addElement($e);
        $e = new Zend_Form_Element_Hidden('txtImagen[]');
        $this->addElement($e);

        foreach ($this->getElements() as $element) {
            $element->removeDecorator('Label');
            $element->removeDecorator('DtDdWrapper');
            $element->removeDecorator('HtmlTag');
        }
    }

}


