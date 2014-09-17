<?php
$errors = array();
$allCommands = array();

class xmlToArrayParser { 
  /** The array created by the parser can be assigned to any variable: $anyVarArr = $domObj->array.*/ 
  public  $array = array(); 
  public  $parse_error = false; 
  private $parser; 
  private $pointer; 
  
  /** Constructor: $domObj = new xmlToArrayParser($xml); */ 
  public function __construct($xml) { 
    $this->pointer =& $this->array; 
    $this->parser = xml_parser_create("UTF-8"); 
    xml_set_object($this->parser, $this); 
    xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false); 
    xml_set_element_handler($this->parser, "tag_open", "tag_close"); 
    xml_set_character_data_handler($this->parser, "cdata"); 
    $this->parse_error = xml_parse($this->parser, ltrim($xml))? false : true; 
  } 
  
  /** Free the parser. */ 
  public function __destruct() { xml_parser_free($this->parser);} 

  /** Get the xml error if an an error in the xml file occured during parsing. */ 
  public function get_xml_error() { 
    if($this->parse_error) { 
      $errCode = xml_get_error_code ($this->parser); 
      $thisError =  "Error Code [". $errCode ."] \"<strong style='color:red;'>" . xml_error_string($errCode)."</strong>\", 
                            at char ".xml_get_current_column_number($this->parser) . " 
                            on line ".xml_get_current_line_number($this->parser).""; 
    }else $thisError = $this->parse_error; 
    return $thisError; 
  } 
  
  private function tag_open($parser, $tag, $attributes) { 
    $this->convert_to_array($tag, 'attrib'); 
    $idx=$this->convert_to_array($tag, 'cdata'); 
    if(isset($idx)) { 
      $this->pointer[$tag][$idx] = Array('@idx' => $idx,'@parent' => &$this->pointer); 
      $this->pointer =& $this->pointer[$tag][$idx]; 
    }else { 
      $this->pointer[$tag] = Array('@parent' => &$this->pointer); 
      $this->pointer =& $this->pointer[$tag]; 
    } 
    if (!empty($attributes)) { $this->pointer['attrib'] = $attributes; } 
  } 

  /** Adds the current elements content to the current pointer[cdata] array. */ 
  private function cdata($parser, $cdata) { $this->pointer['cdata'] = trim($cdata); } 

  private function tag_close($parser, $tag) { 
    $current = & $this->pointer; 
    if(isset($this->pointer['@idx'])) {unset($current['@idx']);} 
    
    $this->pointer = & $this->pointer['@parent']; 
    unset($current['@parent']); 
    
    if(isset($current['cdata']) && count($current) == 1) { $current = $current['cdata'];} 
    else if(empty($current['cdata'])) {unset($current['cdata']);} 
  } 
  
  /** Converts a single element item into array(element[0]) if a second element of the same name is encountered. */ 
  private function convert_to_array($tag, $item) { 
    if(isset($this->pointer[$tag][$item])) { 
      $content = $this->pointer[$tag]; 
      $this->pointer[$tag] = array((0) => $content); 
      $idx = 1; 
    }else if (isset($this->pointer[$tag])) { 
      $idx = count($this->pointer[$tag]); 
      if(!isset($this->pointer[$tag][0])) { 
        foreach ($this->pointer[$tag] as $key => $value) { 
            unset($this->pointer[$tag][$key]); 
            $this->pointer[$tag][0][$key] = $value; 
    }}}else $idx = null; 
    return $idx; 
  } 
}

function getUrl($page = "", $path = "", $absolute = false, $upVars = array()) {
	$vars = array();
	$query_a = array();
	$query = "";

    if($page==="null"){
        $vars['page']=getPage();
    }else{
        $vars['page']=$page;        
    }
	$vars['repo']=getRepo();
	$vars['lang']=getLang();
    if($absolute==true){
        $vars['path']=urlencode($path); 
    }else{
        $vars['path']=urlencode(getPath().$path);   
    }

	$vars['rev']=getRev();
	if(getRev2()){
		$vars['rev2']=getRev2();		
	}

	foreach ($upVars as $k => $value) {
		if(isset($vars[$k])){
			unset($vars[$k]);
		}
		$vars[$k] = $value;
	}

	foreach (array_filter($vars) as $key => $value) {
		$query_a[] =$key."=".$value;
	}

	$query = implode("&", $query_a);

	return "?".$query;
}

