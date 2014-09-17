<?php
include 'header.php';
$config = $_POST;

if(!empty($config)){

    $repos = $config['repos'];
    unset($config['repos']);

    $out = array();
    $out[]="<?php";

    foreach ($repos as $key => $repo) {
        @$slug = $repo['Slug'];
        if(!empty($slug)){
            $repos[$slug] = $repo;
            unset($repos[$key]);
        }
    }

    foreach ($repos as $key1 => $repo) {
        foreach ($repo as $key => $value) {
            if($value=="true"){
                $repos[$key1][$key] = true;
            }elseif($value=="false"){
                $repos[$key1][$key] = false;
            }
        }
    }

    foreach ($config as $key => $value) {
        if($value=="true"){
            $config[$key] = true;
        }elseif($value=="false"){
            $config[$key] = false;
        }
    }

    foreach ($config as $key => $value) {
        if($key=="CommandDebug" OR
           $key=="AgeInsteadDate"
           ){
            $out[] = "\$config['".$key."'] = ".trim(var_export($value,true),"'").";";
        }else{
            $out[] = "\$config['".$key."'] = '".$value."';";
        }
    }

    $out[]="";
    $out[]="";

    foreach ($repos as $key1 => $repo) {
        foreach ($repo as $key => $value) {
            if($key=="Slug") continue;
            
            if($key=="IsParent"){
                $out[] = "\$config['repos']['".$key1."']['".$key."'] = ".trim(var_export($value,true),"'").";";      
            }elseif($key=="FullUrl"){

                if($repo['IsParent']=="true"){
                    $out[] = "\$config['repos']['".$key1."']['Protocol'] = 'file://';";
                    $out[] = "\$config['repos']['".$key1."']['Url'] = '".$value."';";
                }else{
                    $UrlParts = parse_url($value);
                    $out[] = "\$config['repos']['".$key1."']['Protocol'] = '".$UrlParts['scheme']."://';";   
                    $out[] = "\$config['repos']['".$key1."']['Url'] = '".$UrlParts['host']."';";
                    $out[] = "\$config['repos']['".$key1."']['RootPath'] = '".trim($UrlParts['path'],"/")."';";                   
                }
     
            }else{
                $out[] = "\$config['repos']['".$key1."']['".$key."'] = '".$value."';";      
            }
        }
        $out[]="";
    }
    $out[]="?>";


    $file = '../config.php';
    if(!file_exists($file)){
        $handle = fopen($file, 'w') or die('Cannot open file:  '.$my_file); //implicitly creates file
        fclose($handle);
    }

    if (is_writable($file)) {
        $content = implode("\n", $out);
        file_put_contents($file, $content);
        ?>
        <div class="alert alert-success" role="alert">The config file has been generated.</div>
        <p class="lead"><a href="../">You can now start using it</a></p>
        <?php
    } else {
        echo '<div class="alert alert-danger" role="alert">File not accessible for writing.</div>';
    }

}else{
        echo '<div class="alert alert-danger" role="alert">You must pass by the <a href="./config.php" class="alert-link">last page.</a></div>';
}
?>

<?php
include 'footer.php';
?>
