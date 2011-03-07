<?

$asset_folders = array();

function register_asset_folder($module_name, $path, $type)
{
  global $asset_folders;
  if (!array_key_exists($module_name, $asset_folders)) $asset_folders[$module_name] = array();
  if (!array_key_exists($type, $asset_folders[$module_name])) $asset_folders[$module_name][$type] = array();
  if (!file_exists($path)) click_error("Error. $type path $path does not exist.");
  $asset_folders[$module_name][$type][] = $path;
}
