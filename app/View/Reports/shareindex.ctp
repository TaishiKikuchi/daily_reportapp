<div class="report_article">
    <?php
    debug($shares);
    foreach ($shares as $share): ?>
    <div class="report_container"><?php
        echo $share['Share']['content']; ?>
    </div>
    <?php
    endforeach;
    echo $this->Paginator->numbers();
    ?>
    </div>
    <?php unset($share); ?>