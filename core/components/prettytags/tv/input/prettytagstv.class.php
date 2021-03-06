<?php

if(!class_exists('PrettyTagsTvInputRender')) {
    class PrettyTagsTvInputRender extends modTemplateVarInputRender {

        public function getTemplate() {
            return $this->modx->getOption('core_path').'components/prettytags/tv/tpl/prettytagstv.tpl';
        }

        public function process($value,array $params = array()) {
            //TODO: хз, должен был по идее и так пакет видеть, если знаете, пишите
            $this->modx->addPackage('prettytags', $this->modx->getOption('core_path') . 'components/prettytags/model/');
            $this->modx->lexicon->load('prettytags:default');

            $query = $this->modx->newQuery('prettyTagsItem');

            $query->sortby('name','ASC');
            $query->where(array(
                'active' => 1,
            ));

            $prettyTags = $this->modx->getCollection('prettyTagsItem', $query);

            $values = explode(",", $value);

            $tags = [];
            foreach($prettyTags as $tag){
                $tags[$tag->id]['name'] = $tag->name;
                $tags[$tag->id]['checked'] = in_array($tag->id, $values);
            }


            $noTagsText = $this->modx->lexicon('prettytags_no_tags');

            $this->setPlaceholder('opts', $tags);
            $this->setPlaceholder('noTagsText', $noTagsText);
        }
    }
}

return 'PrettyTagsTvInputRender';
