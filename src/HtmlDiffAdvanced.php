<?php

class HtmlDiffAdvanced extends \Caxy\HtmlDiff\HtmlDiff implements HtmlDiffAdvancedInterface {

  protected $separatorTags = array(
    'ul',
    'ol',
    'li',
    'p',
    'h\d+',
    'br',
    'table',
    'td'
  );
  protected $separatorCounter = 0;
  protected $buildRequired = TRUE;
  protected $oldTextPurified = '';
  protected $newTextPurified = '';

  public function __construct($oldText = '', $newText = '', $encoding = 'UTF-8', $specialCaseTags = null, $groupDiffs = null) {
    parent::__construct($oldText, $newText, $encoding, $specialCaseTags, $groupDiffs);

    if ($oldText) {
      $this->setOldHtml($oldText);
    }

    if ($newText) {
      $this->setNewHtml($newText);
    }
  }

  public function setEncoding($encoding) {
    $this->encoding = $encoding;
    $this->buildRequired = TRUE;
  }

  public function setOldHtml($oldText) {
    $this->oldTextPurified = $this->purifyHtml(trim($oldText));
    $this->oldText = $this->addSeparatorTags($this->oldTextPurified);
    $this->buildRequired = TRUE;
  }

  public function getOldHtml() {
    return $this->oldTextPurified;
  }

  public function setNewHtml($newText) {
    $this->newTextPurified = $this->purifyHtml(trim($newText));
    $this->newText = $this->addSeparatorTags($this->newTextPurified);
    $this->buildRequired = TRUE;
  }

  public function getNewHtml() {
    return $this->newTextPurified;
  }

  public function setInsertSpaceInReplace($boolean) {
    parent::setInsertSpaceInReplace($boolean);
    $this->buildRequired = TRUE;
  }

  public function setSpecialCaseChars(array $chars) {
    parent::setSpecialCaseChars($chars);
    $this->buildRequired = TRUE;
  }

  public function addSpecialCaseChar($char) {
    parent::addSpecialCaseChar($char);
    $this->buildRequired = TRUE;
  }

  public function removeSpecialCaseChar($char) {
    parent::removeSpecialCaseChar($char);
    $this->buildRequired = TRUE;
  }

  public function setSpecialCaseTags(array $tags = array()) {
    parent::setSpecialCaseTags($tags);
    $this->buildRequired = TRUE;
  }

  public function addSpecialCaseTag($tag) {
    parent::addSpecialCaseTag($tag);
    $this->buildRequired = TRUE;
  }

  public function removeSpecialCaseTag($tag) {
    parent::removeSpecialCaseTag($tag);
    $this->buildRequired = TRUE;
  }

  public function setGroupDiffs($boolean) {
    parent::setGroupDiffs($this->groupDiffs);
    $this->buildRequired = TRUE;
  }

  public function getDifference() {
    if ($this->buildRequired) {
      $this->build();
    }
    return $this->removeSeparatorTags(parent::getDifference());
  }

  public function build() {
    if ($this->buildRequired) {
      $this->buildRequired = FALSE;
      return parent::build();
    }
  }

  protected function addSeparatorTags($html) {
    foreach ($this->separatorTags as $tag) {
      $html = preg_replace_callback('#<' . $tag . '(\s|>)#',
        function ($matches) {
          return '<t' . $this->separatorCounter++ . '>' . $matches[0];
        }, $html);
    }
    return $html;
  }

  protected function removeSeparatorTags($html) {
    return preg_replace('#<t\d+[^>]*>#', '', $html);
  }
}