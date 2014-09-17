<?php
include 'header.php';

$reposConfig = getOrderedReposConfig();

?>

<script type="text/javascript">

$(function() {
    var ParentRepo = $(".sampleRepo .ParentRepo").html();

    $('[data-loading-text]').click(function () {
        var btn = $(this);
        btn.button('loading');
    });
});

var currentVal= <?php echo (count($reposConfig)+1); ?>;


function addSimpleRepo(){
    event.preventDefault();
    currentVal = currentVal + 1;

    var repo = $(".sampleRepo .DistantRepo")
        .clone()
        .appendTo($(".reposStack"));
        repo.find("input").attr("name",function(i,oldVal) {
            if(oldVal){
                return oldVal.replace('%nbr%',currentVal);
            }
        });
        repo.find(".btn-collapse").attr('data-target','#repo'+currentVal);
        repo.find(".collapse").attr('id','repo'+currentVal);
        repo.fadeIn(500);
}

function addParentRepo(){
    event.preventDefault();
    currentVal = currentVal + 1;

    var repo = $(".sampleRepo .ParentRepo")
        .clone()
        .appendTo($(".reposStack"));
        repo.find("input").attr("name",function(i,oldVal) {
            if(oldVal){
                return oldVal.replace('%nbr%',currentVal);
            }
        });
        repo.find(".btn-collapse").attr('data-target','#repo'+currentVal);
        repo.find(".collapse").attr('id','repo'+currentVal);
        repo.fadeIn(500);
}

function toggleRepo(){
    var repoCollapse = $(this);

    if($(repoCollapse).hasClass("collapsed")){
        $(this).children('span').attr('class','glyphicon glyphicon-chevron-down');
    }else{
        $(this).children('span').attr('class','glyphicon glyphicon-chevron-right');
    }
}


function removeRepo(){
    event.preventDefault();
    var well = $(this).closest(".well");
    well.css('overflow','hidden');
    well.animate({
        'height': "0px",
        'padding-top': "0",
        'padding-bottom': "0",
        'min-height': "0",
        'border': "none",
        'margin': "0"
    }, 500, function() {
        $(this).remove()
    });

}

</script>

    
<form role="form" method="POST" action="install.php" autocomplete="off">

    <ul class="nav nav-tabs" role="tablist">
        <li class="active">
            <a href="#parameters" role="tab" data-toggle="tab">Parameters</a>
        </li>
        <li>
            <a href="#repos" role="tab" data-toggle="tab">Repos</a>
        </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane active" id="parameters">
        <p> </p>
            <?php
            include "config_params.php";
            ?>
      </div>

      <div class="tab-pane" id="repos">
        <p> </p>
            <div class="well well-sm">
                <span href="#" class="addRepo btn btn-success" onclick="addSimpleRepo()"><span class="glyphicon glyphicon-plus"></span> Add Simple</span>
                <span href="#" class="addRepo btn btn-success" onclick="addParentRepo()"><span class="glyphicon glyphicon-plus"></span> Add Parent</span>
            </div>

            <div class="reposStack">
                <?php
                $i=0;
                    foreach ($reposConfig as $key => $repo) {
                        if($repo['IsParent']==true){
                            include "config_ParentRepo.php";
                        }else{
                            include "config_DistantRepo.php";
                        }
                        $i++;
                    }
                $i=null;
                ?>
            </div>
      </div>
    </div>

  <button type="submit" data-loading-text="Loading..." class="btn btn-default">Continue</button>
</form>

<div class="sampleRepo" style="display:none;">

    <?php
    include "config_ParentRepo.php";
    include "config_DistantRepo.php";
    ?>
   
</div>

<?php
include 'footer.php';
?>