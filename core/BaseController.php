<?php

namespace Core;

/**
 * Abstract class for controllers in the application.
 */
abstract class BaseController
{
    protected $viewPath;
    protected $layoutPath;
    protected $view;
    protected $pageTitle;

    public function __construct()
    {
        $this->view = new \stdClass();
        $this->pageTitle = '';
    }

    protected function getViewPath($viewName)
    {
        return __DIR__.'/../app/Views/'.$viewName.'.phtml';
    }

    protected function renderView($viewName, $layoutName = null)
    {
        $this->viewPath = $this->getViewPath($viewName);
        $this->layoutPath = $this->getViewPath($layoutName);

        if ($layoutName) {
            return $this->getLayout();
        } else {
            return $this->getContent();
        }
    }

    protected function getLayout()
    {
        $file = $this->layoutPath;

        if (file_exists($file)) {
            return require_once $file;
        }

        throw new \Exception('Layout path not found.', 404);
    }

    protected function getContent()
    {
        $file = $this->viewPath;

        if (file_exists($file)) {
            return require_once $file;
        }

        throw new \Exception('View path not found.', 404);
    }

    protected function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;
    }

    protected function getPageTitle($separator = null)
    {
        if ($separator && !empty($this->pageTitle)) {
            return $this->pageTitle.' '.$separator.' ';
        } else {
            return $this->pageTitle;
        }
    }
}
