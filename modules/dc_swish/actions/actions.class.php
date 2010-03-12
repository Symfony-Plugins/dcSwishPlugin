<?php

/**
 * main actions.
 *
 * @package    swish
 * @subpackage main
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class dc_swishActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->swish_form = new SwishSearchForm();

    $this->swish_form->setDefault("query", $this->getUser()->getAttribute("request_query", ""));
    $this->getUser()->getAttributeHolder()->remove("request_query");

    // sorting
    if ($request->getParameter('sort'))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort=$this->getSort();
    $this->display = sfConfig::get("app_dc_swish_display", array());
  }

  public function executeSearch(sfWebRequest $request)
  {
    $this->getUser()->setAttribute("request_query", $request->getParameter("swish[query]"));

    $this->setPage(1);
    $this->swish_form = new SwishSearchForm();
    $this->swish_form->bind($request->getParameter('swish'));
    if ($this->swish_form->isValid())
    {
      $this->setQuery($this->swish_form->getValues());
      $this->redirect('@dc_swish');
    }
    $this->pager = $this->getPager();
    $this->sort=$this->getSort();
    $this->display = sfConfig::get("app_dc_swish_display", array());
    $this->setTemplate('index');
  }

  public function executeDownload(sfWebRequest $request)
  {
    sfConfig::set('sf_web_debug', false);
    $result=$request->getParameter('resource');
    $this->setLayout(false);
    $this->path=SwishResultWrapper::getUnobfuscatedPath($result);
    $this->getResponse()->clearHttpHeaders();
    $this->getResponse()->setContentType(mime_content_type($this->path));
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename="' .basename($this->path).'"'); 
    $this->getResponse()->setHttpHeader('Content-length', filesize($this->path));
  }

  protected function getPager()
  {
    $pager = new SwishPager();
    $pager->setQuery($this->getQuery());
    $pager->setPage($this->getPage());
    $pager->setSort($this->getSort());
    try
    {
      $pager->init();
    }
    catch (Exception $e)
    {
      $this->getUser()->setFlash("error", "All search words too common to be useful");
      $this->setQuery(array());
    }
    return $pager;
  }

  protected function setPage($page)
  {
    $this->getUser()->setAttribute('swish.page', $page, 'swish_plugin');
  }

  protected function getPage()
  {
    return $this->getUser()->getAttribute('swish.page', 1, 'swish_plugin');
  }

  protected function getSort()
  {
    if (!is_null($sort = $this->getUser()->getAttribute('swish.sort', null, 'swish_plugin')))
    {
      return $sort;
    }
    $this->setSort(SwishManager::getDefaultSort());
    return $this->getUser()->getAttribute('swish.sort', null, 'swish_plugin');
  }



  protected function setSort(array $sort)
  {
    if (!is_null($sort[0]) && is_null($sort[1]))
    {
      $sort[1] = 'desc';
    }
    $this->getUser()->setAttribute('swish.sort', $sort, 'swish_plugin');
  }


  protected function setQuery(array $swish_query)
  {
    return $this->getUser()->setAttribute('swish.query', $swish_query, 'swish_plugin');
  }

  protected function getQuery()
  {
    return $this->getUser()->getAttribute('swish.query', array(), 'swish_plugin');
  }
}
