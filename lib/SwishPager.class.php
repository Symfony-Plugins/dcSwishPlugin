<?php
class SwishPager extends sfPager
{
  private 
      $index=null, 
      $limit=0,
      $offset=0;


  public function setSwishIndex($i)
  {
    $this->index=$i;
  }

  public function getSwishIndex()
  {
    return $this->index;
  }

  public function __construct($maxPerPage = 10, $index=null)
  {
    $this->setSwishIndex($index);
    parent::__construct('SwishManager', $maxPerPage);
  }


  public function init()
  {
    $hasMaxRecordLimit = ($this->getMaxRecordLimit() !== false);
    $maxRecordLimit = $this->getMaxRecordLimit();

    $query = $this->getQuery();
    $count = call_user_func(array($this->getClass(), 'doCount'), $query, $this->getSwishIndex());
    $this->setNbResults($hasMaxRecordLimit ? min($count, $maxRecordLimit) : $count);

    if (($this->getPage() == 0 || $this->getMaxPerPage() == 0))
    {
      $this->setLastPage(0);
    }
    else
    {
      $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
      $this->setOffset( ($this->getPage() - 1) * $this->getMaxPerPage() );

      if ($hasMaxRecordLimit)
      {
        $maxRecordLimit = $maxRecordLimit - $offset;
        if ($maxRecordLimit > $this->getMaxPerPage())
        {
          $limit=$this->getMaxPerPage();
        }
        else
        {
          $limit=$maxRecordLimit;
        }
      }
      else
      {
        $limit=$this->getMaxPerPage();
      }
      $this->setLimit($limit);
    }
  }

  public function getResults()
  {
    return call_user_func(array($this->getClass(), 'doSelect'), $this->getQuery(), $this->getSwishIndex(), $this->getOffset(),$this->getLimit(),$this->getSort());
  }

  protected function retrieveObject($offset)
  {
    $results = call_user_func(array($this->getClass(), 'doSelect'), $this->getQuery(),  $this->getSwishIndex(), max($this->getOffset()-1,0),1,$this->getSort());
    return is_array($results) && isset($results[0]) ? $results[0] : null;
  }

  public function setLimit($l)
  { 
    $this->limit=$l;
  }

  public function getLimit()
  { 
    return $this->limit;
  }

  public function setOffset($o)
  { 
    $this->offset=$o;
  }

  public function getOffset()
  { 
    return $this->offset;
  }

  public function setQuery($q)
  {
    $this->query=$q;
  }

  public function setSort($s)
  {
    $this->sort=$s;
  }

  public function getSort()
  {
    return $this->sort;
  }

  public function getQuery()
  {
    return $this->query;
  }

  public function getQueryString()
  {
    return $this->query['query'];
  }

}
