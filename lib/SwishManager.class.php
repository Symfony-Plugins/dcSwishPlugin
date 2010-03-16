<?php

class SwishManager
{
  const RANK = "swishrank";
  const PATH = "swishdocpath";
  const TITLE = "swishtitle";
  const SIZE = "swishdocsize";
  const MODIFIED = "swishlastmodified";

  static private $instances=array();
  private $swish,$swish_search;

  private function __construct($index)
  {
    $this->swish=new Swish($index);
    $this->swish_search=$this->swish->prepare();
  }

  public static function getDefaultSort()
  {
    return array(self::RANK, 'desc');
  }


  public static function getInstance($index)
  {
    if (empty($index) )
    {
      $index = sfConfig::get('app_dc_swish_index', "swish_index_default");
    }
    if (!array_key_exists($index,self::$instances))
    {
      self::$instances[$index]=new SwishManager($index);
    }
    return self::$instances[$index];
  }

  public static function doCount($query,$index)
  {
    $sm=SwishManager::getInstance($index);
    $qs=$sm->getQueryString($query);
    if ( empty($qs) )
    {
      return 0;
    }
    $result=$sm->search($query);
    return $result->hits;
  }

  public static function doSelect($query, $index, $offset, $limit, $sort=null)
  {
    if (empty($index) )
    {
      $index = sfConfig::get('app_dc_swish_index', "swish_index_default");
    }
    $sm=SwishManager::getInstance($index);
    $result=$sm->search($query,$sort);
    $result->seekResult($offset);
    $removed_stopwords = $result->getRemovedStopwords($index);
    $i=0;
    $ret=array();
    while( ( $current=$result->nextResult() ) && ($i++ < $limit) )
    {
      $ret[]=new SwishResultWrapper($current, $removed_stopwords);
    }
    return $ret;
  }

  public function search($query,$sort=null)
  {
    if (!is_null($sort))
    {
      $this->swish_search->setSort($this->getSortString($sort));
    }
    return $this->swish_search->execute($this->getQueryString($query));
  }

  protected function getQueryString($query)
  {
    $str = (is_array($query)&&array_key_exists('query',$query))?$query['query']:(!is_array($query)?$query:null);

    return $str;
  }

  protected function getSortString($sort)
  {
    return is_array($sort)?$sort[0]." ".$sort[1]:$sort;
  }

}
