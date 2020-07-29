<?php
class camunda_variable {
    var $value;
    var $type;
    /**1
     * CamundaVar constructor.
     *
     * @param $value
     * @param $type
     */
    public function __construct($value, $type) {
        $this->value = $value;
        $this->type = $type;
    }
}