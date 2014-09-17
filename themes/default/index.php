<div class="page-header">
    <h1><?php echo t('home') ?></h1>
</div>

<div class="row">
    <div class="col-md-3">
        <p class="lead">
            SvnAdmin uses :
            <ul>
                <li><a href="http://jquery.com">Jquery</a></li>
                <li><a href="http://getbootstrap.com">Bootstrap 3</a></li>
                <li><a href="http://fontawesome.io">Font Awesome</a></li>
            </ul>

            <strong>Version:</strong> <span>1.0</span>
        </p>

    </div>
    <div class="col-md-9">
        <table class="table">
            <thead>
                <tr>
                    <th><?php echo t('repo') ?></th>
                    <th><?php echo t('revision') ?></th>
                    <th><?php echo t('author') ?></th>
                    <th><?php echo t('lastModif') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach (getReposList() as $key => $repo) {
                    setRepo($repo);
                    ?>
                    <tr>
                        <td><span class="fa fa-archive"></span> <a href="<?php echo getUrl('repo',"",true,array('repo'=>$repo)) ?>"><?php echo $key; ?></a></td>
                        <td><span class="badge"><?php echo getLastRev(); ?></span></td>
                        <td><?php echo getCommitAuthor(); ?></td>
                        <td><?php echo getCommitDate(); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>

</div>