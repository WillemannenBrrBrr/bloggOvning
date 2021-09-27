<?php

class CFormCreator
{
    public function __construct(CApp &$app)
    {
        $this->m_app = $app;
    }

    public function openDiv(string $class)
    {
        echo('<div class="' . $class . '">');
    }

    public function openForm()
    {
        echo('<form method="post" enctype="multipart/form-data">');
    }

    public function createInput(string $type, string $name, string $label, string $required = "required")
    {
        echo('<div class="flexForm">');
        /* echo('<label for="' . $name . '">' . $label . ':</label>'); */
        echo('<input placeholder="' . $label . '" type="' . $type . '" name="' . $name . '" id="' . $name . '" "' . $required . '">');
        echo('</div>');
    }

    public function createTextArea(string $name, string $label)
    {
        echo('<textarea placeholder="' . $label . '" name="' . $name . '"></textarea>');
    }

    public function createSubmit(string $label)
    {
        echo('<div class="flexForm">');
        echo('<input type="submit" value="' . $label . '">');
        echo('</div>');
    }

    public function closeForm()
    {
        echo('</form>');
    }

    public function closeDiv()
    {
        echo('</div>');
    }

    //////////////////////////////////////////////////
    //variables

    private $m_app = null;

};

?>