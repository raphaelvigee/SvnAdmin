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

<div class="well Repo DistantRepo" <?php echo $displayNone; ?> >

    <div class="collapse-group">
        <?php 
        include "config_repoBar.php";
        ?>
        
        <div class="collapse in" id="repo<?php echo $i; ?>">

            <input type="hidden" name="repos[<?php echo $i_inc; ?>][IsParent]" value="false">

            <div class="page-header">
                <h3>Distant Repo</h3>
            </div>

            <div class="form-group">
                    <label for="MaxPerPage">Slug</label>
                    <input name="repos[<?php echo $i_inc; ?>][Slug]" type="text" class="form-control" placeholder="My repo" value="<?php echo $key_inc; ?>">
            </div>

            <div class="form-group">
                    <label for="MaxPerPage">Full SVN URL</label>
                    <input name="repos[<?php echo $i_inc; ?>][FullUrl]" type="text" class="form-control" placeholder="svn://svn.example.com/repo" value="<?php echo $repo_inc['Protocol'].$repo_inc['Url']."/".$repo_inc['RootPath']; ?>">
            </div>

            <div class="form-group">
                <label for="RepoUsername">Repo Username</label>
                <input type="text" name="repos[<?php echo $i_inc; ?>][RepoUsername]" class="form-control" id="RepoUsername" placeholder="MySecretUsername" value="<?php echo $repo_inc['RepoUsername']; ?>">
            </div>

            <div class="form-group">
                <label for="RepoPassword">Repo Password</label>
                <input type="password" name="repos[<?php echo $i_inc; ?>][RepoPassword]" class="form-control" id="RepoPassword" placeholder="MySecretPassword" value="<?php echo $repo_inc['RepoPassword']; ?>">
            </div>

        </div>
    </div>

</div>
