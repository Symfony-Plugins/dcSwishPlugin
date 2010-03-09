<?php
class SwishResultWrapper
{
  private 
    $rank,
    $path,
    $size,
    $lastmodified,
    $title,
    $description;

  public function __construct(SwishResult $s)
  {
    $this->rank= @$s->swishrank;
    $this->path= @$s->swishdocpath;
    $this->size = @$s->swishdocsize;
    $this->lastmodified = @$s->swishlastmodified;
    $this->title = @$s->swishtitle;
    $this->description = @$s->swishdescription;
  }

  public function getRank()
  {
    return $this->rank;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function getSize()
  {
    return $this->size;
  }

  public function getLastModified()
  {
    return $this->lastmodified;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function getObfuscatedPath()
  {
    return base64_encode($this->getPath());
  }

  public static function getUnobfuscatedPath($p)
  {
    return base64_decode($p);
  }

}