function getPath(){
	$path = @$_GET['path'];

    $chunks = explode('/', $path);
    foreach ($chunks as $i => $chunk) {
        if(empty($chunk)){
            unset($chunks[$i]);
        }
    }

    array_values($chunks);

    $path = implode('/', $chunks);

	if($path){
		return $path."/";
	}else{
		return "";
	}
}

function getGET($remove = array()){
	$return = array();
	foreach ($_GET as $key => $value) {
		if(!in_array($key, $remove)){
			$return[$key]=$value;
		}
	}
	return $return;
}

function getRepo(){
	return @$_GET['repo'];
}

function getPage(){
	return @$_GET['page'];
}

function getMax(){
    $max = @$_GET['max'];
    if(!isset($max)){
        return get('MaxPerPage');
    }else{
        return $max;
    }
}

function getPageNb(){
    $pagenb = @$_GET['pagenb'];
    if(!isset($pagenb)){
        return 1;
    }else{
        return $pagenb;
    }
}

function getRev($null = false){
	$rev = @$_GET['rev'];
	if($rev && $rev!="HEAD"){
		return $rev;
	}else{
		if($null==true){
			return null;
		}else{
			return 'HEAD';
		}
	}
}

function getRev2($null = false,$same=false){
    $rev = @$_GET['rev2'];
    if($same===true){
        $rev = @$_GET['rev'];
    }
	if($rev && $rev!="HEAD"){
		return $rev;
	}else{
		if($null==true){
			return null;
		}else{
			return 'HEAD';
		}
	}
}

function getCallingFunction() {
  $caller = debug_backtrace();
  @$caller = $caller[2];
  $r = $caller['function'] . '()';
  if (isset($caller['class'])) {
    $r .= ' in ' . $caller['class'];
  }
  if (isset($caller['object'])) {
    $r .= ' (' . get_class($caller['object']) . ')';
  }
  return $r;
}

function getCommand($command,$errors=1) {
    global $errors;
    global $allCommands;
	//echo get_calling_function().": <code>".$command."</code><br>";
	exec($command." 2>&1", $outputAndErrors, $return_var);
    $i = (count($allCommands)+1);
    $allCommands[$i]['initiator'] = getCallingFunction();
    $allCommands[$i]['command'] = $command;
	//echo $command."<br>";
	if($return_var){
       /* <div class="alert alert-danger" role="alert"><?php echo ltrim(strip_tags(implode("<br>", array_filter($outputAndErrors)),"<br>"),"<br><br>") ?></div> */
		?>
		<?php
		$errors[] = implode("<br>", $outputAndErrors);
	}
	return $outputAndErrors;
}

function getAllCommands(){
    global $allCommands;
    return $allCommands;
}

function getThemeRoot(){
    return "themes/".get('Theme');
}

function getFilesList(){
	$files = array();
	$files_dir = getDirList();

	foreach ($files_dir as $key => $value) {
		if(isFile($value)){
			$files[$key] = $value;
		}
	}
	return $files;
}

function getFoldersList(){
	$folders = array();
	$files_dir = getDirList();

	foreach ($files_dir as $key => $value) {
		if(isDir($value)){
			$folders[$key] = $value;
		}
	}
	return $folders;
}

function getSeparatedDirList(){
	return array_merge(getFoldersList(),getFilesList());
}

function getDirList($path= null){
	$return = array();
	if($path==""){
		$path = getPath();
	}
	$files = getCommand('svn -r '.getRev().' ls --xml  '.getRepoUrl().'/'.$path);

	$domObj = new xmlToArrayParser(implode("\n", $files)); 
	$domArr = $domObj->array;

	$list = $domArr['lists']['list']['entry'];

	if(!isset($list[0])){
		$return[0] = $list;
	}else {
		$return = $list;
	}

	//print_r($list);
	return $return;
}

