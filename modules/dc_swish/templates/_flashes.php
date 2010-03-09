<?php use_helper("I18N") ?>

<?php if ($sf_user->hasFlash("error")): ?>
  <div class="error">
    <?php echo __("%error%", array("%error%" => $sf_user->getFlash("error"))) ?>
  </div>
<?php endif ?>
