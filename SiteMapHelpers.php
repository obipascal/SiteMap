<?php namespace BS\Libraries\SiteMap;

use Exception;

/**
 * Site map helpers
 * @since 1.0.0
 */
trait SiteMapHelpers
{
  // Error reporting helpers
  public string $ERROR;
  public bool $STATE = false;
  public $RESPONSE;
  //   personal use only
  private bool $canProcessSitmap = false;

  //   --------------------------------------------------------
  /**
   * The url locations
   * --
   * the url locations to use and build the site map
   * e.g Structure:
   *
   * - array(1) {
   * - -  [0]=>
   * - - - array(1) {
   * - - - - ["url"]=>
   * - - - - - - array(3) {
   * - - - - - - -  ["loc"]=> '',
   * - - - - - - -  ["lastmod"]=> '',
   * - - - - - - -  ["priority"]=> ''
   * - - - - - -}
   * - - }
   * - }
   *
   * @var array
   */
  protected $locations = [];
  /**
   * The site urls to be compile to a sitemap
   *
   *
   * Structure:
   * - [
   * - - [
   * - - link => 'url'
   * - - preority => '0.80' if not provided this value will be used
   * - - ]
   * - ]
   *
   * --- OR ---
   * ______
   * [link => 'url', link => 'url' ...]
   *
   * @var array
   */
  protected $links = [];

  //   -----------------------------------
  /** Report an operational error in flow */
  private function __error(string $error)
  {
    if (!empty($error)) {
      $this->ERROR = $error;
      $this->STATE = false;
    }
    return $this;
  }

  /** Return the operation response on completion */
  private function __respond($response, bool $state = true)
  {
    if (!empty($response)) {
      $this->RESPONSE = $response;
    }
    $this->STATE = $state;

    return $this;
  }
  /**
   * Get the xml time stamp
   *
   * @return string
   */
  protected function getTimeStamp()
  {
    return date("c", time());
  }

  protected function buildStructure()
  {
    try {
      if (!empty(count($this->links))) {
        // @todo : check which structure of data was provided
        // and push them to urls

        $urls = [];

        foreach ($this->links as $sitelinks => $links) {
          if (is_array($links)) {
            $locs = null;
            // array-in-array

            // link building
            if (isset($links["link"])) {
              $locs["loc"] = $links["link"];
            }

            //  prority building
            if (isset($links["priority"])) {
              $locs["priority"] = $links["priority"];
            } else {
              $locs["priority"] = "0.8";
            }

            // last modified building
            $locs["lastmod"] = $this->getTimeStamp();

            // others settings
            $locs["changefreq"] = "always";

            // push locs to urls
            array_push($urls, ["url" => $locs]);
          } else {
            // array-key->value
            array_push([
              "url" => [
                "loc" => $links,
                "lastmod" => $this->getTimeStamp(),
                "priority" => "0.8",
                "changefreq" => "always",
              ],
            ]);
          }
        }

        if (count($urls)) {
          $this->locations = $urls;
          $this->canProcessSitmap = true;
        } else {
          $this->canProcessSitmap = false;
          throw new Exception("Couldn't process links list.");
        }
      }

      //   make sure you disabled the processing of the site map
      $this->canProcessSitmap = false;
      throw new Exception("No site links provided.");
    } catch (Exception $th) {
      return $this->__error($th->getMessage());
    }
  }
}