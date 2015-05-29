<?php

class MultiselectField extends CheckboxesField {

  public $yaml = false;

  static public $assets = array(
    'css' => array(
      'multiselect.css'
     ),
    'js' => array(
      'multiselect.js'
    )
  );

  public function __construct() {
    $this->icon    = 'chevron-down';
  }

  public function content() {

    $multiselect = new Brick('div');
    $multiselect->addClass('input input-display');

    if($this->readonly()) $multiselect->addClass('input-is-readonly');
    $multiselect->data(array(
      'field'    => 'multiselect',
      'readonly' => ($this->readonly or $this->disabled) ? 1 : 0
    ));

    // prepopulate with values
    $multiselect->append('<span class="placeholder">&nbsp;</span>');
    $options = $this->options();
    foreach($this->value() as $value) {
      if(!empty($value) and isset($options[$value])) {
        $tag = '<span class="item" title='.$value.'>'.$options[$value].'</span>';
        $multiselect->append($tag);
      }
    }

    $content = new Brick('div');
    $content->addClass('field-content input-with-multiselectbox');
    $content->append($multiselect);

    // list with options
    if(!$this->readonly and !$this->disabled) {
      $html = '<ul class="input-list">';
      foreach($this->options() as $key => $value) {
        $html .= '<li class="input-list-item">';
        $html .= $this->item($key, $value);
        $html .= '</li>';
      }
      $html .= '</ul>';

      $content->append($html);
    }

    $content->append($this->icon());

    return $content;

  }

  public function label() {
    $label = parent::label();
    $label->attr('for', '');
    return $label;
  }

  public function result() {
    $result = parent::result();
    if($this->yaml and !is_array($result)) {
      $result = array_filter(explode(', ', $result));
    }

    return empty($result) ? null : $result;
  }

}
