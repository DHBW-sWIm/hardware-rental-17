<?php

class Resource extends stdClass {

    public $name;
    public $comment;
    public $description;
    public $category;
    public $quantity;
    public $tenant;
    public $serial;
    public $manufacturer;
    public $inventory_nr;
    public $tags;

    public function __construct($name, $comment, $description, $category, $quantity, $tenant, $manufacturer, $serial, $inventory_nr, $tags)
    {
        $this->name = $name;
        $this->comment = $comment;
        $this->description = $description;
        $this->category = $category;
        $this->quantity = $quantity;
        $this->tenant = $tenant;
        $this->serial = $serial;
        $this->manufacturer = $manufacturer;
        $this->inventory_nr = $inventory_nr;
        $this->tags = $tags;
    }
}