function getLang(){
	$lang = @$_GET['lang'];
	if($lang){
		return $lang;
	}else{
		if(get('Lang')){
			return get('Lang');
		}else{
			return 'fr_FR';
		}
	}
}

function getLangArray(){
	include 'languages/'.getLang().'.php';
	return $lang;
}

function getTrad($strSlug){
	$lang = getLangArray();
	if(isset($lang[$strSlug])){
		return $lang[$strSlug];
	}else {
		return "## ".$strSlug." ##";
	}
}

function t($strSlug = "",$replace = array()){
	$trad = getTrad($strSlug);

	foreach ($replace as $key => $value) {
		$trad = str_replace("%".$key."%", $value, $trad);
	}

	return $trad;
}

function getThemesList(){
    $path = __DIR__.'/themes';
    $results = array();

    foreach (scandir($path) as $result) {
        if ($result === '.' or $result === '..' or $result === '.AppleDouble') continue;

        if (is_dir($path . '/' . $result)) {
            $results[] = $result;
        }
    }

    return $results;
}

function getOrderedDirList(){
	$list = getDirList();
	$files = array();
	$folders = array();
	foreach ($list as $key => $value) {
		if($value['attrib']['kind']=="dir"){
			$folders[]=$value;
		}else{
			$files[]=$value;
		}
	}
	return array_merge($folders,$files);
}

function getLangList(){
    require __DIR__.'/IsoToLanguage.php';
	$languages = array_diff(scandir(__DIR__."/languages/"), array('..', '.'));
    $return = array();

	foreach ($languages as $key => $value) {
		$languages[$key] = basename($value, '.php');
		if(strlen($languages[$key])>2){
			unset($languages[$key]);
		}
	}

    foreach ($languages as $key => $iso_f) {
        $return[$iso_f] = $iso[$iso_f];
    }

	return $return;
}

function getHumanSize($bytes) {
	$bytes = intval($bytes);
    if(!empty($bytes)) {
        $s = array('bytes', 'kb', 'MB', 'GB', 'TB', 'PB');
        $e = floor(log($bytes)/log(1024));
        $output = sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
        return $output;

    }
}

function getHumanDate($date,$forceDate=false){
    if(get('AgeInsteadDate')==true && $forceDate==false){
        return dateDiff(strtotime($date),time(),get('DateDiffPrecision'));
    }else{
        return date(get('DateFormat'), strtotime($date));
    }
}

 
// Time format is UNIX timestamp or
// PHP strtotime compatible strings
function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
        $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
        $time2 = strtotime($time2);
    }

    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
        $ttime = $time1;
        $time1 = $time2;
        $time2 = $ttime;
    }

    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $intervals_out = array('Y','M','d','H','m','s');

    $diffs = array();

    // Loop thru all intervals
    foreach ($intervals as $k => $interval) {
        // Create temp time from time1 and interval
        $ttime = strtotime('+1 ' . $interval, $time1);
        // Set initial values
        $add = 1;
        $looped = 0;
        // Loop until temp time is smaller than time2
        while ($time2 >= $ttime) {
            // Create new temp time from time1 and interval
            $add++;
            $ttime = strtotime("+" . $add . " " . $interval, $time1);
            $looped++;
        }

        $time1 = strtotime("+" . $looped . " " . $interval, $time1);
        $diffs[$intervals_out[$k]] = $looped;
    }

    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
        // Break if we have needed precission
        if ($count >= $precision) {
            break;
        }
        // Add value and interval 
        // if value is bigger than 0
        if ($value > 0) {
            // Add s if value is not 1
            if ($value != 1) {
                //$interval .= "s";
            }
            // Add value and interval to times array
            $times[] = "<span class='label label-primary'>".$value." ".t($interval)."</span>";
            $count++;
        }
    }

    // Return string with times
    return implode(" ", $times);
}


