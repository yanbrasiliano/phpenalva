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
    $possibleExtensions = ['.phtml', '.html'];

    foreach ($possibleExtensions as $extension) {
      $filePath = __DIR__ . '/../app/Views/' . $viewName . $extension;
      if (file_exists($filePath)) {
        return $filePath;
      }
    }

    return __DIR__ . '/../app/Views/' . $viewName . '.phtml';
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

    $this->renderExceptionView(404, 'Layout path not found.');
  }

  protected function getContent()
  {
    $file = $this->viewPath;

    if (file_exists($file)) {
      return require_once $file;
    }

    $this->renderExceptionView(404, 'View path not found.');
  }

  protected function renderExceptionView($statusCode, $message)
  {
    $errorDetails = [
      'message' => $message,
      'status_code' => $statusCode,
    ];

    $exceptionPath = $this->getViewPath('/System/exception');
    if (file_exists($exceptionPath)) {
      return require_once $exceptionPath;
    }

    throw new \Exception('Exception view not found.', 500);
  }

  protected function setPageTitle($pageTitle)
  {
    $this->pageTitle = $pageTitle;
  }

  protected function getPageTitle($separator = null)
  {
    if ($separator && !empty($this->pageTitle)) {
      return $this->pageTitle . ' ' . $separator . ' ';
    } else {
      return $this->pageTitle;
    }
  }

  /**
   * Handle forbidden requests by returning an array with an error message.
   *
   * @param string $message Optional custom message for the forbidden response.
   * @return array Response array containing the error message and status code.
   */
  public function forbidden($message = 'Unauthorized')
  {

    return [
      'error' => $message,
      'status' => 403
    ];
  }
}
