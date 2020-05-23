<?php

class prettyTagsOfficeItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'prettyTagsItem';
    public $classKey = 'prettyTagsItem';
    public $languageTopics = ['prettytags'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('prettytags_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('prettytags_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'prettyTagsOfficeItemCreateProcessor';