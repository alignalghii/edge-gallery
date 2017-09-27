<div id="header">
			Igthorn &amp; Toadie Ltd
		</div
		><div id="big-one"
			><img id="focus" class="fitbox big" src="<?php echo $focusedPicture['src']; ?>"
		/></div
		><div id="test-pager-strip" data-count="<?php echo count($triagedPictures); ?>" data-triage-left="<?php echo $triageCfg['left']; ?>" data-triage-right="<?php echo $triageCfg['right']; ?>"
					><a href="/xfocus-js/<?php echo $propertyId; ?>/<?php echo $prevId; ?>"<?php if (!isset($prevId)): ?> class="hidden"<?php endif; ?>><img id="left" class="navigation small" src="/assets/img/left.png"/></a
	<?php foreach ($triagedPictures as $i => $triagedPicture): ?>
	<?php if ($triagedPicture[0] == 'focus'): ?>
					><a class="slide focus" data-order="<?php echo $i; ?>" data-href="/xfocus-js/<?php echo $propertyId; ?>/<?php echo $pictureId; ?>"><img id="focus-small" class="fitbox" data-dbid="<?php echo $triagedPicture[1]['id']; ?>" src="<?php echo $triagedPicture[1]['src']; ?>"/></a
	<?php else: ?>
					><a class="slide <?php echo $triagedPicture[0]; ?>" data-order="<?php echo $i; ?>" href="/xfocus-js/<?php echo $propertyId; ?>/<?php echo $triagedPicture[1]['id']; ?>"><img class="fitbox small" data-dbid="<?php echo $triagedPicture[1]['id']; ?>" src="<?php echo $triagedPicture[1]['src']; ?>"/></a
	<?php endif; ?>
	<?php endforeach; ?>
					><a href="/xfocus-js/<?php echo $propertyId; ?>/<?php echo $nextId; ?>"<?php if (!isset($nextId)): ?> class="hidden"<?php endif; ?>><img id="right" class="navigation small" src="/assets/img/right.png"/></a
		></div>
