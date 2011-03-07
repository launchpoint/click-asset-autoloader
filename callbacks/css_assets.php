<?

$vpaths = autoload_all_assets('css');

$assets = array();
foreach($vpaths as $asset)
{
  $assets[] = array('src'=>$asset);
}

if(browser_is('ie') && count($assets)>30 && !array_key_exists('minify', $manifests))
{
  click_error("Over 30 CSS assets will be loaded, but IE does not support that many. Use minify.");
};