function getDiff(){
	$diff =  getCommand('svn -r '.getRev().':'.getRev2().' diff '.getRepoUrl().'/'.getPath());
	return $diff;
}

function getLog($rev2=null){
	$rev = getRev();
	if($rev2){
		$rev = getRev2();
	}
	$log =  getCommand('svn -r '.$rev.' log --xml '.getRepoUrl().'/');
	return $log;
}

function getLogDiff(){
	$return = array();

	$log =  getCommand('svn -r '.getRev().':'.getRev2().' log --xml '.getRepoUrl().'/'.getPath().' -v');

	$domObj = new xmlToArrayParser(implode("\n", $log)); 
	$domArr = $domObj->array;

	if(isset($domArr['log']['logentry'])){
		$logentry = $domArr['log']['logentry'];

		if(!isset($logentry[0])){
			$return[0] = $logentry;
		}else {
			$return = $logentry;
		}

		foreach ($return as $key => $value) {
			if(!isset($return[$key]['paths']['path'][0])){
				$path = $return[$key]['paths']['path'];
				unset($return[$key]['paths']['path']);
				$return[$key]['paths']['path'][0] = $path;
			}
		}
	}else{
		$return = array();
	}

	return $return;
}

function getRepoUrl(){
	$protocol = get('Protocol',true);
	$url = get('Url',true);
	$root = get('RootPath',true);
    if($protocol!="file://"){
        $username = get('RepoUsername',true);
        $password = get('RepoPassword',true);   
    }

	//$fullUrl = "--username ".$username." --password ".$password." ".$protocol.$url.$root."/".getRepo();

	$fullUrl = "";
	if(!empty($username)){
		$fullUrl .= "--username ".$username;
		if(!empty($password)){
			$fullUrl .= " --password ".$password;
		}
	}
	$fullUrl .= " ".$protocol.$url."/".$root;

	//$fullUrl = $protocol.$url.$root;

	// $fullUrl = $protocol;
	// if(!empty($username)){
	// 	$fullUrl.=$username;
	// 	if(!empty($password)){
	// 		$fullUrl.=':'.$password;
	// 	}
	// 	$fullUrl.="@";
	// }
	// $fullUrl.=$url.$root."/".getRepo();

	//echo $fullUrl;
	return $fullUrl;
}

function getRepoPath(){
	return get('Url',true)."/".getRepo();
}

function getReposForParent($url){
	$parentLs = getCommand('ls '.$url);
	return $parentLs;
}

function getOrderedReposConfig(){
	global $config;
	$return = array();

	foreach ($config['repos'] as $key => $value) {
		if(isset($return[$key])){
			array_push($return[$key], $value);
		}else{
			$return[$key]=$value;
		}
	}
return $return;
}

function getFullReposConfig(){
	$config = getOrderedReposConfig();

	foreach ($config as $key => $value) {
		if($value['IsParent']==true){
			foreach (getReposForParent($value['Url']) as $key2 => $value2) {
				$return[$value2]['IsParent'] = $value['IsParent'];
				$return[$value2]['Protocol'] = $value['Protocol'];
				$return[$value2]['Url'] = $value['Url'];
				$return[$value2]['RootPath'] = $value2;
				$return[$value2]['RepoUsername'] = $value['RepoUsername'];
				$return[$value2]['RepoPassword'] = $value['RepoPassword'];
			}
		}else{
            if(is_int($key)){
                $return[$value['RootPath']] = $value;
            }else{              
                $return[$key] = $value;
           }
		}
	}

	//$return = array_values($return);
	return $return;
}

function printR($return){
    echo "<pre>".getCallingFunction().": <br>";
    print_r($return);
    echo "</pre>";
}

function getReposList(){
	$config = getFullReposConfig();
	$return = array();
	
	foreach ($config as $key => $value) {
		$return[$key] = $value['RootPath'];
	}
    asort($return);
	return $return;
}

