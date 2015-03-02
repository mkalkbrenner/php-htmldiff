<?php

class HtmlDiffAdvanced extends HtmlDiff implements HtmlDiffAdvancedInterface {
  protected $oldText = '';
  protected $newText = '';
  protected $encoding = 'UTF-8';
  protected $separatorTags = array(
    '<ul',
    '<ol',
    '<li',
    '<p',
    '<h',
    '<br',
    '<table',
    '<td'
  );
  protected $separatorCounter = 0;
  protected $buildRequired = TRUE;

  public function __construct($oldText = '', $newText = '', $encoding = '') {
    if ($oldText) {
      $this->setOldHtml($oldText);
    }

    if ($newText) {
      $this->setNewHtml($newText);
    }

    if ($encoding) {
      $this->setEncoding($encoding);
    }
  }

  public function setEncoding($encoding) {
    $this->buildRequired = TRUE;
    $this->encoding = $encoding;
    parent::__construct($this->oldText, $this->newText, $this->encoding);
  }

  public function setOldHtml($oldText) {
    $this->buildRequired = TRUE;
    $this->oldText = $this->addSeparatorTags($oldText);
    parent::__construct($this->oldText, $this->newText, $this->encoding);
  }

  public function getOldHtml() {
    return $this->removeSeparatorTags($this->oldText);
  }

  public function setNewHtml($newText) {
    $this->buildRequired = TRUE;
    $this->newText = $this->addSeparatorTags($newText);
    parent::__construct($this->oldText, $this->newText, $this->encoding);
  }

  public function getNewHtml() {
    return $this->removeSeparatorTags($this->newText);
  }

  public function getDifference() {
    if ($this->buildRequired) {
      $this->build();
    }
    return $this->removeSeparatorTags(parent::getDifference());
  }

  protected function addSeparatorTags($html) {
    foreach ($this->separatorTags as $tag) {
      $html = preg_replace_callback('#' . $tag . '#',
        function ($matches) {
          return '<t' . $this->separatorCounter++ . '>' . $matches[0];
        }, $html);
    }
    return $html;
  }

  protected function removeSeparatorTags($html) {
    return preg_replace('#<t\d+[^>]*>#', '', $html);
  }

  public function build() {
    if ($this->buildRequired) {
      $this->buildRequired = FALSE;
      return parent::build();
    }
  }
}