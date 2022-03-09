<?php

class PrimaryMenuItem
{
    protected $post;
    public $url;
    public $label;
    public $title;
    public $subItems = [];

    public function __construct($post)
    {
        $this->post= $post;
        $this->url = $post->url;
        $this->label = $post->title;
        $this->title = $post->attr_title;
    }

    public function hasSubItems()
    {
        return  ! empty($this->subItems);

    }

    public function isSubItems()
    {
        return boolval($this->getParentId());
            //boolval evalue ce quon lui donne et regrde sil est true ou false
            //menu item parent vaut 0 sil ya pas subitem
    }
    public function getParentId(){
        return $this->post->menu_item_parent;
    }

    public function isParentFor(PrimaryMenuItem $instance)
    {
        return ($this->post->ID == $instance->getParentId());
    }

    public function addSubItem(PrimaryMenuItem $instance)
    {

    $this->subItems[] = $instance;
    }
}