function get($param,$repo=false,$repoName=null){

	if($repo==true){
		$config = getFullReposConfig();

		if($repoName==null){
			$repoName = getRepo();
		}

		foreach ($config as $key => $value) {
			if($value['RootPath']==$repoName){
				if(isset( $config[$key][$param] ) ){
					return $config[$key][$param];
				}else{
					return "error 1";
				}
			}
		}

	}else{
		global $config;
		if(isset($config[$param])){
			return $config[$param];
		}else{
			return "error 2";
		}
	}

}

function getInfos($path = null, $rev = true){
	if($path===null){
		$path = getPath();
	}
	if($rev==true){
		$log =  getCommand('svn -r'.getRev().' info --xml '.getRepoUrl().'/'.$path);
	}else{
		$log =  getCommand('svn info --xml '.getRepoUrl().'/'.$path);
	}
	return $log;
}

function getLastRev(){
    $infos = getInfos("",null);

    $domObj = new xmlToArrayParser(implode("\n", $infos)); 
    $domArr = $domObj->array;
    $rev = $domArr['info']['entry']['attrib']['revision'];
    if(isset($domArr['info']['entry']['attrib']['revision'])){
        return $rev;
    }
    // return $domArr['info']['entry']['attrib']['revision'];
}

function getPropList(){
    echo "svn -r".getRev()." -v proplist  --xml  ".getRepoUrl().'/'.getPath();
    $infos = getCommand("svn -v -r".getRev()." proplist --xml  ".getRepoUrl().'/'.getPath());

    $domObj = new xmlToArrayParser(implode("\n", $infos)); 
    $domArr = $domObj->array;
    // $rev = $domArr['info']['entry']['attrib']['revision'];
    // if(isset($domArr['info']['entry']['attrib']['revision'])){
    //     return $rev;
    // }
    return $domArr;
}

function getCommitMsg($rev2=null){
	$log = getLog($rev2);

	$domObj = new xmlToArrayParser(implode("\n", $log)); 
	$domArr = $domObj->array;
    if(isset($domArr['log']['logentry']['msg'])){
        return nl2br($domArr['log']['logentry']['msg']);
    }else{
        return t('noCommit');
    }
}

function getCommitAuthor($rev2=null){
	$log = getLog($rev2);

	$domObj = new xmlToArrayParser(implode("\n", $log)); 
	$domArr = $domObj->array;
    if(isset($domArr['log']['logentry']['author'])){
        return $domArr['log']['logentry']['author'];
    }else{
        return t('noCommit');
    }
}

function getCommitDate($rev2=null,$force=false){
	$log = getLog($rev2);

	$domObj = new xmlToArrayParser(implode("\n", $log)); 
	$domArr = $domObj->array;

    if(isset($domArr['log']['logentry']['date'])){
        return getHumanDate($domArr['log']['logentry']['date'],$force);
    }else{
        return t('noCommit');
    }
}

function download($path=""){
    global $TmpUid;
    global $TmpCurrentDir;

    $files = getDirList($path);

    if(!$TmpUid){
        $TmpUid = md5( uniqid().date("H:i:s"));
    }

    if(!$TmpCurrentDir){
        $TmpCurrentDir = "";
    }

    $dirPath = get('TmpPath').'/'.$TmpUid.'/';
    if(!file_exists($dirPath)){
        mkdir($dirPath, 0777);
    }

    foreach ($files as $key => $value) {
        switch ($value['attrib']['kind']) {
            case 'dir':
                $TmpCurrentDir .= "/".$value['name'];
                if(!file_exists($dirPath.ltrim($TmpCurrentDir,'/').'/')){
                    mkdir($dirPath.ltrim($TmpCurrentDir,'/').'/', 0777);
                }

                download(getPath().$TmpCurrentDir);
                $TmpCurrentDir = dirname($TmpCurrentDir);
                break;
            
            case 'file':
                $old_path = $_GET['path'];
                if(basename(getPath())==$value['name']){
                    $_GET['path']= getPath().$TmpCurrentDir;
                }else{
                    $_GET['path']= getPath().$TmpCurrentDir."/".$value['name'];
                }
                $file_content = getFile(true);
                if(!empty($file_content)){
                    file_put_contents($dirPath.ltrim($TmpCurrentDir,'/').'/'.$value['name'], $file_content);
                }
                $_GET['path'] = $old_path;
                break;
            
            default:
                echo 'error';
                break;
        }
    }

    Zip($dirPath, get('TmpPath').'/'.$TmpUid.'.zip');
    rrmdir($dirPath);

    return $TmpUid;

}


