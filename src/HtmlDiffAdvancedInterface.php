<?php

/**
 */
interface HtmlDiffAdvancedInterface {
  public function setEncoding($encoding);

  public function setOldHtml($oldText);

  public function getOldHtml();

  public function setNewHtml($newText);

  public function getNewHtml();

  public function getDifference();
}