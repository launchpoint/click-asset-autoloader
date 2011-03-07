<?

function autoload_assets($path, $ext)
{
  $s = array();
  
  foreach( glob($path . "/*.$ext") as $asset_path)
  {
    $vpath = ftov($asset_path);
    event($ext .'_loaded', array('path'=>$asset_path) );
    $s[] = $vpath;
  }

  if(array_key_exists('HTTP_USER_AGENT', $_SERVER))
  {
    $ua=$_SERVER['HTTP_USER_AGENT'];
    if($ua)
    {
      $ua = strtolower($ua);
      $isWebKit = strpos($ua, 'applewebkit');
      $isChrome = strpos($ua, 'chrome');
      $isOpera = strpos($ua, 'opera');
      $isFireFox307 = strpos($ua, 'firefox/3.0.7');
      $isFireFox = strpos($ua, 'firefox');
      $isSafari=false;
      $isSafari3=false;
      $isIE=false;
      $isIE7=false;
      $isIE8=false;
      if(!$isChrome && strpos($ua, 'webkit/5') && strpos($ua, "version/4")){$isSafari=true;}
      if(!$isChrome && !$isSafari && strpos($ua,'webkit/5')){$isSafari3=true;}
      if(!$isSafari && strpos($ua,'gecko')){$isGecko=true;}
      if(!$isSafari && strpos($ua,'rv:1.9')){$isGecko3=true;}
      if(!$isOpera && strpos($ua,'msie 7')){$isIE7=true;}
      if(!$isOpera && strpos($ua,'msie 8')){$isIE8=true;}
      if(!$isOpera && !$isIE7 && !$isIE8 && strpos($ua,'msie')){$isIE=true;}
    }
    $path .= "/browser";
    if (!file_exists($path)) return $s;
    
    $checks = array(
      'FireFox307'=>array('firefox', 'firefox.3.0.7'),
      'FireFox'=>array('firefox'),
      'Safari'=>array('safari'),
      'Safari3'=>array('safari','safari3'),
      'IE'=>array('ie'),
      'IE7'=>array('ie', 'ie7'),
      'IE8'=>array('ie', 'ie8')
    );
  
    foreach($checks as $k=>$v)
    {
      if (eval("return \$is{$k};"))
      {
        foreach($v as $node)
        {
          foreach(glob($path."/*.$node.$ext") as $fpath)
          {
            $s[] = ftov($fpath);
          }
        }
      }
    }
  }

  return $s;
}

function autoload_all_assets($ext)
{
  global $asset_folders, $manifests;
  $vpaths = array();
  foreach($manifests as $module_name=>$manifest)
  {
    if (!array_key_exists($module_name, $asset_folders)) continue;
    if (!array_key_exists($ext, $asset_folders[$module_name])) continue;
    foreach($asset_folders[$module_name][$ext] as $path)
    {
      foreach(array($ext, $ext.".php") as $fext)
      {
        $s = autoload_assets($path, $fext);
        $vpaths = array_merge($vpaths,$s);
      }
    }
  }
  $vpaths = array_unique($vpaths);
  return $vpaths;
}