function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
}

function emptyTmp(){
    if($_GET['sure']==1){
        if(is_writable(get('TmpPath'))){
            rrmdir(get('TmpPath'));
            mkdir(get('TmpPath'), 0777);
            return 1;
        }else{
            return -1;
        }
    }else{
        return 0;
    }
}

function Zip($source, $destination)
{
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
            $file = str_replace('\\', '/', $file);

            // Ignore "." and ".." folders
            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                continue;

            $file = realpath($file);

            if (is_dir($file) === true)
            {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            }
            else if (is_file($file) === true)
            {
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    }
    else if (is_file($source) === true)
    {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    return $zip->close();
}


function getFile($base64=false){
	if($base64===true){
		$file = getCommand('svn cat -r'.getRev().' '.getRepoUrl().'/'.getPath().' | base64');
		$file = base64_decode(implode("\n", $file));
	}else{
		$file = getCommand('svn cat -r'.getRev().' '.getRepoUrl().'/'.getPath());
		$file = implode("\n", $file);
	}
	
	return $file;
}

function requireAuth(){

    $valid_passwords = array (getFullReposConfig()[getRepoSlug()]['RepoUsername']  => getFullReposConfig()[getRepoSlug()]['RepoPassword']);
    $valid_users = array_keys($valid_passwords);

    $user = $_SERVER['PHP_AUTH_USER'];
    $pass = $_SERVER['PHP_AUTH_PW'];

    if ((in_array($user, $valid_users)) && ($pass == $valid_passwords[$user])) {
      header('WWW-Authenticate: Basic realm="SVN Login"');
      header('HTTP/1.0 401 Unauthorized');
      die ("Not authorized");
    }

}

function http_digest_parse($txt)
{
    // protection contre les données manquantes
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));
 
    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}

function getRepoSlug(){
    $i=0;
    foreach (getFullReposConfig() as $key => $value) {
        if($value['RootPath']==getRepo()){
            if(is_int($key)){
                $RepoSlug = getRepo();
            }else{
                $RepoSlug = $key;
            }
            break;
        }
    }
    return $RepoSlug;
}

