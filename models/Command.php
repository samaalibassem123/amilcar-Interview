<?php
    class Command{
        private $conn;
        private $id;
        private $name;
        private $description;

        public __construct($id, $name, $description, $price, $image){
            $this->id = $id;
            $this->name = $name;
            $this->description = $description;
            $this->price = $price;
            $this->image = $image;
        }

    }
?>