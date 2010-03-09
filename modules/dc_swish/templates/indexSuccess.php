<?php use_helper('I18N', 'Date') ?>
<form action="<?php echo url_for('@dc_swish_search') ?>" method="POST">
  <table>
    <?php echo $swish_form ?>
    <tr>
      <td colspan="2">
        <input type="submit" value=""/>
      </td>
    </tr>
  </table>
</form>
<div class="sf_admin_list">
  <?php if (!$pager->getNbResults()): ?>
    <p><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php else: ?>
    <?php include_partial('sort',array('sort'=> $sort, "display" => $display)) ?>

    <div id="nb_results">
      <?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'sf_admin') ?>
      <?php echo __('for query: %query%',array('%query%'=>$pager->getQueryString()))?>
    </div>

    <?php foreach ($pager->getResults() as  $swish_result): ?>
      <?php include_partial('search_result', array('swish_result' => $swish_result, "display" => $display)) ?>
    <?php endforeach ?>

    <?php if ($pager->haveToPaginate()): ?>
      <?php include_partial('pagination', array('pager' => $pager)) ?>
    <?php endif; ?>
  <?php endif ?>
</div>