function getMimeType($file) {
    // MIME types array
    $mimeTypes = array(
        "323"       => "text/h323",
        "acx"       => "application/internet-property-stream",
        "ai"        => "application/postscript",
        "aif"       => "audio/x-aiff",
        "aifc"      => "audio/x-aiff",
        "aiff"      => "audio/x-aiff",
        "asf"       => "video/x-ms-asf",
        "asr"       => "video/x-ms-asf",
        "asx"       => "video/x-ms-asf",
        "au"        => "audio/basic",
        "avi"       => "video/x-msvideo",
        "axs"       => "application/olescript",
        "bas"       => "text/plain",
        "bcpio"     => "application/x-bcpio",
        "bin"       => "application/octet-stream",
        "bmp"       => "image/bmp",
        "c"         => "text/plain",
        "cat"       => "application/vnd.ms-pkiseccat",
        "cdf"       => "application/x-cdf",
        "cer"       => "application/x-x509-ca-cert",
        "class"     => "application/octet-stream",
        "clp"       => "application/x-msclip",
        "cmx"       => "image/x-cmx",
        "cod"       => "image/cis-cod",
        "cpio"      => "application/x-cpio",
        "crd"       => "application/x-mscardfile",
        "crl"       => "application/pkix-crl",
        "crt"       => "application/x-x509-ca-cert",
        "csh"       => "application/x-csh",
        "css"       => "text/css",
        "dcr"       => "application/x-director",
        "der"       => "application/x-x509-ca-cert",
        "dir"       => "application/x-director",
        "dll"       => "application/x-msdownload",
        "dms"       => "application/octet-stream",
        "doc"       => "application/msword",
        "dot"       => "application/msword",
        "dvi"       => "application/x-dvi",
        "dxr"       => "application/x-director",
        "eps"       => "application/postscript",
        "etx"       => "text/x-setext",
        "evy"       => "application/envoy",
        "exe"       => "application/octet-stream",
        "fif"       => "application/fractals",
        "flr"       => "x-world/x-vrml",
        "gif"       => "image/gif",
        "gtar"      => "application/x-gtar",
        "gz"        => "application/x-gzip",
        "h"         => "text/plain",
        "hdf"       => "application/x-hdf",
        "hlp"       => "application/winhlp",
        "hqx"       => "application/mac-binhex40",
        "hta"       => "application/hta",
        "htc"       => "text/x-component",
        "htm"       => "text/html",
        "html"      => "text/html",
        "htt"       => "text/webviewhtml",
        "ico"       => "image/x-icon",
        "ief"       => "image/ief",
        "iii"       => "application/x-iphone",
        "ins"       => "application/x-internet-signup",
        "isp"       => "application/x-internet-signup",
        "jfif"      => "image/pipeg",
        "jpe"       => "image/jpeg",
        "jpeg"      => "image/jpeg",
        "jpg"       => "image/jpeg",
        "js"        => "application/x-javascript",
        "latex"     => "application/x-latex",
        "lha"       => "application/octet-stream",
        "lsf"       => "video/x-la-asf",
        "lsx"       => "video/x-la-asf",
        "lzh"       => "application/octet-stream",
        "m13"       => "application/x-msmediaview",
        "m14"       => "application/x-msmediaview",
        "m3u"       => "audio/x-mpegurl",
        "man"       => "application/x-troff-man",
        "mdb"       => "application/x-msaccess",
        "me"        => "application/x-troff-me",
        "mht"       => "message/rfc822",
        "mhtml"     => "message/rfc822",
        "mid"       => "audio/mid",
        "mny"       => "application/x-msmoney",
        "mov"       => "video/quicktime",
        "movie"     => "video/x-sgi-movie",
        "mp2"       => "video/mpeg",
        "mp3"       => "audio/mpeg",
        "mpa"       => "video/mpeg",
        "mpe"       => "video/mpeg",
        "mpeg"      => "video/mpeg",
        "mpg"       => "video/mpeg",
        "mpp"       => "application/vnd.ms-project",
        "mpv2"      => "video/mpeg",
        "ms"        => "application/x-troff-ms",
        "mvb"       => "application/x-msmediaview",
        "nws"       => "message/rfc822",
        "oda"       => "application/oda",
        "p10"       => "application/pkcs10",
        "p12"       => "application/x-pkcs12",
        "p7b"       => "application/x-pkcs7-certificates",
        "p7c"       => "application/x-pkcs7-mime",
        "p7m"       => "application/x-pkcs7-mime",
        "p7r"       => "application/x-pkcs7-certreqresp",
        "p7s"       => "application/x-pkcs7-signature",
        "pbm"       => "image/x-portable-bitmap",
        "pdf"       => "application/pdf",
        "pfx"       => "application/x-pkcs12",
        "pgm"       => "image/x-portable-graymap",
        "pko"       => "application/ynd.ms-pkipko",
        "pma"       => "application/x-perfmon",
        "pmc"       => "application/x-perfmon",
        "pml"       => "application/x-perfmon",
        "pmr"       => "application/x-perfmon",
        "pmw"       => "application/x-perfmon",
        "pnm"       => "image/x-portable-anymap",
        "pot"       => "application/vnd.ms-powerpoint",
        "ppm"       => "image/x-portable-pixmap",
        "pps"       => "application/vnd.ms-powerpoint",
        "ppt"       => "application/vnd.ms-powerpoint",
        "prf"       => "application/pics-rules",
        "ps"        => "application/postscript",
        "pub"       => "application/x-mspublisher",
        "qt"        => "video/quicktime",
        "ra"        => "audio/x-pn-realaudio",
        "ram"       => "audio/x-pn-realaudio",
        "ras"       => "image/x-cmu-raster",
        "rgb"       => "image/x-rgb",
        "rmi"       => "audio/mid",
        "roff"      => "application/x-troff",
        "rtf"       => "application/rtf",
        "rtx"       => "text/richtext",
        "scd"       => "application/x-msschedule",
        "sct"       => "text/scriptlet",
        "setpay"    => "application/set-payment-initiation",
        "setreg"    => "application/set-registration-initiation",
        "sh"        => "application/x-sh",
        "shar"      => "application/x-shar",
        "sit"       => "application/x-stuffit",
        "snd"       => "audio/basic",
        "spc"       => "application/x-pkcs7-certificates",
        "spl"       => "application/futuresplash",
        "src"       => "application/x-wais-source",
        "sst"       => "application/vnd.ms-pkicertstore",
        "stl"       => "application/vnd.ms-pkistl",
        "stm"       => "text/html",
        "svg"       => "image/svg+xml",
        "sv4cpio"   => "application/x-sv4cpio",
        "sv4crc"    => "application/x-sv4crc",
        "t"         => "application/x-troff",
        "tar"       => "application/x-tar",
        "tcl"       => "application/x-tcl",
        "tex"       => "application/x-tex",
        "texi"      => "application/x-texinfo",
        "texinfo"   => "application/x-texinfo",
        "tgz"       => "application/x-compressed",
        "tif"       => "image/tiff",
        "tiff"      => "image/tiff",
        "tr"        => "application/x-troff",
        "trm"       => "application/x-msterminal",
        "tsv"       => "text/tab-separated-values",
        "txt"       => "text/plain",
        "uls"       => "text/iuls",
        "ustar"     => "application/x-ustar",
        "vcf"       => "text/x-vcard",
        "vrml"      => "x-world/x-vrml",
        "wav"       => "audio/x-wav",
        "wcm"       => "application/vnd.ms-works",
        "wdb"       => "application/vnd.ms-works",
        "wks"       => "application/vnd.ms-works",
        "wmf"       => "application/x-msmetafile",
        "wps"       => "application/vnd.ms-works",
        "wri"       => "application/x-mswrite",
        "wrl"       => "x-world/x-vrml",
        "wrz"       => "x-world/x-vrml",
        "xaf"       => "x-world/x-vrml",
        "xbm"       => "image/x-xbitmap",
        "xla"       => "application/vnd.ms-excel",
        "xlc"       => "application/vnd.ms-excel",
        "xlm"       => "application/vnd.ms-excel",
        "xls"       => "application/vnd.ms-excel",
        "xlsx"      => "vnd.ms-excel",
        "xlt"       => "application/vnd.ms-excel",
        "xlw"       => "application/vnd.ms-excel",
        "xof"       => "x-world/x-vrml",
        "xpm"       => "image/x-xpixmap",
        "xwd"       => "image/x-xwindowdump",
        "z"         => "application/x-compress",
        "zip"       => "application/zip"
    );

    $extension = end(explode('.', $file));
    if(isset($mimeTypes[$extension])){
        return $mimeTypes[$extension]; // return the array value       
    }else{
        return "text/plain";
    }
}

function setRepo($repo=""){
    global $TmpRepo;
    $TmpRepo = getRepo();
    $_GET['repo']=$repo;
}

function revertRepo(){
    global $TmpRepo;
    $_GET['repo']=$TmpRepo;
}

function setRev($Rev=""){
    global $TmpRev;
    $TmpRev = getRev();
    $_GET['rev']=$Rev;
}

function revertRev(){
    global $TmpRev;
    $_GET['rev']=$TmpRev;
}

?>

