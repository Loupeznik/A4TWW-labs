<div class="card text-center" id="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#show" data-toggle="tab">Zobrazení záznamu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#edit" data-toggle="tab" >Úprava záznamu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#remove" data-toggle="tab">Odstranění záznamu</a>
            </li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane container active" id="show">
            <div class="card body">
                <?php $db->showRecord($_GET['zakaznikID'],'show'); ?>
            </div>
        </div>
        <div class="tab-pane container fade" id="edit">
            <?php $db->showRecord($_GET['zakaznikID'],''); ?>
        </div>
        <div class="tab-pane container fade" id="remove">
            <h5 class="card-title">Odstranit záznam</h5>
            <p class="card-text"><b>Chystáte se odebrat záznam zákazníka s ID <i><?php print $_GET['zakaznikID']; ?></i> - <?php print $db->showColumn($_GET['zakaznikID'],'jmeno') . ' ' . $db->showColumn($_GET['zakaznikID'],'prijmeni'); ?></b></p>
            <button class="btn btn-danger" data-toggle="modal" data-target="#removeRecord">Odstranit záznam</button>
        </div>
    </div>
</div>
<div class="modal fade" id="removeRecord" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <b>Opravdu chcete záznam odstranit?</b>
                    <form method="POST">
                        <input type="submit" class="btn btn-danger" value="Ano, odstranit záznam" name="submitDelete">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ne</button>
                    </form>
                    <?php if ($_POST['submitDelete']) $db->deleteRecord($_GET['zakaznikID']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
