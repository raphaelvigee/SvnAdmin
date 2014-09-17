<?php
if($i === null){
    $i_inc = "%nbr%";
    $key_inc = "";
    $repo_inc = null;
    $displayNone = 'style="display:none;"';
}else{
    $i_inc = $i;
    $key_inc = $key;
    $repo_inc = $repo;
    $displayNone = '';
}
?>

<div class="well Repo ParentRepo" <?php echo $displayNone; ?> >

    <div class="collapse-group">
        <?php 
        include "config_repoBar.php";
        ?>
        
        <div class="collapse in" id="repo<?php echo $i; ?>">

            <input type="hidden" name="repos[<?php echo $i_inc; ?>][IsParent]" value="true">

            <div class="page-header">
                <h3>Parent Folder</h3>
            </div>

            <div class="form-group">
                <label for="FullUrl">Absolute path of SVN:</label>
                <div class="input-group">
                    <span class="input-group-addon">file://</span>
                    <input name="repos[<?php echo $i_inc; ?>][FullUrl]" type="text" class="form-control" placeholder="/var/svn" value="<?php echo $repo_inc['Url'] ?>">
                </div>
            </div>
        </div>
    </div>

</div>
