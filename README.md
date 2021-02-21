# SiteMap - A simple and easy to use sitemap bulder written in PHP

# Usage

  ## Intallation
  In other to start using this package you need to install it by typing this command in your terminal. This tutorial assumes you already have composer installed
  if not just grap it @ https://getcomposer.org/download/
  
  composer require obitechinvent/simplesitemapbuilder
  
  ## Example 
  
  When you have successfully install the lib package 
  initalize as follows:
  
   ```PHP
   <?php

    namespace BS\Controllers;

    use BS\Libraries\SiteMap\SiteMapBuilder;

    class Home extends BaseController
    {
      public function index()
      {
        $sitemap_url = [
          [
            "link" => "https://www.bitmoservice.com",
            "priority" => "0.80",
          ],
          [
            "link" => "https://www.bitmoservice.com/categories",
            "priority" => "0.80",
          ],
          [
            "link" => "https://www.bitmoservice.com/services",
            "priority" => "0.80",
          ],
        ];

        $builder = SiteMapBuilder::IO($sitemap_url)->create_sitemap();
        echo "--------------------< Processing.... >..........................<br>";
        var_dump($builder);
        echo "<br>--------------------< Done!      >...............................<br>";
      }
    }
   
   ```


## This will be the output saved as: 
sitemap/sitmap.xml

```XML 

<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://www.bitmoservice.com</loc>
    <priority>0.80</priority>
    <lastmod>2021-02-21T23:40:12+01:00</lastmod>
    <changefreq>always</changefreq>
  </url>
  <url>
    <loc>https://www.bitmoservice.com/categories</loc>
    <priority>0.80</priority>
    <lastmod>2021-02-21T23:40:12+01:00</lastmod>
    <changefreq>always</changefreq>
  </url>
  <url>
    <loc>https://www.bitmoservice.com/services</loc>
    <priority>0.80</priority>
    <lastmod>2021-02-21T23:40:12+01:00</lastmod>
    <changefreq>always</changefreq>
  </url>
</urlset>
```

 
