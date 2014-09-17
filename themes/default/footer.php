		</div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if(get('CommandDebug')==true){
                ?>
                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Open Log</button>
                    <div id="demo" class="collapse">
                        <ul class="list-group">
                        <?php
                        foreach (getAllCommands() as $key => $value) {
                        ?>
                            <li class="list-group-item"><?php echo $value['command']; ?> <span class="badge pull-right" ><?php echo $value['initiator']; ?></span></li>
                        <?php
                        }
                        ?>
                        </ul>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
    			<p class="text-center"><small>Raphaël Vigée</small></p>
            </div>
        </div>
	</div>
</body>
</html>