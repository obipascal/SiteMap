<?php

namespace BS\Libraries\SiteMap;

use DOMDocument;
use Exception;

/**
 * SiteMapBuilder
 * --
 * This package helps you create a simple site map for your website
 * @package Libraries
 * @since 1.0.0
 *
 */
class SiteMapBuilder extends DOMDocument
{
  use SiteMapHelpers;

  public function __construct(array $links = [])
  {
    parent::__construct(null, "UTF-8");
    // Config
    // $this->xmlEncoding = 'UTF-8';
    $this->xmlVersion = "1.0";
    $this->formatOutput = true;
    $this->links = $links;

    $this->buildStructure();
  }

  /** Input-Output stream context initalize the sitemap builder class. */
  public static function IO(array $links = [])
  {
    return new SiteMapBuilder($links);
  }
  /**
   * Sitemap Parer - PB server Sitemap Helper
   * --
   * Parse site map links
   *
   * @return bool
   */
  public function create_sitemap()
  {
    try {
      if (!count($this->locations)) {
        throw new Exception("Invalid links location.");
      }

      // @todo : Build and save the xml file
      // create the urlset
      $urlset = $this->createElement("urlset");
      $urlset->setAttribute(
        "xmlns",
        "http://www.sitemaps.org/schemas/sitemap/0.9"
      );
      // the dom nodes
      $nodes = [];

      // create nodes and stor them in the nodes array

      // @todo : Debuging -> data structure
      // echo "<pre>";
      // var_dump($this->locations);
      // echo "</pre>";
      // die();
      foreach ($this->locations as $index) {
        foreach ($index as $url => $entrying) {
          $path = $this->createElement($url);
          foreach ($entrying as $prop => $val) {
            if ($prop === "lastmod") {
              $node = $this->createElement($prop, date("c", time()));
              $path->appendChild($node);
              array_push($nodes, $path);
            } else {
              $node = $this->createElement($prop, $val);
              $path->appendChild($node);
              array_push($nodes, $path);
            }
          }
        }
      }

      // var_dump($this->locations, $nodes);
      // die('testing locations');
      // append children
      if (count($nodes) > 0) {
        foreach ($nodes as $node) {
          $urlset->appendChild($node);
        }
      }

      // append the urlset
      $this->appendChild($urlset);
      // save the dom

      if (!is_dir("sitemap")) {
        mkdir("sitemap");
        $data = $this->save("sitemap/sitemap.xml");
      } else {
        $data = $this->save("sitemap/sitemap.xml");
      }
      if ($data > 0) {
        return $this->__respond("Site map generated");
      } else {
        throw new Exception("Couldn't generate sitemap");
      }
    } catch (Exception $th) {
      return $this->__error($th->getMessage());
    }
  }
}