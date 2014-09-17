<input type="hidden" name="CommandDebug" value="false">

<div class="form-group">
    <label for="MaxSizeTmpDir">Max size for tmp directory:</label>
    <input type="number" class="form-control" name="MaxSizeTmpDir" id="MaxSizeTmpDir" placeholder="1073741824" value="<?php echo $config['MaxSizeTmpDir'] ?>">
</div>

<div class="form-group">
    <label for="TmpPath">Absolute path for tmp directory:</label>
    <input type="text" class="form-control" name="TmpPath" id="TmpPath" placeholder="/var/www/svnadmin" value="<?php echo $config['TmpPath'] ?>">
</div>

<div class="form-group">
    <label for="Theme">Theme:</label>
    <select name="Theme" class="form-control" id="Theme">            
            <?php
            foreach (getThemesList() as $k => $v) {
                ?>
                <option value="<?php echo $v ?>"><?php echo $v ?></option>
                <?php
            }
            ?>
    </select>
</div>

<div class="form-group">
    <label for="MaxPerPage">Default language:</label>
    <select name="Lang" class="form-control" id="MaxPerPage">
        <?php
        foreach (getLangList() as $iso => $lang) {
            ?>
            <option value="<?php echo $iso ?>"><?php echo $lang['nativeName'] ?></option>
            <?php
        }
        ?>
    </select>
</div>

<div class="form-group">
    <label for="MaxPerPage">Max by page:</label>
    <input type="number" name="MaxPerPage" class="form-control" id="MaxPerPage" placeholder="5" value="<?php echo $config['MaxPerPage'] ?>">
</div>

<div class="form-group">
    <label for="DateFormat">Date Format:</label>
    <input type="text" name="DateFormat" class="form-control" id="DateFormat" placeholder="d\/m\/Y H:i:s" value="<?php echo $config['DateFormat'] ?>">
</div>

<div class="form-group">
    <label for="DateDiffPrecision">Precision for age:</label>
    <input type="number" name="DateDiffPrecision" class="form-control" id="DateDiffPrecision" placeholder="3" value="<?php echo $config['DateDiffPrecision'] ?>">
</div>

<div class="form-group">
    <label for="AgeInsteadDate">Use age instead of date:</label>
    <div class="radio">
      <label>
        <input type="radio" name="AgeInsteadDate" value="true" checked>
        Yes
      </label>
    </div>
    <div class="radio">
      <label>
        <input type="radio" name="AgeInsteadDate" value="false">
        No
      </label>
    </div>
</div>