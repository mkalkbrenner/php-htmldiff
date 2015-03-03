<?php

class HtmlDiffAdvanced extends \Caxy\HtmlDiff\HtmlDiff implements HtmlDiffAdvancedInterface {
  protected $oldText = '';
  protected $newText = '';
  protected $encoding = 'UTF-8';
  protected $specialCaseTags;
  protected $groupDiffs;

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

  public function __construct($oldText = '', $newText = '', $encoding = '', $specialCaseTags = null, $groupDiffs = null) {
    $tags = ($specialCaseTags === null) ? static::$defaultSpecialCaseTags : $specialCaseTags;
    $this->setSpecialCaseTags($tags);

    $this->setGroupDiffs($groupDiffs);

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
    parent::__construct($this->oldText, $this->newText, $this->encoding, $this->specialCaseTags, $this->groupDiffs);
  }

  public function setOldHtml($oldText) {
    $this->buildRequired = TRUE;
    $this->oldText = $this->addSeparatorTags($oldText);
    parent::__construct($this->oldText, $this->newText, $this->encoding, $this->specialCaseTags, $this->groupDiffs);
  }

  public function getOldHtml() {
    return $this->removeSeparatorTags($this->oldText);
  }

  public function setNewHtml($newText) {
    $this->buildRequired = TRUE;
    $this->newText = $this->addSeparatorTags($newText);
    parent::__construct($this->oldText, $this->newText, $this->encoding, $this->specialCaseTags, $this->groupDiffs);
  }

  public function getNewHtml() {
    return $this->removeSeparatorTags($this->newText);
  }

  public function setInsertSpaceInReplace($boolean) {
    $this->buildRequired = TRUE;
    parent::setInsertSpaceInReplace($boolean);
  }

  public function setSpecialCaseChars(array $chars) {
    $this->buildRequired = TRUE;
    parent::setSpecialCaseChars($chars);
  }

  public function addSpecialCaseChar($char) {
    $this->buildRequired = TRUE;
    parent::addSpecialCaseChar($char);
  }

  public function removeSpecialCaseChar($char) {
    $this->buildRequired = TRUE;
    parent::removeSpecialCaseChar($char);
  }

  public function setSpecialCaseTags(array $tags = array()) {
    $this->buildRequired = TRUE;
    $this->specialCaseTags = $tags;
    parent::setSpecialCaseTags($this->specialCaseTags);
  }

  public function addSpecialCaseTag($tag) {
    $this->buildRequired = TRUE;
    parent::addSpecialCaseTag($tag);
  }

  public function removeSpecialCaseTag($tag) {
    $this->buildRequired = TRUE;
    parent::removeSpecialCaseTag($tag);
  }

  public function setGroupDiffs($boolean) {
    $this->buildRequired = TRUE;
    $this->groupDiffs = ($boolean === null) ? static::$defaultGroupDiffs : $boolean;
    parent::setGroupDiffs($this->groupDiffs);
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