<?

foreach(array('css', 'js') as $type)
{
  foreach($manifests as $module_name=>$manifest)
  {
    if (!$manifest['enabled']) continue;
    $path = $manifest['path']."/assets/$type";
    if (!file_exists($path)) continue;
    $codegen[] = "register_asset_folder('$module_name', '$path', '$type');";
  }
}
