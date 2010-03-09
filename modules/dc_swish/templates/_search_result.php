<div style="border-bottom: 1px solid black">
  <?php foreach ($display as $field): ?>
    <strong><?php echo __("%s%", array("%s%" => sfInflector::humanize($field))) ?></strong>
    <?php if ($field == "path"): ?>
      <?php echo link_to($swish_result->getPath(),'@dc_swish_download',array("query_string"=>'resource='.$swish_result->getObfuscatedPath()),array('title'=>__("View file")))?>
    <?php elseif ($field == "lastmod"): ?>
      <?php echo format_date($swish_result->getLastModified())?>
    <?php else: ?>
      <?php echo call_user_func(array($swish_result, "get".sfInflector::camelize($field))) ?>
    <?php endif ?>
    <br/>
  <?php endforeach ?>
</div>
