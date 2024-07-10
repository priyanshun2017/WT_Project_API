<?php
class User {
    private $name;
    private $regno;
    
    public function __construct($name, $regno) {
        $this->name = $name;
        $this->regno = $regno;
    }

    public function getName() {
        return $this->name;
    }

    public function getRegno() {
        return $this->regno;
    }
}
?>
